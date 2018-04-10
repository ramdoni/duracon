<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesso extends CI_Controller {


	/**
	 * Constructor
	 * @param	-
	 * @return 	-
	 **/
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('username')):
			redirect('login');
		else:

			// cek akses
			$access = $this->session->userdata('access_id');
			// sales dan admin
			if($access != 3) {
				redirect('site/index?access=forbidden');
			}
			
			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		
		$this->load->model('Salesorder_model');
		$this->model = $this->Salesorder_model;
	}

	/**
	 * [stock_product description]
	 * @return [type] [description]
	 */
	public function stockproduct()
	{
		$params = [];

		$this->load->model('Products_model');

		$params['page'] = 'salesso/stock';
		$params['data'] = $this->Products_model->data_();
		
		$this->load->view('layouts/main', $params);
	}

	/**
	 * @return html
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'salesso/index';
		$params['data'] = $this->model->data_sales();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [historysik description]
	 * @return [type] [description]
	 */
	public function historysik($id)
	{
		$num =  $this->db->get('surat_izin_kirim');
		$model = $this->model->get_by_id($id);

		$params['page'] 	= 'salesso/sik_history';
		$params['data'] 	= $model;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [createsik description]
	 * @return [type] [description]
	 */
	public function createsik($id) 
	{
		$num =  $this->db->get('surat_izin_kirim');
		$model = $this->model->get_by_id($id);

		if(!empty($model['sales_code']))
			$code = $model['sales_code'];
		else
			$code = $model['marketing_code'];

		$model['no_sik'] = ($num->num_rows()==0? 1 : ($num->num_rows() +1) ) .'/SIK/'. $code .'/'. toRomawi(date('m')).'/'. date('y'); 
		
		if($this->input->post())
		{
			$post  = $this->input->post();

			$param = $post['Sik'];
			$param['create_time'] 		= date('Y-m-d H:i:s');  
			$param['position']			= 1;
			$param['masa_berlaku'] 		= date('Y-m-d', strtotime(date('Y-m-d') ." + 3day"));

			// pembuatan sik melebihi jam 3 maka akan dikirim lusa
			$jam = date('Hi');
			if($jam >= 1500)
			{
				$param['date_proses'] = date('Y-m-d', strtotime(date('Y-m-d') ." + 2day"));
			}else{
				// jika create sebelum jam 3 maka akan dikirim besoknya
				$param['date_proses'] = date('Y-m-d', strtotime(date('Y-m-d') ." + 1day"));
			}

			$this->db->insert('surat_izin_kirim', $param);

			$id_insert = $this->db->insert_id();
			$this->db->flush_cache();

			foreach($post['Product'] as $key => $item)
			{
				if($item['id'] == 0 or $item['id'] == "") continue;
				
				$param = [];
				$param['surat_izin_kirim_id'] 	= $id_insert;
				$param['product_id'] 			= $key;
				$param['volume_yang_dikirim'] 	= $item['id'];
				$param['harga_yang_dikirim'] 	= ($item['id'] * $item['price_list']);
				$param['sales_order_id']		= $id;

				$this->db->insert('surat_izin_kirim_history', $param);
				$this->db->flush_cache();

				// update stok temporary 
				$this->db->query("UPDATE products SET stock_temporary=(stock_temporary + {$item['id']}) WHERE id={$key}");
			}

			$this->session->set_flashdata('messages', 'SIK (Surat Izin Kirim) berhasil dibuat');

			redirect('salesso/historysik/'. $id,'location');
		}
		
		$params['page'] 	= 'salesso/sik_form';
		$params['data'] 	= $model;

		$this->load->model('Quotationorder_model');

		$so   		= $this->db->get_where('sales_order', ['id' => $id])->row_array();
		$qo 		= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		$products 	= $this->db->get_where('quotation_order_products', ['quotation_order_id' =>$qo['id']])->result_array();

		$params['quotation_order']	= $qo;
		$params['products'] 		= $products;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * proccess sales order
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function proccess($id)
	{
		$model = $this->model->get_by_id_sales($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Sales_order');
			
			if($post['approved'] == 1){
				$post['position'] = 4; 
				$status  = 2; // Approved
				$position = 2; // AR
			}else{
				$post['position'] = 1;

				$status  = 3; // Rejected
				$position = 2; // Sales
			}

			// insert history
			$value['quotation_order_id'] = $id;
			$value['status'] = $status;
			$value['position'] = $position;
			$value['employee_id'] = $this->session->userdata('employee_id');
			$value['create_time'] = date('Y-m-d H:i:s');
			$value['note'] = $post['note'];
			$this->db->insert('sales_order_history', $value);
			$this->db->flush_cache();

			unset($post['approved']);
			unset($post['note']);

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			redirect('salesso/index','location');
		}
		
		$params['page'] = 'salesso/proccess';
		$params['data'] = $model;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * @param  id integer 
	 * @return pdf
	 */
	public function printso($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/employeeso/printso', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Sales Order ". date('d M Y')." - ". $params['data']['customer'] ." .pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");		
	}

	/**
	 * [viewsik description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function viewsik($id)
	{
		$this->load->model('Suratizinkirim_model');

		$params['data'] = $this->Suratizinkirim_model->get_sales_order($id);
		$params['so'] = $this->model->get_by_id($id);
		$html = $this->load->view('pages/salesso/viewsik', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Surat Izin Kirim ". date('d M Y')." - ". $params['data']['customer'] ." .pdf";

        //load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();
		
		$this->m_pdf->showImageErrors = true;

		$this->m_pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");		
	}

	/**
	 * [submitdispensasi description]
	 * @return [type] [description]
	 */
	public function submitdispensasi()
	{
		$post = $this->input->post();

		$nominal = $post['nominal'];
        $nominal = str_replace('Rp. ','', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $post['nominal'] = $nominal;

		$param = [];
		$param['date'] 				= date('Y-m-d');
		$param['sales_order_id'] 	= $post['sales_order_id'];
		$param['no_sik'] 			= $post['no_sik'];
		$param['nominal_pengajuan'] = $post['nominal'];
		$param['status']			= 0;
		$param['sales_id']			= $this->session->userdata('user_id');

		$this->db->insert('dispensasi', $param);

		$this->session->set_flashdata('messages', 'Pengajuan Dispensasi berhasil dilakukan, Anda masih harus menunggu persetujuan AR, anda bisa lihat <a href="'. site_url('salesdispensasi/index') .'" class="btn btn-xs btn-success">disini</a> untuk melihat progress pengajuan Dispensasi');

		redirect('salesso/createsik/'. $post['sales_order_id']);
	}

	/**
	 * [history description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function history($id)
	{
		$model = $this->model->get_by_id($id);

		$params['page'] = 'so/history';
		$params['data'] = $model;

		$this->load->view('layouts/main', $params);
	}
}

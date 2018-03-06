<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arso extends CI_Controller {


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
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'ar/so/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}
	
	/**
	 * [addcatatan description]
	 * @return [type] [description]
	 */
	public function addcatatan()
	{
		$post = $this->input->post();

		if($post)
		{	
			$param = [];
			$param['sales_order_id'] 	= $post['sales_order_id'];
			$param['catatan'] 			= $post['catatan'];
			$param['date']				= date('Y-m-d H:i:s');

			$this->db->insert('sales_order_catatan_ar', $param);

			$this->session->set_flashdata('messages', 'Catatan berhasil di tambahkan');

			redirect('arso/index');
		}
	}
	
	/**
	 * [invoice description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function invoice($id)
	{
		$params = [];
		$params['page'] = 'ar/invoice';
		$params['data'] = $this->model->get_by_id($id);

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [createinvoice description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createinvoice($id)
	{
		$count = $this->db->get('invoice')->num_rows();
		$data = $this->model->get_by_id($id);
		if($this->input->post())
		{
			$post  = $this->input->post('Invoice');

			$param['date'] 				= date('Y-m-d H:i:s');
			$param['sales_order_id'] 	= $id;
			$param['no_invoice'] 		= $post['no_invoice'];
			$param['untuk_pembayaran'] 	= $post['untuk_pembayaran'];
			$param['catatan']			= $post['catatan'];

			$nominal = $post['nominal'];
            $nominal = str_replace('Rp. ','', $nominal);
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);
			$param['nominal'] 			= $nominal;
			
			if($post['sistem_pembayaran'] == 'Cash')
			{
				$param['status'] = 1;
			}

			$this->db->insert('invoice', $param);
			$insert_id = $this->db->insert_id();
			$this->db->flush_cache();

			// jika sistem pembayaran cash maka otomatis bertambah nominal uang yang di masukan
			if($post['sistem_pembayaran'] == 'Cash')
			{
				$this->db->where(['id' => $id]);
				$this->db->update('sales_order', ['deposit' => ($param['nominal'] + $data['deposit'])]);			
				$this->db->flush_cache();
			}

			$surat_jalan = $this->input->post('surat_jalan');

			if(isset($surat_jalan)){
				foreach($surat_jalan as $i)
				{
					$this->db->where(['id' => $i]);
					$this->db->update('surat_jalan', ['invoice_id' => $insert_id, 'status_invoice' => 1]);
					$this->db->flush_cache();
				}
			}

			$this->session->set_flashdata('messsages', 'Invoice #'. $post['no_invoice'] ." berhasil disubmit");

			redirect('arso/invoice/'. $id);
		}
		$params = [];
		$params['page'] = 'ar/invoice_form';
		$params['data'] = $data;
		$params['qo'] = $this->db->get_where('quotation_order', ['id' => $data['quotation_order_id']])->row_array();
		$params['no_invoice'] = ($count + 1 ) .'/INVOICE/JKT/'.date('y');

		$this->load->view('layouts/main', $params);
	}
	/**
	 * [proccess description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function proccess($id)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Sales_order');
			
			if($post['approved'] == 1){
				$post['position'] = 4; 
				$status  = 2; // Approved
				$position = 3; // AR
			}else{
				$post['position'] = 1;

				$status  = 3; // Rejected
				$position = 3; // Sales
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

			redirect('arso/index','location');
		}
		
		$params['page'] = 'ar/so/form';
		$params['data'] = $model;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [viewinvoice description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function viewinvoice($id)
	{
		$data = $this->db->query("SELECT i.*, s.no_so, s.quotation_order_id FROM invoice i inner join sales_order s on s.id=i.sales_order_id where i.id={$id} ")->row_array();

		$params = [];
		$params['page'] = 'ar/invoice_view';
		$params['data'] = $data;
		$params['qo'] = $this->db->get_where('quotation_order', ['id' => $data['quotation_order_id']])->row_array();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [viewsik description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function printinvoice($id)
	{
		$this->load->model('Quotationorder_model');

		$invoice = $this->db->get_where('invoice', ['id' => $id])->row_array();
		$so 	= $this->db->get_where('sales_order', ['id' => $invoice['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		$params['qo'] = $qo;
		$params['so'] = $so;
		$params['invoice'] = $invoice;

		$html = $this->load->view('pages/ar/invoice_print', $params, true);

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Invoice-". date('d M Y') .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();
		
		$this->m_pdf->showImageErrors = true;

		$this->m_pdf->AddPage('P', // L - landscape, P - portrait
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
}

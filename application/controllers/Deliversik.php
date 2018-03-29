<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deliversik extends CI_Controller {


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
			
			if($access != 8) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}
			
			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Suratizinkirim_model');
		$this->model = $this->Suratizinkirim_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];
		$params['page'] = 'deliversik/index';
		$params['data'] = $this->model->data_('approved');

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [spmdone description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function spmdone($id)
	{
		$item = $this->db->get_where('surat_perintah_muat', ['id' => $id])->row_array();

		$this->db->where(['id' => $id]);
		$this->db->update('surat_perintah_muat', ['status' => 2]);

		redirect('/deliversik/spm/'. $item['surat_izin_kirim_id']);
	}

	/**
	 * [historyreturnproduct description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function historyreturnproduct($id)
	{
		$spm 	= $this->db->get_where('surat_perintah_muat', ['id' => $id])->row_array();

		$params = [];
		$params['page'] = 'deliversik/return_history';	
		$params['spm'] 	= $spm;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [returnproduk description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function returnproduk($id)
	{
		$params = [];

		$this->load->model('Quotationorder_model');

		$sj 	= $this->db->get_where('surat_jalan', ['id' => $id])->row_array();
		$spm 	= $this->db->get_where('surat_perintah_muat', ['id' => $sj['surat_perintah_muat_id']])->row_array();

		$sik  	= $this->model->get_by_id($spm['surat_izin_kirim_id']);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		$num =  $this->db->get('surat_perintah_muat');

		$params['no_spm'] = ($num->num_rows()==0? 1 : ($num->num_rows() +1) ) .'/SPM/'. toRomawi(date('m')).'/'. date('y');

		if($this->input->post())
		{
			$post  = $this->input->post();
			
			foreach($post['Products'] as $item):
				
				$param = [];
				$param['surat_jalan_id'] 	= $id;
				$param['date'] 				= date('Y-m-d H:i:s');  
				$param['product_id']		= $item['product_id'];
				$param['reject']			= $item['reject'];
				$param['baik']				= $item['baik'];
				$param['repair']			= $item['repair'];
				$param['surat_jalan_id'] 	= $id;
				$param['keterangan']		= $item['keterangan'];

				$this->db->insert('surat_jalan_return', $param);

			endforeach;
			
			$this->session->set_flashdata('messages', 'Return Surat Jalan berhasil di submit');

			redirect('deliversik/suratjalan/'. $sj['surat_perintah_muat_id'],'location');
		}

		$product = $this->db->query("SELECT p.* FROM surat_izin_kirim_history si INNER JOIN products p on p.id=si.product_id WHERE si.surat_izin_kirim_id={$id}")->result_array();

		$num = $this->db->get('surat_jalan')->num_rows();

		$params['no_surat_jalan'] = $num+1 .'/SJ/'. date('m').'/'. date('y'); // SJ/<bulan>/<tahun>
		$params['products'] = $product;
		$params['so'] 		= $so;
		$params['qo']		= $qo;
		$params['sik']		= $sik;
		$params['sj']		= $sj;
		$params['spm']		= $spm;
		$params['page'] 	= 'deliversik/suratjalan_return';

		$this->load->view('layouts/main', $params);
	}
	/**
	 * [createsik description]
	 * @return [type] [description]
	 */
	public function createsuratjalan($id) 
	{	
		$params = [];

		$this->load->model('Quotationorder_model');

		$sik  	= $this->model->get_by_id($id);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		$num =  $this->db->get('surat_perintah_muat');

		$params['no_spm'] = ($num->num_rows()==0? 1 : ($num->num_rows() +1) ) .'/SPM/'. toRomawi(date('m')).'/'. date('y');

		if($this->input->post())
		{
			$post  = $this->input->post('Spm');
			
			$post['create_time'] 		= date('Y-m-d H:i:s');  
			$post['surat_izin_kirim_id'] = $id;
			
			$this->db->insert('surat_perintah_muat', $post);

			$this->session->set_flashdata('messages', 'Surat Perintah Muat Berhasil dibuat');

			redirect('deliversik/spm/'. $id,'location');
		}

		$product = $this->db->query("SELECT p.* FROM surat_izin_kirim_history si INNER JOIN products p on p.id=si.product_id WHERE si.surat_izin_kirim_id={$id}")->result_array();

		$num = $this->db->get('surat_jalan')->num_rows();

		$params['no_surat_jalan'] = $num+1 .'/SJ/'. date('m').'/'. date('y'); // SJ/<bulan>/<tahun>
		$params['products'] = $product;
		$params['so'] 		= $so;
		$params['qo']		= $qo;
		$params['sik']		= $sik;
		$params['page'] 	= 'deliversik/suratjalan_form';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [suratjalan description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function suratjalan($id)
	{
		$this->load->model('Quotationorder_model');

		$sik  	= $this->model->get_by_id($id);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		$spm 	= $this->db->get_where('surat_perintah_muat', ['id' => $id])->row_array();

		if($this->input->post())
		{
			$post  = $this->input->post('Spm');
			
			$post['create_time'] 		= date('Y-m-d H:i:s');  
			$post['surat_izin_kirim_id'] = $id;
			
			$this->db->insert('surat_perintah_muat', $post);

			$this->session->set_flashdata('messages', 'Surat Perintah Muat Berhasil dibuat');

			redirect('deliversik/index','location');
		} 

		$params = [];

		$params['so'] 	= $so;
		$params['qo']	= $qo;
		$params['sik']	= $sik;
		$params['spm']	= $spm;
		$params['page'] 	= 'deliversik/suratjalan_list';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [batalsuratjalan description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function batalsuratjalan($id)
	{	
		$post = $this->input->post();

		$this->db->where(['id' => $post['surat_jalan_id']]);
		$this->db->update('surat_jalan', ['status' => 3, 'catatan' => $post['catatan']]);

		$this->session->set_flashdata('messages', 'Surat Jalan Berhasil dibatalkan.');

		redirect('deliversik/suratjalan/'. $id,'location');
	}

	/**
	 * [selesaisuratjalan description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function selesaisuratjalan($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->update('surat_jalan', ['status' => 2]);

		$this->session->set_flashdata('messages', 'Surat Jalan Berhasil dikirim.');


		$sj = $this->db->get_where('surat_jalan', ['id' => $id])->row_array();

		redirect('deliversik/suratjalan/'. $sj['surat_perintah_muat_id'],'location');
	}	

	/**
	 * [spm description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function spm($id) 
	{	
		$this->load->model('Quotationorder_model');

		$sik  	= $this->model->get_by_id($id);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		$params = [];

		$params['so'] 	= $so;
		$params['qo']	= $qo;
		$params['sik']	= $sik;
		$params['page'] 	= 'deliversik/spm_list';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [createsik description]
	 * @return [type] [description]
	 */
	public function createspm($id) 
	{	
		$params = [];

		$this->load->model('Quotationorder_model');

		$sik  	= $this->model->get_by_id($id);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		$num =  $this->db->get('surat_perintah_muat');

		$params['no_spm'] = ($num->num_rows()==0? 1 : ($num->num_rows() +1) ) .'/SPM/'. toRomawi(date('m')).'/'. date('y');

		if($this->input->post())
		{
			$post  = $this->input->post('Spm');
			
			$post['create_time'] 		= date('Y-m-d H:i:s');  
			$post['masa_berlaku'] 	  	= date('Y-m-d');
			$post['surat_izin_kirim_id'] = $id;
			
			$this->db->insert('surat_perintah_muat', $post);
			$insert_id = $this->db->insert_id();
			$this->db->flush_cache();

			$products = $this->input->post('Products');

			foreach($products as $k => $i)
			{
				if(empty($products[$k]['volume'])) continue;

				// get harga satuan
				$harga_satuan = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $so['quotation_order_id'], 'product_id' => $products[$k]['id']])->row_array();

				$param = [];
				$param['product_id'] 	= $products[$k]['id'];
				$param['volume']		= $products[$k]['volume'];
				$param['surat_perintah_muat_id'] = $insert_id;
				$param['catatan'] 		= $products[$k]['catatan'];
				$param['harga_satuan'] 	= $harga_satuan['harga_satuan'];

				$this->db->insert('surat_perintah_muat_product', $param);
				$this->db->flush_cache(); //clear query
			}

			$this->session->set_flashdata('messages', 'Surat Perintah Muat Berhasil dibuat');

			redirect('deliversik/spm/'. $id,'location');
		}

		$product = $this->db->query("SELECT p.* FROM surat_izin_kirim_history si INNER JOIN products p on p.id=si.product_id WHERE si.surat_izin_kirim_id={$sik['id']}")->result_array();

		$params['products'] = $product;
		$params['so'] 		= $so;
		$params['qo']		= $qo;
		$params['sik']		= $sik;
		$params['page'] 	= 'deliversik/spm_form';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [printspm description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function reprintsuratjalan($id=0)
	{
		$this->load->model('Quotationorder_model');

		$sj = $this->db->get_where('surat_jalan', ['id' => $id])->row_array();
		$id = $sj['surat_perintah_muat_id'];
		
		$params['data'] = $this->model->get_by_id($id);
		$params['spm'] = $this->db->get_where('surat_perintah_muat', ['id' => $id])->row_array();
		
		$sik  	= $this->model->get_by_id($params['spm']['surat_izin_kirim_id']);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();

		$total_surat_jalan = $this->db->get('surat_jalan')->num_rows();

		$params['mobil']= $this->db->get_where('mobil', ['id' => $params['spm']['mobil_id']])->row_array();
		$params['sik'] 	= $sik;
		$params['so'] 	= $so;
		$params['qo']	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		$params['no_surat_jalan'] =  ($total_surat_jalan +1).'/SJ/'. date('m').'/'. date('y');

		$html = $this->load->view('pages/deliversik/suratjalan_print', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Surat Jalan ". date('d M Y')." - ". $params['data']['customer'] ." .pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");	
		
	}


	/**
	 * [printspm description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printsuratjalan($id=0)
	{
		// cek surat jalan
		$cek_spm = $this->db->get_where('surat_jalan', ['surat_perintah_muat_id' => $id])->row_array(); 
		if($cek_spm)
		{
			$params['sj'] = $cek_spm;
		}

		$this->load->model('Quotationorder_model');

		$params['spm'] = $this->db->get_where('surat_perintah_muat', ['id' => $id])->row_array();
		
		$sik  	= $this->model->get_by_id($params['spm']['surat_izin_kirim_id']);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();

		$total_surat_jalan = $this->db->get('surat_jalan')->num_rows();

		$params['sik'] 	= $sik;
		$params['so'] 	= $so;
		$params['mobil']= $this->db->get_where('mobil', ['id' => $params['spm']['mobil_id']])->row_array();
		$params['qo']	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		$params['no_surat_jalan'] =  ($total_surat_jalan +1).'/SJ/'. date('m').'/'. date('y');

		// insert surat jalan
		if(!$cek_spm)
		{
			$var = [];
			$var['no_surat_jalan'] 			= $params['no_surat_jalan'];
			$var['status'] 					= 4;
			$var['surat_perintah_muat_id'] 	= $id;
			$var['date'] 					= date('Y-m-d');

			$this->db->insert('surat_jalan', $var);
			$this->db->flush_cache();

			$cek_spm = $this->db->get_where('surat_jalan', ['surat_perintah_muat_id' => $id])->row_array(); 
			
			$params['sj'] = $cek_spm;

				// update status spm
			$this->db->where(['id' => $id]);
			$this->db->update('surat_perintah_muat', ['status' => 2]);
		}

		$html = $this->load->view('pages/deliversik/suratjalan_print', $params, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = 'Surat Jalan-'. str_replace('/','', $params['no_surat_jalan']) . ".pdf";
		
        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");	
		
	}


	/**
	 * [printspm description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printspm($id=0)
	{
		$this->load->model('Quotationorder_model');

		$params['data'] = $this->model->get_by_id($id);
		$params['spm'] = $this->db->get_where('surat_perintah_muat', ['id' => $id])->row_array();
		
		$sik  	= $this->model->get_by_id($params['spm']['surat_izin_kirim_id']);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();

		$params['mobil'] = $this->db->get_where('mobil', ['id' => $params['spm']['mobil_id']])->row_array();
		$params['sik'] 	= $sik;
		$params['so'] 	= $so;
		$params['qo']	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		$html = $this->load->view('pages/deliversik/printspm', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "SPM ". date('d M Y')." - ". $params['data']['customer'] ." .pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");	
		
	}


	/**
	 * [printspm description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printritasi($id=0)
	{
		$this->load->model('Quotationorder_model');

		$params['data'] = $this->db->get_where('surat_jalan', ['id' => $id])->row_array();
		$params['supir'] = $this->db->get_where('supir', ['id' => $params['data']['supir_id']])->row_array();
		
		// cek rit ke
		$params['rit_ke'] = $this->db->query("SELECT * FROM surat_jalan where surat_jalan.supir_id={$params['supir']['id']} and surat_jalan.date='{$params['data']['date']}'")->num_rows();
		
		$params['spm'] = $this->db->get_where('surat_perintah_muat', ['id' => $params['data']['surat_perintah_muat_id']])->row_array();
		
		$sik  	= $this->model->get_by_id($params['spm']['surat_izin_kirim_id']);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();

		$params['sik'] 	= $sik;
		$params['so'] 	= $so;
		$params['qo']	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		
		$html = $this->load->view('pages/deliversik/printritasi', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Ritasi ". date('d M Y')." .pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");	
	}


	/**
	 * [revisi description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function revisisj($id)
	{
		$post = $this->input->post();
		if($post)
		{	
			$this->db->where(['id' => $id]);
			$this->db->update('surat_jalan', ['date' => $post['date'],'is_lock'=> 1]);
			$this->db->flush_cache();
			
			$this->db->where(['surat_jalan_id' => $id, 'is_submit' => 0]);
			$this->db->update('surat_jalan_lock_history', ['catatan' => $post['catatan'],'is_submit' => 1]);
		}

		$this->session->set_flashdata('messages', 'Surat Jalan berhasil direvisi');
		
		redirect('deliversik/printsuratjalan/'. $id);
	}

}
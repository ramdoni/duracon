<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salessik extends CI_Controller {


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
			
			if($access != 3) {
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
		$params['page'] = 'salessik/index';
		$params['data'] = $this->model->data_('sales', $this->session->userdata('employee_id'));

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [createsik description]
	 * @return [type] [description]
	 */
	public function createspm($id) 
	{	
		$this->load->model('Quotationorder_model');

		$sik  	= $this->model->get_by_id($id);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

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
		$params['page'] 	= 'deliversik/spm_form';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [printspm description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printspm($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/deliversik/printspm', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Sales Order ". date('d M Y')." - ". $params['data']['customer'] ." .pdf";

		//load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();

       	$this->m_pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            15, // margin top
            15, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");
	}
}
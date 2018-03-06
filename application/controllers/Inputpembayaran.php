<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inputpembayaran extends CI_Controller {


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
			if($access != 6) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		
		$this->load->model('Pembayaran_model');
		$this->model = $this->Pembayaran_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'inputpembayaran/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
			$params['data'] = $this->model->data_($_GET);

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [create description]
	 * @return [type] [description]
	 */
	public function insert()
	{
		$params = [];
		$params['page'] = 'inputpembayaran/form';

		if($this->input->post())
		{
			$post = $this->input->post();
			$var = $post['input'];

			$nominal = $post['input']['nominal'];
            $nominal = str_replace('Rp. ','', $nominal);
            $nominal = str_replace('.', '', $nominal);
			$var['nominal'] 			= $nominal;
			$var['date'] = date('Y-m-d H:i:s');

			// jika sales order tidak dipilih maka masuk ke depost customer
			if(empty($var['sales_order_id']))
			{
				$customer = $this->db->get_where('customer', ['id' => $var['customer_id']])->row();
				
				$this->db->flush_cache();
				$this->db->where(['id' => $var['customer_id']]);
				$this->db->update('customer', ['deposit' => ($customer->deposit+$var['nominal'])]);
				$this->db->flush_cache();
			}

			// jika ada sales order yang dipilih maka masukan ke deposit sales ordernya
			if(!empty($var['sales_order_id']))
			{
				$so = $this->db->get_where('sales_order', ['id' => $var['sales_order_id']])->row();
				
				$this->db->flush_cache();
				$this->db->where(['id' => $var['sales_order_id']]);
				$this->db->update('sales_order', ['deposit' =>($so->deposit+$var['nominal'])]);
				$this->db->flush_cache();
			}

			// update status di invoice
			if(!empty($var['invoice_id']))
			{
				$this->db->where(['id' => $var['invoice_id']]);
				$this->db->update('invoice', ['status'=> 1]);
			}

			$this->db->flush_cache();
			$this->db->insert('pembayaran', $var);

			redirect('inputpembayaran/index');
		}


		$this->load->view('layouts/main', $params);
	}

	/**
	 * [rekap description]
	 * @return [type] [description]
	 */
	public function rekap()
	{	
		$params['data']  = $_GET;
		$html = $this->load->view('pages/inputpembayaran/rekap', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Rekapitulasi pembayaran.pdf";

        //load mPDF library
		$this->load->library('m_pdf');
		$this->m_pdf = new mPDF();

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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tandaterima extends CI_Controller {


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

		$this->load->model('Tandaterima_model');
		$this->model = $this->Tandaterima_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'tandaterima/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
		{
			$params['data'] = $this->model->data_($_GET);
		}

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [insert description]
	 * @return [type] [description]
	 */
	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Tandaterima');
			$post['tanggal_pembuatan'] = date('Y-m-d');

			$this->db->insert($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Tanda Terima berhasil di buat, selanjutnya anda bisa print / cetak tanda terima yang sudah anda buat.');

			redirect('tandaterima/index','location');
		}
		
		$params['page'] = 'tandaterima/form';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [cetak description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function cetak($id)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/tandaterima/cetak', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "OM ".date('d M Y')." - ". $params['data']['customer'] .".pdf";

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

	/**
	 * [submitdone description]
	 * @return [type] [description]
	 */
	public function submitdone()
	{
		$post = $this->input->post();
		
		$post['overdue'] = date('Y-m-d', strtotime('+'. $post['overdue_day'] .' days', strtotime(date('Y-m-d')))) ;

		$this->db->where(['id' => $post['tanda_terima_id']]);
		$this->db->update('tanda_terima', ['status' => 1, 'tanggal_terima' => $post['tanggal_terima']]);
		$this->db->flush_cache();

		// set invoice overdue
		$this->db->where(['id' => $post['invoice_id']]);
		$this->db->update('invoice', ['overdue' => $post['overdue']]);	
		$this->db->flush_cache();

		$this->session->set_flashdata('messages', 'Tanda Terima berhasil di submit');
		redirect('tandaterima/index');

	}
}

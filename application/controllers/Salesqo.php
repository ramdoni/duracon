<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesqo extends CI_Controller {


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
		$this->load->model('Quotationorder_model');
		$this->model = $this->Quotationorder_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];
		$params['page'] = 'salesqo/index';
		$params['data'] = $this->model->data_(0,0,0, ['quotation_order.sales_id' => $this->session->userdata('employee_id')]);

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
			$post  = $this->input->post('Employee_qo');
			
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
			$this->db->insert('quotation_order_history', $value);
			$this->db->flush_cache();

			unset($post['approved']);
			unset($post['note']);

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			$this->session->set_flashdata('message', 'Quotation berhasil di proses');

			redirect('salesqo/index','location');
		}
		
		$params['page'] = 'salesqo/proccess';
		$params['data'] = $model;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [printqo description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printqo($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/employeeqo/printpo', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Quotation ".date('d M Y')." - ". $params['data']['customer'] .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");
	}

	/**
	 * [printom description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printom($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/employeeqo/om', $params, true);
		
		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "OM ".date('d M Y')." - ". $params['data']['customer'] .".pdf";

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
}
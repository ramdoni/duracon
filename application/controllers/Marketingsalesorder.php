<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketingsalesorder extends CI_Controller {


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
	 * @return html
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'marketingsalesorder/index';
		$params['data'] = $this->model->data_marketing($this->session->userdata('employee_id'));

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
			$post  = $this->input->post('Sik');
			
			$post['create_time'] 		= date('Y-m-d H:i:s');  
			$post['position']			= 1;
			
			$this->db->insert('surat_izin_kirim', $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('marketingsalesorder/index','location');
		}
		
		$params['page'] 	= 'marketingsalesorder/sik_form';
		$params['data'] 	= $model;

		$this->load->view('layouts/main', $params);
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
	 * proccess sales order
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function proccess($id)
	{
		$model = $this->model->get_by_id_sales($id, 'marketing');

		if($this->input->post())
		{
			$post  = $this->input->post('Sales_order');
			
			if($post['approved'] == 1){
				$post['position'] = 3; 
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

			redirect('marketingsalesorder/index','location');
		}
		
		$params['page'] = 'marketingsalesorder/proccess';
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
}

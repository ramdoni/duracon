<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeeso extends CI_Controller {


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

		$params['page'] = 'employeeso/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [soselesai description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function soselesai($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->update('sales_order', ['position' => 6]);

		$so = $this->db->get_where('sales_order', ['id' => $id])->row_array();

		$this->session->set_flashdata('messages', 'Sales Order #'. $so['no_so'] .' sudah selesai');	
		
		redirect('employeeso/index','location');
	}

	/**
	 * [submitapprove description]
	 * @return [type] [description]
	 */
	public function submitapprove($id)
	{		
		$this->db->where(['id' => $id]);
		$this->db->update('sales_order', ['position' => 5]);

		$this->session->set_flashdata('messages', 'Sales Order berhasil diapprove');	

		// insert history
		$value['quotation_order_id'] = $id;
		$value['status'] = 2;
		$value['position'] = 4;
		$value['employee_id'] = $this->session->userdata('employee_id');
		$value['create_time'] = date('Y-m-d H:i:s');
		$value['note'] = "Sales Order diapprove oleh Admin";

		$this->db->insert('sales_order_history', $value);
		$this->db->flush_cache();
		
		redirect('employeeso/index','location');
	}

	/**
	 * [assignproduksi description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function assignproduksi($id=0)
	{
		if(!empty($id)){
			$this->db->where(['id' => $id]);
            $this->db->update($this->model->t_table, ['position' => 5]);
		}

		redirect('employeeso/index');
	}

	/**
	 * [approve description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function approve($id)
	{
		$model = $this->model->get_by_id($id);
		
		$params['data'] = $model;		
		$params['page'] = 'employeeso/form_approve';

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
			$post  = $this->input->post('Employee_so');
			$post['employee_id'] = $this->session->userdata('employee_id');
			$post['create_time'] = date('Y-m-d H:i:s');

			if($post['proccess'] == 1)
			{
				$post['position'] = 2;
			}else{
				$post['position'] = 1;
			}

			unset($post['proccess']);

			$this->db->insert($this->model->t_table, $post);
			
			$this->session->set_flashdata('messages', 'Data berhasil disimpan');
			
			redirect('employeeso/index','location');
		}
			
		$count = $this->db->get('sales_order')->num_rows();

		$params['no_so'] = ($count + 1).'/SO/JKT/'.date('d').'/'.toRomawi(date('m')).'/'.date('y');
		$params['page'] = 'employeeso/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Employee_so');
			$post['update_time'] = date('Y-m-d H:i:s');

			if($post['proccess'] == 1)
			{
				$post['position'] = 2;
				
				$this->session->set_flashdata('messages', 'Data berhasil diproses');

			}else{
				$post['position'] = 1;
				
				$this->session->set_flashdata('messages', 'Data berhasil disimpan');
			}

			unset($post['proccess']);

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			redirect('employeeso/index','location');
		}
		
		$params['page'] = 'employeeso/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		$this->session->set_flashdata('messages', 'Data berhasil dihapus');

		redirect(site_url('employeeso'));
	}

	public function printso($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		$params['qo']	= $this->db->get_where('quotation_order', ['id' => $params['data']['quotation_order_id']])->row_array();

		//$this->load->view('pages/employeeso/printso', $params);

		
		$html = $this->load->view('pages/employeeso/printso', $params, true);

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

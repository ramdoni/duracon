<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managerso extends CI_Controller {


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

			

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Salesorder_model');
		$this->model = $this->Salesorder_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'manager/so/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function proccess($id)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Sales_order');
			
			if($post['approved'] == 1){
				$post['position'] = 5; 
				$status  = 2; // Approved
				$position = 4;
			}else{
				$post['position'] = 1;

				$status  = 3; // Rejected
				$position = 4; 
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

			$this->session->set_flashdata('messages', 'Data berhasil diproses');

			redirect('managerso/index','location');
		}
		
		$params['page'] = 'manager/so/form';
		$params['data'] = $model;

		$this->load->view('layouts/main', $params);
	}
}

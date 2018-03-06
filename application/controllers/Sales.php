<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {


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
		$this->load->model('sales_model');
		$this->model = $this->sales_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'sales/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Sales');
			$post['create_time'] = date('Y-m-d H:i:s');
			$post['is_active'] = 1;
			$post['password'] = md5($post['password']);

			if($this->db->insert($this->model->t_table, $post)):
				$success++;
			else:
				$error++;
			endif;

			redirect('sales/index','location');
		}
		
		$params['page'] = 'sales/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Sales');
			$post['update_time'] = date('Y-m-d H:i:s');
			
			if(!empty($post['password'])){
				$post['password'] = md5($post['password']);
			}
			
			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			redirect('sales/index','location');
		}
		
		$params['page'] = 'sales/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('employee'));
	}
}

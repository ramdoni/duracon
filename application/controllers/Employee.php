<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

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
		$this->load->model('Employee_model');
		$this->model = $this->Employee_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'employee/index';
		$params['data'] = $this->model->data_user();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Employee');
			$post['password'] = md5($post['password']);
			$post['create_time'] = date('Y-m-d H:i:s');
			$post['is_active'] = 1;

			$this->db->insert($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('employee/index','location');
		}
		
		$params['page'] = 'employee/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Employee');

			if(!empty($post['password'])){
				$post['password'] = md5($post['password']);				
			}else{
				unset($post['password']);
			}
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('employee/index','location');
		}
		
		$params['page'] = 'employee/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		$this->session->set_flashdata('messages', 'Data berhasil disimpan');

		redirect(site_url('employee'));
	}
}

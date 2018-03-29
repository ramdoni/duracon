<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeeaccess extends CI_Controller {


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
		$this->load->model('employeeaccess_model');
		$this->model = $this->employeeaccess_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'employeeaccess/index';
		$params['data'] = $this->model->data_employee();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('employeepo');

			$this->db->insert($this->mode->t_table, $post);

			redirect('employeepo/index','location');
		}
		
		$params['page'] = 'employeepo/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('User');

			if(!empty($post['password'])){
				$post['password'] = md5($post['password']);				
			}
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_user, $post);

			redirect('user/index','location');
		}
		
		$params['page'] = 'user/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_user);

		redirect(site_url('user'));
	}
}

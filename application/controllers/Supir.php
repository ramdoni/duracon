<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supir extends CI_Controller {


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
		$this->load->model('Supir_model');
		$this->model = $this->Supir_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'supir/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Supir');
			$post['create_time'] = date('Y-m-d H:i:s');
			
			$this->db->insert('supir', $post);

			$this->session->set_flashdata('messages', 'Data supir berhasil disimpan');

			redirect('supir/index','location');
		}
		
		$params['page'] = 'supir/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Supir');
			
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data supir  berhasil disimpan');

			redirect('user/index','location');
		}
		
		$params['page'] = 'supir/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('supir'));
	}
}

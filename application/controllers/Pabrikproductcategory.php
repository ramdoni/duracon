<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pabrikproductcategory extends CI_Controller {


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
		$this->load->model('Productcategory_model');
		$this->model = $this->Productcategory_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'pabrikproductcategory/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Pabrikproductcategory');
			$post['create_time'] = date('Y-m-d H:i:s');
			
			$this->db->insert($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('pabrikproductcategory/index','location');
		}
		
		$params['page'] = 'pabrikproductcategory/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Pabrikproductcategory');
			
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

            $this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('pabrikproductcategory/index','location');
		}
		
		$params['page'] = 'pabrikproductcategory/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		$this->session->set_flashdata('messages', 'Data berhasil dihapus');

		redirect(site_url('pabrikproductcategory'));
	}
}

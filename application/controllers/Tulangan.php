<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tulangan extends CI_Controller {

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
		$this->load->model('Tulangan_model');
		$this->model = $this->Tulangan_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'tulangan/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('tulangan');
			$post['create_time'] = date('Y-m-d H:i:s');
			$this->db->insert($this->model->t_table, $post);
			
			redirect('tulangan/index','location');
		}
		
		$params['page'] = 'tulangan/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('tulangan');
			
			$post['update_time'] = date('Y-m-d H:i:s');
            
            $data_lama = $this->db->get_where('tulangan', ['id' => $id])->row_array();

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

            if($data_lama['stock']!= $post['stock']){

            	$var['user_id']		= $this->session->userdata('employee_id');
            	$var['stock_lama']	= $data_lama['stock'];
            	$var['stock_baru']	= $post['stock'];
            	$var['date']		= date('Y-m-d H:i:s');

            	$this->db->insert('tulangan_history_stock', $var);
            }

			redirect('tulangan/index','location');
		}
		
		$params['page'] = 'tulangan/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('products'));
	}
}

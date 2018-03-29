<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {


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
		$this->load->model('Employeeso_model');
		$this->model = $this->Employeeso_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'produksi/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}
	
	public function done($id=0)
	{
		if(!empty($id)){
			$this->db->where(['id' => $id]);
            $this->db->update($this->model->t_table, ['position' => 7]);
		}

		redirect('produksi/index');
	}

	public function proccess($id=0)
	{
		if(!empty($id)){
			$this->db->where(['id' => $id]);
            $this->db->update($this->model->t_table, ['position' => 6]);
		}

		redirect('produksi/index');
	}

	public function revisi($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Employee_so');

			if($post['proccess'] == 1)
			{
				$data_revisi = json_encode($post);
				$params['position'] = 5;
				$params['status'] = 4;
				$params['value'] = $data_revisi;
				$params['employee_id'] = $this->session->userdata('employee_id');
				$params['employee_po_id'] = $model['employee_po_id'];
				$params['create_time'] = date('Y-m-d H:i:s');

				$this->db->insert('employee_so_history', $params);
				$post['position'] = 4;
			}
			
			$post['update_time'] = date('Y-m-d H:i:s');

			unset($post['proccess']);

			$this->db->flush_cache();			
			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			redirect('produksi/index','location');
		}
		
		$params['page'] = 'produksi/revisi';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function detail($id)
	{
		$model = $this->model->get_by_id($id);

		$params['page'] = 'produksi/detail';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}
}

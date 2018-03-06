<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arqo extends CI_Controller {


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
		$this->load->model('Quotationorder_model');
		$this->model = $this->Quotationorder_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'ar/qo/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function proccess($id)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Employee_qo');
			
			if($post['approved'] == 1){
				$post['position'] = 4; // Manager
				$status  = 2; // Approved
				$position = 3; // AR
			}else{
				$post['position'] = 1;

				$status  = 3; // Rejected
				$position = 3; // AR
			}

			// insert history
			$value['quotation_order_id'] = $id;
			$value['status'] = $status;
			$value['position'] = $position;
			$value['employee_id'] = $this->session->userdata('employee_id');
			$value['create_time'] = date('Y-m-d H:i:s');
			$value['note'] = $post['note'];

			$this->db->insert('quotation_order_history', $value);
			$this->db->flush_cache();

			unset($post['approved']);
			unset($post['note']);

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			redirect('arqo/index','location');
		}

		$this->db->from('quotation_order_revisi');
		$this->db->order_by('id', 'DESC');
		$this->db->where(['quotation_order_id' => $id]);

		$rev = $this->db->get()->row_array();
		
		if(isset($rev))
		{
			if($rev['sistem_pembayaran'] != "") $rev['sistem_pembayaran'] = '<small>Revisi dari </small> '.  $rev['sistem_pembayaran'] .' <small>ke</small> ';
		}

		$params['rev'] = $rev;
		$params['page'] = 'ar/qo/form';
		$params['data'] = $model;

		$this->load->view('layouts/main', $params);
	}
}

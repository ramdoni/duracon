<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datastok extends CI_Controller {


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
		$this->load->model('Products_model');
		$this->model = $this->Products_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'pabrikproduct/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [edit description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Pabrikproduct');
			
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			/**
			 * cek stok yang dirubah
			 * @var array
			 */
			$param_history_stock = [];
			if($post['stock'] != $model['stock'])
			{
				$param_history_stock['stock'] = $post['stock'];
				$param_history_stock['stock_lama'] = $model['stock'];
			}
			if($post['repair'] != $model['repair'])
			{
				$param_history_stock['repair'] = $post['repair'];
				$param_history_stock['repair_lama'] = $model['repair'];
			}
			if($post['reject'] != $model['reject'])
			{
				$param_history_stock['reject'] = $post['reject'];
				$param_history_stock['reject_lama'] = $model['reject'];
			}
			if($post['finishing'] != $model['finishing'])
			{
				$param_history_stock['finishing'] = $post['finishing'];
				$param_history_stock['finishing_lama'] = $model['finishing'];
			}	


			if(isset($param_history_stock))
			{
				$param_history_stock['product_id'] = $id;
				$param_history_stock['user_id'] 	= $this->session->userdata('employee_id');
				$param_history_stock['create_time']	= date('Y-m-d H:i:s');
				$param_history_stock['keterangan'] 	= $post['keterangan'];

            	$this->db->insert('product_history_stock', $param_history_stock);
			}

            $this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('datastok/index','location');
		}
		
		$params['page'] = 'pabrikproduct/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	/**
	 * [historyperubahanstock description]
	 * @return [type] [description]
	 */
	public function historyperubahanstock($id)
	{
		$this->load->model('Producthistorystock_model');
		
		$model = $this->Producthistorystock_model->get_by_id($id, 'product_id');

		$params['product']	= $this->db->get_where('products',['id' => $id])->row_array();
		$params['page'] 	= 'pabrikproduct/historystock';
		$params['data'] 	= $model;
		
		$this->load->view('layouts/main', $params);
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salestarget extends CI_Controller {


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
		$this->load->model('Salestarget_model');
		$this->model = $this->Salestarget_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'salestarget/index';
		$params['data'] = $this->model->get_data_sales();

		$this->load->view('layouts/main', $params);
	}
}

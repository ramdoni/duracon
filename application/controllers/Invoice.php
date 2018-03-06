<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {


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
			if($access != 10 and $access != 6) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Invoice_model');
		$this->model = $this->Invoice_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'invoice/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
		{
			$params['data'] = $this->model->data_($_GET);
		}

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [create description]
	 * @return [type] [description]
	 */
	public function create()
	{
		$params = [];
		$params['page'] = 'invoice/form';

		$this->load->view('layouts/main', $params);
	}
}

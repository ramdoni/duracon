<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesdispensasi extends CI_Controller {


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
			// sales dan admin
			if($access != 3) {
				redirect('site/index?access=forbidden');
			}
			
			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		
		$this->load->model('Dispensasi_model');
		$this->model = $this->Dispensasi_model;
	}

	/**
	 * @return html
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'salesdispensasi/index';
		$params['data'] = $this->model->data_('sales');

		$this->load->view('layouts/main', $params);
	}
}

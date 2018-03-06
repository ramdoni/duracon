<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportjadwalproduksi extends CI_Controller {

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
		
		$this->load->model('Productschedule_model');
		$this->load->model('Productscheduleplan_model');

		$this->model = $this->Productschedule_model;
		$this->load->library("PHPExcel");
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];
		
		if($_GET)
		{	
			$data = $this->db->query("SELECT * FROM product_schedule where bulan={$_GET['bulan']} and YEAR(create_time)={$_GET['tahun']} ORDER BY minggu ASC")->result_array();
			$params['data'] = $data;
		}

		$params['page'] = 'reportproduksipengecoran/index';

		$this->load->view('layouts/main', $params);
	}
}

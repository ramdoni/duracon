<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('Employee_model');
		$this->model = $this->Employee_model;
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$params = [];
		$params['page'] = 'home-blank';

		if($this->session->userdata('access_id') == 1)
			$params['page'] = 'home';

		if($this->session->userdata('access_id') == 7){
			$this->load->model('Producthistorystock_model');
    
            $params['data'] = $this->Producthistorystock_model->data_();
			$params['page'] = 'home-produksi';
		}

		if($this->session->userdata('access_id') == 6){
			$params['page'] = 'home-ar';
		}

		if($this->session->userdata('access_id') == 9)
		{
			$this->load->model('Tandaterima_model');
			$this->model = $this->Tandaterima_model;
			
			$params['data'] = $this->model->data_();
			$params['page'] = 'home-kolektor';
		}

		// cek custome old or no
		$this->cek_customer_old();	

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [cek_customer_old description]
	 * @return [type] [description]
	 */
	public function cek_customer_old()
	{
		$customer = $this->db->get('customer')->result_array();
		
		foreach($customer as $item)
		{
			$start_date  = date('Y-m-d', strtotime($item['create_time'].' +1 years'));
			$end_date  = date('Y-m-d');
			
			if($start_date <= $end_date)
			{
				$this->db->update('customer', ['kategori_customer' => 'Old']);
			}
		}
	}
}

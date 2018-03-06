<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controller Login
 * @by		: doni (doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/

class Login extends CI_Controller {

	/**
	 * Constructor
	 * @param  -
	 * @return -
	 **/
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data[''] = '';
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[2]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[2]|max_length[20]|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="msg-error"><p>', '</p></div>');

		if ($this->form_validation->run() == FALSE):
			$this->load->view('login-v2');
		else:
			if ($this->input->post('username') and $this->input->post('password')):
				
				$username = $this->input->post('username');
				$password = $this->input->post('password');		
				$query = $this->db->query("SELECT * FROM user WHERE username='".$username."' AND password='". md5($password) ."' AND active=1");		
				
				// set setting
				$data = $this->db->get_where('setting', ['id' => 1]);
				$data = $data->row_array();

				$this->session->set_userdata('meta_title', $data['meta_title']);
				$this->session->set_userdata('meta_description', $data['meta_description']);

				if ($row = $query->row()):

					$group = $this->db->get_where('user_group', ['id' => $row->user_group_id])->row();

					$this->session->set_userdata('username', $row->username);
					$this->session->set_userdata('name', $row->name);
					$this->session->set_userdata('phone', $row->phone);
					$this->session->set_userdata('id_user', $row->id);
					$this->session->set_userdata('user_id', $row->id);
					$this->session->set_userdata('employee_id', $row->id);
					$this->session->set_userdata('access_id', $row->user_group_id);
					$this->session->set_userdata('foto', $row->foto);
					$this->session->set_userdata('group', $group->user_group);
					
					redirect('home', 'location');
				else:
					$this->data['incorrect_login'] = true;
				endif;

				/*
				$username = $this->input->post('username');
				$password = $this->input->post('password');		
				$query = $this->db->query("SELECT * FROM employee WHERE username='".$username."' AND password='". md5($password) ."'");		
				
				// set setting
				$data = $this->db->get_where('setting', ['id' => 1]);
				$data = $data->row_array();

				$this->session->set_userdata('meta_title', $data['meta_title']);
				$this->session->set_userdata('meta_description', $data['meta_description']);

				if ($row = $query->row()):

					$this->session->set_userdata('username', $row->username);
					$this->session->set_userdata('name', $row->name);
					$this->session->set_userdata('id_user', $row->id);
					$this->session->set_userdata('employee_id', $row->id);
					$this->session->set_userdata('access_id', $row->employee_access_id);

					redirect('home', 'location');
				else:
					$this->data['incorrect_login'] = true;
				endif;

				// jika login failed cek sebagai sales
				$query = $this->db->query("SELECT * FROM sales WHERE username='".$username."' AND password='". md5($password) ."'");		
				if ($row = $query->row()):

					$this->session->set_userdata('username', $row->username);
					$this->session->set_userdata('name', $row->name);
					$this->session->set_userdata('id_user', $row->id);
					$this->session->set_userdata('employee_id', $row->id);
					$this->session->set_userdata('access_id', 6); // access sales 

					redirect('home', 'location');
				else:
					$this->data['incorrect_login'] = true;
				endif;

				// jika login failed cek sebagai marketing
				$query = $this->db->query("SELECT * FROM marketing WHERE username='".$username."' AND password='". md5($password) ."'");		
				if ($row = $query->row()):

					$this->session->set_userdata('username', $row->username);
					$this->session->set_userdata('name', $row->name);
					$this->session->set_userdata('id_user', $row->id);
					$this->session->set_userdata('employee_id', $row->id);
					$this->session->set_userdata('access_id', 7); // access marketing 

					redirect('home', 'location');
				else:
					$this->data['incorrect_login'] = true;
				endif;
				*/
			
			endif;
			$this->load->view('login-v2', $this->data);
		endif;
	}

	public function v2()
	{
		$this->data[''] = '';

		$this->load->view('login-v2', $this->data);

	}
}

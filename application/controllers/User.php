<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


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
		$this->load->model('User_model');
		$this->model = $this->User_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'user/index';
		$params['data'] = $this->model->data_user();

		$this->load->view('layouts/main', $params);
	}

	public function profile()
	{
		$params = [];

		$params['page'] = 'user/index';
		$params['data'] = $this->model->data_user();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('User');
			$post['password'] = md5($post['password']);
			$post['create_time'] = date('Y-m-d H:i:s');
			
			$this->db->insert('user', $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('user/index','location');
		}
		
		$params['page'] = 'user/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('User');

			if(!empty($post['password'])){
				$post['password'] = md5($post['password']);				
			}else{
				unset($post['password']);
			}
			
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('user/index','location');
		}
		
		$params['page'] = 'user/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	/**
	 * [unlock description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function unlock($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->update('user', ['is_lock' => 0]);

		$this->session->set_flashdata('messages', 'User Sales berhasil di unlock');

		redirect('user/index','location');
	}
	
	/**
	 * [lock description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function lock($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->update('user', ['is_lock' => 1]);

		$this->session->set_flashdata('messages', 'User Sales berhasil di lock');

		redirect('user/index','location');
	}

	/**
	 * [delete description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('user'));
	}

	/**
	 * Logout
	 * @param  -
	 * @return -
	 **/
	public function signout()
	{
		$this->session->sess_destroy();
		redirect('login', 'location');
	}
}

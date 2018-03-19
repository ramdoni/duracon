<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {


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
	}

	public function index()
	{
		$params['page'] = 'index';
		
		$this->load->view('layouts/main', $params);
	}

	public function setting()
	{
		$data = $this->db->get_where('setting', ['id' => 1]);
		
		$this->load->model('User_model');
		
		if($this->input->post())
		{
			$post = $this->input->post('User');

			$this->db->where(['id' => $this->session->userdata('user_id')]);
			$this->db->update('user', $post);
		}

		$params['page'] 	= 'setting';
		$params['data'] 	=  $data->row_array();
		$params['profile'] 	= $this->User_model->get_by_id($this->session->userdata('employee_id'));

		$this->load->view('layouts/main', $params);
	}

	public function changepassword()
	{
		$post = $this->input->post('User');

		$cek_user = $this->db->get_where('user', ['id' => $this->session->userdata('user_id'), 'password' => md5($post['password_lama'])])->num_rows();

		if($cek_user == 0)
		{
			$this->session->set_flashdata('error', 'Password lama anda salah.');

			redirect('/site/setting');
		}else{
			if($post['password_baru'] != $post['password_baru2'])
			{
				$this->session->set_flashdata('error', 'Password Baru dan Ketik Ulang Password Baru tidak sama, silahkan di coba kembali.');

				redirect('/site/setting');
			}else{
				$this->db->where(['id' => $this->session->userdata('user_id')]);
				$this->db->update('user', ['password' => md5($post['password_baru'])]);

				$this->session->set_flashdata('messages', 'Password berhasil dirubah.');

				redirect('/site/setting');
			}
		}

	}

	/**
	 * [changephoto description]
	 * @return [type] [description]
	 */
	public function changephoto()
	{
		$post = $this->input->post();

		$path = FCPATH .'upload/photo/'. $post['id'];
		
		@mkdir(  $path, 0777 , true );

		# upload file
		$config = Array();
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000';
		$config['max_width'] 		= '2000';
		$config['max_height']		= '2000';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload("foto")):
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		else:

			$upload_data = $this->upload->data();
			
			$this->db->where(['id' => $post['id']]);
			$this->db->update('user', ['foto' => $upload_data['file_name']]);

			$profile = $this->db->get_where('user', ['id' => $post['id']])->row_array();

			$this->session->set_userdata('foto', $profile['foto']);

			$this->session->set_flashdata('messages', 'Foto berhasil di rubah.');

			redirect('/site/setting');

		endif;
	}
}




<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobil extends CI_Controller {


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
			if($access != 8) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Mobil_model');
		$this->model = $this->Mobil_model;
	}
	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'mobil/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [insert description]
	 * @return [type] [description]
	 */
	public function insert()
	{
		if($this->input->post())
		{
			$post  			= $this->input->post('Mobil');
			$post['date'] 	= date('Y-m-d H:i:s');

			$this->db->insert($this->model->t_table, $post);
			
			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('mobil/index','location');
		}
		
		$params['page'] = 'mobil/form';

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
			$post  = $this->input->post('Mobil');
			$post['date'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
            $this->db->flush_cache();

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('mobil/index','location');
		}
		
		$params['page'] = 'mobil/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
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

		$this->session->set_flashdata('messages', 'Data berhasil dihapus');

		redirect(site_url('mobil'));
	}
}

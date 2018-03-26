<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {


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
		$this->load->model('Area_model');
		$this->model = $this->Area_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'area/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Area');
			$post['create_time'] = date('Y-m-d H:i:s');

			$this->db->insert($this->model->t_table, $post);

			$id = $this->db->insert_id();
            $this->db->flush_cache();

			$lokasi = $this->input->post('LokasiForm');
			if(isset($lokasi))
            {
				foreach($lokasi as $i)
				{
					$param = [];
					$param['area_id'] = $id;
					$param['create_time'] = date('Y-m-d H:i:s');
					$param['provinsi_id'] = $i['provinsi_id'];
					$param['kabupaten_id'] = $i['kabupaten_id'];
					$param['kecamatan_id'] = $i['kecamatan_id'];
					$param['kelurahan_id'] = $i['kelurahan_id'];

					$this->db->insert('area_kelurahan', $loc);
					$this->db->flush_cache();
				}
			}

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('area/index','location');
		}
		
		$params['page'] = 'area/form';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [hapus_area_kelurahan description]
	 * @return [type] [description]
	 */
	public function hapus_area_kelurahan()
	{
		$this->db->where(['id' => $_GET['id']]);
		$this->db->delete('area_kelurahan');

		redirect('area/edit/'. $_GET['area_id']);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Area');
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
            $this->db->flush_cache();

            $lokasi = $this->input->post('LokasiForm');
           
            if(isset($lokasi))
            {
				foreach($lokasi as $i)
				{
					$param = [];
					$param['area_id'] = $id;
					$param['create_time'] = date('Y-m-d H:i:s');
					$param['provinsi_id'] = $i['provinsi_id'];
					$param['kabupaten_id'] = $i['kabupaten_id'];
					$param['kecamatan_id'] = $i['kecamatan_id'];
					$param['kelurahan_id'] = $i['kelurahan_id'];

					$this->db->insert('area_kelurahan', $param);
					$this->db->flush_cache();
				}
			}

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('area/index','location');
		}
		
		$params['page'] = 'area/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		$this->session->set_flashdata('messages', 'Data berhasil dihapus');

		redirect(site_url('area'));
	}
}

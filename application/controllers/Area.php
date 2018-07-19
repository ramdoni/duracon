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

	/**
	 * [import description]
	 * @return [type] [description]
	 */
	public function import()
	{
		$params['page'] = 'area/import';
		if($this->input->post())
		{
			$post = $this->input->post();
			# upload file
			$config = Array();
			$config['upload_path'] 		= './upload/';
			$config['allowed_types'] 	= '*';
			$config['max_size']			= '20000';
			$config['max_width'] 		= '20000';
			$config['max_height']		= '20000';

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload("file")):
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			else:

				$upload_data = $this->upload->data();
				
				// Load the spreadsheet reader library
				$this->load->library('Excel_reader');

				$this->excel_reader->setOutputEncoding('230787');
				$file = $upload_data['full_path'];
				$this->excel_reader->read($file);
				error_reporting(E_ALL ^ E_NOTICE);

				$data = $this->excel_reader->sheets[0];
				
			    for ($i = 1; $i <= $data['numRows']; $i++) {
			        
			        if($i==1 or $i == 2) continue;

			        // find area
			        $area = $this->db->query("SELECT * FROM area where area LIKE '%Area ". $data['cells'][$i][5] ."%'")->row_array();

					if($area)
					{
						$provinsi = $this->db->query("SELECT * FROM provinsi where nama LIKE '%". $data['cells'][$i][1] ."%'")->row_array();
						if(!$provinsi) continue;

						$kabupaten = $this->db->query("SELECT * FROM kabupaten where id_prov=". $provinsi['id_prov'] ." AND nama LIKE '%". $data['cells'][$i][2] ."%'")->row_array();
						if(!$kabupaten) continue;
						
						$kecamatan = $this->db->query("SELECT * FROM kecamatan where id_kab=". $kabupaten['id_kab'] ." AND nama LIKE '%". $data['cells'][$i][3] ."%'")->row_array();
						if(!$kecamatan) continue;

						$kelurahan = $this->db->query("SELECT * FROM kelurahan where id_kec=". $kecamatan['id_kec'] ." AND nama LIKE '%". $data['cells'][$i][4] ."%'")->row_array();
						if(!$kelurahan) continue;

						$dataexcel = [];
				        $dataexcel['provinsi_id'] 		= $provinsi['id_prov'];
				        $dataexcel['kabupaten_id'] 		= $kabupaten['id_kab'];
				        $dataexcel['kecamatan_id'] 		= $kecamatan['id_kec'];
				        $dataexcel['kelurahan_id'] 		= $kelurahan['id_kel'];
				        $dataexcel['area_id'] 			= $area['id'];

				        $this->db->insert('area_kelurahan', $dataexcel);
				    }
			    }
				
				//delete file
	            $file = $config['upload_path'] . $upload_data['file_name'];
				unlink($upload_data['full_path']);

				redirect(site_url('area/?import=1&success=true'));
			endif;
		}
		
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

					$this->db->insert('area_kelurahan', $param);
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

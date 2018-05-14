<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spesifikasi extends CI_Controller {


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
		$this->load->model('Spesifikasi_model');
		$this->model = $this->Spesifikasi_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'spesifikasi/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}



	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('ProductSpecification');
			$post['create_time'] = date('Y-m-d H:i:s');

			$this->db->insert($this->model->t_table, $post);

			redirect('spesifikasi/index','location');
		}
		
		$params['page'] = 'spesifikasi/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('ProductSpecification');
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			redirect('spesifikasi/index','location');
		}
		
		$params['page'] = 'spesifikasi/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('spesifikasi'));
	}

	/**
	 * [import description]
	 * @return [type] [description]
	 */
	public function import()
	{
		$params['page'] = 'spesifikasi/import';
		
		if($this->input->post())
		{
			$post = $this->input->post();
			# upload file
			$config = Array();
			$config['upload_path'] 		= './upload/';
			$config['allowed_types'] 	= '*';
			$config['max_size']			= '2000';
			$config['max_width'] 		= '2000';
			$config['max_height']		= '2000';

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
			        
			        if ($data['cells'][$i][1] == '') continue;

			        if($i==1) continue;

					$dataexcel = [];
			        $dataexcel['spesifikasi'] 		= $data['cells'][$i][1];
			        $dataexcel['sistem_produksi'] 	= $data['cells'][$i][2];
			        $dataexcel['mutu_beton'] 		= $data['cells'][$i][3];
			        $dataexcel['mutu_baja'] 		= $data['cells'][$i][4];
			        $dataexcel['tipe_semen'] 		= $data['cells'][$i][5];
			        $dataexcel['system_joint'] 		= $data['cells'][$i][6];
			        $dataexcel['active'] 			= 1;

			        $this->db->insert('product_specification', $dataexcel);
			    }
				
				//delete file
	            $file = $config['upload_path'] . $upload_data['file_name'];
				unlink($upload_data['full_path']);

				redirect(site_url('spesifikasi/?import=1&success=true'));
			endif;
		}
		
		$this->load->view('layouts/main', $params);
	}
}

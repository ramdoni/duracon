<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {


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
		$this->load->model('products_model');
		$this->model = $this->products_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'products/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	public function import()
	{
		$params['page'] = 'products/import';
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
			        $dataexcel['kode'] = $data['cells'][$i][1];
			        $dataexcel['uraian'] = $data['cells'][$i][2];
			        $dataexcel['satuan'] = $data['cells'][$i][3];
			        $dataexcel['weight'] = $data['cells'][$i][4];
			        $dataexcel['price'] = $data['cells'][$i][5];
			        $dataexcel['keterangan'] = $data['cells'][$i][6];
			        $dataexcel['biaya_setting'] = $data['cells'][$i][7];

			        $this->db->insert('products', $dataexcel);
			    }
				
				//delete file
	            $file = $config['upload_path'] . $upload_data['file_name'];
				unlink($upload_data['full_path']);

				redirect(site_url('products/?import=1&success=true'));
			endif;
		}
		
		$this->load->view('layouts/main', $params);
	}

	public function export()
	{
		$filename = "products-".date('Y-m-d').".xls";
		$header = "";
		$content = "";

		$titleHeader = "Products";
		$header .= $titleHeader ."\n";
		
		# title excel 
		$header .= "No"."\t";
		$header .= "Code"."\t";
		$header .= "Uraian"."\t";
		$header .= "Satuan"."\t";
		$header .= "Weight"."\t";
		$header .= "Selling Price"."\t";
		$header .= "\n";
		
		$output = "";
		$i = $this->db->get($this->model->t_table);
		$no = 2;
		foreach ($i->result_array() as $row):
			$content .=$no." \t ";
			$content .=$row['kode']." \t ";
			$content .=$row['uraian']." \t ";
			$content .=$row['satuan']." \t ";
			$content .=$row['weight']." \t ";
			$content .=$row['price']." \t ";
			$content .=" \n ";
			$no++;
		endforeach;
		$output .= $header.$content;
		header('Content-type:application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		die;
	}
	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('products');

			$this->db->insert($this->model->t_table, $post);
			$insert_id = $this->db->insert_id();
			$this->db->flush_cache();
			
			/*
			$area = $this->input->post('area_id');
			$biaya = $this->input->post('area_biaya_setting');

			foreach($area as $k => $i){
				$param = [];
				$param['product_id'] = $insert_id;
				$param['area_id'] = $i;
				$param['biaya'] = $biaya[$k];

				$this->db->insert('product_biaya_area', $param);
				$this->db->flush_cache();
			}
			*/

			redirect('products/index','location');
		}
		
		$params['page'] = 'products/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('products');
			
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();
			
			/*
			$this->db->where('product_id', $id);
			$this->db->delete('product_biaya_area');
			$this->db->flush_cache();

			$area = $this->input->post('area_id');
			$biaya = $this->input->post('area_biaya_setting');

			foreach($area as $k => $i)
			{
				$param = [];
				$param['product_id'] = $id;
				$param['area_id'] = $i;
				$param['biaya'] = $biaya[$k];

				$this->db->insert('product_biaya_area', $param);
				$this->db->flush_cache();
			}
			*/

			redirect('products/index','location');
		}
		
		$params['page'] = 'products/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('products'));
	}
}

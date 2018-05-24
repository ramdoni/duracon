<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {


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
		$this->load->model('Customer_model');
		$this->model = $this->Customer_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'customer/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}
	
	/**
	 * [import description]
	 * @return [type] [description]
	 */
	public function import()
	{
		$params['page'] = 'customer/import';
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

			        if($i <=2 ) continue;

					$dataexcel = [];
			        $dataexcel['tipe_customer'] 	= $data['cells'][$i][1];
			        $dataexcel['company'] 			= $data['cells'][$i][2];
			        $dataexcel['name'] 				= $data['cells'][$i][3];
			        $dataexcel['email'] 			= !empty($data['cells'][$i][4]) ? $data['cells'][$i][4] : '';
			        $dataexcel['telphone'] 			= !empty($data['cells'][$i][5]) ? $data['cells'][$i][5] : '';
			        $dataexcel['handphone'] 		= !empty($data['cells'][$i][6]) ? $data['cells'][$i][6] : '';
			        $dataexcel['fax'] 				= !empty($data['cells'][$i][7]) ? $data['cells'][$i][7] : '';
			        $dataexcel['address'] 			= !empty($data['cells'][$i][8]) ? $data['cells'][$i][8] : '';
			        $dataexcel['active'] 			= 1;

			        // find sales
			        $sales = $this->db->query("SELECT * FROM user where name LIKE '%". $data['cells'][$i][9] ."%' AND user_group_id=3")->row_array();
					if($sales)
					{
						$dataexcel['sales_id'] 			= $sales['id'];
					}
			        $dataexcel['kode'] 				= $data['cells'][$i][10];
			        $dataexcel['sistem_pembayaran'] = $data['cells'][$i][11];

			        $this->db->insert('customer', $dataexcel);
			    }
				
				//delete file
	            $file = $config['upload_path'] . $upload_data['file_name'];
				unlink($upload_data['full_path']);

				$this->session->set_flashdata('messages', 'Data berhasil di import');

				redirect(site_url('customer/?import=1&success=true'));
			endif;
		}
		
		$this->load->view('layouts/main', $params);
	}

	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Customer');
			$post['create_time'] = date('Y-m-d H:i:s');

			$this->db->insert($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('customer/index','location');
		}
		
		$params['page'] = 'customer/form';

		$this->load->view('layouts/main', $params);
	}

	public function edit($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Customer');
			$post['update_time'] = date('Y-m-d H:i:s');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('customer/index','location');
		}
		
		$params['page'] = 'customer/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		$this->session->set_flashdata('messages', 'Data berhasil dihapus');
		
		redirect(site_url('customer'));
	}
}

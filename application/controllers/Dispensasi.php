<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dispensasi extends CI_Controller {


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
			if($access != 10) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		
		$this->load->model('Dispensasi_model');
		$this->model = $this->Dispensasi_model;
	}

	/**
	 * @return html
	 */
	public function index()
	{
		$params = [];
		$params['page'] = 'dispensasi/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
			$params['data'] = $this->model->data_('all', null, $_GET);

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [reject description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function reject($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->update('dispensasi', ['status' => 2]);

		$this->session->set_flashdata('messages', 'Pengajuan Dispensasi Berhasil di Tolak!');

		redirect('dispensasi');
	}
	/**
	 * [proccess description]
	 * @return [type] [description]
	 */
	public function proccess($id)
	{
		$data  	= $this->model->get_by_id($id);

		if($data['status'] > 1)
		{
			$this->session->set_flashdata('error', 'Dispensasi sudah diproses');

			redirect('dispensasi/index','location');
		}

		if($this->input->post())
		{
			$post = $this->input->post();
			$param = [];

			if($post['status'] == 1)
			{
				$param['status'] 	= 1;
				$nominal = $post['nominal'];
		        $nominal = str_replace('Rp. ','', $nominal);
		        $nominal = str_replace('.', '', $nominal);
				$param['nominal_setujui'] 	= $nominal;

				// get nominal SO
				$so = $this->db->get_where('sales_order', ['id' => $post['sales_order_id']])->row_array();
				$this->db->flush_cache();
				// update deposit dispensasi
				$this->db->where(['id' => $post['sales_order_id']]);
				$this->db->update('sales_order', ['deposit_dispensasi' => $nominal + $so['deposit_dispensasi']]);
				$this->db->flush_cache();
				
			}else{
				$param['status'] = 2;
			}

			$this->db->where(['id'=> $id]);
            $this->db->update('dispensasi', $param);
			$this->db->flush_cache();

			$this->session->set_flashdata('message', 'Pengajuan Dispensasi berhasil di proses');

			redirect('dispensasi/index','location');
		}

		$params = [];
		$params['data'] = $data;
		$params['page'] = 'dispensasi/proccess';

		$this->load->view('layouts/main', $params);
	}
}
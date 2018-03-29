<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsik extends CI_Controller {


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
			//if($access != 6 and $access  != 10) {
			if($access  != 10) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		
		$this->load->model('Suratizinkirim_model');
		$this->model = $this->Suratizinkirim_model;
	}

	/**
	 * @return html
	 */
	public function index()
	{
		$params = [];
		$params['page'] = 'arsik/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
			$params['data'] = $this->model->data_('all', null, $_GET);

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [proccess description]
	 * @return [type] [description]
	 */
	public function proccess($id)
	{
		$this->load->model('Quotationorder_model');

		$sik  	= $this->model->get_by_id($id);
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);

		if($sik['position'] > 1)
		{
			$this->session->set_flashdata('error', 'Surat Izin Kirim sudah diproses');

			redirect('arsik/index','location');
		}

		if($this->input->post())
		{
			$this->db->where('id', $id);
            $this->db->update('surat_izin_kirim', ['position' =>  2]);
			$this->db->flush_cache();

			$this->session->set_flashdata('message', 'Surat Izin Kirim berhasil di proses');

			redirect('arsik/index','location');
		}

		$params = [];

		$params['page'] = 'arsik/proccess';
		$params['so'] 	= $so;
		$params['qo']	= $qo;
		$params['sik']	= $sik;

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [proccessall description]
	 * @return [type] [description]
	 */
	public function proccessall()
	{
		if($this->input->post())
		{
			$post  = $this->input->post('Sik');

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			redirect('arso/index','location');
		}
		
		$params['page'] = 'arsik/proccessall';

		$this->load->view('layouts/main', $params);
	}
}
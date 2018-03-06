<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managersik extends CI_Controller {


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
			// sales dan admin
			if($access != 5) {
				redirect('site/index?access=forbidden');
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

		$params['page'] = 'managersik/index';
		$params['data'] = $this->model->data_();

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

		if($sik['position'] > 2)
		{
			$this->session->set_flashdata('error', 'Surat Izin Kirim sudah diproses');

			redirect('managersik/index','location');
		}

		if($this->input->post())
		{
			$this->db->where('id', $id);
            $this->db->update('surat_izin_kirim', ['position' =>  3]);
			$this->db->flush_cache();

			$this->session->set_flashdata('message', 'Surat Izin Kirim berhasil di proses');

			redirect('managersik/index','location');
		}

		$params = [];

		$params['page'] = 'managersik/proccess';
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

	/**
	 * [lock description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function lock($id)
	{
		// update sik menjadi lock 1
		$this->db->where(['id' => $id]);
		$this->db->update('surat_izin_kirim', ['is_lock' => 1]);
		$this->db->flush_cache();

		$post = $this->input->post();
		// insert ke history
		$this->db->insert('surat_izin_kirim_lock_history', ['surat_izin_kirim_id' => $id, 'status' => 1,'date'=>date('Y-m-d H:i:s'), 'user_unlock_id' => $this->session->userdata('user_id'),'catatan' => $post['catatan']]);

		$this->session->set_flashdata('messages', 'Surat Izin Kirim berhasil di Lock');

		redirect('managersik');
	}	

	/**
	 * [unlock description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function unlock($id)
	{
		// update sik menjadi unlock=0
		$this->db->where(['id' => $id]);
		$this->db->update('surat_izin_kirim', ['is_lock' => 0]);
		$this->db->flush_cache();

		// insert ke history
		$this->db->insert('surat_izin_kirim_lock_history', ['surat_izin_kirim_id' => $id, 'status' => 0,'date'=>date('Y-m-d H:i:s'), 'user_unlock_id' => $this->session->userdata('user_id')]);

		$this->session->set_flashdata('messages', 'Surat Izin Kirim berhasil di Unlock');

		redirect('managersik');
	}	
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managertarget extends CI_Controller {


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
			if($access != 5)
			{
				$this->session->set_flashdata('messages', 'Access Denied');
				redirect('index');
			}

			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Salestarget_model');
		$this->model = $this->Salestarget_model;
	}

	public function index()
	{
		$params = [];

		$params['page'] = 'managertarget/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [create description]
	 * @return [type] [description]
	 */
	public function create()
	{
		if($this->input->post())
		{
			$post  = $this->input->post();
			
			$post['Sales_target']['create_time'] = date('Y-m-d H:i:s');
			
			$quartal_1 = $post['Sales_target']['quartal_1'];
            $quartal_1 = str_replace('Rp. ','', $quartal_1);
            $quartal_1 = str_replace('.', '', $quartal_1);
            $post['Sales_target']['quartal_1'] = $quartal_1;

            $quartal_2 = $post['Sales_target']['quartal_2'];
            $quartal_2 = str_replace('Rp. ','', $quartal_2);
            $quartal_2 = str_replace('.', '', $quartal_2);
            $post['Sales_target']['quartal_2'] = $quartal_2;

            $quartal_3 = $post['Sales_target']['quartal_3'];
            $quartal_3 = str_replace('Rp. ','', $quartal_3);
            $quartal_3 = str_replace('.', '', $quartal_3);
            $post['Sales_target']['quartal_3'] = $quartal_3;

            $quartal_4 = $post['Sales_target']['quartal_4'];
            $quartal_4 = str_replace('Rp. ','', $quartal_4);
            $quartal_4 = str_replace('.', '', $quartal_4);
            $post['Sales_target']['quartal_4'] = $quartal_4;


			$this->db->insert('sales_target', $post['Sales_target']);
			$this->db->flush_cache();

			$sales_user = $post['SalesTargetUser'];
			
			$insert_id = $this->db->insert_id();

			foreach($sales_user as $key => $field)
			{	
				$this->db->insert('sales_target_user', ['user_id' => $field['user_id'], 'sales_target_id' => $insert_id]);
				$this->db->flush_cache();
			}

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('managertarget/index','location');
		}
		
		$params['page'] = 'managertarget/form';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [edit description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function edit($id)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post();
			
			$quartal_1 = $post['Sales_target']['quartal_1'];
            $quartal_1 = str_replace('Rp. ','', $quartal_1);
            $quartal_1 = str_replace('.', '', $quartal_1);
            $post['Sales_target']['quartal_1'] = $quartal_1;

            $quartal_2 = $post['Sales_target']['quartal_2'];
            $quartal_2 = str_replace('Rp. ','', $quartal_2);
            $quartal_2 = str_replace('.', '', $quartal_2);
            $post['Sales_target']['quartal_2'] = $quartal_2;

            $quartal_3 = $post['Sales_target']['quartal_3'];
            $quartal_3 = str_replace('Rp. ','', $quartal_3);
            $quartal_3 = str_replace('.', '', $quartal_3);
            $post['Sales_target']['quartal_3'] = $quartal_3;

            $quartal_4 = $post['Sales_target']['quartal_4'];
            $quartal_4 = str_replace('Rp. ','', $quartal_4);
            $quartal_4 = str_replace('.', '', $quartal_4);
            $post['Sales_target']['quartal_4'] = $quartal_4;
            
			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post['Sales_target']);
			$this->db->flush_cache();
			
			$insert_id = $id;
			$sales_user = $post['SalesTargetUser'];

			foreach($sales_user as $key => $field)
			{	
				$this->db->insert('sales_target_user', ['user_id' => $field['user_id'], 'sales_target_id' => $insert_id]);
				$this->db->flush_cache();
			}

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('managertarget/index','location');
		}
		
		$params['page'] = 'managertarget/form';
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

		redirect(site_url('managertarget'));
	}


}

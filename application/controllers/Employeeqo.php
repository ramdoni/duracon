<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeeqo extends CI_Controller {


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
			if($access != 1 and $access != 2) {
				redirect('site/index?access=forbidden');
			}
			
			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Quotationorder_model');
		$this->model = $this->Quotationorder_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'employeeqo/index';
		$params['data'] = $this->model->data_();

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [approve description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function approve($id)
	{
		$params = [];

		$model = $this->model->get_by_id($id);

		if(!isset($model))
		{
			$this->session->set_flashdata('error', 'No Quotation tidak ditemukan');	
			redirect('employeeqo/index','location');
		}
		$params['data']	= $model;
		$params['page'] = 'employeeqo/form_approve';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [submitapprove description]
	 * @return [type] [description]
	 */
	public function submitapprove($id)
	{		
		$this->db->where(['id' => $id]);
		$this->db->update('quotation_order', ['position' => 5]);

		$this->session->set_flashdata('messages', 'No Quotation berhasil diapprove');	

		// insert history
		$value['quotation_order_id'] = $id;
		$value['status'] = 2;
		$value['position'] = 4;
		$value['employee_id'] = $this->session->userdata('employee_id');
		$value['create_time'] = date('Y-m-d H:i:s');
		$value['note'] = "Quotation diapprove oleh Admin";

		$this->db->insert('quotation_order_history', $value);
		$this->db->flush_cache();

		
		redirect('employeeqo/index','location');
	}
	
	/**
	 * [insert description]
	 * @return [type] [description]
	 */
	public function insert()
	{
		$num =  $this->db->get('quotation_order');
		$params['data']['no_po'] = ($num->num_rows()==0? 1 : ($num->num_rows() +1) ) .'/QUOT/DC/SALES/JKT/'. toRomawi(date('m')).'/'. date('y'); 
		if($this->input->post())
		{
			$post  = $this->input->post('Employee_po');
			$post['employee_id'] = $this->session->userdata('employee_id');

			if($post['proccess'] == 1)
			{
				$post['position'] = 2;

				$this->session->set_flashdata('messages', 'Data berhasil proses');

			}else{
				$post['position'] = 1;
				
				$this->session->set_flashdata('messages', 'Data berhasil disimpan');
			}
			
			unset($post['proccess']);

			if($this->db->insert($this->model->t_table, $post)):
				// insert product

				$insert_id = $this->db->insert_id();

				$product_table = $this->input->post('ProductForm');
				foreach($product_table as $i)
				{
					$param = [];
					$param['quotation_order_id'] = $insert_id;

					foreach($i as $key => $val)
					{
						$param[$key] = $val;
					}

					$this->db->insert('quotation_order_products', $param);
				}
			endif;

			redirect('employeeqo/index','location');
		}
		
		$params['page'] = 'employeeqo/form';

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

		if(!isset($model))
		{
			$this->session->set_flashdata('error', 'No Quotation tidak ditemukan');	
			redirect('employeeqo/index','location');
		}
		
		if($this->input->post())
		{
			$post  = $this->input->post('Employee_po');
			$post['update_time'] = date('Y-m-d H:i:s');

			if($post['proccess'] == 1)
			{
				$post['position'] = 2;
				
				$this->session->set_flashdata('messages', 'Quotation berhasil diproses');

			}else{
				$post['position'] = 1;
				
				$this->session->set_flashdata('messages', 'Quotation berhasil disimpan');

			}
			unset($post['proccess']);

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			$product_table = $this->input->post('ProductForm');
			if(isset($product_table))
			{
				foreach($product_table as $i)
				{
					$param = [];
					$param['quotation_order_id'] = $id;
					
					unset($i['id']);

					foreach($i as $key => $val)
					{
						$param[$key] = $val;
					}

					$this->db->insert('quotation_order_products', $param);
				}
			}
			

			redirect('employeeqo/index','location');
		}
		
		$params['page'] = 'employeeqo/form';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}

	/**
	 * [revisi description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function revisi($id)
	{
		$model = $this->model->get_by_id($id);
 
		if(!isset($model))
		{
			$this->session->set_flashdata('error', 'No Quotation tidak ditemukan');	
			redirect('employeeqo/index','location');
		}
		
		if($this->input->post())
		{
			$post  = $this->input->post('Employee_po');
			$post['update_time'] = date('Y-m-d H:i:s');

			if($post['proccess'] == 1)
			{
				$post['position'] = 2;

				$post['count_revisi'] = $model['count_revisi']+1;

				if (strpos($model['no_po'], 'R')) {
					$no_quotation = str_replace('R'.$model['count_revisi'], 'R'.($model['count_revisi']+1), $model['no_po']);
				}else{
					$no_quotation = $model['no_po'].'/R1';
				}

				$post['no_po'] = $no_quotation;
				
				$this->session->set_flashdata('messages', 'Quotation berhasil diproses');

			}else{
				$post['position'] = 1;
				
				$this->session->set_flashdata('messages', 'Quotation berhasil disimpan');

			}
			unset($post['proccess']);

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			$product_table = $this->input->post('ProductForm');
			if(isset($product_table))
			{
				foreach($product_table as $i)
				{
					$param = [];
					$param['quotation_order_id'] = $id;
					
					unset($i['id']);

					foreach($i as $key => $val)
					{
						$param[$key] = $val;
					}

					$this->db->insert('quotation_order_products', $param);
				}
			}
			

			redirect('employeeqo/index','location');
		}
		
		$params['page'] = 'employeeqo/revisi';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}


	/*
	public function revisi($id=0)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post('Employee_po');
			$post['update_time'] = date('Y-m-d H:i:s');
			
			$temp = $this->db->get_where($this->model->t_table, ['id' => $id])->row_array();
			
			$this->db->flush_cache();
			if($post['proccess'] == 1)
			{
				$post['position'] = 2;
			}

			unset($post['proccess']);
			
			$post['count_revisi'] = $temp['count_revisi'] + 1;

			$this->db->where('id', $id);
            $this->db->update($this->model->t_table, $post);
			$this->db->flush_cache();

			unset($post['count_revisi']);
			$data_temp = [];
			foreach($post as $key => $i){

				if($post[$key] !== $temp[$key])
					$data_temp[$key] = $temp[$key];
			}

			$data_temp['quotation_order_id'] = $id;
			
			$this->db->insert('quotation_order_revisi', $data_temp);

			

			redirect('employeeqo/index','location');
		}
		
		$no_quotation = str_replace('R'.$model['count_revisi'], 'R'.($model['count_revisi']+1), $model['no_po']);

		$params['no_quotation'] = $no_quotation;
		$params['page'] = 'employeeqo/revisi';
		$params['data'] = $model;
		
		$this->load->view('layouts/main', $params);
	}
	*/

	public function delete($id=0)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->model->t_table);

		redirect(site_url('employeeqo'));
	}

	public function printpo($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/employeeqo/printpo', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Quotation ".date('d M Y')." - ". $params['data']['customer'] .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');
		$this->m_pdf = new mPDF();

       	$this->m_pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            35, // margin top
            35, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");
	}

	/**
	 * [konfirmasiorder description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function konfirmasiorder($id)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/employeeqo/konfirmasiorder', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "OM ".date('d M Y')." - ". $params['data']['customer'] .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();
		
		$this->m_pdf->showImageErrors = true;

		$this->m_pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            15, // margin top
            15, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");
	}

	/**
	 * [printom description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printom($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		
		$html = $this->load->view('pages/employeeqo/om', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "OM ".date('d M Y')." - ". $params['data']['customer'] .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();
		
		$this->m_pdf->showImageErrors = true;

		$this->m_pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            15, // margin top
            15, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");
	}
}
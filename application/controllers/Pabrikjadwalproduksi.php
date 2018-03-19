<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pabrikjadwalproduksi extends CI_Controller {


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
		
		$this->load->model('Productschedule_model');
		$this->load->model('Productscheduleplan_model');

		$this->model = $this->Productschedule_model;
		$this->load->library("PHPExcel");
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];

		$params['page'] = 'pabrikjadwalproduksi/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
			$params['data'] = $this->model->data_($_GET);


		$this->load->view('layouts/main', $params);
	}

	public function downloadrekapanbulanan()
	{
		
	}

	/**
	 * [insert description]
	 * @return [type] [description]
	 */
	public function insert()
	{
		if($this->input->post())
		{
			$post  = $this->input->post();
			//$tanggal = explode('to', $post['tanggal']);
			
			$param['create_time'] 		= date('Y-m-d H:i:s');
			//$param['start_date'] 		= $tanggal[0];
			//$param['end_date'] 			= $tanggal[1];

			$param['bulan']				= $post['bulan'];
			$param['minggu']			= $post['minggu'];
			$param['plan'] 				= $post['jadwal']['plan'];
			$param['spv_pengecoran'] 	= $post['jadwal']['spv_pengecoran'];
			$param['plan_pekerja'] 		= $post['jadwal']['plan_pekerja'];

			if($this->db->insert($this->model->t_table, $param)):
			
				$insert_id = $this->db->insert_id();

				$product_table = $this->input->post('product_id');
				foreach($product_table as $key => $i)
				{
					$param = [];
					$param['product_schedule_id'] = $insert_id;
					$param['product_id'] = $i;
					$param['day1_shift1'] = $post['day1_shift1'][$key];
					$param['day1_shift2'] = $post['day1_shift2'][$key];
					$param['day2_shift1'] = $post['day2_shift1'][$key];
					$param['day2_shift2'] = $post['day2_shift2'][$key];
					$param['day3_shift1'] = $post['day3_shift1'][$key];
					$param['day3_shift2'] = $post['day3_shift2'][$key];
					$param['day4_shift1'] = $post['day4_shift1'][$key];
					$param['day4_shift2'] = $post['day4_shift2'][$key];
					$param['day5_shift1'] = $post['day5_shift1'][$key];
					$param['day5_shift2'] = $post['day5_shift2'][$key];
					$param['day6_shift1'] = $post['day6_shift1'][$key];
					$param['day6_shift2'] = $post['day6_shift2'][$key];
					$param['day7_shift1'] = $post['day7_shift1'][$key];
					$param['day7_shift2'] = $post['day7_shift2'][$key];
					$param['cetakan']	  = $post['cetakan'][$key];
					$param['pengecoran']  = $post['pengecoran'][$key];	

					$this->db->insert('product_schedule_plan', $param);
				}
			endif;

			$this->session->set_flashdata('messages', 'Schedule berhasil dibuat');

			redirect('pabrikjadwalproduksi/index','location');
		}
		
		$params['page'] = 'pabrikjadwalproduksi/form';

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

		if($this->input->post())
		{
			$post  = $this->input->post();
			$tanggal = explode('to', $post['tanggal']);
			
			$param['update_time'] = date('Y-m-d H:i:s');
			$param['start_date'] = $tanggal[0];
			$param['end_date'] = $tanggal[1];
			$param['plan'] 				= $post['jadwal']['plan'];
			$param['spv_pengecoran'] 	= $post['jadwal']['spv_pengecoran'];
			$param['plan_pekerja'] 		= $post['jadwal']['plan_pekerja'];
			
			$this->db->where(['id' => $id]);

			if($this->db->update($this->model->t_table, $param)):
				// clear history			
				$this->db->flush_cache();

				$product_table = $this->input->post('product_id_old');
				foreach($product_table as $key => $i)
				{
					$param = [];
					$param['product_schedule_id'] = $id;
					$param['product_id'] = $i;
					$param['day1_shift1'] = $post['day1_shift1_old'][$key];
					$param['day1_shift2'] = $post['day1_shift2_old'][$key];
					$param['day2_shift1'] = $post['day2_shift1_old'][$key];
					$param['day2_shift2'] = $post['day2_shift2_old'][$key];
					$param['day3_shift1'] = $post['day3_shift1_old'][$key];
					$param['day3_shift2'] = $post['day3_shift2_old'][$key];
					$param['day4_shift1'] = $post['day4_shift1_old'][$key];
					$param['day4_shift2'] = $post['day4_shift2_old'][$key];
					$param['day5_shift1'] = $post['day5_shift1_old'][$key];
					$param['day5_shift2'] = $post['day5_shift2_old'][$key];
					$param['day6_shift1'] = $post['day6_shift1_old'][$key];
					$param['day6_shift2'] = $post['day6_shift2_old'][$key];
					$param['day7_shift1'] = $post['day7_shift1_old'][$key];
					$param['day7_shift2'] = $post['day7_shift2_old'][$key];
					
					$param['cetakan']	  = $post['cetakan_old'][$key];
					$param['pengecoran']  = $post['pengecoran_old'][$key];	

					$pln = $this->db->get_where('product_schedule_plan', ['id' => $post['plan_id'][$key]])->row_array();
			 		foreach([1,2,3,4,5,6] as $hari ):
                    	foreach([1, 2] as $shift):
                      		
                      		if($post['day'. $hari .'_shift'. $shift .'_old'][$key] != $pln['day'. $hari .'_shift'. $shift])
                      		{
								$param['is_revisi'] = 1;                      			
                      		}
                    	endforeach; 
                	endforeach; 

					$this->db->where(['id' => $post['plan_id'][$key]]);
					$this->db->update('product_schedule_plan', $param);
					$this->db->flush_cache();
				}

				// untuk penambahan produk baru
				$product_table = $this->input->post('product_id');
				foreach($product_table as $key => $i)
				{
					$param = [];
					$param['product_schedule_id'] = $id;
					$param['product_id'] = $i;
					$param['day1_shift1'] = $post['day1_shift1'][$key];
					$param['day1_shift2'] = $post['day1_shift2'][$key];
					$param['day2_shift1'] = $post['day2_shift1'][$key];
					$param['day2_shift2'] = $post['day2_shift2'][$key];
					$param['day3_shift1'] = $post['day3_shift1'][$key];
					$param['day3_shift2'] = $post['day3_shift2'][$key];
					$param['day4_shift1'] = $post['day4_shift1'][$key];
					$param['day4_shift2'] = $post['day4_shift2'][$key];
					$param['day5_shift1'] = $post['day5_shift1'][$key];
					$param['day5_shift2'] = $post['day5_shift2'][$key];
					$param['day6_shift1'] = $post['day6_shift1'][$key];
					$param['day6_shift2'] = $post['day6_shift2'][$key];
					$param['day7_shift1'] = $post['day7_shift1'][$key];
					$param['day7_shift2'] = $post['day7_shift2'][$key];

					$param['cetakan']	  = $post['cetakan'][$key];
					$param['pengecoran']  = $post['pengecoran'][$key];	
					$param['is_revisi'] = 1;

					$this->db->insert('product_schedule_plan', $param);
				}
			endif;

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('pabrikjadwalproduksi/index','location');
		}
		
		$list_plan = $this->Productscheduleplan_model->get_by_productschedule($model['id']);
		$list_plan_revisi = $this->Productscheduleplan_model->get_by_productschedule($model['id'],1);

		$params['page'] = 'pabrikjadwalproduksi/form';
		$params['data'] = $model;
		$params['list_plan'] = $list_plan;
		$params['list_plan_revisi'] = $list_plan_revisi;

		
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
		$this->db->flush_cache();

		$this->db->where('product_schedule_id', $id);
		$this->db->delete('product_schedule_plan');

		$this->session->set_flashdata('messages', 'Data berhasil dihapus');

		redirect(site_url('pabrikjadwalproduksi'));
	}

	/**
	 * [print_jadwal description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function print_jadwal($id=0)
	{
		$params['data'] = $this->model->get_by_id($id);
		$params['list_plan'] = $this->Productscheduleplan_model->get_by_productschedule($id);
		$params['list_plan_revisi'] = $this->Productscheduleplan_model->get_by_productschedule($id,1);

		
		$html = $this->load->view('pages/pabrikjadwalproduksi/print', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Jadwal Produksi Mingguan - ". $params['data']['start_date'] .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();
		
		$this->m_pdf->showImageErrors = true;

		$this->m_pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");
	}

	/**
	 * [reportmingguan description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function reportmingguan($id)
	{
		$model = $this->model->get_by_id($id);
		
		$list_plan = $this->Productscheduleplan_model->get_by_productschedule($model['id']);
		$list_plan_revisi = $this->Productscheduleplan_model->get_by_productschedule($model['id'],1);

		$params['page'] = 'pabrikjadwalproduksi/reportmingguan';
		$params['data'] = $model;
		$params['list_plan'] = $list_plan;
		$params['list_plan_revisi'] = $list_plan_revisi;
		
		$this->load->view('layouts/main', $params);
	}

	/**
	 * [lembarkerja description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function lembarkerja($id)
	{
		$model = $this->model->get_by_id($id);

		if($this->input->post())
		{
			$post  = $this->input->post();
			$tanggal = explode('to', $post['tanggal']);
			
			$param['update_time'] = date('Y-m-d H:i:s');
			$param['start_date'] = $tanggal[0];
			$param['end_date'] = $tanggal[1];
			
			$this->db->where(['id' => $id]);

			if($this->db->update($this->model->t_table, $param)):
				// clear history			
				$this->db->flush_cache();

				$product_table = $this->input->post('product_id_old');
				foreach($product_table as $key => $i)
				{
					$param = [];
					$param['product_schedule_id'] = $id;
					$param['product_id'] = $i;
					$param['day1_shift1'] = $post['day1_shift1_old'][$key];
					$param['day1_shift2'] = $post['day1_shift2_old'][$key];
					$param['day2_shift1'] = $post['day2_shift1_old'][$key];
					$param['day2_shift2'] = $post['day2_shift2_old'][$key];
					$param['day3_shift1'] = $post['day3_shift1_old'][$key];
					$param['day3_shift2'] = $post['day3_shift2_old'][$key];
					$param['day4_shift1'] = $post['day4_shift1_old'][$key];
					$param['day4_shift2'] = $post['day4_shift2_old'][$key];
					$param['day5_shift1'] = $post['day5_shift1_old'][$key];
					$param['day5_shift2'] = $post['day5_shift2_old'][$key];
					$param['day6_shift1'] = $post['day6_shift1_old'][$key];
					$param['day6_shift2'] = $post['day6_shift2_old'][$key];
					$param['cetakan']	  = $post['cetakan_old'][$key];
					$param['pengecoran']  = $post['pengecoran_old'][$key];	

					$this->db->where(['id' => $post['plan_id'][$key]]);
					$this->db->update('product_schedule_plan', $param);
					$this->db->flush_cache();
				}

				// untuk penambahan produk baru
				$product_table = $this->input->post('product_id');
				foreach($product_table as $key => $i)
				{
					$param = [];
					$param['product_schedule_id'] = $id;
					$param['product_id'] = $i;
					$param['day1_shift1'] = $post['day1_shift1'][$key];
					$param['day1_shift2'] = $post['day1_shift2'][$key];
					$param['day2_shift1'] = $post['day2_shift1'][$key];
					$param['day2_shift2'] = $post['day2_shift2'][$key];
					$param['day3_shift1'] = $post['day3_shift1'][$key];
					$param['day3_shift2'] = $post['day3_shift2'][$key];
					$param['day4_shift1'] = $post['day4_shift1'][$key];
					$param['day4_shift2'] = $post['day4_shift2'][$key];
					$param['day5_shift1'] = $post['day5_shift1'][$key];
					$param['day5_shift2'] = $post['day5_shift2'][$key];
					$param['day6_shift1'] = $post['day6_shift1'][$key];
					$param['day6_shift2'] = $post['day6_shift2'][$key];
					$param['cetakan']	  = $post['cetakan'][$key];
					$param['pengecoran']  = $post['pengecoran'][$key];	

					$this->db->insert('product_schedule_plan', $param);
				}
			endif;

			$this->session->set_flashdata('messages', 'Data berhasil disimpan');

			redirect('pabrikjadwalproduksi/index','location');
		}
		
		$list_plan = $this->Productscheduleplan_model->get_by_productschedule($model['id']);
		$list_plan_revisi = $this->Productscheduleplan_model->get_by_productschedule($model['id'],1);


		$params['page'] = 'pabrikjadwalproduksi/lembarkerja';
		$params['data'] = $model;
		$params['list_plan'] = $list_plan;
		$params['list_plan_revisi']	= $list_plan_revisi;
		
		$this->load->view('layouts/main', $params);
	}

	/**
	 * [cetaklembarkerja description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function cetaklembarkerja($id)
	{
		$params['data'] = $this->model->get_by_id($id);
		$params['list_plan'] = $this->Productscheduleplan_model->get_by_productschedule($id);
		
		$html = $this->load->view('pages/pabrikjadwalproduksi/print_lembarkerja', $params, true);

		$data = [];

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Jadwal Produksi Mingguan - ". $params['data']['start_date'] .".pdf";

        //load mPDF library
		$this->load->library('m_pdf');

		$this->m_pdf = new mPDF();
		
		$this->m_pdf->showImageErrors = true;

		$this->m_pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer

       //generate the PDF from the given html
		$this->m_pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->Output($pdfFilePath, "I");
	}


	public function export()
	{
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $data = $this->db->get('user');

        // Nama Field Baris Pertama
    	$fields = $data->list_fields();
    	$col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

 
        // Mengambil Data
        $row = 2;
        foreach($data->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);

        //Set Title
        $objPHPExcel->getActiveSheet()->setTitle('Data Absen');

        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //Header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //Nama File
        header('Content-Disposition: attachment;filename="absen.xlsx"');

        //Download
        $objWriter->save("php://output");
		
    }
}

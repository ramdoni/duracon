<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalanar extends CI_Controller {


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
			
			if($access != 10 and $access != 6) {
				$this->session->set_flashdata('error', 'Access denied');
				redirect('/?access=forbidden');
			}
			
			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
		$this->load->model('Suratjalan_model');
		$this->model = $this->Suratjalan_model;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$params = [];
		$params['page'] = 'suratjalanar/index';
		$params['data'] = $this->model->data_();

		if(isset($_GET))
		{
			$params['data'] = $this->model->data_($_GET);
		}

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [detail description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function detail($id)
	{
		$sj = $this->model->get_by_id($id);

		$sql = "
			SELECT sj.no_surat_jalan, sj.date, m.no_mobil, m.jenis_mobil,  spm.no_spm, sik.no_sik, so.penerima_lapangan, so.no_telepon, so.no_so, qo.no_po, qo.proyek, sj.catatan, p.kode, spmp.volume FROM surat_jalan sj 
				INNER JOIN surat_perintah_muat spm on spm.id=sj.surat_perintah_muat_id
				INNER JOIN surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id
				INNER JOIN surat_izin_kirim sik on sik.id=spm.surat_izin_kirim_id
				INNER JOIN sales_order so on so.id=sik.sales_order_id
				INNER JOIN quotation_order qo on qo.id=so.quotation_order_id
				INNER JOIN products p on p.id=spmp.product_id
				INNER JOIN mobil m on m.id=spm.mobil_id
				WHERE sj.id={$id}
		";

		$sj = $this->db->query($sql)->row_array();

		$params = [];
		$params['sj'] 	= $sj;
		$params['page'] 	= 'suratjalan/detail';

		$this->load->view('layouts/main', $params);
	}

	/**
	 * [confirmar description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function confirmar($id)
	{
		$this->db->where(['id' =>$id]);
		$this->db->update('surat_jalan', ['status' => 2]);

		$this->session->set_flashdata('messages', 'Surat Jalan berhasil di proses');

		redirect('suratjalanar');
	}

	/**
	 * [revisi description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function revisi($id)
	{
		$post = $this->input->post();
		if($post)
		{	
			$this->db->where(['id' => $id]);
			$this->db->update('surat_jalan', ['date' => $post['date'],'is_lock'=> 1]);
			$this->db->flush_cache();
			
			$this->db->where(['surat_jalan_id' => $id, 'is_submit' => 0]);
			$this->db->update('surat_jalan_lock_history', ['catatan' => $post['catatan'],'is_submit' => 1]);
		}

		$this->session->set_flashdata('messages', 'Surat Jalan berhasil direvisi');

		redirect('suratjalanar');
	}

	/**
	 * [printspm description]
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	public function printsuratjalan($id=0)
	{
		// cek surat jalan
		$sj = $this->db->get_where('surat_jalan', ['id' => $id])->row_array(); 
		
		$this->load->model('Quotationorder_model');

		$params['spm'] = $this->db->get_where('surat_perintah_muat', ['id' => $sj['surat_perintah_muat_id']])->row_array();
	
		$sik  	= $this->db->get_where('surat_izin_kirim',['id'=> $params['spm']['surat_izin_kirim_id']])->row_array();
		$so 	= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();

		$total_surat_jalan = $this->db->get('surat_jalan')->num_rows();

		$params['sik'] 	= $sik;
		$params['so'] 	= $so;
		$params['mobil']= $this->db->get_where('mobil', ['id' => $params['spm']['mobil_id']])->row_array();
		$params['qo']	= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		$params['no_surat_jalan'] =  $sj['no_surat_jalan'];
		$params['sj'] = $sj;

		$html = $this->load->view('pages/suratjalanar/suratjalan_print', $params, true);

        //this the the PDF filename that user will get to download
		$pdfFilePath = "Surat Jalan ". date('d M Y')." - ". $params['data']['customer'] ." .pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");	
	}
}
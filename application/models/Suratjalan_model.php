<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Suratjalan_model extends CI_Model
 {
	var $t_table 	= 'surat_jalan';

	/**
	 * Constructor
	 * @param	-
	 * @return 	-
	 **/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Data Investasi
	 * @param	id, page, limit, search
	 * @return 	array
	 **/
	public function data_($get = '')
	{
		$this->db->from($this->t_table);
		$this->db->select('surat_jalan.*, qo.customer_id, so.no_so');
		$this->db->join('surat_perintah_muat spm', 'spm.id=surat_jalan.surat_perintah_muat_id');
		$this->db->join('surat_izin_kirim sik', 'sik.id=spm.surat_izin_kirim_id');
		$this->db->join('sales_order so', 'so.id=sik.sales_order_id');
		$this->db->join('quotation_order qo', 'qo.id=so.quotation_order_id');

		if(isset($get))
		{
			if(isset($get['status']) and !empty($get['status'])){
				if($get['status'] == 'proses')
					$this->db->where(['surat_jalan.status' => 1]);
				elseif($get['status']=='selesai')
					$this->db->where(['surat_jalan.status' => 2]);
			}

			if(isset($get['customer_id']) and !empty($get['customer_id']))
				$this->db->where(['qo.customer_id' => $get['customer_id']]);
			if(isset($get['sales_order_id']) and !empty($get['sales_order_id']))
				$this->db->where(['so.id' => $get['sales_order_id']]);
			
			if(isset($get['surat_jalan_id']) and !empty($get['surat_jalan_id']))
				$this->db->where(['surat_jalan.id' => $get['surat_jalan_id']]);
		}


		$this->db->order_by('id', 'desc');

		$i = $this->db->get();
		
		return $i->result_array();
	}

	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id)
	{
		$this->db->from($this->t_table);
		$this->db->where(['id' => $id]);

		return $this->db->get()->row_array();
	}
}
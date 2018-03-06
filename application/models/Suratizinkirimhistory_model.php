<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Suratizinkirimhistory_model  extends CI_Model
 {
	var $t_table 	= 'surat_izin_kirim_history';

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
	public function get_by_sik($id)
	{
		$this->db->from($this->t_table);
		$this->db->select($this->t_table.".*, p.kode, p.uraian, p.weight");
		$this->db->join('products p', 'p.id='. $this->t_table.'.product_id');
		$this->db->where(['surat_izin_kirim_id' => $id]);

		$i = $this->db->get();
		
		return $i->result_array();
	}
}
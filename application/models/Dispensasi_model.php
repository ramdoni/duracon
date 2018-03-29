<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Dispensasi_model extends CI_Model
 {
	var $t_table 	= 'dispensasi';

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
	public function data_($type= 'all')
	{
		$this->db->from($this->t_table);
		$this->db->select('dispensasi.*, so.no_so, qo.proyek, qo.customer_id, s.name as sales');
		$this->db->join('sales_order as so', 'so.id=dispensasi.sales_order_id');
		$this->db->join('quotation_order as qo', 'qo.id=so.quotation_order_id');
		$this->db->join('user s','s.id=dispensasi.sales_id');

		if($type=='sales')
		{
			$this->db->where(['dispensasi.sales_id' => $this->session->userdata('user_id')]);
		}

		$i = $this->db->get();
		
		return $i->result_array();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->t_table);
		$this->db->select('dispensasi.*, so.no_so, qo.proyek, qo.customer_id, s.name as sales');
		$this->db->join('sales_order as so', 'so.id=dispensasi.sales_order_id');
		$this->db->join('quotation_order as qo', 'qo.id=so.quotation_order_id');
		$this->db->join('user s','s.id=dispensasi.sales_id');
		$this->db->where(['dispensasi.id' => $id]);

		$i = $this->db->get();
		
		return $i->row_array();
	}
}
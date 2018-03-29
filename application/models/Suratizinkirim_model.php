<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Suratizinkirim_model extends CI_Model
 {
	var $t_table 	= 'surat_izin_kirim';

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
	public function data_($type ='all',$user_id = null, $get = null)
	{
		$this->db->select("surat_izin_kirim.*, s.no_po as no_po, q.no_po as no_quotation, q.proyek, m.name as marketing, sales.name as sales, c.tipe_customer, c.name, c.company, s.no_so, q.customer_id");
		$this->db->from($this->t_table);
		$this->db->join("sales_order s", "s.id=surat_izin_kirim.sales_order_id");
		$this->db->join("quotation_order q", "q.id=s.quotation_order_id");
		$this->db->join("user m", "m.id=q.marketing_id", "left");
		$this->db->join("user sales", "sales.id=q.sales_id", "left");
		$this->db->join('customer c', 'c.id=q.customer_id');

		if($type=='approved')
			$this->db->where(['surat_izin_kirim.position' => 3]);

		if($type =='sales')
			$this->db->where(['q.sales_id' => $user_id]);
		
		if(isset($get))
		{
			if(isset($get['customer_id']) and !empty($get['customer_id']))
				$this->db->where(['c.id' => $get['customer_id']]);


			if(isset($get['sales_order_id']) and !empty($get['sales_order_id']))
				$this->db->where(['s.id' => $get['sales_order_id']]);
			
			if(isset($get['surat_izin_kirim_id']) and !empty($get['surat_izin_kirim_id']))
				$this->db->where(['surat_izin_kirim.id' => $get['surat_izin_kirim_id']]);
		}

		$this->db->order_by('surat_izin_kirim.id', 'desc');

		$i = $this->db->get();
		
		return $i->result_array();
	}

	/**
	 * [data_marketing description]
	 * @param  [type] $employee_id [description]
	 * @return [type]              [description]
	 */
	public function data_marketing($employee_id)
	{
		$this->db->select("surat_izin_kirim.*, s.no_po as no_po, q.no_po as no_quotation, q.proyek, m.name as marketing, sales.name as sales");
		$this->db->from($this->t_table);
		$this->db->join("sales_order s", "s.id=surat_izin_kirim.sales_order_id");
		$this->db->join("quotation_order q", "q.id=s.quotation_order_id");
		$this->db->join("user m", "m.id=q.marketing_id", "left");
		$this->db->join("user sales", "s.id=q.sales_id", "left");
		$this->db->where(['q.marketing_id' => $employee_id]);

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
    	$data = $this->db->get_where($this->t_table, ['id' => $id]);

    	return $data->row_array();
    }

    /**
     * [get_sales_order description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function get_sales_order($id)
    {
    	return $this->db->get_where($this->t_table, ['sales_order_id' => $id])->row_array();	
    }
}
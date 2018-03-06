<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Quotationorder_model extends CI_Model
 {
	var $t_table 	= 'quotation_order';

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
	 » Data All
	 * @param	id, page, limit, search
	 * @return 	array
	 **/
	public function data_($id=0, $page=0, $limit=0, $search=0)
	{
		$this->db->select('quotation_order.*, customer.name as customer, sales.name as sales, proyek, area.area as area_kirim, marketing.name as marketing,area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'quotation_order.customer_id=customer.id', 'left');
		$this->db->join('user as sales', 'quotation_order.sales_id=sales.id', 'left');
		//$this->db->join('proyek', 'quotation_order.proyek_id=proyek.id', 'left');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=quotation_order.lokasi_id', 'left');
		$this->db->join('user as marketing', 'marketing.id=quotation_order.marketing_id', 'left');
		//$this->db->join('marketing', 'marketing.id=quotation_order.marketing_id', 'left');

		if($search != 0 and is_array($search))
		{
			$this->db->where($search);
		}

		$this->db->order_by('quotation_order.id', 'desc');

		$i = $this->db->get();
		
		return $i->result_array();
	}

	/**
	 * Data Manager
	 * @param	id, page, limit, search
	 * @return 	array
	 **/
	public function data_manager($id=0, $page=0, $limit=0, $search=0)
	{
		$this->db->select('quotation_order.*, customer.name as customer, sales.name as sales, quotation_order.proyek, area.area as area_kirim, marketing.name as marketing,area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'quotation_order.customer_id=customer.id', 'left');
		$this->db->join('user as sales', 'quotation_order.sales_id=sales.id', 'left');
		//$this->db->join('proyek', 'quotation_order.proyek_id=proyek.id', 'left');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=quotation_order.lokasi_id', 'left');
		$this->db->join('user as marketing', 'marketing.id=quotation_order.marketing_id', 'left');
		$this->db->where(['quotation_order.position >' => 3]);
		$this->db->order_by('quotation_order.id', 'desc');

		$i = $this->db->get();
		
		return $i->result_array();
	}
	
	/**
	 * Total
	 * @param 	search 
	 * @return 	count table
	 **/
	public function total($search = 0)
    {
    	if(!empty($search)):
			$this->db->like('uraian', $search);
		endif;
        $i = $this->db->get($this->t_table);
        return $i->num_rows();
    }

    /**
	 * insert
	 * @param 	data array , table
	 * @return 	
	 **/
    public function insert($table, $data = array())
    {
    	$i = $this->db->insert($table, $data);
    	$no = 0;
    	if($i):
    		echo $no++;
    	endif;
    }

    public function get_by_id($id)
    {
    	$this->db->select('quotation_order.*, customer.name as customer, sales.name as sales, proyek, lokasi.name as area_kirim,area.area as area, area.area as area_kirim, marketing.name as marketing,sales.sales_code, lokasi.code as lokasi_code, area_id, marketing.sales_code as marketing_code');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'quotation_order.customer_id=customer.id', 'left');
		$this->db->join('user as sales', 'quotation_order.sales_id=sales.id', 'left');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=quotation_order.lokasi_id', 'left');
		$this->db->join('user as marketing', 'marketing.id=quotation_order.marketing_id', 'left');

		$this->db->where(['quotation_order.id' => $id]);

    	$data = $this->db->get();

    	return $data->row_array();
    }

    /**
	 * Data Sales
	 * @param	id, page, limit, search
	 * @return 	array
	 **/
	public function data_sales($id=0, $page=0, $limit=0, $search=0)
	{
		$this->db->select('quotation_order.*, customer.name as customer, sales.name as sales, area.area as area_kirim, quotation_order.proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'quotation_order.customer_id=customer.id', 'left');
		$this->db->join('user as sales', 'quotation_order.sales_id=sales.id', 'left');
		$this->db->join('area', 'quotation_order.area_id=area.id', 'left');
		//$this->db->join('proyek', 'quotation_order.proyek_id=proyek.id', 'left');
		$this->db->where(['sales_id' => $this->session->userdata('employee_id'), 'position >='=> 2]);
		$this->db->order_by('quotation_order.id', 'desc');

		$i = $this->db->get();
		
		return $i->result_array();
	}
}
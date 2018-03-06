<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Salesorder_model extends CI_Model
 {
	var $t_table 	= 'sales_order';

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
	public function data_($id=0, $page=0, $limit=0, $search=0)
	{
		$this->db->select('sales_order.*, quotation_order.no_po as no_quotation, customer.name as customer, sales.name as sales, quotation_order.proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('quotation_order', 'quotation_order.id=sales_order.quotation_order_id', 'inner');
		$this->db->join('user as sales', 'sales.id=quotation_order.sales_id','left');
		$this->db->join('customer', 'customer.id=quotation_order.customer_id','left');
		//$this->db->join('proyek', 'proyek.id=quotation_order.proyek_id', 'inner');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->order_by('id', 'desc');

		if($search != 0 and is_array($search))
		{
			$this->db->where($search);
		}

		$i = $this->db->get();

		return $i->result_array();
	}

	/**
	 * [data_ description]
	 * @param  integer $id     [description]
	 * @param  integer $page   [description]
	 * @param  integer $limit  [description]
	 * @param  integer $search [description]
	 * @return [type]          [description]
	 */
	public function data_marketing($id)
	{
		$this->db->select('sales_order.*, quotation_order.no_po as no_quotation, customer.name as customer, sales.name as sales, quotation_order.proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('quotation_order', 'quotation_order.id=sales_order.quotation_order_id', 'inner');
		$this->db->join('user as sales', 'sales.id=quotation_order.sales_id','left');
		$this->db->join('customer', 'customer.id=quotation_order.customer_id','left');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->order_by('id', 'desc');
		$this->db->where(['quotation_order.marketing_id' => $id]);

		$i = $this->db->get();

		return $i->result_array();
	}
	
	/**
	 * @param  id integer
	 * @param  page integer
	 * @param  limit integer
	 * @param  search string
	 * @return array
	 */
	public function data_sales($id=0, $page=0, $limit=0, $search=0)
	{
		$this->db->select('sales_order.*, quotation_order.no_po as no_quotation, customer.name as customer, sales.name as sales, quotation_order.proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('quotation_order', 'quotation_order.id=sales_order.quotation_order_id', 'inner');
		$this->db->join('user as sales', 'sales.id=quotation_order.sales_id', 'inner');
		$this->db->join('customer', 'customer.id=quotation_order.customer_id', 'inner');
		//$this->db->join('proyek', 'proyek.id=quotation_order.proyek_id', 'inner');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->where(['quotation_order.sales_id' => (int)$this->session->userdata('employee_id'), 'sales_order.position >= ' => 1]);
		$this->db->order_by('id','desc');

		$i = $this->db->get();
		
		return $i->result_array();
	}


	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id_sales($id, $type = 'sales')
    {
  		$sales_id = $this->session->userdata('employee_id');

    	$this->db->select('sales_order.*, quotation_order.no_po as no_quotation, quotation_order.tipe_pekerjaan, quotation_order.penurunan_barang, quotation_order.sistem_pembayaran, customer.name as customer, sales.name as sales, quotation_order.proyek, area.area as area, marketing.name as marketing, quotation_order.customer_id');
		$this->db->from($this->t_table);
		$this->db->join('quotation_order', 'quotation_order.id=sales_order.quotation_order_id');
		$this->db->join('user as sales', 'sales.id=quotation_order.sales_id', 'left');
		$this->db->join('customer', 'customer.id=quotation_order.customer_id' ,'left');
		//$this->db->join('proyek', 'proyek.id=quotation_order.proyek_id');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->join('user as marketing', 'marketing.id=quotation_order.marketing_id', 'left');
		
		if($type == 'sales')
    		$this->db->where(['sales_order.id' => $id, 'quotation_order.sales_id' => $sales_id]);
    	else
    		$this->db->where(['sales_order.id' => $id, 'quotation_order.marketing_id' => $sales_id]);

    	return $this->db->get()->row_array();
    }


	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id)
    {
    	$this->db->select('sales_order.*, quotation_order.tipe_pekerjaan, quotation_order.no_po as no_quotation, quotation_order.penurunan_barang, quotation_order.sistem_pembayaran, customer.name as customer, sales.name as sales, quotation_order.proyek, area.area as area, marketing.name as marketing, sales.sales_code, marketing.sales_code as marketing_code, quotation_order.customer_id, quotation_order.no_po');
		$this->db->from($this->t_table);
		$this->db->join('quotation_order', 'quotation_order.id=sales_order.quotation_order_id');
		$this->db->join('user as sales', 'sales.id=quotation_order.sales_id' ,'left');
		$this->db->join('customer', 'customer.id=quotation_order.customer_id');
		$this->db->join('area', 'area.id=quotation_order.area_id', 'left');
		$this->db->join('user as marketing', 'marketing.id=quotation_order.marketing_id', 'left');
    	$this->db->where(['sales_order.id' => $id]);

    	return $this->db->get()->row_array();
    }
}
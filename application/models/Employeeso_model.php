<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Employeeso_model extends CI_Model
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
		$this->db->select('sales_order.*, employee_po.no_po as no_quotation, customer.name as customer, sales.name as sales, proyek.nama as proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('employee_po', 'employee_po.id=employee_so.employee_po_id');
		$this->db->join('sales', 'sales.id=employee_po.sales_id');
		$this->db->join('customer', 'customer.id=employee_po.customer_id');
		$this->db->join('proyek', 'proyek.id=employee_po.proyek_id');
		$this->db->join('area', 'area.id=employee_po.area_id');

		if(!empty($search)):
			$this->db->like('firstname', $search);
		endif;

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
    	$this->db->select('employee_so.*, employee_po.sistem_pembayaran, customer.name as customer, sales.name as sales, proyek.nama as proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('employee_po', 'employee_po.id=employee_so.employee_po_id');
		$this->db->join('sales', 'sales.id=employee_po.sales_id');
		$this->db->join('customer', 'customer.id=employee_po.customer_id');
		$this->db->join('proyek', 'proyek.id=employee_po.proyek_id');
		$this->db->join('area', 'area.id=employee_po.area_id');
    	$this->db->where(['employee_so.id' => $id]);

    	return $this->db->get()->row_array();
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Employeeqo_model extends CI_Model
 {
	var $t_table 	= 'employee_po';

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
		$this->db->select('employee_po.*, customer.name as customer, sales.name as sales_id, area.area as area_kirim, proyek.nama as proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'employee_po.customer_id=customer.id', 'left');
		$this->db->join('user as sales', 'employee_po.sales_id=sales.id', 'left');
		$this->db->join('area', 'employee_po.area_id=area.id', 'left');
		$this->db->join('proyek', 'employee_po.proyek_id=proyek.id', 'left');
		$this->db->order_by('employee_po.id', 'desc');

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
    	$this->db->select('employee_po.*, customer.name as customer, sales.name as sales, area.area as area_kirim, proyek.nama as proyek, area.area as area ');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'employee_po.customer_id=customer.id', 'left');
		$this->db->join('user as sales', 'employee_po.sales_id=sales.id', 'left');
		$this->db->join('area', 'employee_po.area_id=area.id', 'left');
		$this->db->join('proyek', 'employee_po.proyek_id=proyek.id', 'left');
		$this->db->where(['employee_po.id' => $id]);

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
		$this->db->select('employee_po.*, customer.name as customer, sales.name as sales, area.area as area_kirim, proyek.nama as proyek, area.area as area');
		$this->db->from($this->t_table);
		$this->db->join('customer', 'employee_po.customer_id=customer.id', 'left');
		$this->db->join('sales', 'employee_po.sales_id=sales.id', 'left');
		$this->db->join('area', 'employee_po.area_id=area.id', 'left');
		$this->db->join('proyek', 'employee_po.proyek_id=proyek.id', 'left');
		$this->db->where(['sales_id' => $this->session->userdata('employee_id')]);
		$this->db->order_by('employee_po.id', 'desc');

		if(!empty($search)):
			$this->db->like('firstname', $search);
		endif;

		$i = $this->db->get();
		
		return $i->result_array();
	}
}
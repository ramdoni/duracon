<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Productscheduleplan_model extends CI_Model
 {
	var $t_table 	= 'product_schedule_plan';

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
		$this->db->from($this->t_table);

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
     * [get_by_productschedule description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function get_by_productschedule($id, $revisi =0)
    {
    	$this->db->from($this->t_table);
    	$this->db->select('product_schedule_plan.*, products.kode as product, products.weight');
    	$this->db->join('products', 'products.id=product_schedule_plan.product_id');

    	if($revisi == 1)
    	{
    		$this->db->where([$this->t_table.'.product_schedule_id' => $id, 'is_revisi' => 1]);
    	}else
    		$this->db->where([$this->t_table.'.product_schedule_id' => $id,'is_revisi' => 0]);


    	$this->db->order_by('pengecoran', 'DESC');

    	$data = $this->db->get();

    	return $data->result_array();
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
}
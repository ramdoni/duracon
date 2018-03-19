<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Pabrikproduct_model extends CI_Model
 {
	var $t_table 	= 'pabrik_product';

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
		$this->db->select("pabrik_product.*, pabrik_product_category.name as type_product");
		$this->db->join('pabrik_product_category', 'pabrik_product_category.id=pabrik_product.pabrik_product_category_id', 'left');
		$this->db->order_by('pabrik_product.id', 'desc');

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
    	$this->db->from($this->t_table);
		$this->db->select("pabrik_product.*, pabrik_product_category.name as product_type");
		$this->db->join('pabrik_product_category', 'pabrik_product_category.id=pabrik_product.pabrik_product_category_id', 'left');
    	$this->db->where(['pabrik_product.id' => $id]);

    	return $this->db->get()->row_array();
    }
}
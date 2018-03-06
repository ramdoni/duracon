<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Producthistorystock_model extends CI_Model
 {
	var $t_table 	= 'product_history_stock';

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
    	$this->db->select($this->t_table.".*, user.name");
    	$this->db->join('user', 'user.id='.$this->t_table.'.user_id');
    	$this->db->order_by($this->t_table.'.create_time', 'DESC');

		$i = $this->db->get();
		
		return $i->result_array();
	}

	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
    public function get_by_id($id, $type = '')
    {
    	$this->db->from($this->t_table);
    	$this->db->select($this->t_table.".*, user.name");
    	$this->db->join('user', 'user.id='.$this->t_table.'.user_id');
    	$this->db->order_by($this->t_table.'.create_time', 'DESC');
    	
    	if(empty($type))
    		$this->db->where(['id' => $id]);
    	else
    		$this->db->where([$type => $id]);    		

    	$data = $this->db->get();

    	return $data->result_array();
    }
}
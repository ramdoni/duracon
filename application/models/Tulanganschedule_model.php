<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Tulanganschedule_model extends CI_Model
 {
	var $t_table 	= 'tulangan_schedule';

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

    public function get_by_id($id)
    {
    	$data = $this->db->get_where($this->t_table, ['id' => $id]);

    	return $data->row_array();
    }
}
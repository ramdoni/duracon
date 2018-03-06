<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Salestarget_model extends CI_Model
 {
	var $t_table 	= 'sales_target';

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
		$this->db->from($this->t_table);
		
		$i = $this->db->get();
		
		return $i->result_array();
	}

	/**
	 * [get_data_sales description]
	 * @return [type] [description]
	 */
	public function get_data_sales()
	{
		$data = [];

		$result = $this->db->get_where('sales_target_user', ['user_id' => $this->session->userdata('id_user')])->result_array();

		foreach($result as $key => $item)
		{
			$target = $this->db->get_where('sales_target', ['id' => $item['sales_target_id']])->row_array();

			$data[$key] = $item;
			$data[$key]['tahun'] = $target['tahun'];
			$data[$key]['quartal_1'] = $target['quartal_1'];
			$data[$key]['quartal_2'] = $target['quartal_2'];
			$data[$key]['quartal_3'] = $target['quartal_3'];
			$data[$key]['quartal_4'] = $target['quartal_4'];
		}	

		return $data;
	}
	
	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id)
	{
		$data = $this->db->get_where($this->t_table, ['id' => $id])->row_array();

		return $data;
	}
}
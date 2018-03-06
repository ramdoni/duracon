<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Quotationorderhistory_model extends CI_Model
 {
	var $t_table 	= 'quotation_order_history';

	/**
	 * Constructor
	 * @param	-
	 * @return 	-
	 **/
	public function __construct()
	{
		parent::__construct();
	}

    public function get_by_id($id)
    {
		$this->db->from($this->t_table);
		$this->db->where(['quotation_order_id' => $id]);

    	$data = $this->db->get();
    	$result = [];
    	foreach($data->result_array() as $i => $item):
    		$result[$i] = $item;
    		$result[$i]['name'] = '';
    		$resuls[$i]['jabatan'] = '';
            $resuls[$i]['create_time'] = date('d F Y, H:i', strtotime($item['create_time']));

    		if($item['position'] == 2){
    			$result[$i]['name'] = $this->db->get_where('user', ['id' => $item['employee_id']])->row_array()['name'];
                $result[$i]['jabatan'] = 'Sales';
            }

    		if($item['position'] >= 3){
                $this->load->model('User_model');
                $employee = $this->User_model->get_by_id($item['employee_id']);
    			$result[$i]['name'] = $employee['name'];
                $result[$i]['jabatan'] = $employee['access'];
            }

    	endforeach;

    	return $result;
    }
}
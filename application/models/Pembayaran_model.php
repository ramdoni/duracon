<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Pembayaran_model extends CI_Model
 {
	var $t_table 	= 'pembayaran';

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
	 * [data_ description]
	 * @return [type] [description]
	 */
	public function data_($s = "")
	{
		$this->db->from($this->t_table);

		$this->db->select('c.name, c.company, c.tipe_customer, s.no_so, '. $this->t_table.'.date,'. $this->t_table.'.nominal, invoice.no_invoice');
		$this->db->join('customer as c', 'c.id='. $this->t_table.'.customer_id', 'left');
		$this->db->join('sales_order as s', 's.id='. $this->t_table.'.sales_order_id', 'left');
		$this->db->join('invoice', 'invoice.id=pembayaran.invoice_id', 'left');
		$this->db->order_by('pembayaran.id', 'desc');

		if(!empty($s))
		{
			if(isset($s['sales_order_id']) and !empty($s['sales_order_id']))
				$this->db->where(['s.id' => $s['sales_order_id']]);

			if(isset($s['invoice_id']) and !empty($s['invoice_id']))
				$this->db->where(['invoice.id' => $s['invoice_id']]);
		}


		$data = $this->db->get()->result_array();

		return $data;
	}
}
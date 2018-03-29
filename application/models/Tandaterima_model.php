<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by		: doni(doni.enginer@gmail.com)
 * @date	: Oktober 2012
 **/
 
 class Tandaterima_model extends CI_Model
 {
	var $t_table 	= 'tanda_terima';

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
	public function data_($s="")
	{
		$this->db->select($this->t_table.'.*, invoice.nominal, so.no_so, invoice.no_invoice, c.name, c.tipe_customer, c.company, c.kredit_overdue_day');
		$this->db->from($this->t_table);
		$this->db->join('invoice', 'invoice.id='.$this->t_table.'.invoice_id', 'left');
		$this->db->join('sales_order as so', 'so.id=invoice.sales_order_id', 'left');
		$this->db->join('quotation_order as q', 'q.id=so.quotation_order_id', 'left');
		$this->db->join('customer as c', 'c.id=q.customer_id', 'left');
			
		if(!empty($s))
		{	
			if(isset($s['status']) and $s['status'] != "")
				$this->db->where(['tanda_terima.status' => $s['status']]);

			if(isset($s['customer_id']) and !empty($s['customer_id']))
				$this->db->where(['c.id' => $s['customer_id']]);

			if(isset($s['sales_order_id']) and !empty($s['sales_order_id']))
				$this->db->where(['so.id' => $s['sales_order_id']]);

			if(isset($s['invoice_id']) and !empty($s['invoice_id']))
				$this->db->where(['invoice.id' => $s['invoice_id']]);
			
			if(isset($s['tanggal_pembuatan']) and !empty($s['tanggal_pembuatan']))
			{
				$tanggal_pembuatan = explode(' to ', $s['tanggal_pembuatan']);

				$this->db->where("tanda_terima.tanggal_pembuatan BETWEEN '{$tanggal_pembuatan[0]}' and '{$tanggal_pembuatan[1]}'");
			}

			if(isset($s['tanggal_terima']) and !empty($s['tanggal_terima']))
			{
				$tanggal_terima = explode(' to ', $s['tanggal_terima']);

				$this->db->where("tanda_terima.tanggal_terima BETWEEN '{$tanggal_terima[0]}' and '{$tanggal_terima[1]}'");
			}
		}

		$this->db->order_by('tanda_terima.id', 'DESC');

		$i = $this->db->get();

		return $i->result_array();
	}

	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id)
	{
		$this->db->select($this->t_table.'.*, invoice.no_invoice, invoice.nominal, invoice.date, invoice.sales_order_id');
		$this->db->from($this->t_table);
		$this->db->join('invoice', 'invoice.id='.$this->t_table.'.invoice_id');
		$this->db->where([$this->t_table.'.id' => $id]);

		$i = $this->db->get();
		
		return $i->row_array();
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Impor
 * @by    : doni(doni.enginer@gmail.com)
 * @date  : Oktober 2012
 **/
 
 class Invoice_model extends CI_Model
 {
  var $t_table  = 'invoice';

  /**
   * Constructor
   * @param -
   * @return  -
   **/
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Data Investasi
   * @param id, page, limit, search
   * @return  array
   **/
  public function data_($s = null)
  {
    $this->db->select($this->t_table.'.*, so.no_so, c.name, c.company, c.tipe_customer, t.tanggal_terima, invoice.overdue, qo.sistem_pembayaran');
    $this->db->from($this->t_table);
    $this->db->join('sales_order as so', 'so.id='. $this->t_table .'.sales_order_id');
    $this->db->join('quotation_order as qo', 'qo.id=so.quotation_order_id');
    $this->db->join('customer as c', 'c.id=qo.customer_id');
    $this->db->join('tanda_terima t', 't.invoice_id=invoice.id', 'left');

   if(!empty($s))
    {
      if(isset($s['status']) and !empty($s['status']))
        $this->db->where(['invoice.status' => ($s['status'] == 'lunas' ? 1 : 0)]);

      if(isset($s['customer_id']) and !empty($s['customer_id']))
        $this->db->where(['c.id' => $s['customer_id']]);

      if(isset($s['sales_order_id']) and !empty($s['sales_order_id']))
        $this->db->where(['so.id' => $s['sales_order_id']]);

      if(isset($s['invoice_id']) and !empty($s['invoice_id']))
        $this->db->where(['invoice.id' => $s['invoice_id']]);
      
      if(isset($s['sistem_pembayaran']) and !empty($s['sistem_pembayaran']))
        $this->db->where(['qo.sistem_pembayaran' => $s['sistem_pembayaran']]);

      if(isset($s['tanggal']) and !empty($s['tanggal']))
      {
        $tanggal = explode(' to ', $s['tanggal']);

        $this->db->where("invoice.date BETWEEN '{$tanggal[0]}' and '{$tanggal[1]}'");
      }
    }

    $i = $this->db->get();
      
    return $i->result_array();
  }
}

?>
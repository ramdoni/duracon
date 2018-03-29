<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Pembayaran </h2>&nbsp;&nbsp; <a href="<?=site_url('inputpembayaran/insert')?>" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-plus"></i> Input Pembayaran</a>
        <div class="clearfix"></div>
      </div>

      <div class="x_content" style="overflow-x: auto;">
        <form metho="get" action="" class="form-horizontal form-label-left filter-form">
            <div class="col-md-3">
              <select class="form-control" name="customer_id">
                <option value=""> - All Customer - </option>
                <?php 
                  $customer = $this->db->get_where('customer', ['active' => 1])->result_array();
                  foreach($customer as $i) { 
                    if($i['tipe_customer'] == 'Perorangan')
                      $name = $i['name'];
                    else
                      $name = $i['company'];

                    $selected = "";

                    if(isset($_GET['customer_id']) and !empty($_GET['customer_id']) and $_GET['customer_id'] == $i['id'])
                    {
                      $selected = " selected";
                    }

                ?>
                    <option value="<?=$i['id']?>" <?=$selected?>><?=$name?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-3">
              <select class="form-control" name="sales_order_id">
                <option value=""> - All Sales Order - </option>
                  <?php
                    $so = $this->db->get_where('sales_order', ['position' => 5])->result_array();

                    if(isset($_GET['customer_id']) and !empty($_GET['customer_id']))
                      $so = $this->db->query("SELECT so.* FROM sales_order so inner join quotation_order qo on qo.id=so.quotation_order_id WHERE qo.customer_id={$_GET['customer_id']} and so.position=5")->result_array();
                  ?>
                  <?php foreach($so as $i):?>
                    <?php
                      $selected = "";

                      if(isset($_GET['sales_order_id']) and !empty($_GET['sales_order_id']) and $_GET['sales_order_id'] == $i['id'])
                      {
                        $selected = " selected";
                      } 
                    ?>
                    <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_so']?></option>
                  <?php endforeach;?>
              </select>
            </div>

            <div class="col-md-3">
              <select class="form-control" name="invoice_id">
                <option value=""> - All Invoice - </option>
                  <?php
                    $select_invoice = $this->db->get('invoice')->result_array();

                    if(isset($_GET['sales_order_id']) and !empty($_GET['sales_order_id']))
                      $select_invoice = $this->db->get_where('invoice', ['sales_order_id' => $_GET['sales_oder_id']])->result_array();
                  ?>
                  <?php foreach($select_invoice as $i):?>
                    <?php
                      $selected = "";

                      if(isset($_GET['invoice_id']) and !empty($_GET['invoice_id']) and $_GET['invoice_id'] == $i['id'])
                      {
                        $selected = " selected";
                      } 
                    ?>
                    <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_invoice']?></option>
                  <?php endforeach;?>
              </select>
            </div>
          <button type="submit" class="btn btn-success btn-sm">Filter</button>
        </form>
        <br style="clear: both;" />
        <?php 
        $param = "?";
        foreach($_GET as $k => $g)
        {
          $param .="{$k}={$g}&";
        } 

        $param = substr($param, 0, -1);

        ?>
        <a href="<?=site_url('inputpembayaran/rekap'. $param)?>" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Cetak Rekapitulasi Pembayaran</a>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">Customer </th>
                <th class="column-title">Sales Order</th>
                <th class="column-title">Invoice</th>
                <th class="column-title">Nominal</th>
                <th class="column-title">Tanggal Input</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                  <td class="a-center "><?=($key+1)?></td>
                  <?php 
                      if($item['tipe_customer'] == 'Perorangan'){
                        echo '<td>'. $item['name'] .'</td>';
                      }else{
                        echo '<td>'. $item['company'].'</td>';
                      }
                  ?> 
                  <td><?=$item['no_so']?></td> 
                  <td><?=$item['no_invoice']?></td> 
                  <td>Rp. <?=number_format($item['nominal'])?></td>
                  <td><?=date('d F Y H:i:s', strtotime($item['date']))?></td> 
                  <td></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade" id="modal_invoice" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Buat Invoice</h4>
      </div>
      <div class="modal-body">

        <div class="x_content">
          <form class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Pilih No Sales Order : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="no_so">
                  <option value=""> -  NO SO - </option>
                  <?php foreach($this->db->get_where('sales_order', ['position' => 5])->result_array() as $item): ?>
                    <option value="<?=$item['id']?>"><?=$item['no_so']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </form>
        </div>
          <hr />
        <span class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</span>
        <span class="btn btn-success btn-sm" id="btn-submit-poinvoice" style="float: right;"> Submit <i class="fa fa-arrow-right"></i></span>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
  $("#btn-submit-poinvoice").click(function(){

    var no_so =  $('select#no_so').val();

    if(no_so == "")
    { 
      _alert('No SO harus dipilih');
    }else{
      window.location ='<?=site_url()?>arso/createinvoice/'+ no_so;
    }

  });

</script>
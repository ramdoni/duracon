<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Invoice</h2>&nbsp;&nbsp; <a href="#modal_invoice" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-plus"></i> Buat Invoice</a>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive" style="overflow-x: auto;">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="9">
                  <form method="get" action="" class="form-horizontal form-label-left filter-form">
                    <select class="form-control" name="status">
                          <option value=""> - Status Pembayaran</option>
                          <option value="belumlunas" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $_GET['status'] == 'belumlunas'){ echo ' selected';};?>> Belum Lunas </option>
                          <option value="lunas" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $_GET['status'] == 'lunas'){ echo ' selected';};?>> Lunas </option>
                      </select>
                      <select class="form-control" name="sistem_pembayaran">
                          <option value=""> - Jenis Pembayaran</option>
                          <option value="Cash" <?php if(isset($_GET['sistem_pembayaran']) and !empty($_GET['sistem_pembayaran']) and $_GET['sistem_pembayaran'] == 'Cash'){ echo ' selected';};?>> Cash </option>
                          <option value="Kredit" <?php if(isset($_GET['sistem_pembayaran']) and !empty($_GET['sistem_pembayaran']) and $_GET['sistem_pembayaran'] == 'Kredit'){ echo ' selected';};?>> Kredit </option>
                      </select>
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
                      <select class="form-control no_so" name="invoice_id">
                        <option value=""> - All Invoice - </option>
                          <?php $invoice = $this->db->get('invoice')->result_array(); ?>
                          <?php 
                            if(isset($_GET['sales_order_id']) and $_GET['sales_order_id'] != '')
                            {
                              $invoice = $this->db->get_where('invoice', ['sales_order_id' => $_GET['sales_order_id']])->result_array();
                            }
                          ?>

                          <?php foreach($invoice as $i):?>
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
                      <input type="text" name="tanggal" class="form-control date-range2" value="<?=(isset($_GET['tanggal']) ? $_GET['tanggal'] : '')?>" placeholder="Range Tanggal Pembuatan Invoice">
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                  </form>
                </th>
              </tr>
              <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">Customer </th>
                <th class="column-title">No SO </th>
                <th class="column-title">No Invoice</th>
                <th class="column-title">Tanggal Pembuatan</th>
                <th class="column-title">Tanggal Penerimaan</th>
                <th class="column-title">Overdue</th>
                <th class="column-title">Nominal</th>
                <th class="column-title">Status</th>
              </tr>
           
            </thead>
            <tbody>
            <?php 
              $total_nominal      = 0; 
              $total_outstanding  = 0;
            ?>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                  <td class="a-center "><?=($key+1)?></td>
                  <td>
                  <?php 
                    if($item['tipe_customer']=='Perorangan')
                    {
                      echo $item['name'];
                    }else{
                      echo $item['company'];
                    }
                  ?></td>
                  <td><?=$item['no_so']?></td> 
                  <td><?=$item['no_invoice']?></td> 
                  <td><?=date('d F Y', strtotime($item['date']))?></td> 
                  <td>
                    <?php 

                      if(!empty($item['tanggal_terima']) and $item['tanggal_terima'] != '0000-00-00')
                        echo date('d F Y', strtotime($item['tanggal_terima']));
                      else
                        echo '-';
                    ?>  
                  </td> 
                  <td>
                    <?php 
                      if($item['overdue'] != '0000-00-00'){
                        echo date('d F Y', strtotime($item['overdue']));
                      }elseif($item['sistem_pembayaran'] == 'Cash'){
                        echo date('d F Y', strtotime($item['date']));
                      } 
                    ?>    
                  </td> 
                  <td>Rp. <?=number_format($item['nominal'])?></td>
                  <td><?=status_invoice($item['status'])?></td>
                </tr>
                <?php 

                  if($item['status'] == 1)
                    $total_nominal += $item['nominal']; 
                  else
                    $total_outstanding += $item['nominal']; 

                ?>

            <?php endforeach; ?>
            

            </tbody>
             <tfoot>
              <tr>
                <th colspan="7" style="text-align: right;">Total Lunas</th>
                <th colspan="2">Rp. <?=number_format($total_nominal)?></th>
              </tr>
              <tr>
                <th colspan="7" style="text-align: right;">Total Outstanding</th>
                <th colspan="2">Rp. <?=number_format($total_outstanding)?></th>
              </tr>
            </tfoot>
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
<style type="text/css">
  .filter-form .form-control 
  {
    width: auto;
  }
</style>
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
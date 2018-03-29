
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tanda Terima</h2> &nbsp;
        <a href="<?=site_url('tandaterima/insert')?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Buat Tanda Terima</a>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="10">
                  <form method="get" action="" class="form-horizontal form-label-left filter-form">
                    <select name="status" class="form-control">
                        <option value=""> - All Status - </option>
                      <?php 

                        foreach([0 => '- On Progress -', 1 => '- Done -'] as $k => $i)
                        {
                          $selected = "";

                          if(isset($_GET['status']) and $_GET['status'] !="" and $_GET['status'] == $k)
                          {
                            $selected = " selected";
                          }

                          echo "<option value=\"{$k}\" {$selected}>{$i}</option>";

                        }
                      ?>
                    </select>
                     <select class="form-control" name="customer_id">
                        <option value=""> -  All Customer - </option>
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

                      <input type="text" name="tanggal_pembuatan" class="form-control date-range2" value="<?=(isset($_GET['tanggal_pembuatan']) ? $_GET['tanggal_pembuatan'] : '')?>" placeholder="Tanggal Pembuatan">
                      <input type="text" name="tanggal_terima" class="form-control date-range2" value="<?=(isset($_GET['tanggal_terima']) ? $_GET['tanggal_terima'] : '')?>" placeholder="Tanggal Terima">
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                  </form>
                </th>
              </tr>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">Customer </th>
                <th class="column-title">Sales Order </th>
                <th class="column-title">No Invoice </th>
                <th class="column-title">Tanggal Pembuatan </th>
                <th class="column-title">Tanggal Terima  </th>
                <th class="column-title">Faktur Pajak </th>
                <th class="column-title">Nominal </th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
              <?php $total_nominal = 0; ?>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=$key+1?></td>
                    <td>
                    <?php 
                      if($item['tipe_customer'] == 'Perorangan')
                        echo $item['name'];
                      else
                        echo $item['company'];
                    ?>
                    </td>
                    <td><?=$item['no_so']?></td>
                    <td><?=$item['no_invoice']?></td>
                    <td><?=date('d F Y', strtotime($item['tanggal_pembuatan']))?></td>
                    <td>
                      <?php 
                        if($item['tanggal_terima'] != '0000-00-00')
                          echo date('d F Y', strtotime($item['tanggal_terima']));
                      ?>    
                    </td>
                    <td><?=$item['faktur_pajak']?></td>
                    <td>Rp. <?=number_format($item['nominal'])?></td>
                    <td>
                      <?php 
                        if($item['status'] == 0)
                        {
                          echo '<span class="btn btn-xs btn-warning"> On Progress</span>';
                        }else{
                          echo '<span class="btn btn-xs btn-success"> Done</span>';
                        }
                      ?>
                    </td>
                    <td>
                      <?php if($item['status'] == 0):?>
                      <a href="<?=site_url('tandaterima/cetak/'. $item['id'])?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-print"></i> Cetak Tanda Terima </a><br />
                      <a class="btn btn-xs btn-success" onclick="tandaterima_selesai(<?=$item['id']?>, <?=$item['kredit_overdue_day']?>, <?=$item['invoice_id']?>)" target="_blank"><i class="fa fa-check"></i> Selesai</a>
                      <?php endif; ?>
                    </td>
                </tr>
            <?php $total_nominal += $item['nominal']; ?>
            <?php endforeach;?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="7" style="text-align: right;">Total Nominal</th>
                <th colspan="3"><?=number_format($total_nominal)?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modal_tandaterima" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tanda Terima AR</h4>
        </div>
        <div class="modal-body">
          
          <form id="modal-lokasi" action="<?=site_url('tandaterima/submitdone')?>" method="post" class="form-horizontal form-label-left">
            <input type="hidden" class="modal-tandaterimaid" name="tanda_terima_id" value="" />
            <input type="hidden" class="modal-invoiceid" name="invoice_id" value="" />
            <input type="hidden" name="overdue_day" value="" class="modal-overdue-day" />
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Tanggal Terima Penagihan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="tanggal_terima" class="form-control tanggal" value="<?=date('Y-m-d')?>" />
              Overdue (<span class="label-overdue-tanggal"></span> Hari dari tanggal penerimaan)
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</a>
              <button type="submit" class="btn btn-success btn-add-modal btn-sm"><i class="fa fa-save"></i> Submit</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function tandaterima_selesai(id, day, invoice_id)
    {
      $('.modal-invoiceid').val(invoice_id);
      $('.label-overdue-tanggal').html(day);
      $('.modal-overdue-day').val(day);

      $('.modal-tandaterimaid').val(id);

      $("#modal_tandaterima").modal('show');
    }
  </script>
 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Jalan</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="6">
                  <form method="get" action="" class="form-horizontal form-label-left filter-form">
                    <select class="form-control" name="status">
                          <option value=""> - Status Surat Jalan</option>
                          <option value="proses" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $_GET['status'] == 'proses'){ echo ' selected';};?>> On Progress </option>
                          <option value="selesai" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $_GET['status'] == 'lunas'){ echo ' selected';};?>> Selesai </option>
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
                      <select class="form-control no_so" name="surat_jalan_id">
                        <option value=""> - All Surat Jalan - </option>
                          <?php $invoice = $this->db->get('surat_jalan')->result_array(); ?>
                          <?php 
                            if(isset($_GET['surat_jalan_id']) and $_GET['surat_jalan_id'] != '')
                            {
                              $invoice = $this->db->get_where('surat_jalan', ['id' => $_GET['surat_jalan_id']])->result_array();
                            }
                          ?>

                          <?php foreach($invoice as $i):?>
                            <?php
                              $selected = "";

                              if(isset($_GET['surat_jalan_id']) and !empty($_GET['surat_jalan_id']) and $_GET['surat_jalan_id'] == $i['id'])
                              {
                                $selected = " selected";
                              } 
                            ?>
                            <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_surat_jalan']?></option>
                          <?php endforeach;?>
                      </select>
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                  </form>
                </th>
              </tr>
              <tr>
                <th>No</th>
                <th>Customer</th>
                <th>No SO</th>
                <th>No Surat Jalan</th>
                <th>Masa Berlaku</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?php 
                foreach($data as $key => $item)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".(nama_customer($item['customer_id']))."</td>";
                  echo "<td>".($item['no_so'])."</td>";
                  echo "<td>".($item['no_surat_jalan'])."</td>".

                      "<td>". date('d F Y', strtotime($item['date']))."</td>".
                      "<td>". status_spm($item['status']).'<br />'
                      ;
                ?>  
                <?php if($item['status'] == 4): ?>
                    <a onclick="_confirm('Surat Jalan telah diterima oleh AR?', '<?=site_url('suratjalanar/confirmar/'. $item['id'])?>')" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Diterima di AR</a>
                    <br />
                  <?php endif; ?>

                    <a href="<?=site_url()?>suratjalan/detail/<?=$item['id']?>" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i> Detail</a><br />

                    <?php  if($item['is_lock'] == 0){ ?>
                        <a class="btn btn-primary btn-xs" onclick="revisi_surat_jalan('<?=site_url('suratjalanar/revisi/'. $item['id'])?>')"><i class="fa fa-edit"></i> Revisi Surat Jalan</a>
                    <?php }?>
                    <?php 
                      // cek revisi surat jalan
                      $sj = $this->db->get_where('surat_jalan_lock_history', ['surat_jalan_id' => $item['id'], 'is_submit' => 1])->num_rows();
                      if($sj !=0):
                    ?>
                      <a href="<?=site_url('suratjalanar/printsuratjalan/'.$item['id'])?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-car"></i> Cetak Surat Jalan</span></a>
                    <?php endif; ?>

                  </td> 
                <?php 
                  echo "</tr>";
                }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade modal-wide" id="modal_revisi_surat_jalan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Revisi Surat Jalan</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left" method="POST" id="form_revisi" action="">
          <div class="form-group">  
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="date" class="form-control tanggal" required="true" value="<?=date('Y-m-d')?>" >
            </div>
          </div>

          <div class="form-group">  
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" name="catatan" placeholder="Catatan revisi surat jalan" required="true"></textarea>
            </div>
          </div>
          <hr />
          <span class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</span>
          <button type="submit" class="btn btn-sm btn-success" id="button-submit">Submit <i class="fa fa-arrow-right"></i> </button>
          <br style="clear: both">
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">


  function revisi_surat_jalan(url)
  {
    $('#modal_revisi_surat_jalan').modal('show');

    $('#form_revisi').attr('action', url);
  }

</script>

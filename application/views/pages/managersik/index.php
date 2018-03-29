<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Izin Kirim</h2> &nbsp;
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">Customer</th>
                <th class="column-title">Proyek</th>
                <th class="column-title">No. SIK</th>
                <th class="column-title">No PO</th>
                <th class="column-title">Sales</th>
                <th class="column-title">Alamat Pengiriman</th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data as  $key => $item):?>
                      <tr>
                        <td><?=($key+1)?></td>
                        <td><?=nama_customer($item['customer_id'])?></td>
                        <td><?=$item['proyek']?></td>
                        <td><?=$item['no_sik']?></td>
                        <td><?=$item['no_po']?></td>
                        <td><?=$item['sales']?></td>
                        <td><?=$item['alamat_pengiriman']?></td>
                        <td><?=position_sik($item['position'])?></td>
                        <td>
                          <?php if($item['position'] == 2):?>
                          <a href="<?=site_url("managersik/proccess/{$item['id']}")?>" title="Proccess" class="btn btn-success btn-xs">Proses <i class="fa fa-arrow-right"></i></a>
                          <?php endif; ?>

                          <?php if($item['position'] > 2){?>
                            <?php  if($item['is_lock'] == 0){ ?>
                              <a class="btn btn-danger btn-xs" onclick="modal_lock('<?=site_url('managersik/lock/'. $item['id'])?>')"><i class="fa fa-lock"></i> Lock SIK</a>
                            <?php }else{ ?>
                              <a class="btn btn-warning btn-xs" onclick="_confirm('Unlock SIK?', '<?=site_url('managersik/unlock/'. $item['id'])?>')"><i class="fa fa-unlock"></i> Unlock SIK</a>
                            <?php }?>
                          <?php } ?>

                          <span onclick="detail_sik(<?=$item['id']?>,'<?=$item['no_po']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Surat Izin Kirim"><i class="fa fa-search-plus"></i> Detail</span>
                        </td>
                      </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
       </div>
      </div>
    </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade modal-wide" id="modal_unlock" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lock SIK</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left" method="POST" id="form_unlock" action="">
          <div class="form-group">  
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Lock SIK</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" name="catatan" placeholder="Catatan"></textarea>
            </div>
          </div>
          <hr />
          <span class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</span>
          <button type="submit" class="btn btn-sm btn-success">Submit <i class="fa fa-arrow-right"></i> </button>
          <br style="clear: both">
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
  function modal_lock(url)
  {
    $('#modal_unlock').modal('show');

    $('#form_unlock').attr('action', url);
  }

</script>
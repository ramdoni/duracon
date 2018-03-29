<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Pengajuan Dispensasi</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-pengajuan" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Sales_order[approved]" value="0" />
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SO</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['no_so']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Nominal Pengajuan Dispensasi</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: Rp. <?=number_format($data['nominal_pengajuan'])?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Nominal yang disetujui</label>
            <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control idr" name="nominal" value="<?=number_format($data['nominal_pengajuan'])?>"></div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('arso')?>" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
              <a class="btn btn-danger btn-reject  btn-sm"><i class="fa fa-close"></i> Reject</a>
              <a class="btn btn-success btn-proccess  btn-sm">Approved <i class="fa fa-check"></i></a>
            </div>
          </div>
          <input type="hidden" name="status" class="status" value="0">
          <input type="hidden" name="sales_order_id" value="<?=$data['sales_order_id']?>">
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
  $(".btn-proccess").click(function(){

    var idr = $('.idr').val();

    if(idr == 'Rp. 0' || idr == "")
    {
      _alert('Masukan Nominal angka yang disetujui');

      return false;
    }

    $('.status').val(1);

    $('#form-pengajuan').submit();
  });

  $('.btn-reject').click(function(){

    _confirm('Tolak Pengajuan Dispensasi ini?', '<?=site_url("dispensasi/reject/{$data['id']}")?>');

  });
</script>
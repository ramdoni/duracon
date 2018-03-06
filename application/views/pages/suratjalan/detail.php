 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Jalan #<?=$sj['no_surat_jalan']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation 
              </label>
              <div class="col-md-6">
                <input type="text" id="no_sik" disabled="true" value="<?=$sj['no_po']?>"  class="form-control col-md-7 col-xs-10">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Sales Order 
              </label>
              <div class="col-md-6">
                <input type="text" id="no_sik" disabled="true" value="<?=$sj['no_so']?>"  class="form-control col-md-7 col-xs-10">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SIK 
              </label>
              <div class="col-md-6">
                <input type="text" id="no_sik" disabled="true" value="<?=$sj['no_sik']?>"  class="form-control col-md-7 col-xs-10">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="penerima_lapangan">Penerima Lapangan</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal" disabled="true" value="<?=$sj['penerima_lapangan']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">No Telepon</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['no_telepon']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Pengirimin</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="form-control" readonly="true"><?=$sj['proyek']?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">No SPM</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal" readonly="true" value="<?=$sj['no_spm']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">No Mobil</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['no_mobil']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">No Surat Jalan</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['no_surat_jalan']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Berlaku</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['date']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['catatan']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Produk</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['kode']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Volume</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tanggal"  readonly="true" value="<?=$sj['volume']?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>

          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_surat_jalan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-car"></i> Surat Jalan</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="spm_id">
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="post" action="<?=site_url()?>deliversik/batalsuratjalan/<?=$spm['id']?>">
           <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">Alasan Pembatalan Surat Jalan</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="hidden" name="surat_jalan_id" class="surat_jalan_id" />
              <textarea class="form-control catatan_spm" name="catatan" style="height: 200px; width: 100%;" placeholder="Ketik alasan pembatalan disini"></textarea>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <span class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</span>
              <button type="submit" class="btn btn-success btn-sm submit_pembatalan"  style="float: right;">Submit Pembatalan <i class="fa fa-check"></i></button>
            </div>
          </div> 

          </form>
        </div>
        <br style="clear: both;" />
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function cetak_surat_jalan()
  {

    bootbox.confirm({
      title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
      message: 'Buat Surat Jalan ?',
      buttons: {
          confirm: {
              label: 'Yes',
              className: 'btn-success'
          },
          cancel: {
              label: 'No',
              className: 'btn-danger'
          }
      },
      callback: function (result) {
        if(result)
        { 
            window.open('<?=site_url()?>deliversik/printsuratjalan/<?=$spm['id']?>', '_blank');
            location.reload();
        }
      }
    });
  }

</script>
<script src="<?=base_url()?>assets/js/surat-jalan.js?rand=<?=date('His')?>"></script>


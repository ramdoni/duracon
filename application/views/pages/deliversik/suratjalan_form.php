 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Jalan #No Surat Jalan : <?=$no_surat_jalan?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" class="sik_id" value="<?=$sik['id']?>">
          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Surat Jalan
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" value="<?=$no_surat_jalan?>" name="Suratjalan[no]" readonly="true" />
            </div>
          </div>
           <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Berlaku
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" value="<?=date('Y-m-d')?>" readonly="true" name="Spm[masa_berlaku]" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Alamat Pengirimin 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" required name="Sik[alamat_pengiriman]" disabled=""><?=$sik['alamat_pengiriman']?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Tipe Mobil <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required class="form-control select_tipe_mobil" name="Spm[tipe_mobil]">
                <option value=""> - Mobil - </option>
                <?php 
                  $mobil = ['Colt Diesel', 'Fuso', 'Tronton', 'Trailer'];
                  foreach($mobil as $i) {
                ?>
                    <option><?=$i?></option>
                <?php } ?>
                </select>
                <label class="label_beban_maksimal"></label>
            </div>
          </div>
          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Mobil <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" name="Spm[no_mobil]" required />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Barang yang akan dikirim </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required class="form-control select_produk" name="Spm[product_id]">
                <option value=""> - Kode Produksi - </option>
                <?php foreach($products as $i) {?>
                    <option value="<?=$i['id']?>"><?=$i['kode']?></option>
                <?php } ?>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Volume <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required class="form-control volume_yang_dikirim" name="Spm[volume_yang_dikirim]">
                  <option value=""> - Volume - </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="Spm[catatan]" class="form-control"></textarea>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-sm btn-danger"> <i class="fa fa-arrow-left"></i> Cancel</a>
              <button type="submit" class="btn btn-success btn-sm">Buat SPM <i class="fa fa-arrow-right"></i></button>
            </div>
          </div> 
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/spm.js?rand=<?=date('His')?>"></script>



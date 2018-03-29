 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Return Produk #No Surat Jalan : <?=$sj['no_surat_jalan']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" class="surat_jalan_id" value="<?=$sj['id']?>">
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
              <input type="text" class="form-control" readonly="true" value="<?=$spm['tipe_mobil']?>" />
            </div>
          </div>
          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Mobil
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" value="<?=$spm['no_mobil']?>" readonly="true" />
            </div>
          </div>

          <h2>Produk yang mau di return</h2>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th rowspan="2" style="width: 5%;">No</th>
                  <th rowspan="2">Kode</th>
                  <th colspan="3" style="text-align: center;">Volume yang di Return</th>
                  <th rowspan="2">Keterangan</th>
                  <th rowspan="2">#</th>
                </tr>
                <tr>
                  <th style="text-align: center;">Baik</th>
                  <th style="text-align: center;">Repair</th>
                  <th style="text-align: center;">Reject</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $data_product_sik = $this->db->query("SELECT s.*, p.kode FROM surat_izin_kirim_history s inner join products p on p.id=s.product_id WHERE surat_izin_kirim_id={$sik['id']}")->result_array();

                  foreach($data_product_sik as $key => $item):
                ?>
                  <tr>
                    <td><?=$key+1?></td>
                    <td><?=$item['kode']?></td>
                    <td>
                      <input type="hidden" name="Products[<?=$key?>][product_id]" value="<?=$item['product_id']?>" />
                      <select name="Products[<?=$key?>][baik]" class="form-control" required>
                        <option value=""> - Volume - </option>
                        <?php 
                          for($i=0; $i<= $item['volume_yang_dikirim']; $i++){
                            echo '<option>'. $i .'</option>';
                          } 
                        ?>
                      </select>
                    </td>
                    <td>
                      <select name="Products[<?=$key?>][repair]" class="form-control" required>
                        <option value=""> - Volume - </option>
                        <?php 
                          for($i=0; $i<= $item['volume_yang_dikirim']; $i++){
                            echo '<option>'. $i .'</option>';
                          } 
                        ?>
                      </select>
                    </td>
                    <td>
                      <select name="Products[<?=$key?>][reject]" class="form-control" required>
                        <option value=""> - Volume - </option>
                        <?php 
                          for($i=0; $i<= $item['volume_yang_dikirim']; $i++){
                            echo '<option>'. $i .'</option>';
                          } 
                        ?>
                      </select>
                    </td>
                    <td>
                      <input type="hidden" value="<?=$item['product_id']?>" name="Products[<?=$key?>][id]">
                      <textarea name="Products[<?=$key?>][keterangan]" class="form-control"></textarea>
                    </td>
                    <td>
                      <span class="bt btn-sm btn-danger" onclick="hapus_(this)"><i class="fa fa-trash"></i></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-sm btn-danger"> <i class="fa fa-arrow-left"></i> Cancel</a>
              <button type="submit" class="btn btn-success btn-sm">Submit Return <i class="fa fa-arrow-right"></i></button>
            </div>
          </div> 
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/spm.js?rand=<?=date('His')?>"></script>
<script type="text/javascript">
  function hapus_(id)
  {
    $(id).parent().parent().remove();
  }
</script>



 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Surat Perintah Muat</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-spm" method="post" class="form-horizontal form-label-left">
          <input type="hidden" class="sik_id" value="<?=$sik['id']?>">
          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No SPM
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" value="<?=$no_spm?>" name="Spm[no_spm]" readonly="true" />
            </div>
          </div>
           <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Berlaku
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" value="<?=date('d F Y')?>" readonly="true" name="Spm[masa_berlaku]" />
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobil <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required class="form-control select_mobil" required="true" name="Spm[mobil_id]">
                <option value=""> - Mobil - </option>
                <?php 
                  $mobil = $this->db->get('mobil')->result_array();
                  foreach($mobil as $i) {
                ?>
                    <option value="<?=$i['id']?>"><?=$i['no_mobil']?></option>
                <?php } ?>
                </select>
                <label class="label_beban_maksimal"></label>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe Mobil <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control tipe_mobil" readonly="true">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Supir <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control nama_supir">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Telepon <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control no_telepon">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kenek <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control kenek" readonly="true">
            </div>
          </div>

          <h2>Produk</h2>
            <table class="table table-bordered">
              <thead>
                  <th style="width: 5%;">No</th>
                  <th>Kode</th>
                  <th>Volume yang mau dikirim</th>
                  <th>Catatan</th>
              </thead>
              <tbody>
                <?php 
                  $data_product_sik = $this->db->query("SELECT s.*, p.kode FROM surat_izin_kirim_history s inner join products p on p.id=s.product_id WHERE surat_izin_kirim_id={$sik['id']}")->result_array();

                  foreach($data_product_sik as $key => $item):

                    $spm = $this->db->query("SELECT spm.*, sum(spmp.volume) as volume FROM surat_perintah_muat spm inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id WHERE spm.surat_izin_kirim_id={$sik['id']} and (spm.status=1 or spm.status = 2 or spm.status=0) and spmp.product_id={$item['product_id']}")->row_array();

                    $volume_yang_dikirim = $item['volume_yang_dikirim'] - $spm['volume'];

                    if($volume_yang_dikirim <= 0) continue;
                ?>
                  <tr>
                    <td><?=$key+1?></td>
                    <td><?=$item['kode']?></td>
                    <td>
                      <select name="Products[<?=$key?>][volume]" class="form-control volume_yang_dikirim">
                        <option value="0"> - Volume - </option>
                        <?php 
                          for($i=1; $i<= $volume_yang_dikirim; $i++){
                            echo '<option>'. $i .'</option>';
                          } 
                        ?>
                      </select>
                    </td>
                    <td>
                      <input type="hidden" value="<?=$item['product_id']?>" name="Products[<?=$key?>][id]">
                      <textarea name="Products[<?=$key?>][catatan]" class="form-control"></textarea>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-sm btn-danger"> <i class="fa fa-arrow-left"></i> Cancel</a>
              <span class="btn btn-success btn-sm" id="submit-spm">Buat SPM <i class="fa fa-arrow-right"></i></span>
            </div>
          </div> 
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/spm.js?rand=<?=date('His')?>"></script>
<script type="text/javascript">

  $("#submit-spm").click(function(){

    if($('.select_mobil').val() == "")
    {  
      _alert('Mobil Harus dipilih !');

      return false;
    }

    var vol = 0;
    $('select.volume_yang_dikirim').each(function(key, val){
      vol += parseInt(val.value);
    });
    console.log(vol);
    if(vol == 0)
    {
      _alert('Pilih Salah Satu Volume Produk yang akan dikirim');

      return false;
    }

    $('form#form-spm').submit();
  });

  $('.select_mobil').on('change', function(){
    
    var id = $(this).val();

    $.ajax({
        url: site_url+"ajax/getmobil", 
        data: {'id' : id},
        type: 'POST',
        success: function(result){

          if(result == null) return false;

          obj = JSON.parse(result); 

          $('.tipe_mobil').val(obj.jenis_mobil);
          $('.nama_supir').val(obj.nama_supir);
          $('.no_telepon').val(obj.no_telepon);
          $('.kenek').val(obj.kenek);
        }
      })
  });
</script>


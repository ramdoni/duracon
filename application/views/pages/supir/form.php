<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Supir</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Supir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nama" required="required" name="Supir[nama]" value="<?=(isset($data['nama']) ? $data['nama'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Telepon <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_telepon" required="required" name="Supir[no_telepon]" value="<?=(isset($data['no_telepon']) ? $data['no_telepon'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="Supir[alamat]" class="form-control"><?=(isset($data['alamat']) ? $data['alamat'] : '')?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No KTP <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_ktp" required="required" name="Supir[no_ktp]" value="<?=(isset($data['no_ktp']) ? $data['no_ktp'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Mobil <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_mobil" required="required" name="Supir[no_mobil]" value="<?=(isset($data['no_mobil']) ? $data['no_mobil'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe Mobil <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="Supir[tipe_mobil]">
               <option value=""> - Mobil - </option>
                <?php 
                  $mobil = ['Colt Diesel', 'Fuso', 'Tronton', 'Trailer'];
                  foreach($mobil as $i){

                    $selected = '';
                    if(isset($data['tipe_mobil']))
                    {
                      if($data['tipe_mobil'] == $i) $selected = ' selected';
                    }
                ?>
                    <option <?=$selected?>><?=$i?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Beban Maksimal (Kg) <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="beban_maksimal" required="required" name="Supir[beban_maksimal]" value="<?=(isset($data['beban_maksimal']) ? $data['beban_maksimal'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lahir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="beban_maksimal" required="required" name="Supir[tanggal_lahir]" value="<?=(isset($data['tanggal_lahir']) ? $data['tanggal_lahir'] : '')?>" class="form-control col-md-7 col-xs-12 tanggal">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kenek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nama_kenek" required="required" name="Supir[nama_kenek]" value="<?=(isset($data['nama_kenek']) ? $data['nama_kenek'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Telepon Kenek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_telepon_kenek" required="required" name="Supir[no_telepon_kenek]" value="<?=(isset($data['no_telepon_kenek']) ? $data['no_telepon_kenek'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No KTP Kenek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_ktp_kenek" required="required" name="Supir[no_ktp_kenek]" value="<?=(isset($data['no_ktp_kenek']) ? $data['no_ktp_kenek'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Kenek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="alamat_kenek" required="required" name="Supir[alamat_kenek]" value="<?=(isset($data['alamat_kenek']) ? $data['alamat_kenek'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="javascript:;" onclick="history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
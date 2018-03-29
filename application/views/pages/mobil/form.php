<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Mobil</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Vendor <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="vendor" required="required" name="Mobil[vendor]"  value="<?=(isset($data['vendor']) ? $data['vendor'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_mobil">No Mobil <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_mobil" required="required" name="Mobil[no_mobil]"  value="<?=(isset($data['no_mobil']) ? $data['no_mobil'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_mobil">Jenis Mobil <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required class="form-control select_tipe_mobil" name="Mobil[jenis_mobil]">
                <option value=""> - Jenis Mobil - </option>
                <?php 
                  $mobil = ['Colt Diesel', 'Fuso', 'Tronton', 'Trailer'];
                  foreach($mobil as $i) {

                    $selected = "";

                    if(isset($data['jenis_mobil']))
                    {
                      if($data['jenis_mobil'] == $i){
                        $selected = " selected";
                      }
                    }
                ?>
                    <option <?=$selected?>><?=$i?></option>
                <?php } ?>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_supir">Nama Supir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nama_supir" required="required" name="Mobil[nama_supir]"  value="<?=(isset($data['nama_supir']) ? $data['nama_supir'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">No Telepon <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_telepon" required="required" name="Mobil[no_telepon]"  value="<?=(isset($data['no_telepon']) ? $data['no_telepon'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kenek">Kenek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kenek" required="required" name="Mobil[kenek]"  value="<?=(isset($data['kenek']) ? $data['kenek'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon_kenek">No Telepon Kenek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_telepon_kenek" required="required" name="Mobil[no_telepon_kenek]"  value="<?=(isset($data['no_telepon_kenek']) ? $data['no_telepon_kenek'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="#" onclick="history.back()" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <button class="btn btn-primary btn-sm" type="reset"><i class="fa fa-refresh"></i> Reset</button>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Spesifikasi</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="spesifikasi">Spesifikasi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="spesifikasi" required="required" name="ProductSpecification[spesifikasi]" value="<?=(isset($data['spesifikasi']) ? $data['spesifikasi'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_produksi">Sistem Produksi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="sistem_produksi" required="required" name="ProductSpecification[sistem_produksi]" value="<?=(isset($data['sistem_produksi']) ? $data['sistem_produksi'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mutu_beton">Mutu Beton <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="mutu_beton" required="required" name="ProductSpecification[mutu_beton]" value="<?=(isset($data['mutu_beton']) ? $data['mutu_beton'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mutu_baja">Mutu Baja <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="mutu_baja" required="required" name="ProductSpecification[mutu_baja]" value="<?=(isset($data['mutu_baja']) ? $data['mutu_baja'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipe_semen">Tipe Semen <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tipe_semen" required="required" name="ProductSpecification[tipe_semen]" value="<?=(isset($data['tipe_semen']) ? $data['tipe_semen'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_joint">System Joint <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="sistem_joint" required="required" name="ProductSpecification[system_joint]" value="<?=(isset($data['system_joint']) ? $data['system_joint'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="status" class="form-control" name="ProductSpecification[active]">
              <?php 
                $i = [1 => 'Active', 0 => 'Inactive'];
    
                foreach($i as $key => $val) {

                  $selected = '';
                  if(isset($data['status']))
                  {
                    if($data['status'] == $key)
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option value="<?=$key?>" <?=$selected?>><?=$val?></option>

                  <?php } ?>
                </select>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('spesifikasi')?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
              <button class="btn btn-primary" type="reset">Reset</button>
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>  Save</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
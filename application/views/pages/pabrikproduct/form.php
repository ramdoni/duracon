<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Product</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_specification_id">Type Product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="product_specification_id" class="form-control" disabled="true" name="Pabrikproduct[product_category_id]">
              <?php 
                $i = $this->db->get('product_specification');
    
                foreach($i->result_array() as $i) {

                  $selected = '';
                  if(isset($data['product_specification_id']))
                  {
                    if($data['product_specification_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option value="<?=$i['id']?>" <?=$selected?>><?=$i['spesifikasi']?></option>

                  <?php } ?>
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Kode Product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="code" required="required" name="Pabrikproduct[kode]" readonly="true" value="<?=(isset($data['kode']) ? $data['kode'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uraian">Uraian Product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="uraian" required="required" name="Pabrikproduct[uraian]" readonly="true" value="<?=(isset($data['uraian']) ? $data['uraian'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock">Stok <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="stock" required="required" name="Pabrikproduct[stock]" value="<?=(isset($data['stock']) ? $data['stock'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="repair">Repair <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="repair" required="required" name="Pabrikproduct[repair]" value="<?=(isset($data['repair']) ? $data['repair'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="reject">Reject <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="reject" required="required" name="Pabrikproduct[reject]" value="<?=(isset($data['reject']) ? $data['reject'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="finishing">Finishing <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="finishing" required="required" name="Pabrikproduct[finishing]" value="<?=(isset($data['finishing']) ? $data['finishing'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" name="Pabrikproduct[keterangan]" required="required" placeholder="Keterangan update stok"></textarea>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('datastok')?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Stok</button>
            </div>`
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
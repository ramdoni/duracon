<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Produk</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_specification_id">Kategory Produk <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="product_specification_id" class="form-control" name="products[product_specification_id]">
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
              <input type="text" id="code" required="required" name="products[kode]" value="<?=(isset($data['kode']) ? $data['kode'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uraian">Uraian Product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="uraian" required="required" name="products[uraian]" value="<?=(isset($data['uraian']) ? $data['uraian'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="satuan">Satuan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="status" class="form-control" name="products[satuan]">
              <?php 
                $i = ['Pcs', 'Lembar', 'Batang'];
    
                foreach($i as $key => $val) {

                  $selected = '';
                  if(isset($data['satuan']))
                  {
                    if($data['satuan'] == $val)
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option <?=$selected?>><?=$val?></option>

                  <?php } ?>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="weight">Weight (Kg/Pc) <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="weight" required="required" name="products[weight]" value="<?=(isset($data['weight']) ? $data['weight'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Product Selling Price (Rp/Pc) <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="price" required="required" name="products[price]" value="<?=(isset($data['price']) ? $data['price'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="keterangan" value="<?=(isset($data['keterangan']) ? $data['keterangan'] : '')?>" required="required" name="products[keterangan]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="biaya_setting">Biaya Setting </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="biaya_setting" value="<?=(isset($data['biaya_setting']) ? $data['biaya_setting'] : '')?>" name="products[biaya_setting]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="products[active]" required id="status" class="form-control">
                <option value=""> - Status - </option>
                <?php 
                  foreach([1 => 'Actice', 0 =>'Inactive'] as $key => $i):

                    $selected = '';
                    if(isset($data['active']))
                    {
                      if($data['active'] == $key or $data['active'] == "")
                      {
                        $selected = ' selected';
                      }
                    }
                ?>
                <option <?=$selected?> value="<?=$key?>"><?=$i?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!--
          <h4>Biaya Area</h4>
          <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Area</th>
                      <th>Biaya Pengiriman</th>
                    </tr>
                  </thead>
                  <tbody class="add-table-product">
                    <?php 
                        $area = $this->db->get_where('area',['active'=> 1]);
                        foreach($area->result_object() as $key => $item):

                          if(isset($data['id'])){
                            $price = $this->db->get_where('product_biaya_area', ['area_id' => $item->id, 'product_id' => $data['id']])->row_array();
                            
                            if(!empty($price))
                              $price = $price['biaya'];
                            else
                              $price = 0;

                          }else{
                            $price = 0;
                          }
                      ?>
                        <tr>
                          <td><?=($key+1)?></td>
                          <td><?=$item->area?></td>
                          <td> 
                              <div class="col-md-3" style="padding:0">
                                <input type="text" class="form-control" name="area_biaya_setting[]" value="<?=$price?>" />
                                <input type="hidden" value="<?=$item->id?>" name="area_id[]" />
                              </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
          </div>
          -->
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a onclick="history.back();" class="btn btn-default">Cancel</a>
              <button class="btn btn-primary" type="reset">Reset</button>
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
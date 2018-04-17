<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form User</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="username" required="required" name="User[username]" value="<?=(isset($data['username']) ? $data['username'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name" required="required" name="User[name]" value="<?=(isset($data['name']) ? $data['name'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="email" id="email" required="required" name="User[email]" value="<?=(isset($data['email']) ? $data['email'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone" required="required" name="User[phone]" value="<?=(isset($data['phone']) ? $data['phone'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Jabatan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone" required="required" name="User[phone]" value="<?=(isset($data['jabatan']) ? $data['jabatan'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">User Group <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="User[user_group_id]">
              <?php 
                $i = $this->db->get('user_group');
    
                foreach($i->result_array() as $i) {

                  $selected = '';
                  if(isset($data['user_group_id']))
                  {
                    if($data['user_group_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option value="<?=$i['id']?>" <?=$selected?>><?=$i['user_group']?></option>

                  <?php } ?>
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?php
              if(isset($data['password'])){
              ?>
              <input type="password" id="password" placeholder="Isi password jika ingin merubahnya" name="User[password]" class="form-control col-md-7 col-xs-12">
              <?php } else {?>
              <input type="password" id="password" required="required" name="User[password]" class="form-control col-md-7 col-xs-12">
              <?php } ?>
            </div>
          </div>

          <?php 
            if(isset($data['user_group_id']) and ($data['user_group_id'] == 3 || $data['user_group_id'] == 4 )){
          ?>
          <div class="form-group sales-code">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="salescode">Kode Sales</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="salescode" value="<?=(isset($data['sales_code']) ? $data['sales_code'] : '')?>"  name="User[sales_code]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group sales-code">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_area">Kode Area</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode_area" value="<?=(isset($data['kode_area']) ? $data['kode_area'] : '')?>"  name="User[kode_area]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <?php }else{ ?>
          <div class="form-group sales-code" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="salescode">Kode Sales</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="salescode" value="<?=(isset($data['sales_code']) ? $data['sales_code'] : '')?>"  name="User[sales_code]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
           <div class="form-group sales-code" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_area">Kode Area</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode_area" value="<?=(isset($data['kode_area']) ? $data['kode_area'] : '')?>"  name="User[kode_area]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <?php } ?>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="User[active]" required id="status" class="form-control">
                <option value=""> - Status - </option>
                <?php 
                  foreach([1 => 'Active', 0 =>'Inactive'] as $key => $i):

                    $selected = '';
            
                    if(isset($data['active']) and $data['active'] == $key)
                    {
                      $selected = ' selected';
                    }
                ?>
                <option <?=$selected?> value="<?=$key?>"><?=$i?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div >
              <a href="javascript:;" onclick="history.back()" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <button class="btn btn-primary btn-sm" type="reset"><i class="fa fa-refresh"></i>  Reset</button>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  $("select[name='User[user_group_id]']").on('change', function(){
    
    if($(this).val() == 3)
    {
      $('.sales-code').show();
    }
    else
    {
      $('.sales-code').hide();
    }

  });

</script>
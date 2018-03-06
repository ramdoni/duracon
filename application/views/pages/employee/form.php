<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Employee</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name" required="required" name="Employee[name]" value="<?=(isset($data['name']) ? $data['name'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="email" id="email" required="required" name="Employee[email]" value="<?=(isset($data['email']) ? $data['email'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone" required="required" name="Employee[phone]" value="<?=(isset($data['phone']) ? $data['phone'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_of_birth">Date of Birth <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="date_of_birth" required="required" name="Employee[date_of_birth]" value="<?=(isset($data['date_of_birth']) ? $data['date_of_birth'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="place_of_birth">Place of Birth <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="place_of_birth" value="<?=(isset($data['place_of_birth']) ? $data['place_of_birth'] : '')?>" required="required"  name="Employee[place_of_birth]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="Employee[address]" required class="form-control col-md-7 col-xs-12"><?=(isset($data['address']) ? $data['address'] : '')?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="username" required="required" name="Employee[username]" value="<?=(isset($data['username']) ? $data['username'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Access <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="Employee[employee_access_id]">
              <?php 
                $i = $this->db->get('employee_access');
    
                foreach($i->result_array() as $i) {

                  $selected = '';
                  if(isset($data['employee_access_id']))
                  {
                    if($data['employee_access_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option value="<?=$i['id']?>" <?=$selected?>><?=$i['label']?></option>

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
              <input type="text" id="password" placeholder="Isi password jika ingin merubahnya" name="Employee[password]" class="form-control col-md-7 col-xs-12">
              <?php } else {?>
              <input type="text" id="password" required="required" name="Employee[password]" class="form-control col-md-7 col-xs-12">
              <?php } ?>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('products')?>" class="btn btn-primary">Cancel</a>
              <button class="btn btn-primary" type="reset">Reset</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
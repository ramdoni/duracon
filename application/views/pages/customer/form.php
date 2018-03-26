<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Customer</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="POST" action="" class="form-horizontal form-label-left">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipe">Tipe Customer <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control tipe-customer" name="Customer[tipe_customer]">
                  <option>BUMN</option>
                  <option>Swasta</option>
                  <option>Pekerjaan Umum</option>
                  <option>Perorangan</option>
                </select>
            </div>
          </div>
           <div class="form-group input-company" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company">Perusahaan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="company" name="Customer[company]" value="<?=(isset($data['company']) ? $data['company'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name" required="required" name="Customer[name]" value="<?=(isset($data['name']) ? $data['name'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="email" id="email" required="required" name="Customer[email]" value="<?=(isset($data['email']) ? $data['email'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telphone">Telphone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="telphone" required="required" name="Customer[telphone]" value="<?=(isset($data['telphone']) ? $data['telphone'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="handphone">Handphone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="handphone" required="required" name="Customer[handphone]" value="<?=(isset($data['handphone']) ? $data['handphone'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fax">Fax</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="fax" name="Customer[fax]" value="<?=(isset($data['fax']) ? $data['fax'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="Customer[address]" required class="form-control col-md-7 col-xs-12"><?=(isset($data['address']) ? $data['address'] : '')?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fax">Sales</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="Customer[sales_id]"  required="true">
                 <option value=""> - Sales - </option>
                 <?php 
                  $sales = $this->db->get_where('user', ['user_group_id' => 3])->result_array();
                  foreach($sales as $i):
                    $selected = "";
                    if(isset($data['sales_id'])){
                      if($data['sales_id'] == $i['id']) $selected = ' selected';
                    }
                 ?>
                  <option value="<?=$i['id']?>" <?=$selected?>><?=$i['name']?></option>
               <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode Customer</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode" required name="Customer[kode]" value="<?=(isset($data['kode']) ? $data['kode'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Customer[active]" required id="status" class="form-control">
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

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Sistem Pembayaran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select_sistem_pembayaran" required="true" name="Customer[sistem_pembayaran]">
                  <option value=""> - Sistem Pembayaran - </option>
                  <?php 
                    
                  $sistem_pembayaran  = ['Cash' => 'Cash', 'Kredit' => 'Kredit','Kredit dengan DP' => 'Kredit dengan DP', 'SCF' => 'SCF (Supply Chain Finance)', 'SKBDN' => 'SKBDN (Surat Kredit Berdokumen Dalam Negeri)' ];

                  foreach($sistem_pembayaran as $i => $k):

                    $selected = '';
                    if(isset($data['sistem_pembayaran']) and $data['sistem_pembayaran'] == $i)
                      $selected = ' selected';

                  ?>
                  <option <?=$selected?> value="<?=$i?>"><?=$k?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>

          <?php
            if(isset($data['sistem_pembayaran']) and ($data['sistem_pembayaran'] == 'Kredit' || $data['sistem_pembayaran'] == 'Kredit denga DP' || $data['sistem_pembayaran'] == 'SCF' || $data['sistem_pembayaran']=='SKBDN' )){
          ?>
          <div class="form-group dp">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dp">DP (%)</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" id="dp" name="Customer[dp]" value="<?=(isset($data['dp']) ? $data['dp'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group overdue_field">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kredit_overdue_day">Limit Overdue Kredit (Day)</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" id="kredit_overdue_day" name="Customer[kredit_overdue_day]" value="<?=(isset($data['kredit_overdue_day']) ? $data['kredit_overdue_day'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <?php } else { ?>
           <div class="form-group dp"  style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dp">DP (%)</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" id="dp" name="Customer[dp]" value="<?=(isset($data['dp']) ? $data['dp'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

            <div class="form-group overdue_field" style="display: none;">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kredit_overdue_day">Limit Overdue Kredit (Day)</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="kredit_overdue_day" name="Customer[kredit_overdue_day]" value="<?=(isset($data['kredit_overdue_day']) ? $data['kredit_overdue_day'] : '')?>" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
          <?php } ?>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a class="btn btn-warning btn-sm" onclick="history.back()"><i class="fa fa-arrow-left"></i> Back</a>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.tipe-customer').on('change', function(){
    if($(this).val() == 'Perorangan') {
      $('.input-company').hide();
    }else{
      $('.input-company').show();
    }
  });


  $('.select_sistem_pembayaran').on('change', function(){
     
     if($(this).val() != 'Cash'){
      $('.overdue_field').show();
      $('.dp').show();
     }else{
      $('.dp').hide();
     }    
  })

</script>
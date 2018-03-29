<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Proyek</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nama" required="required" name="Proyek[nama]" value="<?=(isset($data['nama']) ? $data['nama'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Tahun <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tahun" required="required" name="Proyek[tahun]" value="<?=(isset($data['tahun']) ? $data['tahun'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">PIC <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tahun" required="required" name="Proyek[pic]" value="<?=(isset($data['pic']) ? $data['pic'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Proyek[area_id]" id="select-area" class="form-control">
                <option value=""> - Area Kirim - </option>
                <?php 
                $product = $this->db->get('area');
                foreach($product->result_array() as $i):

                  $selected = '';
                  if(isset($data['area_id']))
                  {
                    if($data['area_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>

                <option value="<?=$i['id']?>" <?=$selected?>><?=$i['area']?></option>

              <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Lokasi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12 area-lokasi">
              <select name="Proyek[lokasi_id]" class="form-control">
              <?php 
                $this->db->from('area_lokasi');
                $this->db->select('lokasi.name as lokasi, lokasi.id');
                $this->db->join('lokasi', 'lokasi.id=area_lokasi.lokasi_id','left');
                $this->db->where(['area_lokasi.area_id' => $data['area_id']]);

                $lokasi = $this->db->get()->result_array();
                foreach($lokasi as $i):
                  $selected = '';
                  if(isset($data['lokasi_id']))
                  {
                    if($data['lokasi_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
              ?>
              <option value="<?=$i['id']?>" <?=$selected?>><?=$i['lokasi']?></option>
            <?php endforeach; ?>
             </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="status" class="form-control" name="Proyek[active]">
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
<script type="text/javascript">
  $("select#select-area").on("change", function(){

      var id_select = $(this).val();
      if(id_select != ""){

        $.ajax({
            url: "<?=site_url('ajax/getarealokasi')?>", 
            data: {id : id_select},
            success: function(result){

              if(result == null) return false;

              obj = JSON.parse(result);

              var str = "<select name=\"Proyek[lokasi_id]\" class=\"form-control\">";

              $.each(obj, function(i, val){
                str += "<option value=\""+ val.id +"\">"+ val.lokasi +"</option>";
              });

              str += "</select>";
              
              $('.area-lokasi').html(str);
            }
        });
      }
  });  
</script>

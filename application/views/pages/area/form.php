<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Area</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Area <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="area" required="required" name="Area[area]"  value="<?=(isset($data['area']) ? $data['area'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Rupiah Perkilo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="area" required="required" name="Area[price]"  value="<?=(isset($data['price']) ? $data['price'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="status" class="form-control" name="Area[active]">
              <?php 
                $i = [1 => 'Active', 0 => 'Inactive'];
    
                foreach($i as $key => $val) {

                  $selected = '';
                  if(isset($data['active']) and $data['active'] == $key)
                  {
                    $selected = ' selected';
                  }
                ?>
                  <option value="<?=$key?>" <?=$selected?>><?=$val?></option>

                  <?php } ?>
                </select>
            </div>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Lokasi</h2>
                <div class="clearfix"></div>      
              </div>
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 50px !important;">No</th>
                      <th>Provinsi</th>
                      <th>Kabupaten</th>
                      <th>Kecamatan</th>
                      <th>Kelurahan</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody class="add-table-lokasi">
                  <?php 
                      $area = $this->db->query("

                          SELECT ak.*, p.nama as provinsi, k.nama as kabupaten, kc.nama as kecamatan, kl.nama as kelurahan FROM area_kelurahan ak
                          LEFT JOIN provinsi p on p.id_prov=ak.provinsi_id
                          LEFT JOIN kabupaten k on k.id_kab=ak.kabupaten_id
                          LEFT JOIN kecamatan kc on kc.id_kec=ak.kecamatan_id
                          LEFT JOIN kelurahan kl on kl.id_kel=ak.kelurahan_id
                          WHERE ak.area_id=". $data['id'])->result_array();
                      foreach($area as $key => $item):
                  ?>
                      <tr>
                          <td><?=($key+1)?></td>
                          <td><?=$item['provinsi']?></td>
                          <td><?=$item['kabupaten']?></td>
                          <td><?=$item['kecamatan']?></td>
                          <td><?=$item['kelurahan']?></td>
                          <td><a href="<?=site_url()?>area/hapus_area_kelurahan?id=<?=$item['id']?>&area_id=<?=$data['id']?>" class="btn btn-danger btn-xs" onclick="return confirm('Hapus Area Kelurahan ini ?')">Hapus</a></td>
                      </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                <a class="btn btn-default btn-sm" style="float: right;" data-toggle="modal" href="#myModal"><i class="fa fa-plus"></i> Add Lokasi</a> 
              </div>
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
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Lokasi</h4>
        </div>
        <div class="modal-body">
          
          <form id="modal-lokasi" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">


           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Provinsi </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="provinsi">
                <option value="">Pilih Provinsi</option>
                <?php
                  $this->db->from('provinsi');
                  $provinsi = $this->db->get()->result_array();
                  foreach($provinsi as $item)
                  {
                ?>
                    <option value="<?=$item['id_prov']?>"><?=$item['nama']?></option>

                <?php } ?>
              </select>
            </div>  
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Kabupaten </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="kabupaten">
                <option value="">Pilih Kabupaten</option>
              </select>
            </div>  
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Kecamatan </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="kecamatan">
                <option value="">Pilih Kecamatan</option>
              </select>
            </div>  
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Kelurahan </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="kelurahan">
                <option value="">Pilih Kelurahan</option>
              </select>
            </div>  
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</a>
              <a class="btn btn-success btn-add-modal btn-sm"  data-dismiss="modal"><i class="fa fa-plus"></i> Add</a>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    


  $("select[name='provinsi']").on('change', function(){

  var id = $(this).val();

  $.ajax({
      url: site_url + "ajax/getkabupaten", 
      data: {'id' : id },
      type: 'GET',
      success: function(result){
        $("select[name='kabupaten']").html(result);
      }
  })
});

$("select[name='kabupaten']").on('change', function(){

  var id = $(this).val();

  $.ajax({
      url: site_url + "ajax/getkecamatan", 
      data: {'id' : id },
      type: 'GET',
      success: function(result){
        $("select[name='kecamatan']").html(result);
      }
  })
});

$("select[name='kecamatan']").on('change', function(){

  var id = $(this).val();

  $.ajax({
      url: site_url + "ajax/getkelurahan", 
      data: {'id' : id },
      type: 'GET',
      success: function(result){
        $("select[name='kelurahan']").html(result);
      }
  })
});


  var num_row=0;
  $('.btn-add-modal').click(function(){

    if($("select[name='provinsi']").val() == "" || $("select[name='kabupaten']").val() == "" || $("select[name='kecamatan']").val() == "" || $("select[name='kelurahan']").val() == ""){

      _alert("Data harus harus diisi");

      return false;
    } 

    num_row = ($('tbody.add-table-lokasi tr').length+1);

    var t_add = "<tr class=\"tr-"+(num_row)+"\">";
    

    t_add += "<td>"+ (num_row) 
                    +"<input type=\"hidden\" value=\""+ $("select[name='provinsi']").val() +"\" name=\"LokasiForm["+num_row+"][provinsi_id]\" />"
                    +"<input type=\"hidden\" value=\""+ $("select[name='kabupaten']").val() +"\" name=\"LokasiForm["+num_row+"][kabupaten_id]\" />"
                    +"<input type=\"hidden\" value=\""+ $("select[name='kecamatan']").val() +"\" name=\"LokasiForm["+num_row+"][kecamatan_id]\" />"
                    +"<input type=\"hidden\" value=\""+ $("select[name='kelurahan']").val() +"\" name=\"LokasiForm["+num_row+"][kelurahan_id]\" />";
    t_add += "</td>";
    t_add += "<td>"+ $("select[name='provinsi'] :selected").text() +"</td>";
    t_add += "<td>"+ $("select[name='kabupaten'] :selected").text() +"</td>";
    t_add += "<td>"+ $("select[name='kecamatan'] :selected").text() +"</td>";
    t_add += "<td>"+ $("select[name='kelurahan'] :selected").text() +"</td>";
    t_add += "<td class=\"btn-action\"><a href=\"javascript:\" title=\"Hapus\" onclick=\"hapus_item_temp("+ (num_row) +")\"><i class=\"fa fa-trash\"></i></a> &nbsp;";
    t_add += '</td>';
    t_add += "</tr>";
    
    $('.add-table-lokasi').append(t_add);
    
    obj = "";

    $('form#modal-lokasi select').val("");

  });

  function hapus_item_temp(lokasi_id){
    
    bootbox.confirm({
        title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
        message: "Hapus lokasi ini ?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
          if(result)
          { 
            $(".tr-"+lokasi_id).remove();
          }          
        }
      });
  }

  function hapus_item(lokasi_id){
    
    bootbox.confirm({
        title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
        message: "Hapus lokasi ini ?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
          if(result)
          { 
            $.ajax({
                url: "<?=site_url('ajax/deletelokasiarea')?>", 
                data: {id : lokasi_id},
                success: function(result){
                  $(".tr-"+lokasi_id).remove();
                }
            });
          }          
        }
      });
  }
  </script>

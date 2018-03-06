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
          <!--
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Harga Rupiah Perkilo Berdasarkan Jenis Mobil</h2>
                <div class="clearfix"></div>      
              </div>
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 50px !important;">No</th>
                      <th>Jenis Mobil</th>
                      <th>Rp. Rupiah Perkilo</th>
                    </tr>
                  </thead>
                  <tbody class="">

                    <?php 
                    if(!isset($data['id'])):
                      $mobil = $this->db->get('jenis_mobil')->result_array();
                        foreach($mobil as $k => $i):
                      ?>
                      <input type="hidden" name="jenis_mobil[]" value="<?=$i['id']?>">
                      <tr>
                        <td><?=($k+1)?></td>
                        <td><?=$i['jenis_mobil']?></td>
                        <td>Rp. <input type="text" name="rupiah_perkilo[]" class="form-control"></td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>


                    <?php if(isset($data['id'])): ?>
                      <?php 
                        
                        $sql = "SELECT a.id, a.jenis_mobil_id, j.jenis_mobil, a.rupiah_perkilo FROM area_biaya_pengiriman a inner join jenis_mobil j on a.jenis_mobil_id=j.id WHERE a.area_id={$data['id']}";
                        
                        $mobil = $this->db->query($sql)->result_array();

                        foreach($mobil as $k => $i):
                      ?>
                          <input type="hidden" name="jenis_mobil[]" value="<?=$i['jenis_mobil_id']?>">
                          <tr>
                            <td><?=($k+1)?></td>
                            <td><?=$i['jenis_mobil']?></td>
                            <td>Rp. <input type="text" name="rupiah_perkilo[]" value="<?=$i['rupiah_perkilo']?>" class="form-control"></td>
                          </tr>
                      <?php endforeach; ?> 

                      <?php  
                      
                      $total_ = $this->db->query($sql)->num_rows();
                      
                      if($total_ == 0):

                          $mobil = $this->db->get('jenis_mobil')->result_array();
                          foreach($mobil as $k => $i):
                        ?>
                        <input type="hidden" name="jenis_mobil[]" value="<?=$i['id']?>">
                        <tr>
                          <td><?=($k+1)?></td>
                          <td><?=$i['jenis_mobil']?></td>
                          <td>Rp. <input type="text" name="rupiah_perkilo[]" class="form-control"></td>
                        </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>

                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        -->

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
                      <th>Lokasi</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody class="add-table-lokasi">
                  <?php
                  if(isset($data['id'])):
                      $this->db->select('lokasi.id, lokasi.name, area_lokasi.id as id_area_lokasi');
                      $this->db->from('area_lokasi');
                      $this->db->join('lokasi', 'lokasi.id=area_lokasi.lokasi_id', 'left');
                      $this->db->where(['area_id' => $data['id']]);

                      $product = $this->db->get();

                     foreach($product->result_array() as $key => $i):
                    ?>
                      <tr class="tr-<?=$i['id_area_lokasi']?>">
                        <td><?=($key+1)?></td>
                        <td><a href="#" class="editable-text" data-type="text" data-url="<?=site_url()?>ajax/savelokasiname" data-pk="<?=$i['id']?>" ><?=$i['name']?></a></td>
                        <td>
                            <a href="javascript:" title="Hapus" onclick="hapus_item(<?=$i['id_area_lokasi']?>)"><i class="fa fa-trash"></i></a></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Lokasi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="lokasi" class="form-control modal-label-lokasi" />
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
  
  var num_row=0;
  $('.btn-add-modal').click(function(){

    if($('form#modal-lokasi input.modal-label-lokasi').val() == ""){

      _alert("Lokasi harus harus diisi");

      return false;
    } 

    num_row = ($('tbody.add-table-lokasi tr').length+1);

    var lokasi = $('input.modal-label-lokasi');
    var t_add = "<tr class=\"tr-"+(num_row)+"\">";
    

    t_add += "<td>"+ (num_row) 
                    +"<input type=\"hidden\" value=\""+lokasi.val()+"\" name=\"LokasiForm["+num_row+"][name]\" />";
    t_add += "</td>";
    t_add += "<td>"+ lokasi.val() +"</td>";
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

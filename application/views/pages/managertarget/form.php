  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Target Sales</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Tahun <span class="required">*</span>
              </label>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <select class="form-control" name="Sales_target[tahun]">
                  <option value=""> -- Tahun -- </option>
                  <?php 

                    $data_tahun = $this->db->query("SELECT tahun FROM sales_target GROUP BY tahun")->result_array();
                      
                    $array_tahun = [];
                    foreach($data_tahun as $t)
                    {
                      $array_tahun[$t['tahun']] = $t['tahun'];
                    }
                    
                    $tahun = [];
                    for($i = date('Y'); $i <= (date('Y')+5); $i++ )
                    {
                      if(isset($data['tahun']))
                      {
                        // jika tahun yang di edit dan tahun yang sama maka jangan di hide
                        if(in_array($i, $array_tahun) and $data['tahun'] != $i) continue;
                      }else{
                        // selain itu hide semua tahun yang sudah di gunakan untuk target sales
                        if(in_array($i, $array_tahun)) continue;
                      }

                      $tahun[$i] = $i;
                    }

                    foreach($tahun as $i):

                      $selected = '';

                      if(isset($data['id']))
                      {
                        if($i==$data['tahun']) $selected = ' selected';
                      }


                      echo '<option value="'. $i .'" '. $selected .'>'. $i .'</option>';
                    endforeach;
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="quartal_1">Quartal I <span class="required">*</span>
              </label>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <input type="text" id="quartal_1" required="required" value="<?=(isset($data['quartal_1']) ? $data['quartal_1'] : '')?>" name="Sales_target[quartal_1]" class="form-control col-md-7 col-xs-12 idr">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="quartal_2">Quartal II <span class="required">*</span>
              </label>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <input type="text" id="quartal_2" required="required" value="<?=(isset($data['quartal_2']) ? $data['quartal_2'] : '')?>" name="Sales_target[quartal_2]" class="form-control col-md-7 col-xs-12 idr">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="quartal_3">Quartal III <span class="required">*</span>
              </label>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <input type="text" id="quartal_3" required="required" value="<?=(isset($data['quartal_3']) ? $data['quartal_3'] : '')?>" name="Sales_target[quartal_3]" class="form-control col-md-7 col-xs-12 idr">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="quartal_4">Quartal VI <span class="required">*</span>
              </label>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <input type="text" id="quartal_4" required="required" value="<?=(isset($data['quartal_4']) ? $data['quartal_4'] : '')?>" name="Sales_target[quartal_4]" class="form-control col-md-7 col-xs-12 idr">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="x_panel">
              <div class="x_title">
                <h2>Sales <a class="btn btn-primary btn-sm" data-toggle="modal" href="#myModal" >Add Sales</a></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 50px;">No</th>
                      <th>Sales</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="add-table-sales">
                    <?php 
                      if(isset($data['id'])){

                        $products = $this->db->get_where('sales_target_user', ['sales_target_id' => $data['id']])->result_array();
                        
                        foreach($products as $key =>  $i):
                          $sales = $this->db->get_where('user', ['id' => $i['user_id']])->row_array();
                    ?>
                        <tr class="tr-<?=$i['id']?>">
                          <td><?=($key+1)?></td>
                          <td class="kode"><?=$sales['name']?></td>
                          <td class="btn-action" style="width: 50px;">
                              <a href="javascript:" title="Hapus" onclick="hapus_item(<?=$i['id']?>)" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Hapus</a>
                          </td>
                        </tr>
                    <?php
                        endforeach;
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <br style="clear: both;">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('managertarget')?>" class="btn btn-danger">Back</a>
              <button class="btn btn-warning" id="btn-reset" type="reset">Reset</button>
              <button type="submit" class="btn btn-primary">Save</button>
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
          <h4 class="modal-title">Add Sales</h4>
        </div>
        <div class="modal-body">
          
          <form id="modal-product" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Sales <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="sales_id" id="select-sales" class="form-control">
                <option value=""> - Select Sales - </option>
                <?php 
                $product = $this->db->get_where('user', ['user_group_id' => 3]);
                foreach($product->result_array() as $i):
                ?>
                <option value="<?=$i['id']?>"><?=$i['name']?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="#" class="btn btn-primary" data-dismiss="modal">Cancel</a>
              <a class="btn btn-success btn-add-modal"  data-dismiss="modal">Add</a>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
  var no_  = 1;

  $(".btn-add-modal").click(function(){

    var sales_id = $('select#select-sales option:selected').val();

    var html = '';

    html += '<tr><td>'+ no_ +'</td><td>'+ $('select#select-sales option:selected').text() +'</td></tr>';
    html += '<input type="hidden" name="SalesTargetUser[][user_id]" value="'+ sales_id +'" />';

    $('.add-table-sales').append(html);


    $('select#select-sales').val("");

    no_++;
  });

  function hapus_item(user_id){

    if(confirm('hapus data ini?'))
    {
      $.ajax({
            url: "<?=site_url('ajax/deletesalesusertarget')?>", 
            data: {id : user_id},
            type: "POST",
            success: function(result){
              $(".tr-"+user_id).remove();
            }
        });
    }
  }
</script>

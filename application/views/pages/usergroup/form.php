<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form User Group</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_group">User Group <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="user_group" required="required" name="Usergroup[user_group]" value="<?=(isset($data['user_group']) ? $data['user_group'] : '')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Usergroup[active]" required id="status" class="form-control">
                <option value=""> - Status - </option>
                <?php 
                  foreach([1 => 'Actice', 0 =>'Inactive'] as $key => $i):

                    $selected = '';
                    if(isset($data['status']))
                    {
                      if($data['status'] == $key)
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
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Access Management</h2>
                <div class="clearfix"></div>      
              </div>
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 50px !important;">No</th>
                      <th>Module</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="add-table-product">
                    
                      <tr>
                        <td>1</td>
                        <td>Quotation</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Delete</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Print</td>
                        <td></td>
                      </tr>

                       <tr>
                        <td>2</td>
                        <td>Sales Order</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Delete</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Print</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Products</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                       <tr>
                        <td>4</td>
                        <td>Customer</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Area Kirim</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Lokasi</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>Spesifikasi roduk</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>Proyek</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>Cabang</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>9</td>
                        <td>User List</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>10</td>
                        <td>Spesifikasi roduk</td>
                        <td><input type="checkbox" id="check-all" class="flat"> Create</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" id="check-all" class="flat"> Edit</td>
                        <td></td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>-->
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <button class="btn btn-primary btn-sm" type="reset"><i class="fa fa-refresh"></i> Reset</button>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
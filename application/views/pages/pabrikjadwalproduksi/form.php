<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Jadwal Produksi</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plan">Plan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="jadwal[plan]" id="plan" class="form-control" required>
                <option value=""> - Plan - </option>
                <?php 
                $product = [1 => 'Area Produksi Plan I', 2 => 'Area Produksi Plan II', 3 => 'Area Produksi Plan III', 4 => 'Area Produksi Plan IV'];
                foreach($product as $key => $i):

                  $selected = "";
                  if(isset($data['plan']))
                  {
                    if($data['plan'] == $key)
                    {
                      $selected = " selected";
                    }
                  }
                ?>
                  <option value="<?=$key?>" <?=$selected?> ><?=$i?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="periode">Periode <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" style="width: 50%;float: left;" name="bulan" required="true">
                <option value=""> - Bulan - </option>
                <?php 
                  $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7=>'Juli', 8=> "Agustus",9=>'September', 10 => 'Oktober', 11=>'November',12=>'Desember'];
                  foreach($bulan as $k => $i)
                  {
                    $selected = "";
                    if(isset($datat['bulan']))
                    {
                      if($data['bulan'] == $key)
                      {
                        $selected = " selected";
                      }
                    }

                    echo "<option value=\"$k\" {$selected}>$i</option>";
                  }
                ?>
              </select>
              <select class="form-control" style="width: 50%;float: left;" name="minggu" required="true">
                <option value=""> - Minggu Ke - </option>
                <?php 
                  $minggu = [1=>'Kesatu', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat'];
                  foreach($minggu as $k => $i)
                  {

                    $selected = '';
                    if(isset($data['minggu']))
                    {
                      if($data['minggu'] == $k)
                        $selected = ' selected';
                    }

                    echo "<option value=\"{$k}\" {$selected}>{$i}</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="periode">Periode <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="periode" required="required" name="tanggal" value="<?=(isset($data['start_date']) ? $data['start_date'] .' to '. $data['end_date'] : '')?>" class="form-control col-md-7 col-xs-12 date-range">
            </div>
          </div> -->

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Spv. Pengecoran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="jadwal[spv_pengecoran]" class="form-control" required value="<?=(isset($data['spv_pengecoran']) ? $data['spv_pengecoran']: '')?>" >
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Plan Jumlah Pekerja <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="jadwal[plan_pekerja]" class="form-control" required value="<?=(isset($data['plan_pekerja']) ? $data['plan_pekerja']: '')?>" >
            </div>
          </div>
          <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th class="column-title" rowspan="2" style="vertical-align: middle;">Produk </th>
                      <th class="column-title" rowspan="2" style="vertical-align: middle;">Jumlah Cetakan </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Senin </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Selasa </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Rabu </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Kamis </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Jumat </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Sabtu </th>
                      <th class="column-title" colspan="2" style="text-align: center;">Minggu </th>
                      <th class="column-title no-link last" colspan="3" style="text-align: center;"><span class="nobr">Total</span></th>
                    </tr>
                    <tr>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th>Shift 1</th>
                      <th>Shift 2</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="content">
                  <?php if(isset($data['id'])):

                    foreach($list_plan as $item):
                      
                      $total_shift1 = $item['day1_shift1']+$item['day2_shift1']+$item['day3_shift1']+$item['day4_shift1']+$item['day5_shift1']+$item['day6_shift1'];
                      $total_shift2 = $item['day1_shift2']+$item['day2_shift2']+$item['day3_shift2']+$item['day4_shift2']+$item['day5_shift2']+$item['day6_shift2'];

                      $total_cetakan = $total_shift1 + $total_shift2;
                      $bg = "";

                      if($item['pengecoran'] == 3) $bg = 'bgblue';
                      if($item['pengecoran'] >= 4) $bg = 'bgred';
                      if($item['is_revisi'] ==1) $bg ='bggreen';

                  ?>
                    <tr class="product-plan<?=$item['id']?> <?=$bg?>">
                        <td><?=$item['product']?> 
                          <input type="hidden" name="product_id_old[]" value="<?=$item['product_id']?>">  
                          <input type="hidden" name="plan_id[]" value="<?=$item['id']?>">  
                          <input type="hidden" name="cetakan_old[]" value="<?=$item['cetakan']?>">  
                          <input type="hidden" name="pengecoran_old[]" value="<?=$item['pengecoran']?>">  
                        </td>
                        <td><?=$item['cetakan']?></td>
                        <td><input type="text" value="<?=$item['day1_shift1']?>" name="day1_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day1_shift2']?>" name="day1_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day2_shift1']?>" name="day2_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day2_shift2']?>" name="day2_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day3_shift1']?>" name="day3_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day3_shift2']?>" name="day3_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day4_shift1']?>" name="day4_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day4_shift2']?>" name="day4_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day5_shift1']?>" name="day5_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day5_shift2']?>" name="day5_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day6_shift1']?>" name="day6_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day6_shift2']?>" name="day6_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day7_shift1']?>" name="day7_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day7_shift2']?>" name="day7_shift2_old[]" class="form-control" /></td>
                        <td><?=$total_shift1?></td>
                        <td><?=$total_shift2?></td>
                        <td><a href="javacript:;" class="btn btn-danger btn-xs" onclick="hapus_plan_item(<?=$item['id']?>)" title="Hapus data ini"><i class="fa fa-trash"></i></a></td>
                    </tr>
                  <?php endforeach; ?>

                   <?php 

                    foreach($list_plan_revisi as $item):
                      
                      $total_shift1 = $item['day1_shift1']+$item['day2_shift1']+$item['day3_shift1']+$item['day4_shift1']+$item['day5_shift1']+$item['day6_shift1'];
                      $total_shift2 = $item['day1_shift2']+$item['day2_shift2']+$item['day3_shift2']+$item['day4_shift2']+$item['day5_shift2']+$item['day6_shift2'];

                      $total_cetakan = $total_shift1 + $total_shift2;
                      $bg = "";
                      $bg ='bggreen';

                  ?>
                    <tr class="product-plan<?=$item['id']?> <?=$bg?>">
                        <td><?=$item['product']?> 
                          <input type="hidden" name="product_id_old[]" value="<?=$item['product_id']?>">  
                          <input type="hidden" name="plan_id[]" value="<?=$item['id']?>">  
                          <input type="hidden" name="cetakan_old[]" value="<?=$item['cetakan']?>">  
                          <input type="hidden" name="pengecoran_old[]" value="<?=$item['pengecoran']?>">  
                        </td>
                        <td><?=$item['cetakan']?></td>
                        <td><input type="text" value="<?=$item['day1_shift1']?>" name="day1_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day1_shift2']?>" name="day1_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day2_shift1']?>" name="day2_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day2_shift2']?>" name="day2_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day3_shift1']?>" name="day3_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day3_shift2']?>" name="day3_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day4_shift1']?>" name="day4_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day4_shift2']?>" name="day4_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day5_shift1']?>" name="day5_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day5_shift2']?>" name="day5_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day6_shift1']?>" name="day6_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day6_shift2']?>" name="day6_shift2_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day6_shift1']?>" name="day7_shift1_old[]" class="form-control" /></td>
                        <td><input type="text" value="<?=$item['day6_shift2']?>" name="day7_shift2_old[]" class="form-control" /></td>
                        <td><?=$total_shift1?></td> 
                        <td><?=$total_shift2?></td>
                        <td><a href="javacript:;" class="btn btn-danger btn-xs" onclick="hapus_plan_item(<?=$item['id']?>)" title="Hapus data ini"><i class="fa fa-trash"></i></a></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
            <a class="btn btn-primary btn-xs" data-toggle="modal" href="#myModal" ><i class="fa fa-plus"></i> Tambah Produk</a>
            <div class="ln_solid"></div>
            <div class="form-group">
            <div>
              <a href="#" onclick="history.back();" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan Jadwal </button>
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
          <h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Product</h4>
        </div>
        <div class="modal-body">
          
          <form id="modal-product" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

          <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Kode Product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="product[kode]" id="select-kode" class="form-control">
                <option value=""> - Product - </option>
                <?php 
                $product = $this->db->get('products');
                foreach($product->result_array() as $i):
                ?>
                <option value="<?=$i['id']?>"><?=$i['kode']?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="uraian">Uraian Product : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-uraian" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="stock">Stok</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-stock" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Jumlah Cetakan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control jumlah_cetakan" name=""></div>
          </div>
           <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Jumlah Cetak / Cor <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control jumlah_cor">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
              </select>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('products')?>" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Batal</a>
              <a class="btn btn-success btn-add-modal btn-sm"  data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
<!-- /end modal -->
<script src="<?=base_url()?>assets/js/jadwal-produksi.js?rand=<?=date('His')?>"></script>
<style type="text/css">
ul li {
  list-style: none;
}
  .bgred {
    background: #fba09c !important;
  }
  .bgblue {
    background: #b1d3ff !important;
  }
  .bggreen {
    background: #59d659 !important;
  }

</style>

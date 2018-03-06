<?php 
  $minggu = [1=>'Kesatu', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat'];
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Lembar Kerja</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">
          <input type="hidden" class="product_schedule_id" value="<?=$data['id']?>" />
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plan">Plan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="plan" class="form-control" disabled>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Periode
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" style="width: 50%;float: left;" disabled value="<?=date('F', mktime(0, 0, 0, $data['bulan'], 10))?>" >
              <input type="text" class="form-control" style="width: 50%;float: left;" disabled value="Minggu <?=$minggu[$data['minggu']]?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Spv. Pengecoran
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" disabled value="<?=(isset($data['spv_pengecoran']) ? $data['spv_pengecoran']: '')?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Plan Jumlah Pekerja
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" disabled value="<?=(isset($data['plan_pekerja']) ? $data['plan_pekerja']: '')?>" >
            </div>
          </div>
          <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr class="headings">
                      <th class="column-title" rowspan="3" style="vertical-align: middle;">Kode Produksi </th>
                      <th class="column-title" rowspan="3" style="vertical-align: middle;">Berat Produk </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Senin </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Selasa </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Rabu </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Kamis </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Jumat </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Sabtu </th>
                      <th class="column-title" colspan="4" style="text-align: center;">Minggu </th>
                    </tr>
                    <tr class="tr-number-right">
                      <?php foreach([1,2,3,4,5,6,7] as $a ): ?>
                            <?php foreach([1, 2] as $b): ?>
                             
                            <?php endforeach; ?>
                             <th>Plan</th>
                              <th>Kg</th>
                              <th>Act</th>
                              <th>Kg</th>
                        <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody class="content" style="color: black !important;">
                  <?php if(isset($data['id'])):

                    $total_senin_plan = 0;
                    $total_senin_kg = 0;
                    $total_senin_act = 0;
                    $total_senin_act_kg = 0;

                    $total_selasa_plan = 0;
                    $total_selasa_kg = 0;
                    $total_selasa_act = 0;
                    $total_selasa_act_kg = 0;

                    $total_rabu_plan = 0;
                    $total_rabu_kg = 0;
                    $total_rabu_act = 0;
                    $total_rabu_act_kg = 0;

                    $total_kamis_plan = 0;
                    $total_kamis_kg = 0;
                    $total_kamis_act = 0;
                    $total_kamis_act_kg = 0;

                    $total_jumat_plan = 0;
                    $total_jumat_kg = 0;
                    $total_jumat_act = 0;
                    $total_jumat_act_kg = 0;

                    $total_sabtu_plan = 0;
                    $total_sabtu_kg = 0;
                    $total_sabtu_act = 0;
                    $total_sabtu_act_kg = 0;


                    $total_minggu_plan = 0;
                    $total_minggu_kg = 0;
                    $total_minggu_act = 0;
                    $total_minggu_act_kg = 0;

                    foreach($list_plan as $item):
                      
                      $total_shift1 = $item['day1_shift1']+$item['day2_shift1']+$item['day3_shift1']+$item['day4_shift1']+$item['day5_shift1']+$item['day6_shift1']+$item['day7_shift1'];
                      $total_shift2 = $item['day1_shift2']+$item['day2_shift2']+$item['day3_shift2']+$item['day4_shift2']+$item['day5_shift2']+$item['day6_shift2']+$item['day7_shift2'];

                      $total_cetakan = $total_shift1 + $total_shift2;
                      $bg = "";

                      if($item['pengecoran'] == 3) $bg = 'bgblue';
                      if($item['pengecoran'] >= 4) $bg = 'bgred';
                  ?>
                    <tr class="product-plan<?=$item['id']?> <?=$bg?>">
                        <td><?=$item['product']?> </td>
                        <td class="right-text"><?=$item['cetakan']?></td>
                        <?php foreach([1,2,3,4,5,6,7] as $hari ): ?>
                            <?php 
                            $total_act = 0;
                            $total_plan = 0;
                            foreach([1, 2] as $shift):
                              $total_act  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['tulangan_id'])['hasil_produksi'];
                              $total_plan += $item['day'.$hari.'_shift'.$shift];
                            endforeach; 
                            
                            if($hari == 1)
                            {
                              $total_senin_plan +=$total_plan;
                              $total_senin_kg += ($total_plan*$item['weight']);
                              $total_senin_act += $total_act;
                              $total_senin_act_kg += ($total_act * $item['weight']);
                            }

                            if($hari == 2)
                            {
                              $total_selasa_plan +=$total_plan;
                              $total_selasa_kg += ($total_plan*$item['weight']);
                              $total_selasa_act += $total_act;
                              $total_selasa_act_kg += ($total_act * $item['weight']);
                            }

                            if($hari == 3)
                            {
                              $total_rabu_plan +=$total_plan;
                              $total_rabu_kg += ($total_plan*$item['weight']);
                              $total_rabu_act += $total_act;
                              $total_rabu_act_kg += ($total_act * $item['weight']);
                            }

                            if($hari == 4)
                            {
                              $total_kamis_plan +=$total_plan;
                              $total_kamis_kg += ($total_plan*$item['weight']);
                              $total_kamis_act += $total_act;
                              $total_kamis_act_kg += ($total_act * $item['weight']);
                            }

                            if($hari == 5)
                            {
                              $total_jumat_plan +=$total_plan;
                              $total_jumat_kg += ($total_plan*$item['weight']);
                              $total_jumat_act += $total_act;
                              $total_jumat_act_kg += ($total_act * $item['weight']);
                            }

                            if($hari == 6)
                            {
                              $total_sabtu_plan +=$total_plan;
                              $total_sabtu_kg += ($total_plan*$item['weight']);
                              $total_sabtu_act += $total_act;
                              $total_sabtu_act_kg += ($total_act * $item['weight']);
                            }

                            if($hari == 7)
                            {
                              $total_minggu_plan +=$total_plan;
                              $total_minggu_kg += ($total_plan*$item['weight']);
                              $total_minggu_act += $total_act;
                              $total_minggu_act_kg += ($total_act * $item['weight']);
                            }

                            ?>
                            <td><?=$total_plan?></td>
                            <td><?=round(($total_plan*$item['weight']) / 1000, 1)?> Ton</td>
                            <td><?=$total_act?></td>
                            <td><?=round(($total_act * $item['weight']) / 1000, 1)?> Ton</td>
                        <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>

                  <?php 
                    foreach($list_plan_revisi as $item):
                      
                      $total_shift1 = $item['day1_shift1']+$item['day2_shift1']+$item['day3_shift1']+$item['day4_shift1']+$item['day5_shift1']+$item['day6_shift1']+$item['day7_shift1'];
                      $total_shift2 = $item['day1_shift2']+$item['day2_shift2']+$item['day3_shift2']+$item['day4_shift2']+$item['day5_shift2']+$item['day6_shift2']+$item['day7_shift2'];

                      $total_cetakan = $total_shift1 + $total_shift2;

                  ?>
                    <tr class="product-plan<?=$item['id']?> bggreen">
                        <td><?=$item['product']?> </td>
                        <td class="right-text"><?=$item['weight']?></td>
                        <?php foreach([1,2,3,4,5,6,7] as $hari ): ?>
                            <?php 
                            $total_act = 0;
                            $total_plan = 0;
                            foreach([1, 2] as $shift):
                              $total_act  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['tulangan_id'])['hasil_produksi'];
                              $total_plan += $item['day'.$hari.'_shift'.$shift];
                            endforeach; 

                            $total_senin_plan +=$total_plan;

                            ?>
                            <td><?=$total_plan?></td>
                            <td><?=round((($total_plan*$item['weight']) / 1000), 1)?> Ton</td>
                            <td><?=$total_act?></td>
                            <td><?=round(($total_act * $item['weight']), 1)?></td>
                        <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th style="text-align: right;" colspan="2">Total</th>
                      <th><?=$total_senin_plan?></th>
                      <th><?=round($total_senin_kg / 1000, 1)?></th>
                      <th><?=$total_senin_act?></th>
                      <th><?=round($total_senin_act_kg / 1000, 1)?></th>

                      <th><?=$total_selasa_plan?></th>
                      <th><?=round($total_selasa_kg / 1000, 1)?></th>
                      <th><?=$total_selasa_act?></th>
                      <th><?=round($total_selasa_act_kg / 1000, 1)?></th>

                      <th><?=$total_rabu_plan?></th>
                      <th><?=round($total_rabu_kg / 1000, 1)?></th>
                      <th><?=$total_rabu_act?></th>
                      <th><?=round($total_rabu_act_kg / 1000, 1)?></th>

                      <th><?=$total_kamis_plan?></th>
                      <th><?=round($total_kamis_kg / 1000, 1)?></th>
                      <th><?=$total_kamis_act?></th>
                      <th><?=round($total_kamis_act_kg / 1000, 1)?></th>

                      <th><?=$total_jumat_plan?></th>
                      <th><?=round($total_jumat_kg / 1000, 1)?></th>
                      <th><?=$total_jumat_act?></th>
                      <th><?=round($total_jumat_act_kg / 1000, 1)?></th>

                      <th><?=$total_sabtu_plan?></th>
                      <th><?=round($total_sabtu_kg / 1000, 1)?></th>
                      <th><?=$total_sabtu_act?></th>
                      <th><?=round($total_sabtu_act_kg / 1000, 1)?></th>

                      <th><?=$total_minggu_plan?></th>
                      <th><?=round($total_minggu_kg / 1000, 1)?></th>
                      <th><?=$total_minggu_act?></th>
                      <th><?=round($total_minggu_act_kg / 1000, 1)?></th>

                    </tr>
                  </tfoot>
                </table>
              </div>
            <div class="ln_solid"></div>
            <div class="form-group">
            <div>
              <a href="#" onclick="history.back();" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="moda_hasil_lembar_kerja" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-database"></i> Tambah Lembar Hasil Kerja Harian</h4>
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
              foreach($list_plan as $i): ?>
              <option value="<?=$i['product_id']?>"><?=$i['product']?></option>
            <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="uraian">Uraian Product : </label>
          <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-uraian" style="text-align: left;"></label>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Hari <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="modal-day form-control">
                <option value="1">Senin</option>
                <option value="2">Selasa</option>
                <option value="3">Rabu</option>
                <option value="4">Kamis</option>
                <option value="5">Jumat</option>
                <option value="6">Sabtu</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Shift <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="modal-shift form-control">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Aktual Jumlah Pekerja <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control modal-aktual_jumlah_pekerja"></div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Jam Lembur <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control modal-jam_lembur"></div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Jumlah Pekerja Lembur <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control modal-jumlah_pekerja"></div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Jumlah Hasil Produksi <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control modal-hasil_produksi"></div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Finishing <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control modal-finishing"></div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Reject <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12"><input type="number" class="form-control modal-reject"></div>
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

<!-- Modal -->
<div class="modal fade" id="modal_print_lembar_kerja" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-print"></i> Cetak Lembar Kerja Harian</h4>
      </div>
      <div class="modal-body">
        
        <form id="modal-product" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Hari <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="modal2-day form-control">
                <option value="1">Senin</option>
                <option value="2">Selasa</option>
                <option value="3">Rabu</option>
                <option value="4">Kamis</option>
                <option value="5">Jumat</option>
                <option value="6">Sabtu</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 col-sm-3 col-xs-12" for="code">Shift <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="modal2-shift form-control">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
          </div>
        </div>
       
        <div class="ln_solid"></div>
        <div class="form-group">
          <div>
            <a href="<?=site_url('products')?>" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Batal</a>
            <a class="btn btn-default btn-cetak-modal btn-sm"  data-dismiss="modal"><i class="fa fa-print"></i> Cetak</a>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- /end modal -->
<script src="<?=base_url()?>assets/js/lembar-kerja.js?rand=<?=date('His')?>"></script> 
<style type="text/css">
.right-text {
  text-align: right;
}
.tr-number-right th {
  text-align: right;
}
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

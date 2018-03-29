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
              <input type="text" class="form-control" style="width: 50%;float: left;" disabled value="<?=$minggu[$data['minggu']]?>" >
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
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Man Hour
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" disabled value="0" >
            </div>
          </div>
          <a href="#modal_print_lembar_kerja" data-toggle="modal" class="btn btn-default btn-sm"><i class="fa fa-print" title="Cetak Lembar Kerja Harian"></i> Cetak Lembar Kerja Harian</a>
          <a href="<?=site_url("pabrikjadwalproduksi/reportmingguan/{$data['id']}")?>" class="btn btn-default btn-sm" title="Print"><i class="fa fa-bar-chart"></i> Report Mingguan</a>
          <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr class="headings">
                      <th class="column-title" rowspan="3" style="vertical-align: middle;">Kode Produksi </th>
                      <th class="column-title" rowspan="3" style="vertical-align: middle;">Jumlah Cetakan </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Senin </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Selasa </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Rabu </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Kamis </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Jumat </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Sabtu </th>
                      <th class="column-title" colspan="8" style="text-align: center;">Minggu </th>
                    </tr>
                    <tr>
                      <?php foreach([1,2,3,4,5,6,7] as $hari ): ?>
                            <?php foreach([1, 2] as $shift): ?>
                              <th colspan="4">Shift <?=$shift?></th>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                      
                    </tr>
                    <tr class="tr-number-right">
                      <?php foreach([1,2,3,4,5,6,7] as $a ): ?>
                            <?php foreach([1, 2] as $b): ?>
                              <th>Plan</th>
                              <th>Act</th>
                              <th>Finishing</th>
                              <th>Reject</th>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody class="content" style="color: black !important;">
                  <?php if(isset($data['id'])): ?>
                  <?php 

                    $total_jumlah_cetakan = 0;

                    $senin_shift1_plan_total   = 0;
                    $senin_shift1_act          = 0;
                    $senin_shift1_finishing    = 0;
                    $senin_shift1_reject       = 0;

                    $senin_shift2_plan_total   = 0;
                    $senin_shift2_act          = 0;
                    $senin_shift2_finishing    = 0;
                    $senin_shift2_reject       = 0;

                    $selasa_shift1_plan_total   = 0;
                    $selasa_shift1_act          = 0;
                    $selasa_shift1_finishing    = 0;
                    $selasa_shift1_reject       = 0;

                    $selasa_shift2_plan_total   = 0;
                    $selasa_shift2_act          = 0;
                    $selasa_shift2_finishing    = 0;
                    $selasa_shift2_reject       = 0;

                    $rabu_shift1_plan_total   = 0;
                    $rabu_shift1_act          = 0;
                    $rabu_shift1_finishing    = 0;
                    $rabu_shift1_reject       = 0;

                    $rabu_shift2_plan_total   = 0;
                    $rabu_shift2_act          = 0;
                    $rabu_shift2_finishing    = 0;
                    $rabu_shift2_reject       = 0;

                    $kamis_shift1_plan_total   = 0;
                    $kamis_shift1_act          = 0;
                    $kamis_shift1_finishing    = 0;
                    $kamis_shift1_reject       = 0;

                    $kamis_shift2_plan_total   = 0;
                    $kamis_shift2_act          = 0;
                    $kamis_shift2_finishing    = 0;
                    $kamis_shift2_reject       = 0;

                    $jumat_shift1_plan_total   = 0;
                    $jumat_shift1_act          = 0;
                    $jumat_shift1_finishing    = 0;
                    $jumat_shift1_reject       = 0;

                    $jumat_shift2_plan_total   = 0;
                    $jumat_shift2_act          = 0;
                    $jumat_shift2_finishing    = 0;
                    $jumat_shift2_reject       = 0;

                    $sabtu_shift1_plan_total   = 0;
                    $sabtu_shift1_act          = 0;
                    $sabtu_shift1_finishing    = 0;
                    $sabtu_shift1_reject       = 0;

                    $sabtu_shift2_plan_total   = 0;
                    $sabtu_shift2_act          = 0;
                    $sabtu_shift2_finishing    = 0;
                    $sabtu_shift2_reject       = 0;

                    $minggu_shift1_plan_total   = 0;
                    $minggu_shift1_act          = 0;
                    $minggu_shift1_finishing    = 0;
                    $minggu_shift1_reject       = 0;

                    $minggu_shift2_plan_total   = 0;
                    $minggu_shift2_act          = 0;
                    $minggu_shift2_finishing    = 0;
                    $minggu_shift2_reject       = 0;

                    foreach($list_plan as $item):
                      
                      $total_shift1 = $item['day1_shift1']+$item['day2_shift1']+$item['day3_shift1']+$item['day4_shift1']+$item['day5_shift1']+$item['day6_shift1']+$item['day7_shift1'];

                      $total_shift2 = $item['day1_shift2']+$item['day2_shift2']+$item['day3_shift2']+$item['day4_shift2']+$item['day5_shift2']+$item['day6_shift2']+$item['day7_shift2'];

                      $total_cetakan = $total_shift1 + $total_shift2;
                      $bg = "";

                      if($item['pengecoran'] == 3) $bg = 'bgblue';
                      if($item['pengecoran'] >= 4) $bg = 'bgred';

                      $total_jumlah_cetakan += $item['cetakan'];
                  ?>
                    <tr class="product-plan<?=$item['id']?> <?=$bg?>">
                        <td><?=$item['product']?> </td>
                        <td class="right-text"><?=$item['cetakan']?></td>
                        
                        <?php foreach([1,2,3,4,5,6,7] as $hari ): ?>
                            <?php foreach([1, 2] as $shift): ?>
                              <?php 
                                if($hari == 1){
                                  if($shift == 1){
                                    $senin_shift1_plan_total += $item['day'.$hari.'_shift'. $shift]; 
                                    $senin_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $senin_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $senin_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];

                                  }else{
                                    $senin_shift2_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $senin_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $senin_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $senin_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];          
                                  }
                                }

                                if($hari == 2){
                                  if($shift == 1){
                                    $selasa_shift1_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $selasa_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $selasa_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $selasa_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];           
                                  }else{
                                    $selasa_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];    

                                    $selasa_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $selasa_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $selasa_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];         
                                  }
                                }

                                if($hari == 3){
                                  if($shift == 1){
                                    $rabu_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];   

                                    $rabu_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $rabu_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $rabu_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];         
                                  }else{
                                    $rabu_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];   

                                    $rabu_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $rabu_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $rabu_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];          
                                  }
                                }

                                if($hari == 4){
                                  if($shift == 1){
                                    $kamis_shift1_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $kamis_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $kamis_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $kamis_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];           
                                  }else{
                                    $kamis_shift2_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $kamis_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $kamis_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $kamis_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];            
                                  }
                                }

                                if($hari == 5){
                                  if($shift == 1){
                                    $jumat_shift1_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $jumat_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $jumat_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $jumat_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];          
                                  }else{
                                    $jumat_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];  

                                    $jumat_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $jumat_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $jumat_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];           
                                  }
                                }

                                if($hari == 6){
                                  if($shift == 1){
                                    $sabtu_shift1_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $sabtu_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $sabtu_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $sabtu_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];           
                                  }else{
                                    $sabtu_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];  

                                    $sabtu_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $sabtu_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $sabtu_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];           
                                  }
                                }

                                if($hari == 7){
                                  if($shift == 1){
                                    $minggu_shift1_plan_total += $item['day'.$hari.'_shift'. $shift]; 

                                    $minggu_shift1_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $minggu_shift1_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $minggu_shift1_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];           
                                  }else{
                                    $minggu_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];   

                                    $minggu_shift2_act        += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi'];
                                    $minggu_shift2_finishing  += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];
                                    $minggu_shift2_reject     += total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing'];          
                                  }
                                }

                              ?>
                              <td><?=$item['day'.$hari.'_shift'. $shift]?></td>
                              <td class="right-text">
                                  <a href="#" class="editable-lembarkerjaitem" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="hasil_produksi" data-type="text" data-product_id="<?=$item['product_id']?>"  data-url="<?=site_url()?>ajax/inputlembarkerja">
                                    <?=total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi']?>
                                  </a>
                                </a>
                              </a>
                              </td>
                              <td class="right-text">
                                 <a href="#" class="editable-lembarkerjaitem" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="finishing" data-type="text" data-product_id="<?=$item['product_id']?>"  data-url="<?=site_url()?>ajax/inputlembarkerja">
                                    <?=total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing']?>
                                  </a>
                              </td>
                              <td class="right-text">
                                <a href="#" class="editable-lembarkerjaitem" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="reject" data-type="text" data-product_id="<?=$item['product_id']?>"  data-url="<?=site_url()?>ajax/inputlembarkerja">
                                  <?=total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['reject']?>
                                </a>
                              </td>
                            <?php endforeach; ?>
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
                        <td class="right-text"><?=$item['cetakan']?></td>
                        
                        <?php foreach([1,2,3,4,5,6,7] as $hari ): ?>
                            <?php foreach([1, 2] as $shift): 
                              if($hari == 1){
                                  if($shift == 1){
                                    $senin_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $senin_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                                if($hari == 2){
                                  if($shift == 1){
                                    $selasa_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $selasa_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                                if($hari == 3){
                                  if($shift == 1){
                                    $rabu_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $rabu_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                                if($hari == 4){
                                  if($shift == 1){
                                    $kamis_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $kamis_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                                if($hari == 5){
                                  if($shift == 1){
                                    $jumat_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $jumat_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                                if($hari == 6){
                                  if($shift == 1){
                                    $sabtu_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $sabtu_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                                if($hari == 7){
                                  if($shift == 1){
                                    $minggu_shift1_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }else{
                                    $minggu_shift2_plan_total += $item['day'.$hari.'_shift'. $shift];            
                                  }
                                }

                            ?>
                              <td><?=$item['day'.$hari.'_shift'. $shift]?></td>
                              <td class="right-text">
                                  <a href="#" class="editable-lembarkerjaitem" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="hasil_produksi" data-type="text" data-product_id="<?=$item['product_id']?>"  data-url="<?=site_url()?>ajax/inputlembarkerja">
                                    <?=total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['hasil_produksi']?>
                                  </a>
                              </td>
                              <td class="right-text">
                                 <a href="#" class="editable-lembarkerjaitem" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="finishing" data-type="text" data-product_id="<?=$item['product_id']?>"  data-url="<?=site_url()?>ajax/inputlembarkerja">
                                    <?=total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['finishing']?>
                                  </a>
                              </td>
                              <td class="right-text">
                                <a href="#" class="editable-lembarkerjaitem" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="reject" data-type="text" data-product_id="<?=$item['product_id']?>"  data-url="<?=site_url()?>ajax/inputlembarkerja">
                                  <?=total_shift_lembar_kerja($data['id'], $hari,$shift, $item['product_id'])['reject']?>
                                </a>
                              </td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                  <tr>
                    <th style="text-align:right;">Total</th>
                    <th style="text-align:right;"><?=$total_jumlah_cetakan?></th>

                    <th style="text-align:right;"><?=$senin_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$senin_shift1_act?></th>
                    <th style="text-align:right;"><?=$senin_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$senin_shift1_reject?></th>

                    <th style="text-align:right;"><?=$senin_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$senin_shift2_act?></th>
                    <th style="text-align:right;"><?=$senin_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$senin_shift2_reject?></th>

                    <th style="text-align:right;"><?=$selasa_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$selasa_shift1_act?></th>
                    <th style="text-align:right;"><?=$selasa_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$selasa_shift1_reject?></th>

                    <th style="text-align:right;"><?=$selasa_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$selasa_shift2_act?></th>
                    <th style="text-align:right;"><?=$selasa_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$selasa_shift2_reject?></th>

                    <th style="text-align:right;"><?=$rabu_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$rabu_shift1_act?></th>
                    <th style="text-align:right;"><?=$rabu_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$rabu_shift1_reject?></th>

                    <th style="text-align:right;"><?=$rabu_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$rabu_shift2_act?></th>
                    <th style="text-align:right;"><?=$rabu_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$rabu_shift2_reject?></th>

                    <th style="text-align:right;"><?=$kamis_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$kamis_shift1_act?></th>
                    <th style="text-align:right;"><?=$kamis_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$kamis_shift1_reject?></th>

                    <th style="text-align:right;"><?=$kamis_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$kamis_shift2_act?></th>
                    <th style="text-align:right;"><?=$kamis_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$kamis_shift2_reject?></th>

                    <th style="text-align:right;"><?=$jumat_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$jumat_shift1_act?></th>
                    <th style="text-align:right;"><?=$jumat_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$jumat_shift1_reject?></th>

                    <th style="text-align:right;"><?=$jumat_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$jumat_shift2_act?></th>
                    <th style="text-align:right;"><?=$jumat_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$jumat_shift2_reject?></th>

                    <th style="text-align:right;"><?=$sabtu_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$sabtu_shift1_act?></th>
                    <th style="text-align:right;"><?=$sabtu_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$sabtu_shift1_reject?></th>

                    <th style="text-align:right;"><?=$sabtu_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$sabtu_shift2_act?></th>
                    <th style="text-align:right;"><?=$sabtu_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$sabtu_shift2_reject?></th>

                    <th style="text-align:right;"><?=$minggu_shift1_plan_total?></th>
                    <th style="text-align:right;"><?=$minggu_shift1_act?></th>
                    <th style="text-align:right;"><?=$minggu_shift1_finishing?></th>
                    <th style="text-align:right;"><?=$minggu_shift1_reject?></th>

                    <th style="text-align:right;"><?=$minggu_shift2_plan_total?></th>
                    <th style="text-align:right;"><?=$minggu_shift2_act?></th>
                    <th style="text-align:right;"><?=$minggu_shift2_finishing?></th>
                    <th style="text-align:right;"><?=$minggu_shift2_reject?></th>

                  </tr>
                  <tr>
                      <td></td>
                      <td></td>
                    <?php foreach([1,2,3,4,5,6,7] as $hari ): ?>
                          <?php foreach([1, 2] as $shift): ?>
                            <?php 
                              $pekerja_lembur = $this->db->get_where('product_schedule_pekerja', ['product_schedule_id' => $data['id'], 'day' => $hari, 'shift' => $shift])->row_array();

                              $pekerja  = $pekerja_lembur['pekerja'];
                              $lembur   = $pekerja_lembur['lembur'];
                            ?>
                            <th colspan="4">
                              Total Actual Pekerja : 
                                <a href="#" class="editable-inputpekerjalembur" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="pekerja" data-type="text"><?=$pekerja?></a><br />

                              Total Lembur : <a href="#" class="editable-inputpekerjalembur" data-product_schedule_id="<?=$data['id']?>" data-day="<?=$hari?>" data-shift="<?=$shift?>" data-type_input="lembur" data-type="text"><?=$lembur?></a>

                            </th>
                          <?php endforeach; ?>
                      <?php endforeach; ?>
                  </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
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

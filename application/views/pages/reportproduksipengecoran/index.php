<?php 
$total =0;
$day_array = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis', 5=>'Jumat',6=>'Sabtu', 7=> 'Minggu'];
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Report Produksi Pengecorran</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div>
            <form action="" method="GET">
               <div class="col-md-2" style="padding:0;margin:0;">
                <select class="form-control" name="tahun"  required="true">
                    <option value=""> -- Tahun -- </option>
                    <?php 
                      // ambil data berdasarkan sales order
                      $tahun_array = $this->db->query("SELECT year(create_time) as tahun FROM sales_order GROUP BY tahun")->result_array();

                      foreach($tahun_array as $i => $val):

                        $selected = '';
                        if(isset($_GET['tahun']) and $_GET['tahun'] == $val['tahun'])
                          $selected = ' selected';

                        echo "<option {$selected}>{$val['tahun']}</option>";
                      endforeach;
                    ?>
                </select>
              </div> &nbsp;
              <div class="col-md-2" style="padding:0;margin:0;">
                <select class="form-control" name="bulan" required="true">
                    <option value=""> - Bulan - </option>
                    <?php 
                      $bulan_array = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                      foreach($bulan_array as $i => $val):

                        $selected = '';
                        if(isset($_GET['bulan']) and $_GET['bulan'] == $i)
                          $selected = ' selected';

                        echo "<option value=\"{$i}\" {$selected}>{$val}</option>";
                      endforeach;
                    ?>
                </select>
              </div> &nbsp;
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i> Submit</button>
            </form>
            <?php if(isset($data)): ?>
              <?php foreach($data as $minggu_ke):?>
                <h2>Minggu Ke <?=$minggu_ke['minggu']?></h2>
                <div style="overflow: auto;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th rowspan="3">No</th>
                        <th rowspan="3">Kode Produksi</th>
                        <?php foreach($day_array as $key_har => $hari):?>
                        <th colspan="8" style="text-align: center;"><?=$hari?></th>
                        <?php endforeach; ?> 
                        <th colspan="8" style="text-align: center;">Total Week</th>
                      </tr>
                      <tr>
                        <?php foreach($day_array as $key_har => $hari):?>
                          <th colspan="4" style="text-align: center;">Jumlah (Pcs)</th>
                          <th colspan="4" style="text-align: center;">Weight (Ton)</th>
                        <?php endforeach; ?>
                        <th colspan="4" style="text-align: center;">Jumlah (Pcs)</th>
                        <th colspan="4" style="text-align: center;">Weight (Ton)</th>
                      </tr>
                      <tr>
                        <?php foreach($day_array as $key_har => $hari):?>
                        <th>Plan</th>
                        <th>Act</th>
                        <th>Finishing</th>
                        <th>Reject</th>

                        <th>Plan</th>
                        <th>Act</th>
                        <th>Finishing</th>
                        <th>Reject</th>

                        <?php endforeach; ?>

                        <th>Plan</th>
                        <th>Act</th>
                        <th>Finishing</th>
                        <th>Reject</th>
                        <th>Plan</th>
                        <th>Act</th>
                        <th>Finishing</th>
                        <th>Reject</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $plan_array = $this->db->query("SELECT s.*, p.kode FROM product_schedule_plan s INNER JOIN products p on p.id=s.product_id WHERE s.product_schedule_id={$minggu_ke['id']}")->result_array();

                      $total_plan_senin = 0;
                      $total_act_senin = 0;
                      $total_finishing_senin = 0;
                      $total_reject_senin = 0;

                      $total_plan_selasa = 0;
                      $total_act_selasa = 0;
                      $total_finishing_selasa = 0;
                      $total_reject_selasa = 0;

                      $total_plan_rabu = 0;
                      $total_act_rabu = 0;
                      $total_finishing_rabu = 0;
                      $total_reject_rabu = 0;

                      $total_plan_kamis = 0;
                      $total_act_kamis = 0;
                      $total_finishing_kamis = 0;
                      $total_reject_kamis = 0;

                      $total_plan_jumat = 0;
                      $total_act_jumat = 0;
                      $total_finishing_jumat = 0;
                      $total_reject_jumat = 0;

                      $total_plan_sabtu = 0;
                      $total_act_sabtu = 0;
                      $total_finishing_sabtu = 0;
                      $total_reject_sabtu = 0;

                      $total_plan_minggu = 0;
                      $total_act_minggu = 0;
                      $total_finishing_minggu = 0;
                      $total_reject_minggu = 0;

                      $total_all_week_plan = 0;
                      $total_all_week_act = 0;
                      $total_all_week_finishing = 0;
                      $total_all_week_reject = 0;

                      $total_w_plan_senin = 0;
                      $total_w_act_senin = 0;
                      $total_w_finishing_senin = 0;
                      $total_w_reject_senin = 0;

                      $total_w_plan_selasa = 0;
                      $total_w_act_selasa = 0;
                      $total_w_finishing_selasa = 0;
                      $total_w_reject_selasa = 0;

                      $total_w_plan_rabu = 0;
                      $total_w_act_rabu = 0;
                      $total_w_finishing_rabu = 0;
                      $total_w_reject_rabu = 0;

                      $total_w_plan_kamis = 0;
                      $total_w_act_kamis = 0;
                      $total_w_finishing_kamis = 0;
                      $total_w_reject_kamis = 0;

                      $total_w_plan_jumat = 0;
                      $total_w_act_jumat = 0;
                      $total_w_finishing_jumat = 0;
                      $total_w_reject_jumat = 0;

                      $total_w_plan_sabtu = 0;
                      $total_w_act_sabtu = 0;
                      $total_w_finishing_sabtu = 0;
                      $total_w_reject_sabtu = 0;

                      $total_w_plan_minggu = 0;
                      $total_w_act_minggu = 0;
                      $total_w_finishing_minggu = 0;
                      $total_w_reject_minggu = 0;

                      $total_w_plan_week_all = 0;
                      $total_w_act_week_all = 0;
                      $total_w_finishing_week_all = 0;
                      $total_w_reject_week_all = 0;

                      foreach($plan_array as $no_plan => $plan):

                        $total_week_plan  = 0;
                        $total_week_act   = 0;
                        $total_week_finishing   = 0;
                        $total_week_reject   = 0;

                        $total_w_plan_week = 0;
                        $total_w_act_week = 0;
                        $total_w_finishing_week = 0;
                        $total_w_reject_week = 0;
                    ?>
                      <tr>
                        <td><?=$no_plan+1?></td>
                        <td><?=$plan['kode']?></td>
                        <?php foreach($day_array as $key_hari => $hari):?>
                        <?php 

                          // get lembar kerja
                          $kerja_shift_1 = $this->db->get_where('product_schedule_plan_lembar_kerja', ['product_schedule_id' => $plan['product_schedule_id'], 'day' => $key_hari, 'shift' => 1, 'product_id' => $plan['product_id']])->row_array();

                          $kerja_shift_2 = $this->db->get_where('product_schedule_plan_lembar_kerja', ['product_schedule_id' => $plan['product_schedule_id'], 'day' => $key_hari, 'shift' => 2, 'product_id' => $plan['product_id']])->row_array();

                          $product = $this->db->get_where('products', ['id' => $plan['product_id']])->row_array();

                          $_plan  = $plan['day'.$key_hari.'_shift1']+$plan['day'.$key_hari.'_shift2'];
                          $_act   = $kerja_shift_1['hasil_produksi']+$kerja_shift_2['hasil_produksi'];
                          $_finishing = $kerja_shift_1['finishing']+$kerja_shift_2['finishing']; 
                          $_reject = $kerja_shift_1['reject']+$kerja_shift_2['reject'];


                          $total_week_plan    += $_plan;
                          $total_week_act     += $_act;
                          $total_week_finishing+= $_finishing;
                          $total_week_reject  += $_reject;

                          $_w_plan = $_plan * $product['weight'];
                          $_w_act = $_act * $product['weight'];
                          $_w_finishing = $_finishing * $product['weight'];
                          $_w_reject = $_reject * $product['weight'];

                          $total_w_plan_week += $_w_plan;
                          $total_w_act_week += $_w_act;
                          $total_w_finishing_week += $_w_finishing;
                          $total_w_reject_week += $_w_reject;

                          if($key_hari == 1)
                          {
                            $total_plan_senin += $_plan; 
                            $total_act_senin += $_act; 
                            $total_finishing_senin += $_finishing; 
                            $total_reject_senin += $_reject; 

                            $total_w_plan_senin += $_w_plan;
                            $total_w_act_senin += $_w_act;;
                            $total_w_finishing_senin += $_w_finishing;;
                            $total_w_reject_senin += $_w_reject;;
                          }

                          if($key_hari == 2)
                          {
                            $total_plan_selasa += $_plan; 
                            $total_act_selasa += $_act; 
                            $total_finishing_selasa += $_finishing; 
                            $total_reject_selasa += $_reject; 

                            $total_w_plan_selasa += $_w_plan;
                            $total_w_act_selasa += $_w_act;;
                            $total_w_finishing_selasa += $_w_finishing;;
                            $total_w_reject_selasa += $_w_reject;;
                          }

                          if($key_hari == 3)
                          {
                            $total_plan_rabu += $_plan; 
                            $total_act_rabu += $_act; 
                            $total_finishing_rabu += $_finishing; 
                            $total_reject_rabu += $_reject; 

                            $total_w_plan_rabu += $_w_plan;
                            $total_w_act_rabu += $_w_act;;
                            $total_w_finishing_rabu += $_w_finishing;;
                            $total_w_reject_rabu += $_w_reject;;
                          }

                          if($key_hari == 4)
                          {
                            $total_plan_kamis += $_plan; 
                            $total_act_kamis += $_act; 
                            $total_finishing_kamis += $_finishing; 
                            $total_reject_kamis += $_reject; 

                            $total_w_plan_kamis += $_w_plan;
                            $total_w_act_kamis += $_w_act;;
                            $total_w_finishing_kamis += $_w_finishing;;
                            $total_w_reject_kamis += $_w_reject;;
                          }

                          if($key_hari == 5)
                          {
                            $total_plan_jumat += $_plan; 
                            $total_act_jumat += $_act; 
                            $total_finishing_jumat += $_finishing; 
                            $total_reject_jumat += $_reject; 

                            $total_w_plan_jumat += $_w_plan;
                            $total_w_act_jumat += $_w_act;;
                            $total_w_finishing_jumat += $_w_finishing;;
                            $total_w_reject_jumat += $_w_reject;;
                          }

                          if($key_hari == 6)
                          {
                            $total_plan_sabtu += $_plan; 
                            $total_act_sabtu += $_act; 
                            $total_finishing_sabtu += $_finishing; 
                            $total_reject_sabtu += $_reject; 

                            $total_w_plan_sabtu += $_w_plan;
                            $total_w_act_sabtu += $_w_act;;
                            $total_w_finishing_sabtu += $_w_finishing;;
                            $total_w_reject_sabtu += $_w_reject;;
                          }

                          if($key_hari == 7)
                          {
                            $total_plan_minggu += $_plan; 
                            $total_act_minggu += $_act; 
                            $total_finishing_minggu += $_finishing; 
                            $total_reject_minggu += $_reject; 

                            $total_w_plan_minggu += $_w_plan;
                            $total_w_act_minggu += $_w_act;;
                            $total_w_finishing_minggu += $_w_finishing;;
                            $total_w_reject_minggu += $_w_reject;;
                          }

                        ?>  
                        <td><?=$_plan?></td>
                        <td><?=$_act?></td>
                        <td><?=$_finishing?></td>
                        <td><?=$_reject?></td>
                        <td><?=round($_w_plan/1000,1)?> Ton</td>
                        <td><?=round($_w_act/1000,1)?> Ton</td>
                        <td><?=round($_w_finishing/1000,1)?> Ton</td>
                        <td><?=round($_w_reject/1000,1)?> Ton</td>
                        
                      <?php endforeach; ?> 
                        
                        <td><?=$total_week_plan?></td>
                        <td><?=$total_week_act?></td>
                        <td><?=$total_week_finishing?></td>
                        <td><?=$total_week_reject?></td>

                        <td><?=round($total_w_plan_week/1000,1)?></td>
                        <td><?=round($total_w_act_week/1000,1)?></td>
                        <td><?=round($total_w_finishing_week/1000,1)?></td>
                        <td><?=round($total_w_reject_week/1000,1)?></td>

                        <?php 
                          $total_all_week_plan += $total_week_plan;
                          $total_all_week_act += $total_week_act;
                          $total_all_week_finishing += $total_week_finishing;
                          $total_all_week_reject += $total_week_reject;

                          $total_w_plan_week_all  += $total_w_plan_week;
                          $total_w_act_week_all   += $total_w_act_week;
                          $total_w_finishing_week_all += $total_w_finishing_week;
                          $total_w_reject_week_all += $total_w_reject_week;
                        ?>
                      </tr>

                    <?php endforeach; ?>
                    <?php

                      $plan_pekerjan_senin = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=1 and product_schedule_id={$minggu_ke['id']}")->row_array();

                      $plan_pekerjan_selasa = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=2 and product_schedule_id={$minggu_ke['id']}")->row_array();

                      $plan_pekerjan_rabu = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=3 and product_schedule_id={$minggu_ke['id']}")->row_array();

                      $plan_pekerjan_kamis = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=4 and product_schedule_id={$minggu_ke['id']}")->row_array();

                      $plan_pekerjan_jumat = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=5 and product_schedule_id={$minggu_ke['id']}")->row_array();

                      $plan_pekerjan_sabtu = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=6 and product_schedule_id={$minggu_ke['id']}")->row_array();

                      $plan_pekerjan_minggu = $this->db->query("SELECT sum(pekerja) as total_pekerja, sum(lembur) as total_lembur FROM product_schedule_pekerja p WHERE day=7 and product_schedule_id={$minggu_ke['id']}")->row_array();

                    ?>
                  </tbody>
                    <tbody style="background:#eaeeff;">
                      <tr>
                        <th style="text-align: right;" colspan="2">Jumlah Produksi</th>
                        <th><?=$total_plan_senin?></th>
                        <th><?=$total_act_senin?></th>
                        <th><?=$total_finishing_senin?></th>
                        <th><?=$total_reject_senin?></th>

                        <th><?=round($total_w_plan_senin/1000, 1)?></th>
                        <th><?=round($total_w_act_senin/1000, 1)?></th>
                        <th><?=round($total_w_finishing_senin/1000,1)?></th>
                        <th><?=round($total_w_reject_senin/1000, 1)?></th>

                        <th><?=$total_plan_selasa?></th>
                        <th><?=$total_act_selasa?></th>
                        <th><?=$total_finishing_selasa?></th>
                        <th><?=$total_reject_selasa?></th>

                        <th><?=round($total_w_plan_selasa/1000,1)?></th>
                        <th><?=round($total_w_act_selasa/1000,1)?></th>
                        <th><?=round($total_w_finishing_selasa/1000,1)?></th>
                        <th><?=round($total_w_reject_selasa/1000,1)?></th>

                        <th><?=$total_plan_rabu?></th>
                        <th><?=$total_act_rabu?></th>
                        <th><?=$total_finishing_rabu?></th>
                        <th><?=$total_reject_rabu?></th>

                        <th><?=round($total_w_plan_rabu/1000,1)?></th>
                        <th><?=round($total_w_act_rabu/1000,1)?></th>
                        <th><?=round($total_w_finishing_rabu/1000,1)?></th>
                        <th><?=round($total_w_reject_rabu/1000,1)?></th>

                        <th><?=$total_plan_kamis?></th>
                        <th><?=$total_act_kamis?></th>
                        <th><?=$total_finishing_kamis?></th>
                        <th><?=$total_reject_kamis?></th>

                        <th><?=round($total_w_plan_kamis/1000,1)?></th>
                        <th><?=round($total_w_act_kamis/1000,1)?></th>
                        <th><?=round($total_w_finishing_kamis/1000,1)?></th>
                        <th><?=round($total_w_reject_kamis/1000,1)?></th>

                        <th><?=$total_plan_jumat?></th>
                        <th><?=$total_act_jumat?></th>
                        <th><?=$total_finishing_jumat?></th>
                        <th><?=$total_reject_jumat?></th>

                        <th><?=round($total_w_plan_jumat/1000, 1)?></th>
                        <th><?=round($total_w_act_jumat/1000,1)?></th>
                        <th><?=round($total_w_finishing_jumat/1000,1)?></th>
                        <th><?=round($total_w_reject_jumat/1000,1)?></th>

                        <th><?=$total_plan_sabtu?></th>
                        <th><?=$total_act_sabtu?></th>
                        <th><?=$total_finishing_sabtu?></th>
                        <th><?=$total_reject_sabtu?></th>

                        <th><?=round($total_w_plan_sabtu/1000,1)?></th>
                        <th><?=round($total_w_act_sabtu/1000,1)?></th>
                        <th><?=round($total_w_finishing_sabtu/1000,1)?></th>
                        <th><?=round($total_w_reject_sabtu/1000,1)?></th>

                        <th><?=$total_plan_minggu?></th>
                        <th><?=$total_act_minggu?></th>
                        <th><?=$total_finishing_minggu?></th>
                        <th><?=$total_reject_minggu?></th>

                        <th><?=round($total_w_plan_minggu/1000,1)?></th>
                        <th><?=round($total_w_act_minggu/1000,1)?></th>
                        <th><?=round($total_w_finishing_minggu/1000,1)?></th>
                        <th><?=round($total_w_reject_minggu/1000,1)?></th>

                        <th><?=$total_all_week_plan?></th>
                        <th><?=$total_all_week_act?></th>
                        <th><?=$total_all_week_finishing?></th>
                        <th><?=$total_all_week_reject?></th>

                        <th><?=round($total_w_plan_week_all / 1000, 1)?></th>
                        <th><?=round($total_w_act_week_all / 1000, 1)?></th>
                        <th><?=round($total_w_finishing_week_all / 1000, 1)?></th>
                        <th><?=round($total_w_reject_week_all / 1000, 1)?></th>
                      </tr>
                      <tr>
                        <th style="text-align: right;" colspan="2">Pencapaian</th>
                        
                        <th colspan="8">
                          <?php 
                            if($total_act_senin !=0)
                              echo round($total_w_plan_senin / $total_w_act_senin,1).'%';
                          ?>
                        </th>

                        <th colspan="8">
                          <?php 
                            if($total_act_selasa !=0)
                              echo round($total_w_plan_rabu / $total_w_act_selasa,1).'%';
                          ?>
                        </th>
                        <th colspan="8">
                          <?php 
                            if($total_act_rabu !=0)
                              echo round($total_w_plan_rabu / $total_w_act_rabu,1).'%';
                          ?>
                        </th>
                        <th colspan="8">
                          <?php 
                            if($total_act_kamis !=0)
                              echo round($total_w_plan_kamis / $total_w_act_kamis,1).'%';
                          ?>
                        </th>
                        <th colspan="8">
                          <?php 
                            if($total_act_jumat !=0)
                              echo round($total_w_plan_jumat / $total_w_act_jumat,1).'%';
                          ?>
                        </th>
                        <th colspan="8">
                          <?php 
                            if($total_act_sabtu !=0)
                              echo round($total_w_plan_sabtu / $total_w_act_sabtu,1).'%';
                          ?>
                        </th>
                        <th colspan="8">
                          <?php 
                            if($total_act_minggu !=0)
                              echo round($total_w_plan_minggu / $total_w_act_minggu,1).'%';
                          ?>
                        </th>

                        <th colspan="8">
                          <?php 
                            if($total_w_act_week_all !=0)
                              echo round($total_w_plan_week_all / $total_w_act_week_all,1).'%';
                          ?>
                        </th>
                       
                      </tr>
                      <tr>
                        <th style="text-align: right;" colspan="2">Jumlah pekerja( Cor + Pembesian )</th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_senin['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_selasa['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_rabu['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_kamis['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_jumat['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_sabtu['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']?></th>
                        <th colspan="7"><?=$plan_pekerjan_minggu['total_pekerja']?></th>

                        <th><?=$minggu_ke['plan_pekerja']*7?></th>
                        <th colspan="7"><?=$plan_pekerjan_senin['total_pekerja']+$plan_pekerjan_selasa['total_pekerja']+$plan_pekerjan_rabu['total_pekerja']+$plan_pekerjan_kamis['total_pekerja']+$plan_pekerjan_jumat['total_pekerja']+$plan_pekerjan_sabtu['total_pekerja']+$plan_pekerjan_minggu['total_pekerja']?></th>
                      </tr>

                      <tr>
                        <th style="text-align: right;" colspan="2">% Kwalitas</th>
                        <th>
                          <?php if($total_w_act_senin !=0)
                              echo round($total_w_act_senin / ($total_w_act_senin - $total_w_finishing_senin -$total_w_reject_senin),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_senin !=0)
                              echo round($total_w_act_senin / $total_w_finishing_senin,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_senin !=0)
                              echo round($total_w_act_senin / $total_w_reject_senin,1);?>                          
                        </th>

                        <th>
                          <?php if($total_w_act_selasa !=0)
                              echo round($total_w_act_selasa / ($total_w_act_selasa - $total_w_finishing_selasa -$total_w_reject_selasa),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_selasa !=0)
                              echo round($total_w_act_selasa / $total_w_finishing_selasa,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_selasa !=0)
                              echo round($total_w_act_selasa / $total_w_reject_selasa,1);?>                          
                        </th>

                        <th>
                          <?php if($total_w_act_rabu !=0)
                              echo round($total_w_act_rabu / ($total_w_act_rabu - $total_w_finishing_rabu -$total_w_reject_rabu),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_rabu !=0)
                              echo round($total_w_act_rabu / $total_w_finishing_rabu,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_rabu !=0)
                              echo round($total_w_act_rabu / $total_w_reject_rabu,1);
                          ?>                          
                        </th>

                        <th>
                          <?php if($total_w_act_kamis !=0)
                              echo round($total_w_act_kamis / ($total_w_act_kamis - $total_w_finishing_kamis -$total_w_reject_kamis),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_kamis !=0)
                              echo round($total_w_act_kamis / $total_w_finishing_kamis,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_kamis !=0)
                              echo round($total_w_act_kamis / $total_w_reject_kamis,1);?>                          
                        </th>

                        <th>
                          <?php if($total_w_act_jumat !=0)
                              echo round($total_w_act_jumat / ($total_w_act_jumat - $total_w_finishing_jumat -$total_w_reject_jumat),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_jumat !=0)
                              echo round($total_w_act_jumat / $total_w_finishing_jumat,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_jumat !=0)
                              echo round($total_w_act_jumat / $total_w_reject_jumat,1);?>                          
                        </th>

                        <th>
                          <?php if($total_w_act_sabtu !=0)
                              echo round($total_w_act_sabtu / ($total_w_act_sabtu - $total_w_finishing_sabtu -$total_w_reject_sabtu),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_sabtu !=0)
                              echo round($total_w_act_sabtu / $total_w_finishing_sabtu,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_sabtu !=0)
                              echo round($total_w_act_sabtu / $total_w_reject_sabtu,1);?>                          
                        </th>

                        <th>
                          <?php if($total_w_act_minggu !=0)
                              echo round($total_w_act_minggu / ($total_w_act_minggu - $total_w_finishing_minggu -$total_w_reject_minggu),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_minggu !=0)
                              echo round($total_w_act_minggu / $total_w_finishing_minggu,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_minggu !=0)
                              echo round($total_w_act_minggu / $total_w_reject_minggu,1);?>                          
                        </th>
                                           
                        <th>
                          <?php if($total_w_act_week_all !=0)
                              echo round($total_w_act_week_all / ($total_w_act_week_all - $total_w_finishing_week_all -$total_w_reject_minggu),1) .'%';?>    
                        </th>
                        <th>
                          <?php if($total_w_finishing_week_all !=0)
                              echo round($total_w_act_week_all / $total_w_finishing_week_all,1);?>                          
                        </th>
                        <th colspan="6">
                          <?php 
                            if($total_w_reject_week_all !=0)
                              echo round($total_w_act_week_all / $total_w_reject_week_all,1);
                          ?>                          
                        </th>
                      </tr>

                      <tr>
                        <th style="text-align: right;" colspan="2">Jam Kerja</th>
                        <?php 
                          $jam_kerja = 8;
                        ?>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$jam_kerja?></th>
                        <th colspan="4"><?=$minggu_ke['plan_pekerja']*7?></th>
                        <th colspan="4">
                          <?=$plan_pekerjan_senin['total_pekerja']+$plan_pekerjan_selasa['total_pekerja']+$plan_pekerjan_rabu['total_pekerja']+$plan_pekerjan_kamis['total_pekerja']+$plan_pekerjan_jumat['total_pekerja']+$plan_pekerjan_sabtu['total_pekerja']+$plan_pekerjan_minggu['total_pekerja']?>
                        </th>
                      </tr>
                      <tr>
                        <th style="text-align: right;" colspan="2">mn.hr</th>
                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_senin['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_senin*$jam_kerja?></th>

                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_selasa['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_selasa*$jam_kerja?></th>
                        
                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_rabu['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_rabu*$jam_kerja?></th>

                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_kamis['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_kamis*$jam_kerja?></th>

                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_jumat['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_jumat*$jam_kerja?></th>

                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_sabtu['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_sabtu*$jam_kerja?></th>

                        <th colspan="4"><?=$jam_kerja*$plan_pekerjan_minggu['total_pekerja']?></th>
                        <th colspan="4"><?=$total_act_minggu*$jam_kerja?></th>

                        <th colspan="4"><?php echo ($jam_kerja*7)*($plan_pekerjan_minggu['total_pekerja']);?></th>
                        <th colspan="4"><?=$total_act_minggu*$jam_kerja?>  </th>
                      </tr>
                      <tr>
                        <th style="text-align: right;" colspan="2">mn.hr / Ton</th>
                        <th colspan="8"><?=@round(($jam_kerja*$plan_pekerjan_senin['total_pekerja']) / ($total_w_plan_senin / 1000), 1)?></th>
                        <th colspan="8"><?=@round(($jam_kerja*$plan_pekerjan_selasa['total_pekerja']) / ($total_w_plan_selasa / 1000), 1)?></th>
                        <th colspan="8"><?=@round(($jam_kerja*$plan_pekerjan_rabu['total_pekerja']) / ($total_w_plan_rabu / 1000), 1)?></th>
                        <th colspan="8"><?=@round(($jam_kerja*$plan_pekerjan_kamis['total_pekerja']) / ($total_w_plan_kamis / 1000), 1)?></th>
                        <th colspan="8"><?=@round(($jam_kerja*$plan_pekerjan_jumat['total_pekerja']) / ($total_w_plan_jumat / 1000), 1)?></th>
                        <th colspan="8"><?=@round(($jam_kerja*$plan_pekerjan_sabtu['total_pekerja']) / ($total_w_plan_sabtu / 1000), 1)?></th>
                        <th colspan="8">
                          <?php 
                            if($total_w_plan_minggu != 0)
                              echo round(($jam_kerja*$plan_pekerjan_minggu['total_pekerja']) / ($total_w_plan_minggu / 1000), 1)?>      
                        </th>
                        <th colspan="8">
                          <?php 

                            echo round( ($jam_kerja*($plan_pekerjan_senin['total_pekerja'])+
                                 ($plan_pekerjan_selasa['total_pekerja'])+
                                 ($plan_pekerjan_rabu['total_pekerja'])+
                                 ($plan_pekerjan_kamis['total_pekerja'])+
                                 ($plan_pekerjan_jumat['total_pekerja'])+
                                 ($plan_pekerjan_sabtu['total_pekerja'])+
                                 ($plan_pekerjan_minggu['total_pekerja']) ) /
                                  (
                                    (
                                      ($total_w_plan_senin)+
                                     ($total_w_plan_selasa)+
                                     ($total_w_plan_rabu)+
                                     ($total_w_plan_kamis)+
                                     ($total_w_plan_jumat)+
                                     ($total_w_plan_sabtu)+
                                     ($total_w_plan_minggu)
                                    ) / 1000 ),1 )
                                 ;
                          ?>
                        </th>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>  

            <?php endif; ?>
        </div>
      </div>
    </div>
</div>
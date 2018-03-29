<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Jadwal Tulangan</h2> &nbsp;
        <a href="<?=site_url('pabrikjadwaltulangan/insert')?>" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Buat Jadwal</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="table-responsive">
          <br style="clear" />
            <table id="datatable-buttons"  class="table table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="10">
                  <div>
                    <form action="" method="GET">
                      <select name="plan" class="form-control">
                        <option value=""> - Plan - </option>
                      <?php 
                        $plan = [1 => 'Area Produksi Plan I', 2 => 'Area Produksi Plan II', 3 => 'Area Produksi Plan III', 4 => 'Area Produksi Plan IV'];
                        foreach($plan as $key => $i):

                          $selected = "";
                          if(isset($_GET['plan']))
                          {
                           if($_GET['plan'] == $key)
                            {
                              $selected = " selected";
                            }
                          }
                      ?>
                          <option value="<?=$key?>" <?=$selected?>><?=$i?></option>
                      <?php endforeach; ?>
                      </select>
                      <select class="form-control" name="bulan">
                        <option value=""> - Bulan - </option>
                        <?php 
                          $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7=>'Juli', 8=> "Agustus",9=>'September', 10 => 'Oktober', 11=>'November',12=>'Desember'];

                          foreach($bulan as $k => $i)
                          {

                            $selected = '';

                            if(isset($_GET['bulan']))
                            {
                              if($_GET['bulan'] == $k){
                                $selected = 'selected';
                              }
                            }

                            echo "<option value=\"{$k}\" {$selected}>{$i}</option>";
                          }
                        ?>
                      </select>
                      <?php 
                        $minggu = [1=>'Kesatu', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat'];
                      ?>
                      <select class="form-control" name="minggu">
                        <option value=""> - Minggu ke - </option>
                        <?php 
                          foreach($minggu as $k => $i):
                            $selected = '';

                            if(isset($_GET['minggu']) and !empty($_GET['minggu'])){
                              if($k == $_GET['minggu']) {
                                $selected = ' selected';
                              }
                            }

                        ?>
                          <option value="<?=$k?>" <?=$selected?>><?=$i?></option>
                        <?php endforeach; ?>
                      </select>
                      <input type="submit" class="btn btn-success btn-sm" value="Filter" />
                    </form>
                  </div>
                </th>
              </tr>
              <tr class="headings">
                <th rowspan="2">No</th>
                <th class="column-title" rowspan="2">Area Produksi </th>
                <th class="column-title" colspan="2">Jadwal Produksi </th>
                <th class="column-title" rowspan="2">Total Cetakan </th>
                <th class="column-title" colspan="2">Plan </th>
                <th class="column-title" colspan="2">Actual </th>
                <th class="column-title  no-link last" rowspan="2">#</th>  
              </tr>
              <tr>
                <th>Bulan</th>
                <th>Minggu</th>
                <th>Pcs</th>
                <th>Tonase</th>
                <th>Pcs</th>
                <th>Tonase</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                
                foreach($data as $key => $item):?>
                <?php 
                  $total_cetakan_shift1 = $this->db->query("SELECT (sum(day1_shift1) + sum(day2_shift1) + sum(day3_shift1) + sum(day4_shift1) + sum(day5_shift1) + sum(day6_shift1)) as total from tulangan_schedule_plan where tulangan_schedule_id={$item['id']}")->row();
                  $total_cetakan_shift2 = $this->db->query("SELECT (sum(day1_shift2) + sum(day2_shift2) + sum(day3_shift2) + sum(day4_shift2) + sum(day5_shift2) + sum(day6_shift2)) as total from tulangan_schedule_plan where tulangan_schedule_id={$item['id']}")->row();

                ?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td>Plan <?=$item['plan']?></td>
                    <td><?=date('F', mktime(0, 0, 0, $item['bulan'], 10))?></td> 
                    <td style="text-align: right;"><?=$item['minggu']?></td>
                    <td style="text-align: right"><?=total_cetakan_plan($item['id'])?></td>
                    <td style="text-align: right"><?=total_plan($item['id'],'pcs')?></td>
                    <td style="text-align: right"><?=round(total_plan($item['id'],'tonase') / 1000, 1)?></td>
                    <td style="text-align: right">
                      <?php 
                          $act_pcs = $this->db->query("SELECT sum(hasil_produksi) as total FROM tulangan_schedule_plan_lembar_kerja WHERE tulangan_schedule_id={$item['id']}")->row_array();

                          echo $act_pcs['total'] / 100;
                      ?>
                    </td>
                    <td style="text-align: right">
                      <?php 
                          $act_tonase = $this->db->query("SELECT p.weight as tonase, ps.hasil_produksi FROM `tulangan_schedule_plan_lembar_kerja` ps inner join tulangan p on p.id=ps.tulangan_id WHERE ps.tulangan_schedule_id={$item['id']}")->result_array();

                        $total_act_tonase = 0;
                        foreach($act_tonase as $t)
                        {
                          $total_act_tonase += $t['tonase'] * $t['hasil_produksi'];
                        }

                        echo round($total_act_tonase / 1000, 1);
                      ?>
                    </td>
                    <td>
                      <?php 
                      // cek tanggal 
                      $result = $this->db->query("SELECT * FROM `tulangan_schedule` WHERE end_date >='". date('Y-m-d') ."' AND id={$item['id']}")->num_rows();
                      if($result > 0){
                      ?>
                        <a href="<?=site_url("pabrikjadwaltulangan/edit/{$item['id']}")?>" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Revisi</a>
                      <?php } ?>  

                      <a href="<?=site_url("pabrikjadwaltulangan/print_jadwal/{$item['id']}")?>" target="_blank" class="btn btn-default btn-xs" title="Print"><i class="fa fa-print"></i> Print</a>
                      <a href="<?=site_url("pabrikjadwaltulangan/lembarkerja/{$item['id']}")?>" class="btn btn-success btn-xs" title="Print">Input Produksi <i class="fa fa-arrow-right"></i></a>

                      <a href="<?=site_url("pabrikjadwaltulangan/reportmingguan/{$item['id']}")?>" class="btn btn-default btn-xs" title="Print"><i class="fa fa-bar-chart"></i> Report Mingguan</a>
  
                      <a href="<?=site_url("pabrikjadwaltulangan/delete/{$item['id']}")?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>

                    </td>
                </tr>
            <?php 
                endforeach;
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>



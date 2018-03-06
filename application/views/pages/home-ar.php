<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
      	<p style="text-align: center;"><img src="<?=site_url()?>assets/images/logo.jpg" style="width: 50%;" /></p>

      	<br />
      	<br />
      	<div class="row tile_count">
        <?php
          $history = $this->db->query("SELECT i.*, q.proyek,s.no_so, q.sistem_pembayaran, c.name FROM invoice i INNER JOIN sales_order s on s.id=i.sales_order_id INNER JOIN quotation_order q on q.id=s.quotation_order_id INNER JOIN customer c on c.id=q.customer_id order by id desc")->result_array(); 
        ?>  
        <!-- 
        <h2>History Invoice</h2>
        
        <table class="table table-bordered">
            <thead>
              <tr style="background: #e4e4e4ee;">
                <th>No</th>
                <th>No Invoice</th>
                <th>Jenis Transaksi</th>
                <th>Nominal</th>
                <th>No SO</th>
                <th>Customer</th>
                <th>Proyek</th>
                <th>Catatan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($history as $k => $i): ?>
                <?php 
                $surat_jalan = $this->db->query("
                                    SELECT spmp.surat_perintah_muat_id, sj.*, p.kode, spmp.volume, m.nama_supir, m.no_telepon, m.kenek FROM surat_jalan sj 
                                    inner join surat_perintah_muat spm on spm.id=sj.surat_perintah_muat_id
                                    inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id 
                                    inner join surat_izin_kirim sik on sik.id=spm.surat_izin_kirim_id
                                    inner join products p on p.id=spmp.product_id
                                    inner join mobil m on m.id=spm.mobil_id
                                    where sj.invoice_id={$i['id']}
                                    group by sj.id order by id desc
                                    ")->result_array();
                ?>
                <tr>
                  <td rowspan="<?=(count($surat_jalan) == 0 ? 1 : 2)?>"><?=($k+1)?></td>
                  <td><?=$i['no_invoice']?></td>
                  <td><?=$i['sistem_pembayaran']?></td>
                  <td>Rp. <?=number_format($i['nominal'])?></td>
                  <td><?=$i['no_so']?></td>
                  <td><?=$i['name']?></td>
                  <td><?=$i['proyek']?></td>
                  <td><?=$i['catatan']?></td>
                </tr>
                <?php 

                

                if(count($surat_jalan) == 0) continue;

                ?>
                <tr>
                    <td colspan="7">
                       <table class="table table-bordered">
                          <thead>
                             <tr style="background: #e4e4e4ee;">
                              <th>#</th>
                              <th>No Surat Jalan</th>
                              <th>Nama Supir</th>
                              <th>No Telepon</th>
                              <th>Nama Kenek</th>
                              <th>Tanggal</th>
                            </tr>
                          </thead>
                           <tbody>
                            <?php 
                                
                                foreach($surat_jalan as $key => $item):
                            ?>
                              <tr>
                                <td><?=($key+1)?></td>
                                <td><?=$item['no_surat_jalan']?></td>
                                <td><?=$item['nama_supir']?></td>
                                <td><?=$item['no_telepon']?></td>
                                <td><?=$item['kenek']?></td>
                                <td><?=$item['date']?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                    </td>
                  </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
      -->
        </div>
      </div>
    </div>
</div>
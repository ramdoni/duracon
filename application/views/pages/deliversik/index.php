<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Izin Kirim</h2> &nbsp;
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">No. SIK</th>
                <th class="column-title">No PO</th>
                <th class="column-title">Proyek</th>
                <th class="column-title">Sales</th>
                <th class="column-title">Alamat Pengiriman</th>
                <th class="column-title no-link last">Status</th>
              </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach($data as  $key => $item):?>
              <?php 
                // cek apakah sik sudah selesai semua atau belum
                
                $total_vol_sik = 0;

                $data_product_sik = $this->db->query("SELECT s.*, p.kode FROM surat_izin_kirim_history s inner join products p on p.id=s.product_id WHERE surat_izin_kirim_id={$item['id']}")->result_array();

                  foreach($data_product_sik as $key => $p){
                    $cek_sik = $this->db->query("SELECT spm.*, sum(spmp.volume) as volume FROM surat_perintah_muat spm inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id WHERE spm.surat_izin_kirim_id={$p['id']} and (spm.status=1 or spm.status = 2 or spm.status=0) and spmp.product_id={$p['product_id']}")->row_array();

                    $total_vol_sik = $p['volume_yang_dikirim'] - $cek_sik['volume'];
                  }
                  
                  if($total_vol_sik == 0) continue;
              ?>


                  <tr>
                    <td><?=($no)?></td>
                    <td><?=$item['no_sik']?></td>
                    <td><?=$item['no_po']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['sales']?></td>
                    <td><?=$item['alamat_pengiriman']?></td>
                    <td>
                      <?=status_sik($item)?>
                      <br />
                      <span onclick="detail_sik(<?=$item['id']?>,'<?=$item['no_sik']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Surat Izin Kirim"><i class="fa fa-search-plus"></i> Detail</span>
                    </td>
                  </tr>
            <?php $no++; endforeach; ?>
            </tbody>
          </table>
       </div>        
      </div>
    </div>
</div>
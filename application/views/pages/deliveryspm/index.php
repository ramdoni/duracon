 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Perintah Muat</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
          <div>
            <div class="x_panel">
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No SPM</th>
                      <th>No Mobil</th>
                      <th>Masa Berlaku</th>
                      <th>Status</th>
                      <th>Catatan</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php 
                      $data_products = $this->db->query("SELECT spm.*, m.no_mobil FROM surat_perintah_muat spm INNER JOIN mobil m ON m.id=spm.mobil_id")->result_array();
                      foreach($data_products as $key => $item)
                      {
                        echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".($item['no_spm'])."</td>".

                            "<td>{$item['no_mobil']}</td>".
                            "<td>{$item['masa_berlaku']}</td>".
                            "<td>". status_spm($item['status']) ."</td>".
                            "<td>{$item['catatan']}</td>"
                            ;
                      ?>
                        <td>
                            <a href="<?=site_url()?>deliversik/spm/<?=$item['surat_izin_kirim_id']?>" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i> Detail</a>
                        </td>
                      <?php 
                        echo "</tr>";
                      }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

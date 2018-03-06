 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Perintah Muat #No SPM : <?=$spm['no_spm']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Return Surat Jalan</h2> &nbsp;&nbsp;
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No Surat Jalan</th>
                      <th>Masa Berlaku</th>
                      <th>Produk yang di return</th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php 

                      $this->db->from('surat_jalan');
                      $this->db->order_by('id', 'DESC');
                      $this->db->where(['surat_perintah_muat_id' => $spm['id']]);

                      $data_products =  $this->db->get()->result_array();

                      foreach($data_products as $key => $item): 
                      
                        // get data return
                        $return = $this->db->query("SELECT sj.*, p.kode FROM surat_jalan_return sj INNER JOIN products p on p.id=sj.product_id WHERE surat_jalan_id='{$item['id']}' ");

                        $total = $return->num_rows();
                        if($total == 0) continue;
                      ?>

                        <tr>
                          <td><?=($key+1)?></td>
                          <td><?=$item['no_surat_jalan']?></td>
                          <td><?=date('d F Y', strtotime($item['date']))?></td>
                          <td>
                            <table class="table table-bordered">
                                <tr>
                                  <th>No</th>
                                  <th>Product</th>
                                  <th>Baik</th>
                                  <th>Repair</th>
                                  <th>Reject</th>
                                  <th>Keterangan</th>
                                </tr>
                              <?php foreach($return->result_array() as $k =>$i): ?>
                                  <tr>
                                    <td><?=($k+1)?></td>
                                    <td><?=$i['kode']?></td>
                                    <td><?=$i['baik']?></td>
                                    <td><?=$i['repair']?></td>
                                    <td><?=$i['reject']?></td>
                                    <td><?=$i['keterangan']?></td>
                                  </tr>
                            <?php endforeach;?>
                            </table>

                          </td>
                        </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
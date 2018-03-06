<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Products</h2> &nbsp;
        
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">

            <thead>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">Kategory Produk </th>
                <th class="column-title">Kode </th>
                <th class="column-title">Uraian </th>
                <th class="column-title">Stok</th>
                <th class="column-title">Reject</th>
                <th class="column-title">Repair</th>
                <th class="column-title">Finishing</th>
                <th class="column-title">Outstanding</th>
                <th class="column-title">Hasil Delivery hari ini</th>
                <th class="column-title"></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($data as $key => $item):?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['spesifikasi']?></td>
                    <td><?=$item['kode']?></td>
                    <td><?=$item['uraian']?></td>
                    <td><?=$item['stock']?></td>
                    <td><?=$item['reject']?></td>
                    <td><?=$item['repair']?></td>
                    <td><?=$item['finishing']?></td>
                    <td>
                      <?php 

                      $outstanding = $this->db->query("SELECT sum(qo.vol) as total FROM `sales_order` so 
                                  inner join quotation_order_products qo on qo.quotation_order_id=so.quotation_order_id
                                  where so.position=5 and qo.product_id={$item['id']}")->row_array();

                      // get data yang dikirim
                      $spm = $this->db->query("SELECT sum(spmp.volume) as total FROM surat_perintah_muat spm inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id  where spm.status=2 and spmp.product_id={$item['id']}")->row_array();

                      echo ($outstanding['total'] - $spm['total']);

                      ?>
                    </td>
                    <td>
                      <?php  
                        $sj = $this->db->query("SELECT sum(spmp.volume) as total FROM `surat_jalan` sj inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=sj.surat_perintah_muat_id where sj.status=2 and date(sj.date)=CURDATE() and spmp.product_id={$item['id']}")->row_array();

                        echo $sj['total'];
                       ?>
                    </td>
                    <td>
                      <a href="<?=site_url()."datastok/edit/{$item['id']}"?>" class="btn btn-default btn-xs">Rubah stok <i class="fa fa-arrow-right"></i></a>
                      <a href="<?=site_url()."datastok/historyperubahanstock/{$item['id']}"?>" class="btn btn-default btn-xs"><i class="fa fa-history"></i> History stock</a>
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

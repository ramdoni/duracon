<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
      	<p style="text-align: center;"><img src="<?=site_url()?>assets/images/logo.jpg" style="width: 50%;" /></p>
      	<br />
      	<br />
      	<div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-database"></i> Total Produk</span>
              <div class="count"><?=$this->db->query('SELECT count(*) AS total from products')->row_array()['total']?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-database"></i> All Total Stok</span>
              <div class="count">
                <?=$this->db->query('SELECT sum(stock) as total FROM products')->row_array()['total']?>  
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-database"></i> All Total Reject</span>
              <div class="count">
                <?=$this->db->query('SELECT sum(reject) as total FROM products')->row_array()['total']?> 
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-database"></i> All Total Repair</span>
              <div class="count">
                <?=$this->db->query('SELECT sum(repair) as total FROM products')->row_array()['total']?>
              </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-database"></i> All Total Finishing</span>
              <div class="count">
              	<?=$this->db->query('SELECT sum(finishing) as total FROM products')->row_array()['total']?>
              	</div>
            </div>
          </div>
      </div>
    </div>
</div>
<!--
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">

    <div class="row x_title">
      <div class="col-md-6">
        <h3>Product Activities</h3>
      </div>
      
    </div>
    <div class="clearfix"></div>
    <div class="x_content">
        <ul class="messages">
          <?php foreach($data as $key => $item): if($key == 10) continue; ?>
            <li>
              <img src="<?=base_url()?>assets/images/people.png" class="avatar" alt="Avatar">
              <div class="message_wrapper">
                <h4 class="heading"><?=$item['name']?></h4>
                <blockquote class="message" style="font-size: 12px;">
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Stok Lama</th>
                          <th>Stok Baru</th>
                          <th>Reject Lama</th>
                          <th>Reject Baru</th>
                          <th>Repair Lama</th>
                          <th>Repair Baru</th>
                          <th>Finishing Lama</th>
                          <th>Finishing Baru</th>
                          <th>Tanggal Perubahan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?=$item['stock_lama']?></td>
                          <td><?=$item['stock']?></td>
                          <td><?=$item['repair_lama']?></td>
                          <td><?=$item['repair']?></td>
                          <td><?=$item['reject_lama']?></td>
                          <td><?=$item['reject']?></td>
                          <td><?=$item['finishing_lama']?></td>
                          <td><?=$item['finishing']?></td>
                          <td><?=date('d F Y H:i:s', strtotime($item['create_time']))?></td>
                        </tr>
                      </tbody>
                  </table>
                </blockquote>
                <div class="clearfix"></div>
              </div>
            </li>
          <?php endforeach; ?>            
        </ul>
      </div>
    </div>
  <br class="clearfix" />
</div>
-->

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>History Perubahan Stok </h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <h4><?=$product['kode']?> - <?=$product['uraian']?></h4>
        <ul class="messages">
          <?php foreach($data as $item): ?>
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
                          <th>Keterangan</th>
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
                          <td><?=$item['keterangan']?></td>
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
  </div>
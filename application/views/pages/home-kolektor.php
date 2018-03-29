<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
      	<p style="text-align: center;"><img src="<?=site_url()?>assets/images/logo.jpg" style="width: 50%;" /></p>

      	<br />
      	<br />
      	<h2>History Tanda Terima</h2>
      	<table class="table table-bordered">
      		 <thead>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">No Invoice </th>
                <th class="column-title">Tanggal Pembuatan </th>
                <th class="column-title">Tanggal Terima  </th>
                <th class="column-title">Faktur Pajak </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=$key+1?></td>
                    <td><?=$item['no_invoice']?></td>
                    <td><?=$item['tanggal_pembuatan']?></td>
                    <td><?=$item['tanggal_terima']?></td>
                    <td><?=$item['faktur_pajak']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
      	</table>
      </div>
    </div>
</div>
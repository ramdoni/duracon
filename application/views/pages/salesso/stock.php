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

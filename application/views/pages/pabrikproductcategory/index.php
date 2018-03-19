<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Produk Type</h2> &nbsp;
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">Nama </th>
                <th class="column-title">Keterangan </th>
                <th class="column-title">Create Time </th>
                <th class="column-title">Update Time </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key => $item):?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['description']?></td>
                    <td><?=$item['create_time']?></td>
                    <td><?=$item['update_time']?></td>
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
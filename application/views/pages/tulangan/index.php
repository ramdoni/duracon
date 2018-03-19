<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tulangan</h2> &nbsp;
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">

            <thead>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">Nama Tulangan </th>
                <th class="column-title">Stok </th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($data as $key => $item):?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['stock']?></td>
                    <td>
                        <a href="<?=site_url("tulangan/edit/{$item['id']}")?>" class="btn btn-default btn-xs" title="Edit">Rubah stok <i class="fa fa-arrow-right"></i></a> 
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

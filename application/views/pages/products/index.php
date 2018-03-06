<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Products</h2> &nbsp;
        <a href="<?=site_url('products/insert')?>" class="btn btn-success btn-sm">Create / Insert</a>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?=site_url('products/import')?>">Import</a>
              </li>
            </ul>
          </li>
        </ul>
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
                <th class="column-title">Satuan </th>
                <th class="column-title">Weight </th>
                <th class="column-title">Harga Satuan </th> 
                <th class="column-title">Biaya Setting</th> 
                <th class="column-title">Status </th> 
                <th class="column-title no-link last"></th>
                <th class="bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($data as $key => $item):?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['spesifikasi']?></td>
                    <td><?=$item['kode']?></td>
                    <td><?=$item['uraian']?></td>
                    <td><?=$item['satuan']?></td>
                    <td><?=$item['weight']?></td>
                    <td><?=$item['price']?></td>
                    <td><?=number_format($item['biaya_setting'])?></td>
                    <td><a href="#" class="edit-active" data-type="select" data-url="<?=site_url()?>/ajax/saveproduct" data-pk="<?=$item['id']?>" ><?=($item['active'] == 1 ? 'Active' : 'Inactive')?></a></td>
                    <td>
                        <a href="<?=site_url("products/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a> 
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

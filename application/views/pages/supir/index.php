<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Supir</h2> &nbsp;
        <a href="<?=site_url('supir/insert')?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Supir</a>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">Nama </th>
                <th class="column-title">Mobil </th>
                <th class="column-title">No Mobil </th>
                <th class="column-title">No Telepon </th>
                <th class="column-title">Nama Kenek </th>
                <th class="column-title">No Telepon Kenek </th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach($data as $key => $item):
            ?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['nama']?></td>
                    <td><?=$item['tipe_mobil']?></td>
                    <td><?=$item['no_mobil']?></td>
                    <td><?=$item['no_telepon']?></td>
                    <td><?=$item['nama_kenek']?></td>
                    <td><?=$item['no_telepon_kenek']?></td>
                    <td><a href="<?=site_url("supir/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a></td>
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
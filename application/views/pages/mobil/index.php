<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Mobil</h2> &nbsp;
        <a href="<?=site_url('mobil/insert')?>" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah</a>
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
                <th>No</th>
                <th class="column-title">Vendor </th>
                <th class="column-title">No Mobil </th>
                <th class="column-title">Jenis Mobil </th>
                <th class="column-title">Nama Supir</th>
                <th class="column-title">No Telepon</th>
                <th class="column-title">Kenek</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=$key+1?></td>
                    <td><?=$item['vendor']?></td>
                    <td><?=$item['no_mobil']?></td>
                    <td><?=$item['jenis_mobil']?></td>
                    <td><?=$item['nama_supir']?></td>
                    <td><?=$item['no_telepon']?></td>
                    <td><?=$item['kenek']?></td>
                    <td>
                        <a href="<?=site_url("mobil/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a> 
                        <a title="Hapus" onclick="_confirm('Hapus data ini?', '<?=site_url("mobil/delete/{$item['id']}")?>')" ><i class="fa fa-trash"></i></a> 
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
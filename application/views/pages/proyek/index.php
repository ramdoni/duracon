<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Proyek</h2> &nbsp;
        <a href="<?=site_url('proyek/insert')?>" class="btn btn-success btn-sm">Create / Insert</a>
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
                <th class="column-title">Tahun </th>
                <th class="column-title">PIC </th>
                <th class="column-title">Status </th>
                <th class="column-title">Create Time  </th>
                <th class="column-title">Update Time </th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=$key+1?></td>
                    <td><?=$item['nama']?></td>
                    <td><?=$item['tahun']?></td>
                    <td><?=$item['pic']?></td>
                    <td><a href="#" class="edit-active" data-type="select" data-url="<?=site_url()?>/ajax/saveproyek" data-pk="<?=$item['id']?>" ><?=($item['active'] == 1 ? 'Active' : 'Inactive')?></a></td>
                    <td><?=$item['create_time']?></td>
                    <td><?=$item['update_time']?></td>
                    <td>
                        <a href="<?=site_url("proyek/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a></td>
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
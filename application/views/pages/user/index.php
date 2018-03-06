<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>User List</h2> &nbsp;
        <a href="<?=site_url('user/insert')?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah User</a>
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
                <th class="column-title">Username </th>
                <th class="column-title">Name </th>
                <th class="column-title">User Group </th>
                <th class="column-title">Email </th>
                <th class="column-title">Phone </th>
                <th class="column-title">Status </th>
                <th class="column-title">Create Time  </th>
                <th class="column-title">Update Time </th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key => $item):?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['username']?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['user_group']?></td>
                    <td><?=$item['email']?></td>
                    <td><?=$item['phone']?></td>
                    <td><a href="#" class="edit-active" data-type="select" data-url="<?=site_url()?>/ajax/saveuser" data-pk="<?=$item['id']?>" ><?=($item['active'] == 1 ? 'Active' : 'Inactive')?></a></td>
                    <td><?=$item['create_time']?></td>
                    <td><?=$item['update_time']?></td>
                    <td>
                        <?php if($item['user_group_id'] == 3):?>

                            <?php if($item['is_lock'] == 1):?>
                                <a onclick="_confirm('Unlock User Sales ini?', '<?=site_url('user/unlock/'. $item['id'])?>')" class="btn btn-danger btn-xs"><i class="fa fa-unlock"></i> Unlock User</a>
                            <?php endif; ?>

                            <?php if($item['is_lock'] == 0):?>
                                <a onclick="_confirm('Lock User Sales ini?', '<?=site_url('user/lock/'. $item['id'])?>')" class="btn btn-warning btn-xs"><i class="fa fa-lock"></i> Lock User</a>
                            <?php endif; ?>

                        <?php endif; ?>


                        <a href="<?=site_url("user/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a>
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
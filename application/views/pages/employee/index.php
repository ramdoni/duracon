<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Employee</h2> &nbsp;
        <a href="<?=site_url('employee/insert')?>" class="btn btn-success btn-sm">Create / Insert</a>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th>
                  <input type="checkbox" id="check-all" class="flat">
                </th>
                <th class="column-title">Name </th>
                <th class="column-title">Email </th>
                <th class="column-title">Phone </th>
                <th class="column-title">Date of Birth </th>
                <th class="column-title">Place of Birth </th>
                <th class="column-title">Address </th>
                <th class="column-title">Access </th>
                <th class="column-title">Create Time  </th>
                <th class="column-title">Update Time </th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody>
              <?php
                foreach($data as $key => $item):
            ?>
                <tr class="even pointer">
                    <td class="a-center ">
                    <input type="checkbox" class="flat" name="table_records">
                  </td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['email']?></td>
                    <td><?=$item['phone']?></td>
                    <td><?=$item['date_of_birth']?></td>
                    <td><?=$item['place_of_birth']?></td>
                    <td><?=$item['address']?></td>
                    <td><?=$item['access']?></td>
                    <td><?=$item['create_time']?></td>
                    <td><?=$item['update_time']?></td>
                    <td>
                        <a href="<?=site_url("employee/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a> 
                        <a href="<?=site_url("employee/delete/{$item['id']}")?>" onclick="return (confirm('Hapus data ini?') ? true : false);" title="Delete"><i class="fa fa-trash-o"></i></a></td>
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
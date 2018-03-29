<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Customer</h2> &nbsp;
        <a href="<?=site_url('customer/insert')?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
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
                <th class="column-title">Name </th>
                <th class="column-title">Email </th>
                <th class="column-title">Telphone </th>
                <th class="column-title">Fax </th>
                <th class="column-title">Handhone </th>
                <th class="column-title">Address </th>
                <th class="column-title">Status </th>
                <th class="column-title">Sistem Pembayaran </th>
                <th class="column-title">Create Time  </th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=$key+1?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['email']?></td>
                    <td><?=$item['telphone']?></td>
                    <td><?=$item['fax']?></td>
                    <td><?=$item['handphone']?></td>
                    <td><?=$item['address']?></td>
                    <td><a href="#" class="edit-active" data-type="select" data-url="<?=site_url()?>/ajax/savecustomer" data-pk="<?=$item['id']?>" ><?=($item['active'] == 1 ? 'Active' : 'Inactive')?></a></td>
                    <td>
                        <?php 

                            if($item['sistem_pembayaran'] !== 'Cash')
                            {
                                echo $item['sistem_pembayaran'] .'<br />Limit Overdue Day : '. $item['kredit_overdue_day'] .' Day<br />Dp : '. $item['dp'] ."%";
                            }   
                            else
                            {
                                echo $item['sistem_pembayaran'];
                            }
                        ?>
                    </td>
                    <td><?=$item['create_time']?></td>
                    <td>
                        <a href="<?=site_url("customer/edit/{$item['id']}")?>" title="Edit"><i class="fa fa-edit"></i></a>    
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
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Pengajuan Dispensasi</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?=site_url('employeepo/export')?>">Export</a></li>
              <li><a href="<?=site_url('employeepo/import')?>">Import</a></li>
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
                <th class="column-title">No</th>
                <th class="column-title">Customer</th>
                <th class="column-title">Proyek </th>
                <th class="column-title">No SO </th>
                <th class="column-title">Nominal Pengajuan </th>
                <th class="column-title">Nominal Yang disetujui </th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data as $k => $item):?>
                    <tr>
                      <td><?=($k+1)?></td>
                      <td><?=nama_customer($item['customer_id'])?></td>
                      <td><?=$item['proyek']?></td>
                      <td><?=$item['no_so']?></td>
                      <td>Rp. <?=number_format($item['nominal_pengajuan'])?></td>
                      <td>Rp. <?=number_format($item['nominal_setujui'])?></td>
                      <td><a href="<?=site_url('salesso/historysik/'. $item['sales_order_id'])?>"><?=status_dispensasi($item['status'])?></a></td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
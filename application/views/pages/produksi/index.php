<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Sales Order</h2>
        &nbsp;
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
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th>
                  <input type="checkbox" id="check-all" class="flat">
                </th>
                <th class="column-title">No PO </th>
                <th class="column-title">Customer / PT </th>
                <th class="column-title">Proyek </th>
                <th class="column-title">Area Kirim </th>
                <th class="column-title">Jadwal Mulai </th>
                <th class="column-title">Jadwal Selesai </th>
                <th class="column-title">Sales </th>
                <th class="column-title no-link last">Position</th>
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
                    <td><?=$item['no_po']?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['area']?></td>
                    <td><strong><code><?=date('d M Y', strtotime($item['jadwal_mulai']))?></code></strong></td>
                    <td><strong><code><?=date('d M Y', strtotime($item['jadwal_selesai']))?></code></strong></td>
                    <td><?=$item['sales']?></td>
                    <td>
                       <?php 
                      if($item['position'] == 5){
                      ?>
                        <a href="<?=site_url("produksi/proccess/{$item['id']}")?>" onclick="return confirm('Proses Produksi ?') ? true: false; " title="Proccess" class="btn btn-success btn-xs"> <i class="fa fa-check"></i>  Proses </a>
                        <a href="<?=site_url("produksi/revisi/{$item['id']}")?>" title="Revisi" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i>  Revisi </a>

                      <?php }else { echo position_so($item['position']);} ?>
                      <br />
                      <?php  if($item['position'] == 6){ ?>
                          <a href="<?=site_url("produksi/done/{$item['id']}")?>" onclick="return confirm('Proses Produksi sudah selesai ?') ? true: false; " title="Proccess" class="btn btn-success btn-xs"> <i class="fa fa-check-circle"></i>  Produksi Selesai </a>
                      <?php } ?>
                      <a href="<?=site_url("produksi/detail/{$item['id']}")?>" title="Proccess" class="btn btn-default btn-xs"> <i class="fa fa-check-circle"></i>  Detail </a>
                    </td>
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
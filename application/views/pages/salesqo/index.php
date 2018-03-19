<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Quotation Order</h2>
        &nbsp;
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?=site_url('employeeqo/export')?>">Export</a></li>
              <li><a href="<?=site_url('employeeqo/import')?>">Import</a></li>
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
                <th class="column-title">No</th>
                <th class="column-title">No Quotation</th>
                <th class="column-title">Customer / PT </th>
                <th class="column-title">Proyek </th>
                <th class="column-title">Area Kirim </th>
                <th class="column-title">Tanggal </th>
                <th class="column-title no-link last">Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach($data as $key => $item):
            ?>
                <tr class="even pointer">
                    <td><?=($key+1)?></td>
                    <td><?=$item['no_po']?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['area_kirim']?></td>
                    <td><?=$item['tanggal']?></td>
                    <td>
                      <?php 
                        if($item['position'] !== 2)echo position_qo($item['position']);
                      ?>
                    </td>
                    <td>
                      <a href="<?=site_url("salesqo/printom/{$item['id']}")?>" target="_blank" class="btn btn-default btn-xs" title="Print"><i class="fa fa-print"></i> Print OM</a><br />

                      <?php if($item['position'] == 2){ ?>
                      <a href="<?=site_url("salesqo/proccess/{$item['id']}")?>" title="Proccess"><span class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Proses</span></a>
                      <?php } ?>
                      <?php  if($item['position'] == 5):?>
                        <a href="<?=site_url("salesqo/printqo/{$item['id']}")?>" target="_blank" class="btn btn-default btn-xs" title="Print"><i class="fa fa-print"></i> Print</a><br />
                      <?php endif; ?>
                        <span onclick="detail_quotation(<?=$item['id']?>,'<?=$item['no_po']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Quotation"><i class="fa fa-search-plus"></i> Detail</span>
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
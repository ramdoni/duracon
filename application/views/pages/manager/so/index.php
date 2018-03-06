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
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">Customer</th>
                <th class="column-title">Proyek </th>
                <th class="column-title">No SO </th>
                <th class="column-title">No PO </th>
                <th class="column-title">Area Kirim </th>
                <th class="column-title">Sales </th>
                <th class="column-title">Position</th>
                <th class="column-title">Catatan AR</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>

            <tbody>
              <?php
                foreach($data as $key => $item):
            ?>
                <tr class="even pointer">
                    <td><?=($key+1)?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['no_so']?></td>
                    <td><?=$item['no_po']?></td>
                    <td><?=$item['area']?></td>
                    <td><?=$item['sales']?></td>
                    <td><?=position_so($item['position'])?></td>
                    <td>
                      <?php $catatan = $this->db->get_where('sales_order_catatan_ar', ['sales_order_id' => $item['id']])->result_array(); ?>
                      <?php foreach($catatan as $i) { echo '<p>'. $i['catatan']. '<p><br />'; } ?>
                    </td>
                    <td>
                       <?php 
                      if($item['position'] == 4){
                      ?>
                        <a href="<?=site_url("managerso/proccess/{$item['id']}")?>" title="Proccess"><span class="btn btn-success btn-xs"> Proses <i class="fa fa-arrow-right"></i></span></a>
                      <?php } ?>
                      <span onclick="detail_sales_order(<?=$item['quotation_order_id']?>,<?=$item['id']?>,'<?=$item['no_po']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Quotation"><i class="fa fa-search-plus"></i> Detail</span>
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
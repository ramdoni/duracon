<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Sales Order</h2>
        &nbsp;
        <a href="<?=site_url('employeeso/insert')?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Buat Sales Order</a>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th class="column-title">No SO </th>
                <th class="column-title">No Quotation </th>
                <th class="column-title">No PO </th>
                <th class="column-title">Customer / PT </th>
                <th class="column-title">Proyek </th>
                <th class="column-title">Area Kirim </th>
                <th class="column-title">Jadwal Mulai </th>
                <th class="column-title">Jadwal Selesai </th>
                <th class="column-title">Sales </th>
                <th class="column-title">Catatan AR </th>
                <th class="column-title">Posisi / Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>

            <tbody>
              <?php
                foreach($data as $key => $item):
            ?>
                <tr class="even pointer">
                    <td><?=($key+1)?></td>
                    <td><?=$item['no_so']?></td>
                    <td><?=$item['no_quotation']?></td>
                    <td><?=$item['no_po']?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['area']?></td>
                    <td><?=$item['jadwal_mulai']?></td>
                    <td><?=$item['jadwal_selesai']?></td>
                    <td><?=$item['sales']?></td>
                    <td>
                      <?=catatan_ar_by_so_id($item['id'])?>
                    </td>
                    <td><?=position_so($item['position'])?></td>
                    <td>
                      <?php if($item['position'] == 1):?>
                        <a href="<?=site_url("employeeso/edit/{$item['id']}")?>" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a> 
                        <a href="<?=site_url("employeeso/delete/{$item['id']}")?>" class="btn btn-xs btn-danger" onclick="return (confirm('Hapus data ini?') ? true : false);" title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
                      <?php endif; ?>

                      <?php if($item['position'] == 2): ?>
                        <a href="<?=site_url('employeeso/approve/'. $item['id'])?>" title="Approve Sales Order yang masih pending" class="btn btn-xs btn-success"><i class="fa fa-arrow-right"></i> Approve Sales Order</a>
                      <?php endif; ?>

                      <?php if($item['position'] >= 4):?>
                        <a href="<?=site_url("employeeso/printso/{$item['id']}")?>" target="_blank" class="btn btn-default btn-xs" title="Print"><i class="fa fa-print"></i> Print</a>
                        <a onclick="_confirm('Close Sales Order ini ?','<?=site_url("employeeso/soselesai/{$item['id']}")?>')" class="btn btn-danger btn-xs" title="Print"><i class="fa fa-check"></i> Close SO</a>
                      <?php endif;?>
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
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Quotation Order</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th class="column-title">No </th>
                <th class="column-title">No Quotation </th>
                <th class="column-title">Customer / PT </th>
                <th class="column-title">Proyek </th>
                <th class="column-title">Total Quotation </th>
                <th class="column-title">Tanggal </th>
                <th class="column-title">Sales </th>
                <th class="column-title no-link last"></th>
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
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['no_po']?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td>Rp. <?=number_format(total_nominal_quotation($item['id']))?></td>
                    <td><?=$item['tanggal']?></td>
                    <td><?=$item['sales']?></td>
                    <td>
                      <?php 
                      if($item['position'] == 3 or $item['position'] == 4){
                      ?>
                        <a href="<?=site_url("managerqo/proccess/{$item['id']}")?>" title="Proccess"><span class="btn btn-success btn-xs"> Proses <i class="fa fa-arrow-right"></i> </span></a>
                      <?php }else {echo position_qo($item['position']);} ?>
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
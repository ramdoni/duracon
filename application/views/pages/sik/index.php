<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Izin Kirim</h2> &nbsp;
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
                <th>No</th>
                <th class="column-title">No. SIK</th>
                <th class="column-title">No PO</th>
                <th class="column-title">Proyek</th>
                <th class="column-title">Marketing</th>
                <th class="column-title">Sales</th>
                <th class="column-title">Alamat Pengiriman</th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data as  $key => $item):?>
                      <tr>
                        <td><?=($key+1)?></td>
                        <td><?=$item['no_sik']?></td>
                        <td><?=$item['no_po']?></td>
                        <td><?=$item['proyek']?></td>
                        <td><?=$item['marketing']?></td>
                        <td><?=$item['sales']?></td>
                        <td><?=$item['alamat_pengiriman']?></td>
                        <td><?=position_sik($item['position'])?></td>
                        <td>
                          <span onclick="detail_sik(<?=$item['id']?>,'<?=$item['no_po']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Surat Izin Kirim"><i class="fa fa-search-plus"></i> Detail</span>
                        </td>
                      </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
       </div>        
      </div>
    </div>
</div>
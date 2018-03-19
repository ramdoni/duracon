<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Sales Order</h2>
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

      <?php if( $this->session->userdata('access_id') == 6): // Ar Admin ?>
      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">No SO </th>
                <th class="column-title">Sales </th>
                <th class="column-title">Customer</th>
                <th class="column-title">Proyek </th>
                <th class="column-title">No PO </th>
                <th class="column-title">Nilai Kiriman</th>
                <th class="column-title">Nilai Invoice</th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['no_so']?></td>
                    <td><?=$item['sales']?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['no_po']?></td>
                    <td>Rp. <?=number_format(total_kiriman_perso($item['id']))?></td>
                    <td>Rp. <?=number_format(total_invoice_perso($item['id']))?></td>
                    <td>
                      <?php echo position_so($item['position'])?>
                    </td>
                    <td>
                      <span onclick="detail_sales_order(<?=$item['quotation_order_id']?>,<?=$item['id']?>,'<?=$item['no_po']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Quotation"><i class="fa fa-search-plus"></i> Detail</span>

                      <?php if($item['position'] == 5): ?>
                        <a href="<?=site_url("arso/invoice/{$item['id']}")?>" title="Invoice" class="btn btn-default btn-xs"><i class="fa fa-money"></i> Invoice</a>
                      <?php endif; ?>
                    </td>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>

      <?php endif; ?>

      <?php if( $this->session->userdata('access_id') == 10): // Ar Manager ?>
        <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">No SO </th>
                <th class="column-title">Sales </th>
                <th class="column-title">Customer</th>
                <th class="column-title">Proyek </th>
                <th class="column-title">No PO </th>
                <th class="column-title">Nilai Kiriman</th>
                <th class="column-title">Status</th>
                <th class="column-title">Catatan</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($data as $key => $item): ?>
                <tr class="even pointer">
                    <td class="a-center "><?=($key+1)?></td>
                    <td><?=$item['no_so']?></td>
                    <td><?=$item['sales']?></td>
                    <td><?=$item['customer']?></td>
                    <td><?=$item['proyek']?></td>
                    <td><?=$item['no_po']?></td>
                    <td>Rp. <?=number_format(total_kiriman_perso($item['id']))?></td>
                    <td>
                      <?php echo position_so($item['position'])?>
                    </td>
                    <td>
                      <?php $catatan = $this->db->get_where('sales_order_catatan_ar', ['sales_order_id' => $item['id']])->result_array(); ?>
                      <?php foreach($catatan as $i) { echo '<p>'. $i['catatan']. '<p><br />'; } ?>
                    </td>
                    <td>
                       <?php if($item['position'] >= 4): ?>
                        <label onclick="add_catatan_so(<?=$item['id']?>)" title="Tambah Catatan" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah Catatan</label>
                      <?php endif; ?>

                      <span onclick="detail_sales_order(<?=$item['quotation_order_id']?>,<?=$item['id']?>,'<?=$item['no_po']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Quotation"><i class="fa fa-search-plus"></i> Detail</span>

                      <?php if($item['position'] == 5): ?>
                        <a href="<?=site_url("arso/invoice/{$item['id']}")?>" title="Invoice" class="btn btn-default btn-xs"><i class="fa fa-money"></i> Invoice</a>
                      <?php endif; ?>
                    </td>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
      </div>
    </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade modal-wide" id="modal_tambah_catatan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Catatan</h4>
      </div>
      <div class="modal-body">
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="<?=site_url('arso/addcatatan')?>" method="post"  >
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="form-control" name="catatan"></textarea>
              </div>
            </div>
            <input type="hidden" name="sales_order_id" value="" class="modal_sales_order_id">

            <hr />
            <span class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</span>
            <button type="submit" class="btn btn-sm btn-success" style="float: right;"><i class="fa fa-save"></i> Submit</button>
          </form>          
          </div>
          <br style="clear: both;" />
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function add_catatan_so(sales_order_id)
  {
    $('#modal_tambah_catatan').modal('show');
    $('.modal_sales_order_id').val(sales_order_id);
  }
</script>

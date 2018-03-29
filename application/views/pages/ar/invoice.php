<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Sales Order #<?=$data['no_so']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form class="form-horizontal form-label-left">
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SO : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label label-no_po_sales_order"><?=$data['no_so']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label label-no_po"><?=$data['no_quotation']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No PO : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label label-no_po_sales_order"><?=$data['no_po']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales : </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="control-label label-sales_id"><?=$data['sales']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / Perusahaan : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="control-label label-customer_id"><?=$data['customer']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek : </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label label-proyek"><?=$data['proyek']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="control-label label-sistem_pembayaran"><?=$data['sistem_pembayaran']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Tipe Pekerjaan : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="control-label label-tipe_pekerjaan"><?=$data['tipe_pekerjaan']?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Uang yang sudah masuk : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="control-label label-tipe_pekerjaan">Rp. <?=number_format($data['deposit'])?></label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sisa Uang : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="control-label label-tipe_pekerjaan">Rp. <?=number_format(sisa_uang_so($data['id']))?></label>
              </div>
            </div>
          </form>
          <div class="x_panel">
              <div class="x_title">
                <h2>Invoice </h2> &nbsp;&nbsp;&nbsp;
                <a href="<?=site_url()?>arso/createinvoice/<?=$data['id']?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Buat Invoice</a>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No Invoice</th>
                      <th>Nominal Pembayaran</th>
                      <th>Catatan</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="content-invoice">
                      <?php $invoice = $this->db->order_by('id', 'desc')->get_where('invoice', ['sales_order_id' => $data['id']])->result_array(); ?>
                      <?php 
                        $total = 0; 
                        $total_belum_lunas = 0;
                      ?>
                      <?php foreach($invoice as $key => $item):?>
                          <tr>
                            <td><?=$key+1?></td>
                            <td><?=$item['no_invoice']?></td>
                            <td>Rp . <?=number_format($item['nominal'])?></td>
                            <td><?=$item['catatan']?></td>
                            <td><?=$item['date']?></td>
                            <th><?=status_invoice($item['status'])?></th>
                            <td>
                              <a href="<?=site_url()?>arso/printinvoice/<?=$item['id']?>" target="_blank" class="btn btn-default btn-xs"> <i class="fa fa-print"></i> Cetak</a>

                              <a href="<?=site_url()?>arso/viewinvoice/<?=$item['id']?>" class="btn btn-default btn-xs"> <i class="fa fa-search-plus"></i> Detail</a>

                            </td>
                          </tr>
                        <?php 
                          if($item['status'] == 1)
                            $total += $item['nominal']; 
                          else
                            $total_belum_lunas += $item['nominal'];
                        ?>
                      <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="2" style="text-align: right">Total Sudah Lunas</th>
                      <th colspan="5" style="color: #26B99A;">Rp. <?=number_format($total)?></th>
                    </tr>
                    <tr>
                      <th colspan="2" style="text-align: right">Total Outstanding</th>
                      <th colspan="5" style="color: #d9534f;">Rp. <?=number_format($total_belum_lunas)?></th>
                    </tr>
                  </tfoot>
                <?php if(empty($invoice)) echo '<tr><td colspan="6"><i>Tidak ada invoice</i></td></tr>'; ?>
                </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/sales-order-approve.js"></script>



 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Buat Surat Izin Kirim</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-sik" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Sik[sales_order_id]" class="sales_order_id" value="<?=$data['id']?>" />

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SIK 
            </label>
            <div class="col-md-6">
              <input type="text" id="no_sik" required="required" readonly="true" name="Sik[no_sik]" value="<?=(isset($data['no_sik']) ? $data['no_sik'] : '')?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="penerima_lapangan">Penerima Lapangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" disabled="true" value="<?=(isset($data['penerima_lapangan']) ? $data['penerima_lapangan'] : '')?>" name="Employee_so[penerima_lapangan]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">No Telepon</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal"  readonly="true" value="<?=(isset($data['no_telepon']) ? $data['no_telepon'] : '')?>"  name="Employee_so[no_telepon]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">Sistem Pembayaran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" readonly="true" value="<?=$quotation_order['sistem_pembayaran']?>" class="form-control col-md-7 col-xs-12 sistem_pembayaran">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">Sisa Uang</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal"  readonly="true" value="Rp. <?=number_format(sisa_uang_so($data['id']),0,'','.')?>" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">Dispensasi AR</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" readonly="true" value="Rp. <?=number_format($data['deposit_dispensasi'],0,'','.')?>" class="form-control col-md-7 col-xs-12">
              <input type="hidden" name="nominal_dispensasi" class="nominal_dispensasi" value="<?=$data['deposit_dispensasi']?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Alamat Pengirimin <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" required name="Sik[alamat_pengiriman]"><?=$data['proyek']?></textarea>
            </div>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Produk yang akan dikirim </h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Produk</th>
                      <th>Volume PO</th>
                      <th>Harga Satuan</th>
                      <th>Outstanding</th>
                      <th>Volume yang sudah Terkirim</th>
                      <th>Harga yang sudah Terkirim</th>
                      <th>Stok</th>
                      <th>Volume yang akan Dikirim</th>
                      <th>Harga yang akan dikirim</th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                    <?php

                      $total_all = $this->db->query("SELECT sum(volume_yang_dikirim) as total_volume_yang_dikirim, sum(harga_yang_dikirim) as total_harga_yang_dirkirim FROM surat_izin_kirim_history WHERE sales_order_id={$data['id']}")->row_array();

                      $total_harga_yang_terkirim = $total_all['total_harga_yang_dirkirim'];
                      $total_volume_yang_terkirim = $total_all['total_volume_yang_dikirim'];

                    ?>
                    <?php foreach($products as $key  => $item): ?>
                    <?php 

                      $cek = $this->db->query("SELECT sum(volume_yang_dikirim) as total_volume_yang_dikirim, sum(harga_yang_dikirim) as total_harga_yang_dirkirim FROM surat_izin_kirim_history WHERE product_id={$item['product_id']} and sales_order_id={$data['id']}")->row_array();

                      $volume_yang_terkirim = $cek['total_volume_yang_dikirim'];
                      $harga_yang_terkirim = $cek['total_harga_yang_dirkirim'];
                      $volume_yang_belum_terkirim = $item['vol'] - $volume_yang_terkirim;
                    ?>
                        <tr>
                          <td><?=($key+1)?></td>
                          <td><?=$item['kode']?></td>
                          <td><?=$item['vol']?></td>
                          <td>Rp. <?=number_format($item['harga_satuan'],0,'','.')?></td>
                          <td style="text-align: right;background: #ffc8c8;color:black;"><?=$volume_yang_belum_terkirim?></td>
                          <td style="text-align: right;background: #efef2a;color:black;"><?=$volume_yang_terkirim?></td>
                          <td style="text-align: right;">Rp. <?=number_format($harga_yang_terkirim,0,'','.')?></td>
                          <td><?=get_stock_product($item['product_id'])?></td>
                          <td style="text-align: right;">
                            <?php 
                              $limit_volume_set = "{";
                              for($i=1; $i <= $volume_yang_belum_terkirim; $i++){
                                $limit_volume_set .= "{$i} : {$i}, ";
                              }
                              $limit_volume_set = substr($limit_volume_set, 0, -1). '}';
                            ?>
                            <a href="#" class="editable-set-volume" data-type="select" data-source="<?=$limit_volume_set?>" title="SET VOLUME YANG AKAN DIKIRIM" data-stock="<?=get_stock_product($item['product_id'])?>" data-pk="<?=$item['product_id']?>" data-uang="<?=$data['deposit']?>" data-totalkirimuang="<?=empty($total_harga_yang_terkirim) ? 0 : $total_harga_yang_terkirim?>"> 0 </a> 
                          </td>
                          <td class="harga_yg_kirim<?=$item['product_id']?>"></td>
                        </tr>
                        <input type="hidden" name="Product[<?=$item['product_id']?>][id]" class="product_id<?=$item['product_id']?> product_item" value="" />
                        <input type="hidden" name="Product[<?=$item['product_id']?>][price_list]" class="price_id<?=$item['product_id']?>" value="<?=$item['harga_satuan']?>" />
                        <input type="hidden" class="total_uang_yang_dikirim price_product_<?=$item['product_id']?>">
                    <?php endforeach; ?> 
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="8" style="text-align: right;">Total Volume yang akan dikirim</th>
                      <th style="text-align: right;" class="footer_total_volume"></th>
                      <th style="text-align: right;" class="footer_total_harga"></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Cancel</a>
              <a class="btn btn-success btn-sm btn-proccess-sik"> Proses SIK <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Modal -->
<div class="modal fade modal-wide" id="modal_pengajuan_dispensasi" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Pengajuan Dispensasi No SIK : <label class="label-no-sik"></label></h4>
      </div>
      <div class="modal-body">
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="POST" action="<?=site_url('salesso/submitdispensasi')?>">
            
            <input type="hidden" name="no_sik" class="hidden_no_sik">
            <input type="hidden" name="sales_order_id" class="hidden_sales_order_id">

            <div class="form-group">
              <label class="control-label col-md-5 col-sm-3 col-xs-12" for="no_po">Nominal Pengajuan Dispensasi : 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control idr" name="nominal"></div>
            </div>
            <hr />
            <div>
              <a class="btn btn-default btn-sm" data-dismiss="modal">Cancel</a>
              <button type="submit" class="btn btn-sm btn-success">Submit Pengajuan <i class="fa fa-arrow-right"></i></button>
            </div>
          </form>
        </div>
        <br style="clear: both" />
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/js/createsik.js?rand=<?=date('His')?>"></script>


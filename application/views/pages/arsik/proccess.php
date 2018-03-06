<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Proses Surat Izin Kirim</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Sales_order[approved]" value="0" />
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SIK</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$sik['no_sik']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No PO</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$so['no_po']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$qo['sales']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Marketing</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$qo['marketing']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$qo['customer']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$qo['proyek']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Berlaku</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=date('d F Y', strtotime($sik['masa_berlaku']))?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Pengiriman</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$sik['alamat_pengiriman']?></label>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Products </h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Uraian</th>
                      <th>Volume</th>
                      <th>Nominal</th>
                    </tr>
                  </thead>
                 <tbody class="add-table-product">
                    <?php 

                        $products = $this->db->query("SELECT sik.id, sik.harga_yang_dikirim, p.kode, p.uraian, sik.volume_yang_dikirim as vol FROM surat_izin_kirim_history sik INNER JOIN products p on p.id=sik.product_id WHERE sik.surat_izin_kirim_id={$sik['id']}")->result_array();

                        $total = 0;
                        $total_vol = 0;
                        foreach($products as $key =>  $i):
                    ?>
                        <tr class="tr-<?=$i['id']?>">
                          <td class="input-hidden"><?=($key+1)?></td>
                          <td class="kode"><?=$i['kode']?></td>
                          <td class="uraian"><?=$i['uraian']?></td>
                          <td class="vol"><?=$i['vol']?></td>
                          <td class="satuan">Rp. <?=number_format(($i['harga_yang_dikirim']))?></td>
                        </tr>
                        <?php $total_vol += $i['vol']; ?>
                        <?php $total += ($i['harga_yang_dikirim']); ?>
                    <?php endforeach; ?>
                  </tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3" style="text-align: right;">Total</th>
                      <th><?=$total_vol?></th>
                      <th>Rp. <?=number_format($total)?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('arsik')?>" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
              <a class="btn btn-success btn-proccess btn-sm">Approved <i class="fa fa-check"></i></a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/sik-approve.js"></script>



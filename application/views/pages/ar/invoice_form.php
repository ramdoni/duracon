<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Buat Invoice #NO SO : <?=$data['no_so']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="form-invoice" method="POST" class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">No Invoice</label>
              <div class="col-md-6">
                <input type="text" required="required" name="Invoice[no_invoice]" value="<?=$no_invoice?>"  class="form-control col-md-7 col-xs-10">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">No PO</label>
              <div class="col-md-6">
                <input type="text"  readonly="true" value="<?=$data['no_quotation']?>" class="form-control col-md-7 col-xs-10"> 
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Nama / PT</label>
              <div class="col-md-6">
                <input type="text" required="required" readonly="true" value="<?=$data['customer']?> <?=(!empty($data['company']) ? ' - '. $data['company'] : '' )?>" class="form-control col-md-7 col-xs-10"> 
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Nama Proyek</label>
              <div class="col-md-6">
                <input type="text"  readonly="true" value="<?=$data['proyek']?>" class="form-control col-md-7 col-xs-10"> 
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Sistem Pembayaran</label>
              <div class="col-md-6">
                <input type="text" required="required" name="Invoice[sistem_pembayaran]" readonly="true" value="<?=$qo['sistem_pembayaran']?>"  class="form-control col-md-7 col-xs-10"> 
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Nominal Uang</label>
              <div class="col-md-6">
                <input type="text" id="nominal" required="required" name="Invoice[nominal]" class="form-control col-md-7 col-xs-10 idr">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Untuk Pembayaran</label>
              <div class="col-md-6">
                <input type="text" name="Invoice[untuk_pembayaran]" class="form-control col-md-7 col-xs-10">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
              <div class="col-md-6">
               <textarea class="form-control" name="Invoice[catatan]" id="catatan" placeholder="Jika surat jalan belum ada maka isi catatan untuk dapat mencetak invoice"></textarea>
              </div>
            </div> 

            <div class="ln_solid"></div>

           <div id="step1">
            <h2>Surat Jalan yang akan diproses</h2>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>No Surat Jalan</th>
                  <th>Nama Supir</th>
                  <th>No Telepon</th>
                  <th>Nama Kenek</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    $surat_jalan = $this->db->query("
                        SELECT spmp.surat_perintah_muat_id, sj.*, p.kode, spmp.volume, m.nama_supir, m.no_telepon, m.kenek FROM surat_jalan sj 
                        inner join surat_perintah_muat spm on spm.id=sj.surat_perintah_muat_id
                        inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id 
                        inner join surat_izin_kirim sik on sik.id=spm.surat_izin_kirim_id
                        inner join products p on p.id=spmp.product_id
                        inner join mobil m on m.id=spm.mobil_id
                        where sik.sales_order_id='{$data['id']}' and spm.status=2 and sj.status_invoice = 0 and sj.status=2
                        group by sj.id
                        ")->result_array();

                    foreach($surat_jalan as $key => $item):
                ?>
                  <tr>
                    <td rowspan="2">
                      <input type="checkbox" name="surat_jalan[]" value="<?=$item['id']?>" class="form-control checked-sj" title="Pilih Surat Jalan yang akan di proses" />
                    </td>
                    <td><?=$item['no_surat_jalan']?></td>
                    <td><?=$item['nama_supir']?></td>
                    <td><?=$item['no_telepon']?></td>
                    <td><?=$item['kenek']?></td>
                    <td><?=$item['date']?></td>
                  </tr>
                  <tr>
                    <td colspan="5">
                        <table class="table table-bordered">
                          <tr>
                            <th style="width: 20px;">No</th>
                            <th>Kode Produk</th>
                            <th>Volume</th>
                            <th>Nominal</th>
                          </tr>
                          <?php 
                          $spm_product = $this->db->query("SELECT p.kode, spm.volume,spm.harga_satuan FROM surat_perintah_muat_product spm inner join products p on p.id=spm.product_id where spm.surat_perintah_muat_id={$item['surat_perintah_muat_id']}")->result_array();
                          $total = 0;
                          $total_vol = 0;
                          foreach($spm_product as $k =>  $i):
                            $total += $i['harga_satuan'] * $i['volume'];
                            $total_vol += $i['volume'];

                          ?>
                          <tr>
                            <td><?=($k+1)?></td>
                            <td><?=$i['kode']?></td>
                            <td><?=$i['volume']?></td>
                            <td>Rp. <?=number_format($i['harga_satuan'] * $i['volume'])?></td>
                          </tr>
                        <?php endforeach; ?>
                        <tfoot>
                          <tr>
                            <th colspan="2" style="text-align: right">Total</th>
                            <th><?=$total_vol?></th>
                            <th>Rp. <?=number_format($total)?></th>
                          </tr>
                        </tfoot>
                        </table>
                    </td>
                  </tr>
                  <input type="hidden" name="total_sj" class="total_sj<?=$item['id']?>" value="<?=$total?>">
                <?php endforeach; ?>
                <?php 
                  if(count($surat_jalan) == 0) echo '<tr><td colspan="6"><i>Tidak ada surat jalan</i></td></tr>';
                ?>
              </tbody>
            </table>

            <div class="form-group">
              <div>
                <a onclick="history.back();" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Cancel</a>
                <button class="btn btn-primary btn-sm" type="reset"> <i class="fa fa-refresh"></i> Reset</button>
                <span class="btn btn-success btn-sm" id="btn-proses">Buat Invoice <i class="fa fa-arrow-right"></i></span>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  var total_nominal = 0;

  $('.checked-sj').change(function() {
      
      var nominal = $('.total_sj'+$(this).val()).val();

      if($(this).is(":checked")) 
      {
        total_nominal += parseInt(nominal);
      }else{
        total_nominal -= parseInt(nominal);
      }


      $('#nominal').val('Rp. '+ numberWithComma(total_nominal));
  });

  
  $("#btn-proses").click(function(){

    var total_surat_jalan = $("input[name='surat_jalan[]']:checked").length;
    var catatan = $('#catatan').val();
    var nominal = $('#nominal').val();

    if(nominal == 'Rp. 0' || nominal == "")
    {
      if(total_surat_jalan != 0){
        _alert('Nominal Uang harus diisi');   
        return false;       
      }

    }

    if(total_surat_jalan == 0)
    {
      if(catatan == "")
      {
        _alert('Catatan harus diisi jika tidak ada surat jalan yang dipilih');  
        
        return false;
      }
    }

    $('form#form-invoice').submit();

  });

</script>
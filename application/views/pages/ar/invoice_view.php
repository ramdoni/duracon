<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Invoice #NO SO : <?=$data['no_so']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="form-invoice" method="POST" class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">No Invoice</label>
              <div class="col-md-6">
                <input type="text" readonly="true" value="<?=$data['no_invoice']?>"  class="form-control col-md-7 col-xs-10">
              </div>
            </div> 
             <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Sistem Pembayaran</label>
              <div class="col-md-6">
                <input type="text" required="required" readonly="true" value="<?=$qo['sistem_pembayaran']?>"  class="form-control col-md-7 col-xs-10">
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">Nominal Uang</label>
              <div class="col-md-6">
                <input type="text" readonly="true" value="<?=$data['nominal']?>" class="form-control col-md-7 col-xs-10 idr">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
              <div class="col-md-6">
               <textarea class="form-control" readonly="true" placeholder="Jika surat jalan belum ada maka isi catatan untuk dapat mencetak invoice"><?=$data['catatan']?></textarea>
              </div>
            </div> 

            <div class="ln_solid"></div>

           <div id="step1">
            <h2>Surat Jalan yang sudah diproses</h2>
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
                        where sj.invoice_id={$data['id']}
                        group by sj.id
                        ")->result_array();

                    foreach($surat_jalan as $key => $item):
                ?>
                  <tr>
                    <td rowspan="2"><?=($key+1)?></td>
                    <td><?=$item['no_surat_jalan']?></td>
                    <td><?=$item['nama_supir']?></td>
                    <td><?=$item['no_telepon']?></td>
                    <td><?=$item['kenek']?></td>
                    <td><?=$item['date']?></td>
                  </tr>
                  <tr>
                    <td colspan="5">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 20px;">No</th>
                              <th>Kode Produk</th>
                              <th>Volume</th>
                            </tr>
                          </thead>
                          <?php 
                          $spm_product = $this->db->query("SELECT p.kode, spm.volume FROM surat_perintah_muat_product spm inner join products p on p.id=spm.product_id where spm.surat_perintah_muat_id={$item['surat_perintah_muat_id']}")->result_array();
                          foreach($spm_product as $k =>  $i):
                          ?>
                          <tr>
                            <td><?=($k+1)?></td>
                            <td><?=$i['kode']?></td>
                            <td><?=$i['volume']?></td>
                          </tr>
                        <?php endforeach; ?>
                        </table>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php 
                  if(count($surat_jalan) == 0) echo '<tr><td colspan="5"><i>Tidak ada surat jalan</i></td></tr>';
                ?>
              </tbody>
            </table>

            <div class="form-group">
              <div>
                <a onclick="history.back();" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  
  $("#btn-proses").click(function(){

    var total_surat_jalan = $("input[name='surat_jalan[]']:checked").length;
    var catatan = $('#catatan').val();
    
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
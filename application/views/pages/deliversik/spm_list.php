 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Surat Perintah Muat</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left" onsubmit="return false;">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SIK 
            </label>
            <div class="col-md-6">
              <input type="text" id="no_sik" required="required" readonly="true" name="Sik[no_sik]" value="<?=(isset($sik['no_sik']) ? $sik['no_sik'] : '')?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="penerima_lapangan">Penerima Lapangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" disabled="true" value="<?=(isset($so['penerima_lapangan']) ? $so['penerima_lapangan'] : '')?>" name="Employee_so[penerima_lapangan]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">No Telepon</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal"  readonly="true" value="<?=(isset($so['no_telepon']) ? $so['no_telepon'] : '')?>"  name="Employee_so[no_telepon]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Alamat Pengirimin <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" required name="Sik[alamat_pengiriman]"><?=$sik['alamat_pengiriman']?></textarea>
            </div>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>History Surat Perintah Muat</h2> &nbsp;&nbsp; 
              <a id="detail_sik" class="btn btn-default btn-sm"  data-toggle="modal"><i class="fa fa-search-plus"></i> Detail Produk SIK</a>
              <a href="<?=site_url()?>deliversik/createspm/<?=$sik['id']?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Buat SPM</i></a>
               <a id="detail_spm_done" class="btn btn-default btn-sm"  data-toggle="modal"><i class="fa fa-history"></i> SPM yang sudah diproses</a>

                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-border">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No SPM</th>
                      <th>No Mobil</th>
                      <th>Nama Supir</th>
                      <th>No Telepon</th>
                      <th>Kenek</th>
                      <th>Masa Berlaku</th>
                      <th>Status</th>
                      <th>Catatan</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php 
                      $data_products = $this->db->query("SELECT spm.*, s.no_mobil, s.nama_supir, s.no_telepon, s.kenek FROM surat_perintah_muat spm INNER JOIN mobil s on s.id=spm.mobil_id")->result_array();

                      foreach($data_products as $key => $item)
                      {
                        // cek surat jalan
                        $ceksj  = $this->db->get_where('surat_jalan', ['surat_perintah_muat_id' => $item['id']])->row_array();

                        if($ceksj)
                        {
                          if($ceksj['is_lock'] == 1) continue;
                        }

                        echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".($item['no_spm'])."</td>".

                            "<td>{$item['no_mobil']}</td>".
                            "<td>{$item['nama_supir']}</td>".
                            "<td>{$item['no_telepon']}</td>".
                            "<td>{$item['kenek']}</td>".
                            "<td>{$item['masa_berlaku']}</td>".
                            "<td>". status_spm($item['status']) ."</td>".
                            "<td>{$item['catatan']}</td>"
                            ;
                      ?>
                        <td rowspan="2">
                          <?php if($item['status'] != 3 and $item['status'] != 2 ): ?>
                            <a onclick="_confirm_surat_jalan('<?=site_url('deliversik/printsuratjalan/'.$item['id'])?>',true)" class="btn btn-default btn-xs"><i class="fa fa-car"></i> Cetak Surat Jalan</span></a>
                              <br />
                            <a href="<?=site_url()?>deliversik/printspm/<?=$item['id']?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> Cetak SPM</span></a><br />
                          <?php endif; ?>
                          <?php if($item['status'] == 1 || $item['status'] == 0): ?>
                            <span class="btn btn-danger btn-xs" onclick="batal_spm(<?=$item['id']?>)"><i class="fa fa-trash"></i> Batal</span>
                          <?php endif; ?>
                          
                          <?php  if($ceksj['is_lock'] == 0 and $ceksj !="" ){ ?>
                            <a class="btn btn-primary btn-xs" onclick="revisi_surat_jalan('<?=site_url('deliversik/revisisj/'. $item['id'])?>')"><i class="fa fa-edit"></i> Revisi Surat Jalan</a>
                          <?php }?>


                        </td>
                      <?php  echo "</tr>"; ?>
                      <tr >
                        <td style="border: 0;"></td>
                        <td colspan="5"  style="border: 0;">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Volume</th>
                                <th>Catatan</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $spm_product = $this->db->query("SELECT s.*, p.kode FROM surat_perintah_muat_product s inner join products p on p.id=s.product_id where s.surat_perintah_muat_id={$item['id']}")->result_array();

                                foreach($spm_product as $spm_k =>  $spm_i):
                               ?>
                                <tr>
                                  <td><?=($spm_k+1)?></td>
                                  <td><?=($spm_i['kode'])?></td>
                                  <td><?=($spm_i['volume'])?></td>
                                  <td><?=($spm_i['catatan'])?></td>
                                </tr>
                             <?php endforeach;?>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade modal_detail_products modal-wide" id="modal_history_revisi_surat_jalan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">History Revisi Surat Jalan <label></label></h4>
      </div>
      <div class="modal-body">
        <table class="table table-border">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Revisi</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody class="table_revisi_surat_jalan">
          </tbody>
        </table>
        <hr />
        <a class="btn btn-default btn-xs" data-dismiss="modal"> <i class="fa fa-close"></i> Close</a>
      </div>
    </div>
  </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade modal_detail_products modal-wide" id="modal_detail_spm_done" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">History SPM</h4>
      </div>
      <div class="modal-body">
        <div class="x_content" style="overflow-x: auto;">
                <table class="table table-border">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No SPM</th>
                      <th>No Surat Jalan</th>
                      <th>No Mobil</th>
                      <th>Nama Supir</th>
                      <th>No Telepon</th>
                      <th>Kenek</th>
                      <th>Masa Berlaku</th>
                      <th>Catatan</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php 
                      $data_products = $this->db->query("SELECT sj.id as surat_jalan_id, sj.no_surat_jalan, spm.*, s.no_mobil, s.nama_supir, s.no_telepon, s.kenek  FROM surat_perintah_muat spm INNER JOIN mobil s on s.id=spm.mobil_id inner join surat_jalan sj on sj.surat_perintah_muat_id=spm.id and spm.status=2 and spm.surat_izin_kirim_id={$sik['id']}")->result_array();

                      foreach($data_products as $key => $item)
                      {
                        echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".($item['no_spm'])."</td>".

                            "<td>{$item['no_surat_jalan']}</td>".
                            "<td>{$item['no_mobil']}</td>".
                            "<td>{$item['nama_supir']}</td>".
                            "<td>{$item['no_telepon']}</td>".
                            "<td>{$item['kenek']}</td>".
                            "<td>". date('d F Y', strtotime($item['masa_berlaku'])) ."</td>".
                            "<td>{$item['catatan']}</td>"
                            ;
                          // cek history revisi surat jalan 
                          $history_sj = $this->db->get_where('surat_jalan_lock_history', ['surat_jalan_id' => $item['surat_jalan_id']])->row_array();

                          if($history_sj){ ?>
                          <td><a class="btn btn-xs btn-default" onclick="modal_history_revisi(<?=$item['surat_jalan_id']?>, '#<?=$item['no_surat_jalan']?>')"><i class="fa fa-history"></i> History Revisi</a></td>
                          <?php } ?>

                          </tr>
                      <tr >
                        <td style="border: 0;"></td>
                        <td colspan="5"  style="border: 0;">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Volume</th>
                                <th>Catatan</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $spm_product = $this->db->query("SELECT s.*, p.kode FROM surat_perintah_muat_product s inner join products p on p.id=s.product_id where s.surat_perintah_muat_id={$item['id']}")->result_array();

                                foreach($spm_product as $spm_k =>  $spm_i):
                               ?>
                                <tr>
                                  <td><?=($spm_k+1)?></td>
                                  <td><?=($spm_i['kode'])?></td>
                                  <td><?=($spm_i['volume'])?></td>
                                  <td><?=($spm_i['catatan'])?></td>
                                </tr>
                             <?php endforeach;?>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
        <hr />
        <span class="btn btn-default btn-xs" data-dismiss="modal" style="float: right;"><i class="fa fa-close"></i> Close</span>
        <br style="clear: both">
      </div>
    </div>
  </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade" id="modal_detail_sik" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Semua Produk yang harus dikirim</h4>
      </div>
      <div class="modal-body">
        <div class="x_content">

          <form class="form-horizontal form-label-left">
            <table class="table table-bordered detail-products-sik">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jadwal Volume Yang Harus Dikirim</th>
                    <th>Volume Yang Sudah Terkirim</th>
                    <th>Sisa Volume Yang Belum Terkirim</th>
                  </tr>                  
                </thead>
                <tbody></tbody>
            </table>    
             <p>
                <b>Keterangan: </b>
                <p style="background: #9de69d;">Hijau : Selesai pengiriman</p>
                <p style="background: #ffffba;">Kuning : Belum Selesai Pengiriman</p>
              </p>
          </form>
        </div>
        <hr />
        <span class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</span>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  
  $("#detail_spm_done").click(function(){

    $("#modal_detail_spm_done").modal('show');

  });

  function modal_history_revisi(surat_jalan_id, no)
  {


    $("#modal_detail_spm_done").modal('hide');

    $("#modal_history_revisi_surat_jalan .modal-title label").html(no);

    // get history surat jalan
    $.ajax({
        url: site_url+"ajax/gethistorysuratjalan", 
        data: {'id' : surat_jalan_id},
        type: 'POST',
        success: function(result){

          if(result == null) return false;

          obj = JSON.parse(result); 

          var html = '';

          $(obj).each(function(k, v){
            html += "<tr><td>"+(k+1)+"</td><td>"+ v.tanggal +"</td><td>"+v.catatan+"</td></tr>";
          });

          $('.table_revisi_surat_jalan').html(html);
        }
    });


    $('#modal_history_revisi_surat_jalan').modal('show');
  }

  function _confirm_surat_jalan(url)
  {
    bootbox.confirm({
      title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
      message: 'Cetak Surat Jalan?',
      buttons: {
          confirm: {
              label: 'Yes',
              className: 'btn-success'
          },
          cancel: {
              label: 'No',
              className: 'btn-danger'
          }
      },
      callback: function (result) {
        if(result)
        { 
          window.open(url, '_blank');

          location.reload();
        }
      }
    });
  }

  $("#detail_sik").click(function(){

    $("#modal_detail_sik").modal('show');

    $.ajax({
        url: site_url+"ajax/getdetailproductspm", 
        data: {'id' : <?=$sik['id']?>},
        type: 'POST',
        success: function(result){

          if(result == null) return false;

          obj = JSON.parse(result); 
          console.log(obj);
          var content_detail_product = '';

          $(obj).each(function(index,val){
            
            var sisa_volume = (parseInt(val.volume_yang_dikirim) - parseInt(val.volume_sudah_terkirim));
            var bg = '';

            if(sisa_volume <= 0)
              bg = ' style="background: #9de69d;"';
            else
              bg = ' style="background: #ffffba"';

            content_detail_product += "<tr "+ bg +"><td>"+(index+1)+"</td>";
            content_detail_product += "<td>"+val.kode+"</td>";
            content_detail_product += "<td style=\"text-align: center;\">"+val.volume_yang_dikirim+"</td>";
            content_detail_product += "<td style=\"text-align: center;\">"+val.volume_sudah_terkirim+"</td>";
            content_detail_product += "<td style=\"text-align: center;\">"+sisa_volume+"</td>";

          });

          $('.detail-products-sik tbody').html(content_detail_product);
        }
      });
  });

</script>

<div class="modal fade" id="modal_batal_spm" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-car"></i> Pembatalan Surat Perintah Muat</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="spm_id">
        <div class="x_content">
          <form class="form-horizontal form-label-left">
           <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">Alasan Pembatalan SPM</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <textarea class="form-control catatan_spm" style="height: 200px; width: 100%;" placeholder="Ketik alasan pembatalan disini"></textarea>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <span class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</span>
              <label class="btn btn-success btn-sm submit_pembatalan"  style="float: right;">Submit Pembatalan <i class="fa fa-check"></i></label>
            </div>
          </div> 

          </form>
        </div>
        <br style="clear: both;" />
      </div>
    </div>
  </div>
</div>

<!-- detail Surat Izin Kirim -->
<div class="modal fade modal-wide" id="modal_revisi_surat_jalan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Revisi Surat Jalan</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left" method="POST" id="form_revisi" action="">
          <div class="form-group">  
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Revisi Tanggal</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="date" class="form-control tanggal" required="true" value="<?=date('Y-m-d')?>" >
            </div>
          </div>

          <div class="form-group">  
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" name="catatan" placeholder="Catatan revisi surat jalan" required="true"></textarea>
            </div>
          </div>
          <hr />
          <span class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</span>
          <button type="submit" class="btn btn-sm btn-success" id="button-submit">Submit <i class="fa fa-arrow-right"></i> </button>
          <br style="clear: both">
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">


  function revisi_surat_jalan(url)
  {
    $('#modal_revisi_surat_jalan').modal('show');

    $('#form_revisi').attr('action', url);
  }

</script>

<script src="<?=base_url()?>assets/js/spm.js?rand=<?=date('His')?>"></script>


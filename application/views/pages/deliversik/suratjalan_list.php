 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Jalan #No SPM : <?=$spm['no_spm']?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Surat Jalan</h2> &nbsp;&nbsp; 

                <a onclick="create_suratjalan()" class="btn btn-success btn-xs"><i class="fa fa-print"></i> Buat Surat Jalan</i></a>

                <a href="<?=site_url('deliversik/historyreturnproduct/'. $spm['id'])?>" class="btn btn-warning btn-xs"><i class="fa fa-history"></i> History Return Produk</a>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No Surat Jalan</th>
                      <th>Nama Supir</th>
                      <th>Nama Kenek</th>
                      <th>Masa Berlaku</th>
                      <th>Status</th>
                      <th>Catatan</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php 

                      $this->db->from('surat_jalan');
                      $this->db->select('surat_jalan.*, supir.nama, supir.nama_kenek');
                      $this->db->join('supir', 'supir.id=surat_jalan.supir_id');
                      $this->db->order_by('id', 'DESC');
                      $this->db->where(['surat_perintah_muat_id' => $spm['id']]);

                      $data_products =  $this->db->get()->result_array();

                      foreach($data_products as $key => $item)
                      {
                        echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".($item['no_surat_jalan'])."</td>".
                            "<td>". $item['nama'] ."</td>".
                            "<td>". $item['nama_kenek'] ."</td>".
                            "<td>". $item['date'] ."</td>".
                            "<td>". status_spm($item['status']) ."</td>".
                            "<td>{$item['catatan']}</td>"
                            ;
                      ?>
                        <td>
                          <?php if($item['status'] == 1): ?>
                            <span class="btn btn-danger btn-xs" onclick="batal_suratjalan(<?=$item['id']?>)"><i class="fa fa-trash"></i> Batal</span><br />
                         
                            <a href="<?=site_url()?>deliversik/reprintsuratjalan/<?=$item['id']?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> Cetak Ulang Surat Jalan</a></a> <br style="clear: both" />
                         
                            <a onclick="_confirm('Surat Jalan berhasil dikirim?','<?=site_url()?>deliversik/selesaisuratjalan/<?=$item['id']?>')" class="btn btn-success btn-xs"> Berhasil dikirim <i class="fa fa-check-square"></i></a><br style="clear: both" />

                              <a href="<?=site_url()?>deliversik/returnproduk/<?=$item['id']?>" class="btn btn-warning btn-xs"> Return Produk <i class="fa fa-close"></i></a>
                              <br />
                              <a href="<?=site_url()?>deliversik/printritasi/<?=$item['id']?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> Cetak Ritasi Supir</span></a>
                          <?php endif; ?>
                        </td> 
                      <?php 
                        echo "</tr>";
                      }
                  ?>
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

<div class="modal fade" id="modal_surat_jalan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-car"></i> Surat Jalan</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="spm_id">
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="post" action="<?=site_url()?>deliversik/batalsuratjalan/<?=$spm['id']?>">
           <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">Alasan Pembatalan Surat Jalan</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="hidden" name="surat_jalan_id" class="surat_jalan_id" />
              <textarea class="form-control catatan_spm" name="catatan" style="height: 200px; width: 100%;" placeholder="Ketik alasan pembatalan disini"></textarea>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <span class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</span>
              <button type="submit" class="btn btn-success btn-sm submit_pembatalan"  style="float: right;">Submit Pembatalan <i class="fa fa-check"></i></button>
            </div>
          </div> 

          </form>
        </div>
        <br style="clear: both;" />
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal_create_surat_jalan" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-car"></i> Buat Surat Jalan</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="spm_id">
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="post" action="<?=site_url()?>deliversik/batalsuratjalan/<?=$spm['id']?>">
           <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="no_po">Supir</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <select name="supir" class="supir_id form-control">
                <option value=""> - PILIH SUPIR - </option>
                <?php 
                  $supir  = $this->db->get('supir')->result_array();
                  foreach($supir as $item):
                ?>
                  <option value="<?=$item['id']?>"><?=$item['nama']?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="no_po">No Telepon</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="text" name="" class="form-control no_telepon" readonly="true">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="no_po">Kenek</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="text" name="" class="form-control kenek" readonly="true">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="no_po">No Telepon Kenen</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="text" name="" class="form-control kenek-no_telepon" readonly="true">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <span class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</span>
              <span class="btn btn-success btn-sm btn_modal_submit_surat_jalan"  style="float: right;">Submit Surat Jalan <i class="fa fa-check"></i></span>
            </div>
          </div> 
          </form>
        </div>
        <br style="clear: both;" />
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  function create_suratjalan()
  {
    $('#modal_create_surat_jalan').modal("show");


    $('select.supir_id').on('change', function(){
      
      var id = $(this).val();

      $.ajax({
        url: site_url+"ajax/getsupir", 
        data: {'id' : id},
        type: 'POST',
        success: function(result){

          if(result == null) return false;

          obj = JSON.parse(result); 

          $('.no_telepon').val(obj.no_telepon);
          $('.kenek').val(obj.nama_kenek);
          $('.kenek-no_telepon').val(obj.no_telepon_kenek);
        }
      })
    });

    $('.btn_modal_submit_surat_jalan').click(function(){

      var id = $('select.supir_id').val();

      if(id == ""){
        _alert("Supir Harus dipilih !");
      }else{
        window.open('<?=site_url()?>deliversik/printsuratjalan/<?=$spm['id']?>?supir_id='+id, '_blank');
        
        location.reload();
      }
    });

  }

</script>
<script src="<?=base_url()?>assets/js/surat-jalan.js?rand=<?=date('His')?>"></script>


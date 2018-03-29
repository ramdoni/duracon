 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Izin Kirim </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Sik[sales_order_id]" value="<?=$data['id']?>" />
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="proyek" required class="form-control select-proyek" disabled="true" name="proyek_id">
                <option value=""> - Proyek - </option>
              <?php 
                $this->db->from('quotation_order');
                $this->db->group_by('proyek');

                $select_proyek = $this->db->get();
    
                foreach($select_proyek->result_array() as $i) {
                  
                  $selected = ''; 
                  if(isset($data['proyek']))
                  {
                    if($data['proyek'] == $i['proyek'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option value="<?=$i['proyek']?>" <?=$selected?>><?=$i['proyek']?></option>
                  <?php } ?>
                </select>
            </div>
          </div>
          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select-qo" disabled="true" name="Employee_so[quotation_order_id]">
                <option value=""> - Quotation - </option>
                <?php
                if(isset($data['id'])):
                  
                  $this->db->from('quotation_order');
                  $this->db->like('proyek', $data['proyek']);

                  $select_proyek = $this->db->get();
      
                  foreach($select_proyek->result_array() as $i):
                    
                    if($this->db->get_where('sales_order',['quotation_order_id' => $i['id']])->num_rows() == 0 and $data['quotation_order_id'] != $i['id']) continue;
                    
                    $selected = ''; 
                    
                    if(isset($data['quotation_order_id']))
                    {
                      if($data['quotation_order_id'] == $i['id'])
                      {
                        $selected = ' selected';
                      }
                    }
                ?>
                  <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_po']?></option>
                <?php
                  endforeach;
                endif;
                ?>
              </select>
            </div>
            <?php if(!isset($data['id'])):?>
             <div class="col-md-2 col-sm-2 col-xs-2">
              <label class="btn btn-info btn-xs generate-po"><i class="fa fa-clipboard"></i> Copy </label>
            </div>
          <?php endif; ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No PO 
            </label>
            <div class="col-md-6">
              <input type="text" id="no_po" required="required" readonly="true" name="Employee_so[no_po]" value="<?=(isset($data['no_po']) ? $data['no_po'] : '')?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Marketing : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-marketing" style="text-align: left;"><?=(isset($data['marketing']) ? $data['marketing'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-customer" style="text-align: left;"><?=(isset($data['customer']) ? $data['customer'] : '')?></label>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Alamat Pengirimin <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" required name="Sik[alamat_pengiriman]"><?=$data['proyek']?></textarea>
            </div>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>History Surat Izin Kirim</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No SIK</th>
                      <th>Total Volume</th>
                      <th>Total Ton</th>
                      <th>Total Biaya Barang</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Catatan</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php  
                    $sik_history = $this->db->query("SELECT * FROM surat_izin_kirim WHERE sales_order_id={$data['id']} ORDER BY id DESC")->result_array();
                    foreach($sik_history as $key => $item): ?>
                    <?php 

                      $total = $this->db->query("SELECT sum(volume_yang_dikirim) as total_volume, sum(harga_yang_dikirim) as total_harga FROM surat_izin_kirim_history WHERE surat_izin_kirim_id={$item['id']} AND sales_order_id={$data['id']}")->row_array();

                      $total_berat = $this->db->query("SELECT sum(p.weight) as berat FROM `surat_izin_kirim_history` s
                                                              inner join products p on p.id=s.product_id WHERE sales_order_id={$data['id']} AND surat_izin_kirim_id={$item['id']} ")->row_array();

                    ?>
                    <tr>
                      <td><?=($key+1)?></td>
                      <td><?=$item['no_sik']?></td>
                      <td style="text-align: right;"><?=$total['total_volume']?></td>
                      <td><?=round(($total_berat['berat'] * $total['total_volume'])  / 1000) ?> Ton</td>
                      <td>Rp. <?=number_format($total['total_harga'],0,'','.')?></td>
                      <td><?=date('d F Y H:i', strtotime($item['create_time']))?></td>
                      <td><?=position_sik($item['position'])?></td>
                      <td><?=$item['catatan']?></td>
                      <td>
                        <span class="btn btn-xs btn-default detail-sik" onclick="detail_sik_product(<?=$item['id']?>, '<?=$item['no_sik']?>')"><i class="fa fa-list"></i> Detail</span>   
                        <?php if($item['position'] == 3): ?>
                        <a href="<?=site_url('salesso/viewsik/'. $item['id'])?>" target="_blank" class="btn btn-default btn-xs" title="Buat Surat Izin Kirim"><i class="fa fa-print"></i> Print </a>
                        <?php endif; ?>

                        <?php if($item['position'] == 1): ?>
                           <span class="btn btn-default btn-xs" title="Batalkan Surat Izin Kirim" onclick="cancel_sik(<?=$item['id']?>)"><i class="fa fa-trash"></i> Batal </a>
                        <?php endif;?>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                  <?php if(count($sik_history) == 0) echo '<tr><td colspan="9"><i>Tidak ada Surat Izin Kirim</i></td></tr>'; ?>
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
              
              <?php if($data['position'] ==5):?>

                <a href="<?=site_url('salesso/createsik')?>/<?=$data['id']?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Buat SIK</i></a>
              <?php endif; ?>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/sik.js?rand=<?=date('His')?>"></script>
<style type="text/css">
  #modal_detal_sik.modal-wide .modal-dialog {
      width: 80%;
    }
</style>
<!-- Modal -->
<div class="modal fade modal-wide" id="modal_detal_sik" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-history"></i></h4>
      </div>
      <div class="modal-body">
        <form id="modal-product" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
        <div style="overflow: auto;">
            <table class="detail-sik-product table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Uraian</th>
                  <th>Volume yang Terkirim</th>
                  <th>Total Tonase</th>
                  <th>Harga yang Terkirim</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        <div class="ln_solid"></div>
        <div class="form-group">
          <div>
            <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- /end modal -->

<!-- Modal -->
<div class="modal fade modal-wide" id="modal_detal_sik" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-history"></i></h4>
      </div>
      <div class="modal-body">
        <form id="modal-product" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
        <div style="overflow: auto;">
            <table class="detail-sik-product table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Uraian</th>
                  <th>Volume yang Terkirim</th>
                  <th>Total Tonase</th>
                  <th>Harga yang Terkirim</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        <div class="ln_solid"></div>
        <div class="form-group">
          <div>
            <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- /end modal -->

<div class="modal fade" id="modal_batal_sik" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-car"></i> Pembatalan Surat Izin Kirim</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="sik_id">
        <div class="x_content">
          <form class="form-horizontal form-label-left">
           <div class="form-group">
            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">Alasan Pembatalan SIK</label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <textarea class="form-control catatan_sik" style="height: 200px; width: 100%;" placeholder="Ketik alasan pembatalan disini"></textarea>
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
<script src="<?=base_url()?>assets/js/createsik.js?rand=<?=date('His')?>"></script>


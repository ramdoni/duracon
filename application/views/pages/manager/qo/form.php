<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Proses Quotation Order</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Employee_qo[approved]" value="0" />
          <?php 
          if($data['perihal'] != ''){
          ?>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Perihal</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['perihal']?></label>
          </div>
          <?php } ?>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['no_po']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['sales']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Marketing</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['marketing']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT</label>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['customer']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['proyek']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['sistem_pembayaran']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['area']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tanggal</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['tanggal']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Penurunan Barang</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['penurunan_barang']?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tipe Pekerjaan</label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['tipe_pekerjaan']?></label>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Products </h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Uraian</th>
                      <th>Volume</th>
                      <th>Satuan</th>
                      <th>Price List</th>
                      <th>Disc</th>
                      <th>Harga Satuan</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody class="add-table-product">
                    <?php 
                      if(isset($data['id'])){

                        $products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['id']])->result_array();
                        $total = 0;
                        
                        foreach($products as $key =>  $i):

                          $harga_diskon = $i['harga_satuan'] * $i['disc_ppn'] / 100;
                          $harga_diskon = $i['harga_satuan'] - $harga_diskon;
                    ?>
                        <tr class="tr-<?=$i['id']?>">
                          <td class="input-hidden"><?=($key+1)?>
                            <input type="hidden" name="ProductForm[<?=$key?>][harga_satuan]"  class="input-harga_satuan" value="<?=$i['harga_satuan']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][disc_ppn]" class="input-disc_ppn" value="<?=$i['disc_ppn']?>" />
                          </td>
                          <td class="kode"><?=$i['kode']?></td>
                          <td class="uraian"><?=$i['uraian']?></td>
                          <td class="vol"><?=$i['vol']?></td>
                          <td class="satuan"><?=$i['satuan']?></td>
                          <td class="harga_satuan">Rp. <?=number_format($i['harga_satuan'])?></td>
                          <td class="disc_ppn"><?=$i['disc_ppn']?> %</td>
                          <td class="harga">Rp. <?=number_format( ($harga_diskon) )?></td>
                          <td class="harga">Rp. <?=number_format( ($harga_diskon*$i['vol']) )?></td>
                        </tr>
                        <?php 
                            $total += $harga_diskon*$i['vol'];
                        ?>

                        <?php 
                        // cek revisi 
                        $this->db->where(['quotation_order_products_id' => $i['id']]);
                        $this->db->order_by('id', 'desc');

                        $revisi = $this->db->get('quotation_order_products_revisi')->result_array();
                        if($revisi):
                          foreach($revisi as $k_rev => $val_rev):

                            $employe = $this->db->query("SELECT e.name, ea.label as access FROM employee e
                                                          inner join employee_access ea on ea.id=e.`employee_access_id` WHERE e.id={$val_rev['employee_id']};")->row_array();
                        ?>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><?=$employe['name']?> ( <?=$employe['access']?> ) Revisi : <?=date('d M Y H:i', strtotime($val_rev['create_time']))?></td>
                              <td>Rp. <?=number_format((($i['harga_satuan'] -($i['harga_satuan'] * $val_rev['disc_ppn'] / 100))))?></td>
                              <td><?=$val_rev['disc_ppn']?>%</td>
                              <td>
                                <?php if($val_rev['employee_id'] != $this->session->userdata('employee_id')):?>
                                <a href="javascript:" title="Approve" onclick="alert('Fungsi masih dalam proses')"><i class="fa fa-check"></i></a>
                              <?php endif; ?>
                              </td>
                          </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                    <?php
                        endforeach;
                      }
                    ?>
                    <tr>
                      <th colspan="8" style="text-align: right;">Total</th>
                      <th>Rp. <?=number_format($total)?></th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Catatan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="Employee_qo[note]" id="note" class="form-control col-md-7 col-xs-12"></textarea>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('arqo')?>" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <a class="btn btn-danger btn-reject btn-sm"><i class="fa fa-close"></i> Reject</a>
              <a class="btn btn-success btn-proccess btn-sm"><i class="fa fa-check"></i> Approved</a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/quotation-approve.js"></script>

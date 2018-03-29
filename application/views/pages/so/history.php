<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>History Sales Order</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

          <ul class="list-unstyled timeline">
            <li>
              <div class="block">
                <div class="tags">
                  <a href="" class="tag">
                    <span>SO</span>
                  </a>
                </div>
                <div class="block_content">
                    <h2 class="title"><a>&nbsp;</a></h2>

                    <div class="x_panel">
                      <form id="form-quotation" method="post" class="form-horizontal form-label-left">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">No SO</label>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['no_so']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">No Quotation</label>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['no_quotation']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="no_po">No PO</label>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['no_po']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="sales">Sales</label>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['sales']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="sales">Marketing</label>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['marketing']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="sales">Customer / PT</label>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left;">: <?=$data['customer']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="proyek">Proyek</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['proyek']?></label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['sistem_pembayaran']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['area']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Jadwal Mulai</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['jadwal_mulai']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Jadwal Selesai</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['jadwal_selesai']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Penurunan Barang</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['penurunan_barang']?></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tipe Pekerjaan</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" style="text-align: left;">: <?=$data['tipe_pekerjaan']?></label>
                          </div>
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
                                    <th>Harga</th>
                                    <th>Disc</th>
                                    <th>Harga + Disc</th>
                                    <th>Subtotal</th>
                                  </tr>
                                </thead>
                                <tbody class="add-table-product">
                                  <?php 
                                    if(isset($data['id'])){

                                      $products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['quotation_order_id']])->result_array();
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
                                        <td class="harga">Rp. <?=number_format($i['harga_satuan'])?></td>
                                        <td class="satuan"><?=$i['disc_ppn']?>%</td>
                                        <td class="harga">Rp. <?=number_format( ($harga_diskon) )?></td>
                                        <td class="harga">Rp. <?=number_format( ($harga_diskon*$i['vol']) )?></td>
                                      </tr>
                                  <?php
                                    $total += $harga_diskon*$i['vol'];
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
                      </form>
                    </div>
                </div>
              </div>
            </li>
            <?php 
              $surat_izin_kirim = $this->db->get_where('surat_izin_kirim', ['sales_order_id' => $data['id']])->result_array();
              foreach($surat_izin_kirim as $no_s =>  $sik):
            ?>
                <li>
                  <div class="block">
                    <div class="tags">
                      <a href="" class="tag">
                        <span>SIK #<?=$no_s+1?></span>
                      </a>
                    </div>
                    <div class="block_content">
                      <h2 class="title"><a>#<?=$sik['no_sik']?></a></h2>
                      <br />
                       <div class="x_panel">
                          <div class="x_title">
                            <h2>Surat Izin Kirim </h2>
                            <ul class="nav navbar-right panel_toolbox">
                              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                              </li>
                            </ul>

                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                                
                                <table class="table table-hover">
                                  <thead>
                                    <tr class="headings">
                                      <th class="column-title">No. SIK</th>
                                      <th>Tanggal</th>
                                      <th>Catatan</th>
                                      <th>Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?=$sik['no_sik']?></td>
                                      <td><?=date('d F Y', strtotime($sik['masa_berlaku']))?></td>
                                      <td><?=$sik['catatan']?></td>
                                      <td>
                                        <?=position_sik($sik['position'])?>
                                        <span class="btn btn-default btn-xs" onclick="show_product_sik(<?=$sik['id']?>)"><i class="fa fa-arrows-v"></i> Product </span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="5">
                                        <div class="product_sik<?=$sik['id']?>" style="display: none;">
                                          <table class="table table-bordered">
                                            <thead>
                                              <tr class="headings">
                                                <th style="width: 50px;">No</th>
                                                <th>Kode</th>
                                                <th>Description</th>
                                                <th>Volume</th>
                                                <th>Harga Yang Dikirim</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php 
                                                $sik_product = $this->db->query("SELECT s.volume_yang_dikirim as volume,  s.harga_yang_dikirim, p.kode, p.uraian FROM surat_izin_kirim_history s inner join products p on p.id=s.product_id where s.surat_izin_kirim_id={$sik['id']}")->result_array();

                                                foreach($sik_product as $no => $sp):
                                              ?>
                                                <tr>
                                                  <td><?=$no+1?></td>
                                                  <td><?=$sp['kode']?></td>
                                                  <td><?=$sp['uraian']?></td>
                                                  <td><?=$sp['volume']?></td>
                                                  <td>Rp. <?=number_format($sp['harga_yang_dikirim'])?></td>
                                                </tr>
                                              <?php endforeach; ?>
                                            </tbody>
                                          </table>
                                        </div>
                                      </td>
                                    </tr>
                                   </tbody>
                                </table>
                                <ul class="list-unstyled timeline">
                                  <?php 
                                    $surat_perintah_muat = $this->db->get_where('surat_perintah_muat', ['surat_izin_kirim_id' => $sik['id']])->result_array();
                                    foreach($surat_perintah_muat as $key_spm => $s):?>
                                      <li>
                                        <div class="block">
                                          <div class="tags">
                                            <a href="" class="tag">
                                              <span>SPM #<?=$key_spm+1?></span>
                                            </a>
                                          </div>
                                          <div class="block_content">
                                              <h2 class="title"><a>No SPM : #<?=$s['no_spm']?></a></h2>
                                                <ul class="list-unstyled timeline">
                                              <?php 
                                                $sj = $this->db->get_where('surat_jalan', ['surat_perintah_muat_id' => $s['id']])->row_array();
                                                $mobil = $this->db->get_where('mobil', ['id' => $s['mobil_id']])->row_array();
                                              ?>  
                                                 <li>
                                                  <div class="block">
                                                    <div class="tags">
                                                      <a href="" class="tag">
                                                        <span>Surat Jalan</span>
                                                      </a>
                                                    </div>
                                                    <div class="block_content">
                                                        <h2 class="title"><a>&nbsp;</a></h2>
                                                        <table class="table table-bordered">
                                                            <tr>
                                                              <th>No Surat Jalan</th>
                                                              <th>Vendor</th>
                                                              <th>No Mobil</th>
                                                              <th>Nama Supir</th>
                                                              <th>No Telepon</th>
                                                              <th>Kenek</th>
                                                              <th>Masa Berlaku</th>
                                                              <th>Status</th>
                                                              <th>Catatan</th>
                                                            </tr>
                                                            <tr>
                                                              <td><?=$sj['no_surat_jalan']?></td>
                                                              <td><?=$mobil['vendor']?></td>
                                                              <td><?=$mobil['no_mobil']?></td>
                                                              <td><?=$mobil['nama_supir']?></td>
                                                              <td><?=$mobil['no_telepon']?></td>
                                                              <td><?=$mobil['kenek']?></td>
                                                              <td><?=date('d F Y', strtotime($s['masa_berlaku']))?></td>
                                                              <td>
                                                                <?=status_spm($sj['status'])?>
                                                                <span class="btn btn-default btn-xs" onclick="show_product_sj(<?=$sj['id']?>)"><i class="fa fa-arrows-v"></i> product</span>  
                                                              </td>
                                                              <td><?=$sj['catatan']?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div id="product_sj<?=$sj['id']?>" style="display: none;">
                                                      <table class="table table-bordered">
                                                        <thead>
                                                          <tr class="headings">
                                                            <th style="width: 50px;">No</th>
                                                            <th>Kode</th>
                                                            <th>Description</th>
                                                            <th>Volume</th>
                                                            <th>Catatan</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php 
                                                            $product_spm = $this->db->query("SELECT p.kode, p.uraian, s.volume, s.catatan FROM surat_perintah_muat_product s inner join products p on p.id=s.product_id WHERE s.surat_perintah_muat_id={$s['id']}")->result_array();

                                                            foreach($product_spm as $no_spm => $i):?>
                                                              <tr>
                                                                <td><?=$no_spm+1?></td>
                                                                <td><?=$i['kode']?></td>
                                                                <td><?=$i['uraian']?></td>
                                                                <td><?=$i['volume']?></td>
                                                                <td><?=$i['catatan']?></td>
                                                              </tr>
                                                          <?php endforeach; ?>
                                                        </tbody>
                                                      </table>
                                                    </div>
                                                  </div>
                                                </li>
                                            </ul>
                                          </div>
                                        </div>
                                      </li>
                                    <?php endforeach; ?>
                                  </ul>
                                  <br />
                          </div>
                        </div>
                    </div>
                  </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <a onclick="history.back()" class="btn btn-default btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
      </div>
    </div>
</div>
<script type="text/javascript">
  function show_product_sik(id)
  {
    $('.product_sik'+id).slideToggle();
  }

  function show_product_sj(id)
  {
    $('#product_sj'+id).slideToggle();
  }
</script>



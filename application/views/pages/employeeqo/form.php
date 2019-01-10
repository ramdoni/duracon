  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Quotation Order</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Employee_po[proccess]" value="0" />
          
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Perihal <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[perihal]" required class="form-control">
                  <option value=""> Pilih Perihal</option>
                <?php 
                  $perihal  = ['Penawaran Harga', 'Revisi Penawaran Harga', 'Harga Nett', 'Revisi Harga Nett', 'Harga Satuan'];
                  foreach($perihal as $item):
                ?>
                  <option <?=(isset($data['perihal']) and $item == $data['perihal']) ? 'selected' : ''?>><?=$item?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_po" required="required" value="<?=(isset($data['no_po']) ? $data['no_po'] : '')?>" name="Employee_po[no_po]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control autocomplete-customer" />
              <input type="hidden" name="Employee_po[customer_id]">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales <span class="required">*</span>
            </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-sales_id" style="text-align: left;"><?=isset($data['sales']) ? $data['sales'] : ''?></label>
            <input type="hidden" name="Employee_po[sales_id]" class="sales_id" value="<?=isset($data['sales_id']) ? $data['sales_id'] : ''?>">
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Marketing <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control marketing_id" name="Employee_po[marketing_id]">
                <option value=""> - Marketing - </option>
                <?php
                //$marketing = $this->db->get('marketing');
                $marketing = $this->db->get_where('user', ['user_group_id' => 4]);

                foreach($marketing->result_array() as $i):
                  $selected = '';

                  if(isset($data['marketing_id']))
                  {
                    if($data['marketing_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option value="<?=$i['id']?>" <?=$selected?>><?=$i['name']?></option>
              <?php
                endforeach;
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="proyek" required="required" value="<?=(isset($data['proyek']) ? $data['proyek'] : '')?>" name="Employee_po[proyek]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Kecamatan </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
             
              <input type="text" class="form-control autocomplete-kecamatan" />
              <input type="hidden" name="Employee_po[kecamatan_id]">

            </div>  
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Kelurahan </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name="Employee_po[kelurahan_id]">
                <option value="">Pilih Kelurahan</option>
              </select>
            </div>  
          </div>
        
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label col-md-6 col-sm-6 col-xs-12 label-area_kirim" style="text-align: left;"><?=isset($data['area_id']) ? $data['area'] : ''?></label>
              <input type="hidden" name="Employee_po[area_id]" class="area_id" value="<?=isset($data['area_id']) ? $data['area_id'] : ''?>" />
              <input type="hidden" name="Employee_po[transport]" value="<?=isset($data['transport']) ? $data['transport'] : ''?>" />

            </div> 
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran <span class="required">*</span>
            </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-sistem_pembayaran" style="text-align: left;"><?=isset($data['sistem_pembayaran']) ? $data['sistem_pembayaran'] : ''?></label>
            <input type="hidden" name="Employee_po[sistem_pembayaran]" class="sistem_pembayaran" value="<?=isset($data['sistem_pembayaran']) ? $data['sistem_pembayaran'] : ''?>">
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tanggal <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal"  value="<?=(isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d'))?>"  required="required" name="Employee_po[tanggal]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Penurunan Barang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[penurunan_barang]" id="select-penurunan-barang" class="form-control" required>
                <option value=""> - Penurunan Barang - </option>
                <?php 
                $setting = ['Setting', 'Tidak Setting'];
                foreach($setting as $i):

                  $selected = '';
                  if(isset($data['penurunan_barang'])){
                    if($data['penurunan_barang'] == $i)
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option <?=$selected?>><?=$i?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tipe Pekerjaan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[tipe_pekerjaan]" class="form-control" required>
                <option value=""> - Tipe Pekerjaan - </option>
                <?php 
                $setting = ['Education','Office','Apartement','Warehouse','Factory','Power Plant','Oil dan Gas','Toll/Road','Railway','Tunnel','Bridge','Dam/Channel','Drainage','Irrigation','Road','Rail Way','Airport','Ship Harbour','Real Estate','Ruko','Shopping Building','Hotel','Hospital','Cemetery'];
                foreach($setting as $i):

                  $selected = '';
                  if(isset($data['tipe_pekerjaan'])){
                    if($data['tipe_pekerjaan'] == $i)
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option <?=$selected?>><?=$i?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Products <a class="btn btn-primary btn-sm btn-xs" data-toggle="modal" href="#myModal" > <i class="fa fa-plus-circle"></i> Add Product</a></h2>
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
                      <th>Price List</th>
                      <th>Transport</th>
                      <th>Harga Awal</th>
                      <th>Disc</th>
                      <th>Harga Akhir</th>
                      <th>Subtotal</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="add-table-product">
                    <?php 
                    $total = 0;
                      if(isset($data['id'])){

                        $products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['id']])->result_array();
                        
                        foreach($products as $key =>  $i):

                          $harga_diskon = $i['harga_akhir'] * $i['disc_ppn'] / 100;
                          $harga_diskon = $i['harga_akhir'] - $harga_diskon;
                    ?>
                        <tr class="tr-<?=$i['id']?> list-product">
                          <td><?=($key+1)?>
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][product_id]" value="<?=$i['product_id']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][kode]" value="<?=$i['kode']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][uraian]" value="<?=$i['uraian']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][vol]" class="input-hidden-vol" value="<?=$i['vol']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][satuan]" value="<?=$i['satuan']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][harga_satuan]" class="input-hidden-harga" value="<?=$i['harga_satuan']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][disc_ppn]" class="input-hidden-disc_ppn" value="<?=$i['disc_ppn']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][weight]" class="input-hidden-weight" value="<?=$i['weight']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][harga_awal]" class="input-hidden-weight" value="<?=$i['harga_awal']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][harga_akhir]" class="input-hidden-weight" value="<?=$i['harga_akhir']?>" />
                          </td>
                          <td class="kode"><?=$i['kode']?></td>
                          <td class="uraian"><?=$i['uraian']?></td>
                          <td class="vol">
                            <a href="#" class="editable-vol" data-type="text" data-url="<?=site_url()?>/ajax/savequotationproductvol" data-pk="<?=$i['id']?>" ><?=($i['vol'])?></a>
                          </td>
                          <td class="harga_satuan">Rp. <?=number_format($i['harga_satuan'])?></td>
                          <td class="transport"><?=$i['transport']?></td>
                          <td class="disc_harga_satuan">Rp. <?=number_format($i['harga_awal'])?></td>
                          <td class="disc_ppn"><?=($i['disc_ppn'])?>%</td>
                          <td class="disc_harga_akhir">Rp. <?=number_format($i['harga_akhir'])?></td>
                          <td class="subtotal">Rp. <?=number_format($harga_diskon*$i['vol'])?></td>
                          <td class="btn-action">
                              <a href="javascript:" title="Hapus" onclick="hapus_item(<?=$i['id']?>)"><i class="fa fa-remove"></i></a>
                          </td>
                        </tr>
                    <?php
                        $total += $harga_diskon*$i['vol'];
                        endforeach;
                      }

                      $ppn = $total * 0.11;
                    ?>
                  </tbody>
                  <tfoot class="footer-date-total">
                    <tr>
                      <th colspan="9" style="text-align: right;">Sub Total</th>
                      <th colspan="2" class="sub_total">Rp. <?=number_format($total)?></th>
                    </tr>
                    <tr>
                      <th colspan="9" style="text-align: right;">PPN</th>
                      <th colspan="2" class="total_ppn">Rp. <?=number_format($ppn)?></th>
                    </tr>
                    <tr>
                      <th colspan="9" style="text-align: right;">Total</th>
                      <th colspan="2" class="total_">Rp. <?=number_format($total + $ppn)?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('employeeqo')?>" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <button class="btn btn-warning btn-sm" id="btn-reset" type="reset"><i class="fa fa-refresh"></i> Reset</button>
              <button type="submit" class="btn btn-primary btn-sm" title="Simpan data sebagai draft sebelum di lanjutkan ke proses approval"> <i class="fa fa-save"></i> Save as Draft</button>
              <span class="btn btn-success btn-proccess btn-sm">Proccess <i class="fa fa-arrow-right"></i></span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product</h4>
        </div>
        <div class="modal-body">
          
          <form id="modal-product" method="post" onsubmit="return false;" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Kode Product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control autocomplete-produk">
              <input type="hidden" name="product[kode]" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uraian">Uraian Product : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-uraian" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="weight">Weight : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-weight" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="satuan">Price Transport : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-transport" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price List : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-price" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume">Volume : </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="input-volume" required="required" name="volume[volume]" value="0" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Transport : </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select_transport">
                <option value="1">Include Transport</option>
                <option value="0">Tidak</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="disc_ppn">Persentase Up</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="input-disc_ppn" required="required" name="products[disc_ppn]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-price-up" style="text-align: left;"></label>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('products')?>" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</a>
              <a class="btn btn-success btn-add-modal btn-sm"  data-dismiss="modal"><i class="fa fa-plus-circle"></i> Add</a>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
<!-- include file js -->
<link rel="stylesheet" href="<?=base_url()?>assets/jquery-ui/jquery-ui.css">
<script src="<?=base_url()?>assets/jquery-ui/jquery-ui.js"></script>

<script type="text/javascript">
  var total = <?=empty($total) ? 0 : $total?>;

  $(".autocomplete-customer" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "<?=site_url()?>ajax/getcustomerautocomplete",
              method : 'POST',
              data: {
                'name': request.term
              },
              dataType: 'json',
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
          $("input[name='Employee_po[customer_id]']").val(ui.item.id);
        }
    }).on('focus', function () {
      $(this).autocomplete("search", "");
    });

     $(".autocomplete-produk" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "<?=site_url()?>ajax/getproductautocomplete",
              method : 'POST',
              data: {
                'name': request.term
              },
              dataType: 'json',
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
          $("input[name='product[kode]']").val(ui.item.id).trigger('change');
        }
    }).on('focus', function () {
      $(this).autocomplete("search", "");
    });

    $(".autocomplete-kecamatan" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "<?=site_url()?>ajax/getkecamatanautocomplete",
              method : 'POST',
              data: {
                'name': request.term
              },
              dataType: 'json',
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
          $("input[name='Employee_po[kecamatan_id]']").val(ui.item.id).trigger('change');
        }
    }).on('focus', function () {
      $(this).autocomplete("search", "");
    });
</script>
<script src="<?=base_url()?>assets/js/quotation.js?rand=<?=date('YmdHis')?>"></script>
<style type="text/css">
  .ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {
    z-index: 10000 !important;
  }
</style>
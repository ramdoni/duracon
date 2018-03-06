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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_po" required="required" readonly="true" value="<?=$no_quotation?>" name="Employee_po[no_po]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control sales_id" name="Employee_po[sales_id]">
                <option value=""> - Sales - </option>
                <?php
                $sales = $this->db->get_where('user', ['user_group_id' => 3]);
                foreach($sales->result_array() as $i):
                  $selected = '';

                  if(isset($data['sales_id']))
                  {
                    if($data['sales_id'] == $i['id'])
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" required name="Employee_po[customer_id]">
                <option value=""> - Customer - </option>
                <?php
                $customer = $this->db->get('customer');

                foreach($customer->result_array() as $i):
                  $selected = '';

                  if(isset($data['customer_id']))
                  {
                    if($data['customer_id'] == $i['id'])
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[sistem_pembayaran]" required id="sistem_pembayaran" class="form-control">
                <option value=""> - Pembayaran - </option>
                <?php 
                  foreach(['Cash', 'Kredit', 'SCF'] as $i):

                    $selected = '';
                    if(isset($data['sistem_pembayaran']))
                    {
                      if($data['sistem_pembayaran'] == $i)
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[area_id]" id="select-kode" class="form-control">
                <option value=""> - Area Kirim - </option>
                <?php 
                $product = $this->db->get('area');
                foreach($product->result_array() as $i):

                  $selected = '';
                  if(isset($data['area_id']))
                  {
                    if($data['area_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>

                <option value="<?=$i['id']?>" <?=$selected?>><?=$i['area']?></option>

              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tanggal <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" readonly="" value="<?=(isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d'))?>"  required="required" name="Employee_po[tanggal]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Penurunan Barang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            
              <select name="Employee_po[penurunan_barang]" id="select-kode" class="form-control">
                <option value=""> - Penurunan Barang - </option>
                <?php 
                $setting = ['Setting', 'Tidak Setting'];
                foreach($setting as $i):

                  $selected = '';
                  if($data['penurunan_barang'] == $i)
                  {
                    $selected = ' selected';
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
                <h2>Products <a class="btn btn-primary btn-sm" data-toggle="modal" href="#myModal" >Add Product</a> /  
                <input type="file" class="btn btn-success btn-sm" name="file" style="display: inline;" /> <small>sample excel <a href="<?=base_url('assets/contoh-import-products.xls')?>" class="link"> <i class="fa fa-cloud-download"></i> Download</a></small></h2>

                
                <div class="clearfix"></div>
                <div id="progress-wrp">
                    <div class="progress-bar"></div>
                    <div class="status">0%</div>
                </div>
                
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
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="add-table-product">
                    <?php 
                    $total = 0;
                      if(isset($data['id'])){

                        $products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['id']])->result_array();
                        
                        foreach($products as $key =>  $i):

                          $harga_diskon = $i['harga_satuan'] * $i['disc_ppn'] / 100;
                          $harga_diskon = $i['harga_satuan'] - $harga_diskon;
                    ?>
                        <tr class="tr-<?=$i['id']?> list-product">
                          <td><?=($key+1)?>
                            <input type="hidden" name="ProductForm[<?=$key?>][product_id]" value="<?=$i['product_id']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][kode]" value="<?=$i['kode']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][uraian]" value="<?=$i['uraian']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][vol]" class="input-hidden-vol" value="<?=$i['vol']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][satuan]" value="<?=$i['satuan']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][harga_satuan]" class="input-hidden-harga" value="<?=$i['harga_satuan']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][disc_ppn]" class="input-hidden-disc_ppn" value="<?=$i['disc_ppn']?>" />
                            <input type="hidden" name="ProductForm[<?=$key?>][weight]" class="input-hidden-weight" value="<?=$i['weight']?>" />
                          </td>
                          <td class="kode"><?=$i['kode']?></td>
                          <td class="uraian"><?=$i['uraian']?></td>
                          <td class="vol">
                            <a href="#" class="editable-number" data-type="text" data-url="<?=site_url()?>/ajax/savequotationproductvol" data-pk="<?=$i['id']?>" ><?=($i['vol'])?></a>
                          </td>
                          <td class="satuan"><?=$i['satuan']?></td>
                          <td class="harga_satuan">Rp. <?=number_format($i['harga_satuan'])?></td>
                          <td class="disc_ppn"><?=$i['disc_ppn']?>%</td>
                          <td class="disc_harga_satuan">Rp. <?=number_format($harga_diskon)?></td>
                          <td class="subtotal">Rp. <?=number_format($harga_diskon*$i['vol'])?></td>
                          <td class="btn-action">
                              <a href="javascript:" title="Hapus" onclick="hapus_item(<?=$i['id']?>)"><i class="fa fa-remove"></i></a>&nbsp;
                              <a href="javascript:" title="Edit" onclick="edit_item(<?=$i['id']?>)"><i class="fa fa-edit"></i></a>
                          </td>
                        </tr>
                    <?php
                        $total += $harga_diskon*$i['vol'];
                        endforeach;
                      }
                    ?>
                    
                  </tbody>
                  <tfoot class="footer-date-total">
                    <tr>
                      <th colspan="8" style="text-align: right;">Total</th>
                      <th colspan="2" class="total_">Rp. <?=number_format($total)?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('employeeqo')?>" class="btn btn-danger">Cancel</a>
              <a class="btn btn-success btn-proccess">Proccess</a>
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
              <select name="product[kode]" id="select-kode" class="form-control">
                <option value=""> - Product - </option>
                <?php 
                $product = $this->db->get('products');
                foreach($product->result_array() as $i):
                ?>
                <option value="<?=$i['id']?>"><?=$i['kode']?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uraian">Uraian Product : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-uraian" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="satuan">Satuan : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-satuan" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="weight">Weight : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-weight" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12 label-modal-price" style="text-align: left;"></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume">Volume : </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="input-volume" required="required" name="volume[volume]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="disc_ppn">Disc</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="input-disc_ppn" required="required" name="products[disc_ppn]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('products')?>" class="btn btn-primary" data-dismiss="modal">Cancel</a>
              <a class="btn btn-success btn-add-modal"  data-dismiss="modal">Add</a>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">


  $('.editable-vol').editable({
      validate: function(value) {
        if ($.isNumeric(value) == '') {
            return 'Number Only';
        }
      },
      type: 'text',
      title: 'Rubah Data'
    });

  var t_add = "";
  var obj;
  var num_row=0;

  $('.btn-proccess').click(function(){
    
    if($("select[name='Employee_po[sales_id]']").val() =="" || $("select[name='Employee_po[customer_id]']").val() =="" || $("select[name='Employee_po[proyek_id]']").val() =="" || $("select[name='Employee_po[sistem_pembayaran]']").val() =="" || $("select[name='Employee_po[area_id]']").val() =="" || $("select[name='Employee_po[marketing_id]']").val() =="" ){
        
        alert('Data belum lengkap');
        return false;
      }

    if(confirm('Proccess Quotation ?'))
    {
      $("input[name='Employee_po[proccess]']").val(1);

      setTimeout(function(){
        $('form#form-quotation').submit();
      }, 500);
    }
  });

  $('.btn-add-modal').click(function(){

    if($('form#modal-product select').val() == ""){

      alert("produk harus dipilih");

      return false;
    } 

    obj.disc_ppn = $('input#input-disc_ppn').val();
    obj.vol = $('input#input-volume').val();

    t_add = "<tr class=\"tr-"+(num_row+1)+"\">";
    t_add += "<td>"+ (num_row+1) 
                    +"<input type=\"hidden\" value=\""+obj.id+"\" name=\"ProductForm["+num_row+"][product_id]\" />"
                    +"<input type=\"hidden\" value=\""+obj.kode+"\" name=\"ProductForm["+num_row+"][kode]\" />"
                    +"<input type=\"hidden\" value=\""+obj.uraian+"\" name=\"ProductForm["+num_row+"][uraian]\" />"
                    +"<input type=\"hidden\" value=\""+obj.satuan+"\" name=\"ProductForm["+num_row+"][satuan]\" />"
                    +"<input type=\"hidden\" value=\""+obj.price+"\" name=\"ProductForm["+num_row+"][harga_satuan]\" />"
                    +"<input type=\"hidden\" value=\""+obj.vol+"\" name=\"ProductForm["+num_row+"][vol]\"  class=\"input-hidden-vol\" />"
                    +"<input type=\"hidden\" value=\""+obj.disc_ppn+"\" class=\"input-hidden-disc_ppn\" name=\"ProductForm["+num_row+"][disc_ppn]\" />"
                    ;

    t_add += "</td>";
    t_add += "<td>"+ obj.kode +"</td>";
    t_add += "<td>"+ obj.uraian +"</td>";
    t_add += "<td class=\"vol\">"+ obj.vol +"</td>";
    t_add += "<td>"+ obj.satuan +"</td>";
    t_add += "<td>Rp. "+ numberWithComma(obj.price) +"</td>";
    t_add += "<td class=\"disc_ppn\">"+ obj.disc_ppn +"%</td>";
    t_add += "<td class=\"btn-action\"><a href=\"javascript:\" title=\"Hapus\" onclick=\"hapus_item("+ (num_row+1) +")\"><i class=\"fa fa-remove\"></i></a> &nbsp;";
    t_add += '<a href="javascript:" title="Edit" onclick="edit_item('+ (num_row+1) +')"><i class="fa fa-edit"></i></a>';
    t_add += '</td>';
    t_add += "</tr>";
    
    num_row++;

    $('.add-table-product').append(t_add);
    
    obj = "";

    $('label.label-modal-uraian, label.label-modal-volume, label.label-modal-satuan, label.label-modal-weight, label.label-modal-price').html("");

    $('form#modal-product input').each(function(){
      $(this).val("");
    });
    
    $('form#modal-product select').val("");
  });

  $("select#select-kode").on("change", function(){

      var id_select = $(this).val();
      if(id_select != ""){

        $.ajax({
            url: "<?=site_url('ajax/getkodeproduct')?>", 
            data: {id : id_select},
            success: function(result){

              if(result == null) return false;

              obj = JSON.parse(result);

              $("label.label-modal-uraian").html(obj.uraian);
              $("label.label-modal-satuan").html(obj.satuan);
              $("label.label-modal-weight").html(obj.weight);
              $("label.label-modal-price").html('Rp. '+ numberWithComma(obj.price));
              $('input#input-disc_ppn').val(0);
            }
        });
      }
  });  


  function edit_item(product_id)
  {
    var tr_ = $('tr.tr-'+product_id);

    tr_.find('td.disc_ppn').html('<input type="text" value="'+ tr_.find('input.input-hidden-disc_ppn').val() +'" />');
    tr_.find('td.vol').html('<input type="text" value="'+ tr_.find('input.input-hidden-vol').val() +'" />');

    tr_.find('td.btn-action').html('<a href="javascript:" onclick="cancel_edit_product('+ product_id +')" title="Cancel"><i class="fa fa-close"></i></a> <a href="javascript:" onclick="approved_edit_product('+ product_id +')" title="Oke"><i class="fa fa-check"></i></a>');
  } 

  function hapus_item(product_id){

    if(confirm('hapus data ini?'))
    {
      $.ajax({
            url: "<?=site_url('ajax/deletepoproduct')?>", 
            data: {id : product_id},
            success: function(result){
              $(".tr-"+product_id).remove();
            }
        });
    }
  }

  function cancel_edit_product(product_id){

    var tr_ = $('tr.tr-'+product_id);

    var disc_ppn_ = tr_.find('input.input-hidden-disc_ppn').val();
    var vol_ = tr_.find('input.input-hidden-vol').val();
    
    tr_.find('td.disc_ppn').html(disc_ppn_+"%");
    tr_.find('td.vol').html(vol_);

    tr_.find('td.btn-action').html('<a href="javascript:" title="Edit" onclick="edit_item('+ product_id +')"><i class="fa fa-edit"></i></a>');
  }


  function approved_edit_product(product_id){

    var tr_ = $('tr.tr-'+product_id);

    var disc_ppn_ = tr_.find('td.disc_ppn input').val();
    var vol_ = tr_.find('td.vol input').val();
    
    tr_.find('td.disc_ppn').html(disc_ppn_+"%");
    tr_.find('td.vol').html(vol_);

    tr_.find('td.btn-action').html('<a href="javascript:" title="Edit" onclick="edit_item('+ product_id +')"><i class="fa fa-edit"></i></a>');

    // $.post("<?=site_url('ajax/editlineproduct')?>",
    // {
    //   id : product_id, 
    //   quotation_order_id: <?php //=$data['id']?>, 
    //   vol: vol_,
    //   disc_ppn:  disc_ppn_
    // },
    // function(data, status){
    //   console.log(data);
    // });
  }

var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function () {
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);

    $.ajax({
        type: "POST",
        url: "<?=site_url('ajax/uploadproductqo')?>",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
            // your callback here
            var obj = JSON.parse(data);
            console.log(obj);

            obj.disc_ppn = $('input#input-disc_ppn').val();

            t_add = "<tr class=\"tr-"+(num_row+1)+"\">";
            t_add += "<td>"+ (num_row+1) +"<input type=\"hidden\" value=\""+obj.id+"\" name=\"ProductForm["+num_row+"][product_id]\" /></td>";
            t_add += "<td>"+ obj.kode +"<input type=\"hidden\" value=\""+obj.kode+"\" name=\"ProductForm["+num_row+"][kode]\" /></td>";
            t_add += "<td>"+ obj.uraian +"<input type=\"hidden\" value=\""+obj.uraian+"\" name=\"ProductForm["+num_row+"][uraian]\" /></td>";
            t_add += "<td>"+ obj.vol +"<input type=\"hidden\" value=\""+obj.vol+"\" name=\"ProductForm["+num_row+"][vol]\" /></td>";
            t_add += "<td>"+ obj.satuan +"<input type=\"hidden\" value=\""+obj.satuan+"\" name=\"ProductForm["+num_row+"][satuan]\" /></td>";
            //t_add += "<td>"+ obj.weight +"<input type=\"hidden\" value=\""+obj.weight+"\" name=\"ProductForm["+num_row+"][weight]\" /></td>";
            t_add += "<td>Rp. "+ numberWithComma(obj.price) +"<input type=\"hidden\" value=\""+obj.price+"\" name=\"ProductForm["+num_row+"][harga_satuan]\" /></td>";
            t_add += "<td>"+ obj.disc_ppn +"%<input type=\"hidden\" value=\""+obj.disc_ppn+"\" name=\"ProductForm["+num_row+"][disc_ppn]\" /></td>";
            t_add += '<td><a href="javascript:" title="Hapus" onclick="hapus_item('+ (num_row+1) +')"><i class="fa fa-remove"></i></a> &nbsp;';
            t_add += '<a href="javascript:" title="Edit" onclick="edit_item('+ (num_row+1) +')"><i class="fa fa-edit"></i></a>';
            t_add += '</td>';
            t_add += "</tr>";
            
            num_row++;

            $('.add-table-product').append(t_add);

            setTimeout(function(){
              $('#progress-wrp').hide();
            }, 1000);
            
        },
        error: function (error) {
            // handle error
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    
    $('#progress-wrp').show();

    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};

//Change id to your id
$("input[type='file']").on("change", function (e) {
    var file = $(this)[0].files[0];
    var upload = new Upload(file);
    // execute upload
    upload.doUpload();
});

</script>
<style type="text/css">
  #progress-wrp {
    display: none;
    border: 1px solid #35b964;
    padding: 1px;
    position: relative;
    height: 30px;
    border-radius: 3px;
    margin: 10px;
    text-align: left;
    background: #fff;
    box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}
#progress-wrp .progress-bar{
    height: 100%;
    border-radius: 3px;
    background-color: #14c114;
    width: 0;
    box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}
#progress-wrp .status{
    top:3px;
    left:50%;
    position:absolute;
    display:inline-block;
    color: #000000;
}
</style>
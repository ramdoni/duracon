// init function 
editable_volume();
editable_disc();

var t_add = "";
var obj;
var num_row=0;
var transport = 0;
var is_transport = 1;

$("select[name='provinsi']").on('change', function(){

  var id = $(this).val();

  $.ajax({
      url: site_url + "ajax/getkabupaten", 
      data: {'id' : id },
      type: 'GET',
      success: function(result){
        $("select[name='kabupaten']").html(result);
      }
  })
});

$("select[name='kabupaten']").on('change', function(){

  var id = $(this).val();

  $.ajax({
      url: site_url + "ajax/getkecamatan", 
      data: {'id' : id },
      type: 'GET',
      success: function(result){
        $("select[name='kecamatan']").html(result);
      }
  })
});

$("select[name='kecamatan']").on('change', function(){

  var id = $(this).val();

  $.ajax({
      url: site_url + "ajax/getkelurahan", 
      data: {'id' : id },
      type: 'GET',
      success: function(result){
        $("select[name='kelurahan']").html(result);
      }
  })
});


$("select[name='Employee_po[kelurahan_id]']").on('change', function(){

  var provinsi_id   = $("select[name='provinsi']").val();
  var kabupaten_id  = $("select[name='kabupaten']").val();
  var kecamatan_id  = $("select[name='kecamatan']").val();
  var kelurahan_id  = $(this).val();
  
  if($(this).val() == "")
  {
    return false;
  }

  $.ajax({
      url: site_url + "ajax/cekareakirim", 
      data: {'kelurahan_id' : kelurahan_id },
      type: 'GET',
      success: function(result){
        
        obj = JSON.parse(result); 

        if(obj.message == 'success')
        { 
          var transport = obj.data.price; 

          $("input[name='Employee_po[area_id]']").val(obj.data.id);
          $('.label-area_kirim').html(obj.data.area);
          $("input[name='Employee_po[transport]']").val(obj.data.price);

        }else{
          _alert("Area kirim tidak ditemukan untuk kelurahan ini, silahkan pilih kelurahan yang lain !");
        }
      }
  })
});


$("select[name='perihal']").on('change', function(){

  if( $(this).val() == 'Harga Satuan')
  {
    $("input[name='volume[volume]']").attr('readonly', true).val(1);
    $("input[name='products[disc_ppn]']").attr('readonly', true).val(0);
  }
  else
  {
    $("input[name='volume[volume]']").removeAttr('readonly');
    $("input[name='products[disc_ppn]']").removeAttr('readonly');
  }
});

$('.select_customer').on('change', function(){

  var id_customer = $(this).val();
  $.ajax({
      url: site_url + "ajax/getcustomer", 
      data: {id : id_customer },
      type: 'POST',
      success: function(result){

        obj = JSON.parse(result); 

        $('.label-sistem_pembayaran').html(obj.sistem_pembayaran);
        $('.sistem_pembayaran').val(obj.sistem_pembayaran);

        $('input.sales_id').val(obj.sales_id);
        $('.label-sales_id').html(obj.sales);

        var no_po = $("input#no_po");
        var no_po_split = no_po.val().split('/');
        
        if(result == null) return false;

          if(obj.sales_code == "" || obj.sales_code == null) return false;

          var replace_no_po = "";

          $.each(no_po_split, function(key, value){
            
            if(key ==3)
              replace_no_po += obj.sales_code + "/";
            else
              replace_no_po += value +"/";
          })
          
          no_po_split[0]+ '/'+ no_po_split[1]+ '/'+ no_po_split[2]+ '/'+obj.sales_code+"/"+ no_po_split[4]+ '/'+ no_po_split[5]+ '/'+no_po_split[6]+ '/';

          no_po.val(replace_no_po.slice(0, -1))
      }
  });
});

$('select.select_transport').on('change', function(){

  is_transport = $(this).val();

});


$("#btn-reset").click(function(){
  $(".add-table-product").html("");
  $('.footer-date-total').html("");
});

  $('.btn-proccess').click(function(){
    
    if($("select[name='Employee_po[marketing_id]']").val() =="" && $("select[name='Employee_po[sales_id]']").val() =="")
    {
      _alert("Marketing atau Sales Harus dipilih!");

      return false;
    }
    
    if($("select[name='Employee_po[customer_id]']").val() =="" || $("select[name='Employee_po[proyek_id]']").val() =="" || $("select[name='Employee_po[sistem_pembayaran]']").val() =="" || $("select[name='Employee_po[area_id]']").val() ==""){
        
        _alert('Data belum lengkap');
        return false;
      }

     bootbox.confirm({
        title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
        message: "Proccess Quotation ?",
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
            $("input[name='Employee_po[proccess]']").val(1);

            setTimeout(function(){
              $('form#form-quotation').submit();
            }, 500);
          }          
        }
      });
  });

  $('.btn-add-modal').click(function(){


    if($("select[name='perihal'").val() == "")
    {
      _alert('Perihal harus dipilih terlebih dahulu !');

      $("#myModal").modal('hide');

      return false;
    }

    if($('select#area_id').val() == ""){

      _alert("Area harus dipilih terlebih dahulu");

      return false;
    }
    
    if($('form#modal-product select').val() == ""){

      _alert("produk harus dipilih");

      return false;
    } 

    if($('#input-volume').val() == 0 || $('.input-volume').val() =="")
    {
      _alert('Volume harus diisi !');

      return false;
    }

    obj.disc_ppn = parseInt($('input#input-disc_ppn').val());
    obj.vol = parseInt($('input#input-volume').val());

    var harga_diskon = parseInt(obj.price) * parseInt(obj.disc_ppn) / 100;
    harga_diskon = parseInt(obj.price) - parseInt(harga_diskon);

    // cek apakah penurunan barang setting / tidak setting
    var is_setting = $("select#select-penurunan-barang").val();
    if(is_setting == 'Setting'){

      if(obj.biaya_setting != "" && obj.biaya_setting != null)
        harga_diskon = parseInt(obj.biaya_setting) + harga_diskon;
    }

    var transport = $("input[name='Employee_po[transport]']").val();

    var harga_transport = (transport*obj.weight);

    t_add = "<tr class=\"tr-"+(obj.id)+" list-product\">";
    t_add += "<td>"+ (num_row+1) 
                    +"<input type=\"hidden\" value=\""+obj.id+"\" name=\"ProductForm["+num_row+"][product_id]\" />"
                    +"<input type=\"hidden\" value=\""+obj.kode+"\" name=\"ProductForm["+num_row+"][kode]\" />"
                    +"<input type=\"hidden\" value=\""+obj.uraian+"\" name=\"ProductForm["+num_row+"][uraian]\" />"
                    +"<input type=\"hidden\" value=\""+obj.satuan+"\" name=\"ProductForm["+num_row+"][satuan]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-harga\" value=\""+obj.price+"\" name=\"ProductForm["+num_row+"][harga_satuan]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-vol\" value=\""+obj.vol+"\" name=\"ProductForm["+num_row+"][vol]\"  />"
                    +"<input type=\"hidden\" class=\"input-hidden-disc_ppn\" value=\"0\" name=\"ProductForm["+num_row+"][disc_ppn]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-weight\" value=\""+obj.weight+"\" name=\"ProductForm["+num_row+"][weight]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-transport\" value=\""+transport+"\" name=\"ProductForm["+num_row+"][transport]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-hara_awal\" value=\""+obj.harga_up+"\" name=\"ProductForm["+num_row+"][harga_awal]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-harga_akhir\" value=\""+obj.harga_up+"\" name=\"ProductForm["+num_row+"][harga_akhir]\" />"
                    ;

    t_add += "</td>";
    t_add += "<td>"+ obj.kode +"</td>";
    t_add += "<td>"+ obj.uraian +"</td>"; 
    t_add += "<td class=\"vol\"><a href=\"#\" class=\"editable-vol\" data-type=\"text\" data-url=\""+base_url+"ajax/savequotationproductvol\" data-pk=\""+obj.id+"\" >"+ obj.vol +"</a></td>";
    t_add += "<td>Rp. "+ numberWithComma(obj.price) +"</td>";
    t_add += "<td>Rp. "+ numberWithComma(harga_transport) +"</td>";
    t_add += "<td class=\"disc_harga_satuan\">Rp. "+ numberWithComma(precisionRound(obj.harga_up, -2)) +"</td>";
    t_add += "<td class=\"disc_ppn\"><a href=\"#\" class=\"editable-disc\" data-type=\"text\" data-url=\""+site_url+"ajax/savequotationproducthargaakhir\" data-pk=\""+ obj.id +"\" >0</a>%</td>";
    t_add += "<td class=\"harga_akhir\">Rp. <a href=\"#\" class=\"editable-harga_akhir\" data-type=\"text\" data-url=\""+site_url+"ajax/savequotationproducthargaakhir\" data-pk=\""+ obj.id +"\" > "+ numberWithComma(precisionRound(obj.harga_up, -2)) +"</a></td>";
    t_add += "<td class=\"subtotal\">Rp. "+ numberWithComma(precisionRound(parseInt(obj.harga_up), -2) * parseInt(obj.vol)) +"</td>";
    t_add += "<td class=\"btn-action\"><a href=\"javascript:\" title=\"Hapus\" onclick=\"hapus_itemTemp("+ (num_row+1) +")\"><i class=\"fa fa-remove\"></i></a> &nbsp;";
    t_add += '</td>';
    t_add += "</tr>";
    
    num_row++;

    $('.add-table-product').append(t_add);
    
    // set total
    total += (precisionRound(parseInt(obj.harga_up), -2) * parseInt(obj.vol));
    
    obj = "";

    $('label.label-modal-uraian, label.label-modal-volume, label.label-modal-satuan, label.label-modal-weight, label.label-modal-price').html("");

    $('form#modal-product input').each(function(){
      $(this).val("");
    });
    
    $('form#modal-product select').val("");

    $('th.total_').html('Rp. '+numberWithComma(total) );

    editable_volume();
    editable_disc();
    editable_harga_akhir();

  });

  $("select.select-proyek").on("change", function(){  

    var id_select = $(this).val();

    $.ajax({
        url: site_url + "ajax/getareaproyek", 
        data: {id : id_select},
        success: function(result){

          $(".area-kirim").html(result);
        }
    });
  });

  $("select#select-kode").on("change", function(){

    if($("input[name='Employee_po[area_id]']").val() == "")
    {
      _alert("Pilih Kelurahan terlebih dahulu");
      $(this).val("");
      return false;
    }

      var id_select = $(this).val();
      if(id_select != ""){

        $.ajax({
            url: site_url + "ajax/getkodeproduct", 
            data: {id : id_select},
            success: function(result){

              if(result == null) return false;

              obj = JSON.parse(result); 

              $("label.label-modal-uraian").html(obj.uraian); 
              $("label.label-modal-satuan").html(obj.satuan);
              $("label.label-modal-weight").html(obj.weight);
              $("label.label-modal-transport").html( numberWithComma(obj.weight * parseInt($("input[name='Employee_po[transport]']").val())) );

              $("label.label-modal-price").html('<a href="#" class="editable-price" title="Klik untuk rubah manual Harga">'+ numberWithComma(obj.price) +"</a>");
              $('input#input-disc_ppn').val(0);

              // $('.editable-price').editable({
              //   validate: function(value) {
              //     obj.price = value.replace(",", '');
              //     console.log(obj.price);
              //   },
              //   type: 'text',
              //   title: 'Rubah manual Harga'
              // });
              
              obj.harga_up = obj.price;

              $("input[name='products[disc_ppn]']").on('input', function(){

                if($(this).val() == "")
                {
                  return false;
                }

                var tmp_p = obj.price;
                
                if($("select.select_transport").val() == 1) // Incude Transport
                {
                  var harga_up = (parseInt(obj.price) + (parseInt($("input[name='Employee_po[transport]']").val()) * obj.weight) ) * (1+parseInt($(this).val()) / 100);
                }
                else
                {
                  var harga_up = ( tmp_p * (1+parseInt($(this).val()) / 100)) + (parseInt($("input[name='Employee_po[transport]']").val())  * obj.weight);
                }
                
                obj.harga_up = harga_up;

                $('label.label-modal-price-up').html(numberWithComma(precisionRound(harga_up, -2)));
              }); 

              
            }
        });
      }
  });

function precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}

function cek_product(id)
{

}

/**
 * [editable_volume description]
 * @return {[type]} [description]
 */
function editable_volume()
{
  $('.editable-vol').editable({
    validate: function(value) {
      if ($.isNumeric(value) == '') {
          return 'Number Only';
      }

      var product_id = $(this).attr('data-pk');
      var tr_ = $('tr.tr-'+product_id);

      var disc_ppn_ = tr_.find('input.input-hidden-disc_ppn').val();
      var price_ = tr_.find('input.input-hidden-harga').val();
      
      tr_.find('input.input-hidden-vol').val(value);
      tr_.find('input.input-hidden-disc_ppn').val(disc_ppn_);

      var sub_total = 0;

      var harga_diskon = parseInt(price_) * parseInt(disc_ppn_) / 100;
      harga_diskon = parseInt(price_) - parseInt(harga_diskon);

      //tr_.find('td.disc_harga_satuan').html('Rp. '+ numberWithComma(harga_diskon));
      tr_.find('td.harga_akhir').html('Rp. '+ numberWithComma(harga_diskon));
      tr_.find('td.subtotal').html("Rp. "+numberWithComma(harga_diskon * value));
      
      var total = 0;
      $("tr.list-product").each(function(){
          
          var vol_ = $(this).find('input.input-hidden-vol').val();
          var price_ = $(this).find('input.input-hidden-harga').val();
          var disc_ppn_ = $(this).find('input.input-hidden-disc_ppn').val();

          var harga_diskon = parseInt(price_) * parseInt(disc_ppn_) / 100;
          harga_diskon = parseInt(price_) - parseInt(harga_diskon);

          total += parseInt(harga_diskon) * parseInt(vol_);
      });

      $('th.total_').html('Rp. '+ numberWithComma(total));

    },
    type: 'text',
    title: 'Rubah Data'
  });
}

/**
 * [editable_disc description]
 * @return {[type]} [description]
 */
function editable_disc()
{
  $('.editable-disc').editable({
    validate: function(value) {
      if ($.isNumeric(value) == '') {
          return 'Number Only';
      }

      var product_id = $(this).attr('data-pk');
      var tr_ = $('tr.tr-'+product_id);

      var disc_ppn_ = value;
      var volume = tr_.find('input.input-hidden-vol').val();
      var price_ = tr_.find('input.input-hidden-harga_akhir').val();
      
      tr_.find('input.input-hidden-vol').val(volume);
      tr_.find('input.input-hidden-disc_ppn').val(disc_ppn_);

      var sub_total = 0;

      harga_akhir = precisionRound(parseInt(price_) * (1 - parseInt(disc_ppn_) / 100 ), -2);

      tr_.find('td.harga_akhir .editable-harga_akhir').html('Rp. '+ numberWithComma(harga_akhir));
      tr_.find('td.subtotal').html("Rp. "+numberWithComma(harga_akhir * volume));
      tr_.find('input.input-hidden-harga_akhir').val(harga_akhir);
      tr_.find('input.input-hidden-disc_ppn').val(disc_ppn_);
      
      var total = 0;
      $("tr.list-product").each(function(){
          
          var vol_ = $(this).find('input.input-hidden-vol').val();
          var harga_akhir = $(this).find('input.input-hidden-harga_akhir').val();

          total += parseInt(harga_akhir) * parseInt(vol_);
      });

      $('th.total_').html('Rp. '+ numberWithComma(precisionRound(total,-2)));

    },
    type: 'text',
    title: 'Rubah Data'
  });
}

function editable_harga_akhir()
{
  $('.editable-harga_akhir').editable({
    validate: function(value) {
     

      var product_id = $(this).attr('data-pk');
      var tr_ = $('tr.tr-'+product_id);

      var harga_akhir = value.replace(',', '');

      var harga_awal  = tr_.find('.input-hidden-harga').val();
      var volume = tr_.find('input.input-hidden-vol').val();

      var disc = (1 - harga_akhir / precisionRound(harga_awal, -2)) * 100;

      console.log('harga awal : '+ harga_awal);
      console.log('harga akhir : '+ harga_akhir);

      tr_.find('td.subtotal').html("Rp. "+numberWithComma(precisionRound(harga_akhir * volume, -2)));
      tr_.find('td.disc_ppn a.editable-disc').html(Math.round(disc));
      
      $(this).find('input.input-hidden-disc_ppn').val(Math.round(disc));
      
      var total = 0;
      $("tr.list-product").each(function(){
          
          var vol_ = $(this).find('input.input-hidden-vol').val();
          var price_ = $(this).find('input.input-hidden-harga').val();
          var disc_ppn_ = $(this).find('input.input-hidden-disc_ppn').val();

          var harga_diskon = parseInt(price_) * parseInt(disc_ppn_) / 100;
          harga_diskon = parseInt(price_) - parseInt(harga_diskon);

          total += precisionRound(parseInt(harga_diskon) * parseInt(vol_), -2);
      });

      $('th.total_').html('Rp. '+ numberWithComma(precisionRound(total,-2)));

    },
    type: 'text',
    title: 'Rubah Data'
  });
}


function edit_item(product_id)
{
  var tr_ = $('tr.tr-'+product_id);

  tr_.find('td.disc_ppn').html('<input type="text" class="inline-edit-text" value="'+ tr_.find('input.input-hidden-disc_ppn').val() +'" />');
  tr_.find('td.vol').html('<input type="text" class="inline-edit-text" value="'+ tr_.find('input.input-hidden-vol').val() +'" />');

  tr_.find('td.btn-action').html('<a href="javascript:" onclick="cancel_edit_product('+ product_id +')" title="Cancel"><i class="fa fa-close"></i></a> <a href="javascript:" onclick="approved_edit_product('+ product_id +')" title="Oke"><i class="fa fa-check"></i></a>');
}

function hapus_itemTemp(id_class)
{
  $('.tr-'+id_class).remove();
}

function hapus_item(product_id){

  if(confirm('hapus data ini?'))
  {
    $.ajax({
          url: site_url +"ajax/deletepoproduct", 
          data: {id : product_id},
          success: function(result){
            $(".tr-"+product_id).remove();
          }
      });
  }
}

$("select.sales_id").on("change", function(){

    var no_po = $("input#no_po");
    var no_po_split = no_po.val().split('/');
    var id_select = $(this).val();

    $.ajax({
        url: site_url +"ajax/getsales", 
        data: {id : id_select},
        type: 'POST',
        success: function(result){
          
          if(result == null) return false;

          obj = JSON.parse(result); 

          if(obj.sales_code == "" || obj.sales_code == null) return false;

          var replace_no_po = "";

          $.each(no_po_split, function(key, value){
            
            if(key ==3)
              replace_no_po += obj.sales_code + "/";
            else if(key == 4)
              replace_no_po += obj.kode_area + "/";
            else
              replace_no_po += value +"/";

          })
          
          no_po_split[0]+ '/'+ no_po_split[1]+ '/'+ no_po_split[2]+ '/'+obj.sales_code+"/"+ no_po_split[4]+ '/'+ no_po_split[5]+ '/'+no_po_split[6]+ '/';

          no_po.val(replace_no_po.slice(0, -1))
        }
      });
  });

  $("select.marketing_id").on("change", function(){

    if($("select.sales_id").val() != "" || $(this).val() == "") return false;

    var no_po = $("input#no_po");
    var no_po_split = no_po.val().split('/');
    var id_select = $(this).val();

    $.ajax({
        url: site_url +"ajax/getsales", 
        data: {id : id_select},
        type: 'POST',
        success: function(result){
          
          if(result === null) return false;

          obj = JSON.parse(result); 
          
          if(obj.sales_code == "" || obj.sales_code == null) return false;
          
          var replace_no_po = "";

          $.each(no_po_split, function(key, value){
            
            if(key ==3){
              replace_no_po += obj.sales_code + "/";
            }
            else if(key =4)
            {
              replace_no_po += obj.kode_area +"/";
            }else{
              replace_no_po += value +"/";
            }
          })  
          no_po.val(replace_no_po.slice(0, -1))
        }
      });
  });


  /**
   * [description]
   * @param  {[type]} ){                                        var value [description]
   * @param  {[type]} type:    'POST'             [description]
   * @param  {String} success: function(result){                                            var replace_no_po [description]
   * @return {[type]}          [description] 
   */
  
  $("input#proyek").on("input", function(){

    console.log($(this).val());

    var value = $(this).val().split(',');
    var str = "";

    if(value.length == 1)
    { 
      str = value[0];
    }else{
      $(value).each(function(key, val){
        str = val;
      });
    }

    if(str != "")
    {
      $.ajax({
        url: site_url +"ajax/getarealokasiname", 
        data: {'string' : str},
        type: 'POST',
        success: function(result){
          console.log(result);
          var replace_no_po = "";
          var no_po = $("input#no_po");
          var no_po_split = no_po.val().split('/');

          if(result == null || result == "") {

            $('select#area_id').val("");

          }else{

            obj = JSON.parse(result);

            $('select#area_id').val(obj.area_id); 
          }
        }
      });
    }
  });



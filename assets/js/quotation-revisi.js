// init function 
editable_volume();
editable_disc();

var t_add = "";
var obj;
var num_row=0;
var transport = 0;
var is_transport = 1;


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
      }
  });
});


$('select#area_id').on('change', function(){

    var selected = $(this).find('option:selected');
    var transport = selected.data('price');

    console.log(transport);
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
        message: "Proccess Revisi Quotation ?",
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

    var transport_selected = $('select#area_id').find('option:selected');
    var transport = transport_selected.data('price');

    var harga_transport = (transport*obj.weight);

    t_add = "<tr class=\"tr-"+(obj.id+1)+" list-product\">";
    t_add += "<td>"+ (num_row+1) 
                    +"<input type=\"hidden\" value=\""+obj.id+"\" name=\"ProductForm["+num_row+"][product_id]\" />"
                    +"<input type=\"hidden\" value=\""+obj.kode+"\" name=\"ProductForm["+num_row+"][kode]\" />"
                    +"<input type=\"hidden\" value=\""+obj.uraian+"\" name=\"ProductForm["+num_row+"][uraian]\" />"
                    +"<input type=\"hidden\" value=\""+obj.satuan+"\" name=\"ProductForm["+num_row+"][satuan]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-harga\" value=\""+harga_diskon+"\" name=\"ProductForm["+num_row+"][harga_satuan]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-vol\" value=\""+obj.vol+"\" name=\"ProductForm["+num_row+"][vol]\"  />"
                    +"<input type=\"hidden\" class=\"input-hidden-disc_ppn\" value=\""+obj.disc_ppn+"\" name=\"ProductForm["+num_row+"][disc_ppn]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-weight\" value=\""+obj.weight+"\" name=\"ProductForm["+num_row+"][weight]\" />"
                    +"<input type=\"hidden\" class=\"input-hidden-transport\" value=\""+transport+"\" name=\"ProductForm["+num_row+"][transport]\" />"
                    ;

    t_add += "</td>";
    t_add += "<td>"+ obj.kode +"</td>";
    t_add += "<td>"+ obj.uraian +"</td>"; 
    t_add += "<td class=\"vol\"><a href=\"#\" class=\"editable-vol\" data-type=\"text\" data-url=\""+base_url+"ajax/savequotationproductvol\" data-pk=\""+obj.id+"\" >"+ obj.vol +"</a></td>";
    t_add += "<td>"+ obj.satuan +"</td>";
    t_add += "<td>Rp. "+ numberWithComma(obj.price) +"</td>";
    t_add += "<td>Rp. "+ numberWithComma(harga_transport) +"</td>";
    t_add += "<td class=\"disc_ppn\"> <a href=\"#\" class=\"editable-disc\" data-type=\"text\" data-url=\""+site_url+"ajax/savequotationproductvol\" data-pk=\""+ obj.id +"\" >"+ obj.disc_ppn +"</a>%</td>";
    t_add += "<td class=\"disc_harga_satuan\">Rp. "+ numberWithComma(harga_diskon) +"</td>";
    t_add += "<td class=\"subtotal\">Rp. "+ numberWithComma((parseInt(harga_diskon) * parseInt(obj.vol))) +"</td>";

    t_add += "<td class=\"btn-action\"><a href=\"javascript:\" title=\"Hapus\" onclick=\"hapus_itemTemp("+ (num_row+1) +")\"><i class=\"fa fa-remove\"></i></a> &nbsp;";
    t_add += '</td>';
    t_add += "</tr>";
    
    num_row++;

    $('.add-table-product').append(t_add);
    
    // set total
    total += (parseInt(harga_diskon) * parseInt(obj.vol));
    
    obj = "";

    $('label.label-modal-uraian, label.label-modal-volume, label.label-modal-satuan, label.label-modal-weight, label.label-modal-price').html("");

    $('form#modal-product input').each(function(){
      $(this).val("");
    });
    
    $('form#modal-product select').val("");


    $('th.total_').html('Rp. '+numberWithComma(total) );

    editable_volume();
    editable_disc();

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
              $("label.label-modal-price").html('<a href="#" class="editable-price" title="Klik untuk rubah manual Harga">'+ numberWithComma(obj.price) +"</a>");
              $('input#input-disc_ppn').val(0);

              $('.editable-price').editable({
                validate: function(value) {
                  obj.price = value.replace(",", '');
                  console.log(obj.price);
                },
                type: 'text',
                title: 'Rubah manual Harga'
              });
            }
        });
      }
  });

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

      tr_.find('td.disc_harga_satuan').html('Rp. '+ numberWithComma(harga_diskon));
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
      var price_ = tr_.find('input.input-hidden-harga').val();
      
      tr_.find('input.input-hidden-vol').val(volume);
      tr_.find('input.input-hidden-disc_ppn').val(disc_ppn_);

      var sub_total = 0;

      var harga_diskon = parseInt(price_) * parseInt(disc_ppn_) / 100;
      harga_diskon = parseInt(price_) - parseInt(harga_diskon);

      tr_.find('td.disc_harga_satuan').html('Rp. '+ numberWithComma(harga_diskon));
      tr_.find('td.subtotal').html("Rp. "+numberWithComma(harga_diskon * volume));
      
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
    $(".tr-"+product_id).remove();
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



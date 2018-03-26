function numberWithComma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$('input.tanggal').each(function(){

	$(this).datetimepicker({
		  format: 'YYYY-MM-DD'
		});
});

Date.prototype.yyyymmdd = function() {
  var yyyy = this.getFullYear().toString();
  var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
  var dd  = this.getDate().toString();
  return yyyy + "/" + (mm[1]?mm:"0"+mm[0]) + "/" + (dd[1]?dd:"0"+dd[0]); // padding
};

var date = new Date();

if($('input').hasClass('date-range'))
{
    $('.date-range').dateRangePicker(
        {
            startDate: date.yyyymmdd(),
            minDays:1,
            maxDays:7
        });
}

if($('input').hasClass('date-range2'))
{ 
  $('.date-range2').each(function(){
      $(this).dateRangePicker(
      {
      });
  });
}

$(document).ready(function() {

  $('.idr').priceFormat({
    prefix: 'Rp. ',
    centsSeparator: '.',
    thousandsSeparator: '.',
    centsLimit: 0
  });


    $.fn.editable.defaults.mode = 'popup';     
    
    $('.edit-active').editable({
        type: 'select',
        title: 'Select Active',
        placement: 'right',
        value: 1,
        source: [
            {value: 1, text: 'Active'},
            {value: 0, text: 'Inactive'}
        ],   
        title: 'Select Status',
        ajaxOptions: {
            type: 'post'
        }        
    });

    $('.editable-number').editable({
        validate: function(value) {
          if ($.isNumeric(value) == '') {
              return 'Number Only';
          }
        },
        type: 'text',
        title: 'Rubah Data'
      });

    $('.editable-text').editable({
        validate: function(value) {
          
        },
        type: 'text',
      });
    
});
  
/**
 * [detail_quotation description]
 * @param  {[type]} id_quotation_order [description]
 * @param  {[type]} title              [description]
 * @return {[type]}                    [description]
 */
function detail_quotation(id_quotation_order, title)
{
    $("#modal_detail_products").modal("show");
    $('#modal_detail_products .modal-title').html("No Quotation : "+ title);
    $.ajax({
      url: site_url+"ajax/getquotationproducts", 
      data: {id : id_quotation_order},
      success: function(result){

        if(result == null) return false;

        obj = JSON.parse(result); 

        var content_detail_product = '';

        var total=0;

        var modal_ = $("#modal_detail_products");
        
        console.log(obj);

        modal_.find('label.label-no_po').html(obj.no_po);
        modal_.find('label.label-sales_id').html(obj.sales);
        modal_.find('label.label-marketing_id').html(obj.marketing);
        modal_.find('label.label-customer_id').html(obj.customer);
        modal_.find('label.label-proyek').html(obj.proyek);
        modal_.find('label.label-area_id').html(obj.area);
        modal_.find('label.label-sistem_pembayaran').html(obj.sistem_pembayaran);
        modal_.find('label.label-tanggal').html(obj.tanggal);
        modal_.find('label.label-penurunan_barang').html(obj.penurunan_barang);
        modal_.find('label.label-tipe_pekerjaan').html(obj.tipe_pekerjaan);
        total_ = 0;

        $(obj.data).each(function(index,val){

          var harga_diskon = parseInt(val.harga_satuan) * parseInt(val.disc_ppn) / 100;
          
          harga_diskon = parseInt(val.harga_satuan) - parseInt(harga_diskon);
          total += (parseInt(harga_diskon) * parseInt(val.vol));
          
          content_detail_product += "<tr><td>"+(index+1)+"</td>";
          content_detail_product += "<td>"+val.kode+"</td>";
          content_detail_product += "<td>"+val.uraian+"</td>";
          content_detail_product += "<td>"+val.vol+"</td>";
          content_detail_product += "<td>"+val.satuan+"</td>";
          content_detail_product += "<td>"+numberWithComma(val.harga_satuan)+"</td>";
          content_detail_product += "<td>"+val.disc_ppn+"%</td>";
          content_detail_product += "<td>"+numberWithComma(harga_diskon)+"</td>";
          content_detail_product += "<td>"+numberWithComma(parseInt(harga_diskon) * parseInt(val.vol))+"</td></tr>";

          total_ += (parseInt(harga_diskon) * parseInt(val.vol)); 

        });
        content_detail_product += "<tr><th colspan=\"8\"  style=\"text-align: right;\">Total : </td><td>Rp. "+ numberWithComma(total_) +"</th></tr>";
        $('.detail-products tbody').html(content_detail_product);
      }
    });
  }

function detail_sales_order_sales(quotation_order_id, sales_order_id, title)
{
    $("#modal_detail_products_sales_order_sales").modal("show");
    $('#modal_detail_products_sales_order_sales .modal-title').html("No PO : "+ title);
    $.ajax({
      url: site_url+"ajax/getsalesorderroducts", 
      data: {'quotation_order_id' : quotation_order_id, 'sales_order_id' : sales_order_id},
      type: 'POST',
      success: function(result){

        if(result == null) return false;

        obj = JSON.parse(result); 

        var content_detail_product = '';

        var total=0;

        var modal_ = $("#modal_detail_products_sales_order_sales");

        modal_.find('label.label-no_po').html(obj.no_po);
        modal_.find('label.label-no_po_sales_order').html(obj.sales_order.no_po);
        modal_.find('label.label-sales_id').html(obj.sales);
        modal_.find('label.label-marketing_id').html(obj.marketing);
        modal_.find('label.label-customer_id').html(obj.customer);
        modal_.find('label.label-proyek').html(obj.proyek);
        modal_.find('label.label-area_id').html(obj.area);
        modal_.find('label.label-sistem_pembayaran').html(obj.sistem_pembayaran);
        modal_.find('label.label-tanggal').html(obj.tanggal);
        modal_.find('label.label-penurunan_barang').html(obj.penurunan_barang);
        modal_.find('label.label-tipe_pekerjaan').html(obj.tipe_pekerjaan);
        modal_.find('label.label-jadwal_mulai').html(obj.sales_order.jadwal_mulai);
        modal_.find('label.label-jadwal_selesai').html(obj.sales_order.jadwal_selesai);
        modal_.find('label.label-penerima_lapangan').html(obj.sales_order.penerima_lapangan);
        modal_.find('label.label-no_telepon').html(obj.sales_order.no_telepon);

        total_ = 0;
        $(obj.data).each(function(index,val){

          var harga_diskon = parseInt(val.harga_satuan) * parseInt(val.disc_ppn) / 100;
          
          harga_diskon = parseInt(val.harga_satuan) - parseInt(harga_diskon);
          total += (parseInt(harga_diskon) * parseInt(val.vol));
          
          content_detail_product += "<tr><td>"+(index+1)+"</td>";
          content_detail_product += "<td>"+val.kode+"</td>";
          content_detail_product += "<td>"+val.uraian+"</td>";
          content_detail_product += "<td>"+val.vol+"</td>";
          content_detail_product += "<td>"+numberWithComma(val.harga_satuan)+"</td>";
          content_detail_product += "<td>"+numberWithComma(parseInt(harga_diskon) * parseInt(val.vol))+"</td></tr>";
          content_detail_product += "</tr>";

          total_ += (parseInt(harga_diskon) * parseInt(val.vol)); 
        });

        content_detail_product += "<tr><th colspan=\"5\"  style=\"text-align: right;\">Total : </td><td>Rp. "+ numberWithComma(total_) +"</th></tr>";
        $('.detail-products-sales-order-sales tbody').html(content_detail_product);
      }
    });
  }


function detail_sales_order(quotation_order_id, sales_order_id, title)
{
    $("#modal_detail_products_sales_order").modal("show");
    $('#modal_detail_products_sales_order .modal-title').html("No PO : "+ title);
    $.ajax({
      url: site_url+"ajax/getsalesorderroducts", 
      data: {'quotation_order_id' : quotation_order_id, 'sales_order_id' : sales_order_id},
      type: 'POST',
      success: function(result){

        if(result == null) return false;

        obj = JSON.parse(result); 

        var content_detail_product = '';

        var total=0;

        var modal_ = $("#modal_detail_products_sales_order");

        modal_.find('label.label-no_po').html(obj.no_po);
        modal_.find('label.label-no_po_sales_order').html(obj.sales_order.no_po);
        modal_.find('label.label-sales_id').html(obj.sales);
        modal_.find('label.label-marketing_id').html(obj.marketing);
        modal_.find('label.label-customer_id').html(obj.customer);
        modal_.find('label.label-proyek').html(obj.proyek);
        modal_.find('label.label-area_id').html(obj.area);
        modal_.find('label.label-sistem_pembayaran').html(obj.sistem_pembayaran);
        modal_.find('label.label-tanggal').html(obj.tanggal);
        modal_.find('label.label-penurunan_barang').html(obj.penurunan_barang);
        modal_.find('label.label-tipe_pekerjaan').html(obj.tipe_pekerjaan);
        modal_.find('label.label-jadwal_mulai').html(obj.sales_order.jadwal_mulai);
        modal_.find('label.label-jadwal_selesai').html(obj.sales_order.jadwal_selesai);
        modal_.find('label.label-penerima_lapangan').html(obj.sales_order.penerima_lapangan);
        modal_.find('label.label-no_telepon').html(obj.sales_order.no_telepon);

        total_ = 0;
        $(obj.data).each(function(index,val){

          var harga_diskon = parseInt(val.harga_satuan) * parseInt(val.disc_ppn) / 100;
          
          harga_diskon = parseInt(val.harga_satuan) - parseInt(harga_diskon);
          total += (parseInt(harga_diskon) * parseInt(val.vol));
          
          content_detail_product += "<tr><td>"+(index+1)+"</td>";
          content_detail_product += "<td>"+val.kode+"</td>";
          content_detail_product += "<td>"+val.uraian+"</td>";
          content_detail_product += "<td>"+val.vol+"</td>";
          content_detail_product += "<td>"+val.satuan+"</td>";
          content_detail_product += "<td>"+numberWithComma(val.harga_satuan)+"</td>";
          content_detail_product += "<td>"+val.disc_ppn+"%</td>";
          content_detail_product += "<td>Rp. "+numberWithComma(harga_diskon)+"</td>";
          content_detail_product += "<td> Rp. "+numberWithComma(parseInt(harga_diskon) * parseInt(val.vol))+"</td>";
         
          content_detail_product += "</tr>";

          total_ += (parseInt(harga_diskon) * parseInt(val.vol)); 
        });

        content_detail_product += "<tr><th colspan=\"8\"  style=\"text-align: right;\">Total : </td><td>Rp. "+ numberWithComma(total_) +"</th></tr>";
        $('.detail-products-sales-order tbody').html(content_detail_product);
      }
    });
  }
  
/**
 * [detail_sik description]
 * @param  {[type]} sik_id         [description]
 * @param  {[type]} sales_order_id [description]
 * @param  {[type]} l87            title         [description]
 * @return {[type]}                [description]
 */
function detail_sik(sik_id, title)
{
    $("#modal_detail_products_sik").modal("show");
    $('#modal_detail_products_sik .modal-title').html("No SIK : "+ title);
    
    $.ajax({
      url: site_url+"ajax/getdetailsik", 
      data: {'id' : sik_id},
      type: 'POST',
      success: function(result){

        if(result == null) return false;

        obj = JSON.parse(result); 

        var content_detail_product = '';

        var modal_ = $("#modal_detail_products_sik");

        modal_.find('label.label-no_sik').html(obj.surat_izin_kirim.no_sik);
        modal_.find('label.label-no_po').html(obj.quotation_order.no_po);
        modal_.find('label.label-no_po_sales_order').html(obj.sales_order.no_po);
        modal_.find('label.label-sales_id').html(obj.quotation_order.sales);
        modal_.find('label.label-marketing_id').html(obj.quotation_order.marketing);
        modal_.find('label.label-customer_id').html(obj.quotation_order.customer);
        modal_.find('label.label-proyek').html(obj.quotation_order.proyek);
        modal_.find('label.label-area_id').html(obj.quotation_order);
        modal_.find('label.label-sistem_pembayaran').html(obj.sistem_pembayaran);
        modal_.find('label.label-alamat_pengiriman').html(obj.surat_izin_kirim.alamat_pengiriman);
        modal_.find('label.label-masa_berlaku').html(obj.surat_izin_kirim.masa_berlaku);

        total_ = 0;

        $(obj.product_sik).each(function(index,val){

          content_detail_product += "<tr><td>"+(index+1)+"</td>";
          content_detail_product += "<td>"+val.kode+"</td>";
          content_detail_product += "<td>"+val.uraian+"</td>";
          content_detail_product += "<td style=\"text-align: center;\">"+val.volume_yang_dikirim+"</td>";
          content_detail_product += "<td>"+( Math.round( (val.weight / 1000) * 100 + Number.EPSILON ) / 100 )+" Ton</td>";
        });

        $('.detail-products-sik tbody').html(content_detail_product);
      }
    });
  }

/**
 * [alert_ description]
 * @param  {[type]} msg [description]
 * @return {[type]}     [description]
 */
function _alert(msg)
{
  if(msg == "") return false;

  bootbox.alert({
    title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
    message: msg
  })
}

/**
 * [_confirm description]
 * @param  {[type]} msg [description]
 * @return {[type]}     [description]
 */
function _confirm(msg, url="")
{
  if(msg == "") return false;

  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
    message: msg,
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
          window.location = url;
      }
      
    }
  });

  return false;
}


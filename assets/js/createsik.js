
/**
 * [batal_sik description]
 * @param  {[type]} sik_id [description]
 * @return {[type]}        [description]
 */
function cancel_sik(sik_id)
{
  $('#modal_batal_sik').modal("show");

  $('#modal_batal_sik input.sik_id').val(sik_id);
}

$("label.submit_pembatalan").click(function(){

  var catatan = $('textarea.catatan_sik').val();
  var sik_id = $('input.sik_id').val();

  if(catatan == "") 
  {
    _alert("Alasan Pembatalan harus diisi!");

    return false;
  }

  $.ajax({
      url: site_url +"ajax/submitpembatalansik", 
      data: {'sik_id' : sik_id, 'catatan' : catatan },
      type: 'POST',
      success: function(result){

        location.reload();
      }
  });
});

function form_pengajuan_dispensasi()
{
  $('.label-no-sik').html($('#no_sik').val());
  $('.hidden_no_sik').val($('#no_sik').val());
  $('.hidden_sales_order_id').val($('.sales_order_id').val());

  $('#modal_pengajuan_dispensasi').modal("show");
}


/**
 * [detail_sik description]
 * @param  {[type]} id    [description]
 * @param  {[type]} title [description]
 * @return {[type]}       [description]
 */
function detail_sik_product(id, title)
{
	// load data 
	$.ajax({
      url: site_url+"ajax/getdetailsikterkirim", 
      data: {'id' : id},
      type: 'POST',
      success: function(result){

        if(result == null) return false;

        obj = JSON.parse(result); 

        console.log(obj);

        $('#modal_detal_sik .modal-title i').after(' NO SIK : '+title);
    		$('#modal_detal_sik').modal("show");

    		var content_detail_product = "";

    		$(obj).each(function(index,val){

          content_detail_product += "<tr><td>"+(index+1)+"</td>";
          content_detail_product += "<td>"+val.kode+"</td>";
          content_detail_product += "<td>"+val.uraian+"</td>";
          content_detail_product += "<td>"+val.volume_yang_dikirim+"</td>";
          content_detail_product += "<td>"+( Math.round( ((val.volume_yang_dikirim * val.weight) / 1000) * 100 + Number.EPSILON ) / 100 )+" Ton</td>";
          content_detail_product += "<td>Rp. "+ numberWithComma(val.harga_yang_dikirim) +"</td>";
        });

          $('#modal_detal_sik .detail-sik-product tbody').html(content_detail_product);
    	}
	 });
}

editable_volume_dikirim();

function editable_volume_dikirim(){

  $('.editable-set-volume').editable({
      validate: function(value) {

        if ($.isNumeric(value) == '') {
          return 'Number Only';
        }

        if(value == 0)
        {
          return 'Pilih jumlah Volume yang benar';
        }
        var pk        = $(this).data('pk');
        var stock     = $(this).data('stock');
        var uang      = $(this).data('uang');
        var totalkirimuangapprove = parseInt($(this).data('totalkirimuang'));
        var harga_satuan_product = parseInt($('.price_id'+pk).val());
        var jenis_pembayaran = $('.sistem_pembayaran').val();


        // uang ditambah dengan dispensasi 
        uang  += $('.nominal_dispensasi').val();

        // cek jumlah stok barang
        if(parseInt(stock) < parseInt(value))
        {
          return "Stock tidak mencukupi !";
        }
        

        if(jenis_pembayaran != 'Kredit')
        {
          if(parseInt(uang) <= totalkirimuangapprove)
          {
            $('.editable-buttons').append('<label class=\"btn btn-sm btn-success\" onclick="form_pengajuan_dispensasi()"><i class="fa fa-money"></i> Pengajuan Dispensasi</label>');
            return "Sisa uang anda tidak mencukupi untuk pengiriman barang ";
          }

          // cek volume yang dikirim dengan harga satuan
          if(parseInt(uang) <=  parseInt(parseInt(value)*harga_satuan_product))
          {
            $('.editable-buttons').append('<label class=\"btn btn-sm btn-success\" onclick="form_pengajuan_dispensasi()"><i class="fa fa-money"></i> Pengajuan Dispensasi</label>');
            return "Sisa uang anda tidak mencukupi untuk pengiriman barang";
          }

          // cek semua yang sudah di input
          var total_uang_dikirim = 0;

          $('.total_uang_yang_dikirim').each(function(){

            if($(this).hasClass('price_product_'+pk)){
              // skip proses
            }else{
              
              if($(this).val() !="" &&  $(this).val() != 0)
              {
                total_uang_dikirim += parseInt($(this).val());
              }
            }

          });

          total_uang_dikirim = totalkirimuangapprove + total_uang_dikirim + (parseInt(value)*parseInt(harga_satuan_product));

          if(parseInt(uang) <= parseInt(total_uang_dikirim))
          {
            return "Sisa uang anda tidak mencukupi untuk pengiriman barang";
          }
        }
        
        $('input.product_id'+pk).val(value);
        $('input.price_product_'+pk).val((parseInt(value)*parseInt(harga_satuan_product)));

        var total_volume = 0;
        $('.product_item').each(function(){
            if($(this).val() != "") 
            {
              total_volume = parseInt($(this).val()) + parseInt(total_volume);
            }
        });

        $('.harga_yg_kirim'+pk).html('Rp. '+ numberWithComma(parseInt(value)*parseInt(harga_satuan_product)));

        var total_price_sub = 0;
        $('.total_uang_yang_dikirim').each(function(){
          if($(this).val() != "") 
          {
            total_price_sub += parseInt($(this).val());
          }
        });

        // set footer volume
        $('.footer_total_volume').html(total_volume);
        $('.footer_total_harga').html('Rp. '+ numberWithComma((total_price_sub)));
    },
    type: 'text',
    title: 'SET VOLUME YANG AKAN DIKIRIM'
  });
}

$('.btn-proccess-sik').click(function(){

  var is_product_isset = 0;

  $('.product_item').each(function(){
    if($(this).val() != "")
    {
      is_product_isset++;
    }
  });


  if(is_product_isset == 0)
  {
    _alert('Set Volume yang akan dikirim');

    return false
  }

  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
    message: "Proses Surat Izin Kirim",
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
          $('#form-sik').submit();
      }
      
    }
  });

});


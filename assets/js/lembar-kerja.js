$('.editable-lembarkerjaitem').editable({
    validate: function(value) {
      if ($.isNumeric(value) == '') {
          return 'Number Only';
      }

      var id        = $(this).data('product_schedule_id');
      var shift     = $(this).data('shift');
      var day       = $(this).data('day');
      var type_input  = $(this).data('type_input');
      var product_schedule_id = $(this).data('product_schedule_id');
      var product_id = $(this).data('product_id');

      $.ajax({
        url: site_url+"ajax/submitplandaily", 
        data: {'volume': value, 'shift' : shift, 'day': day, 'product_schedule_id': product_schedule_id, 'product_id' : product_id, 'type_input':type_input },
        type: 'POST',
        success: function(result){
          console.log(value);
        }
      });

    },
    type: 'text',
    title: 'Rubah Data'
});


/**
 * [validate description]
 * @param  {[type]} value) {                 if ($.isNumeric(value) [description]
 * @return {[type]}        [description]
 */
$('.editable-inputpekerjalembur').editable({
    validate: function(value) {
      if ($.isNumeric(value) == '') {
          return 'Number Only';
      }

      var id        = $(this).data('product_schedule_id');
      var shift     = $(this).data('shift');
      var day       = $(this).data('day');
      var product_schedule_id = $(this).data('product_schedule_id');
      var type_input  = $(this).data('type_input');

      if(type_input == 'pekerja')
        var param = {'volume': value, 'shift' : shift, 'day': day, 'product_schedule_id': product_schedule_id, 'pekerja': value}
      else
        var param = {'volume': value, 'shift' : shift, 'day': day, 'product_schedule_id': product_schedule_id, 'lembur': value}

      $.ajax({
        url: site_url+"ajax/insertpekerjalembur", 
        data: param,
        type: 'POST',
        success: function(result){
          console.log(value);
        }
      });

    },
    type: 'text',
    title: 'Rubah Data'
});



$('.btn-add-modal').click(function(){

  var hasil_produksi  = $('.modal-hasil_produksi').val();
  var finishing   = $('.modal-finishing').val();
  var reject      = $('.modal-reject').val();
  var product_schedule_id   = $('input.product_schedule_id').val();
  var product_id  = $('form#modal-product select').val();
  var day         = $('.modal-day').val();
  var shift       = $('.modal-shift').val();
  var aktual_jumlah_pekerja = $('.modal-aktual_jumlah_pekerja').val();
  var jam_lembur       = $('.modal-jam_lembur').val();
  var jumlah_pekerja   = $('.modal-jumlah_pekerja').val();

  if(product_id == ""){

    _alert("Pilih Produk !");

    return false;
  }
  
  $.ajax({
      url: site_url+ "ajax/submitlembarkerja", 
      type: 'POST',
      data: {'aktual_jumlah_pekerja' : aktual_jumlah_pekerja, 'jam_lembur' : jam_lembur, 'jumlah_pekerja' : jumlah_pekerja, 'product_schedule_id' : product_schedule_id, 'product_id' : product_id, 'reject' : reject, 'finishing' : finishing, 'hasil_produksi' : hasil_produksi,'day' : day, 'shift': shift},
      success: function(result){
        location.reload();  
      }
    });
});

$('.btn-cetak-modal').click(function(){

  var day         = $('.modal2-day').val();
  var shift       = $('.modal2-shift').val();
  var product_schedule_id   = $('input.product_schedule_id').val();

  window.open(site_url +'pabrikjadwalproduksi/cetaklembarkerja/'+product_schedule_id +"?day="+day+"&shift="+shift, '_blank');

});


$("select#select-kode").on("change", function(){

    var id_select = $(this).val();
    if(id_select != ""){

      $.ajax({
          url: site_url+ "ajax/getkodeproduct", 
          data: {id : id_select},
          success: function(result){

            if(result == null) return false;

            obj = JSON.parse(result);

            $("label.label-modal-uraian").html(obj.uraian);
            $("label.label-modal-stock").html(obj.stock);
          }
      });
    }
}); 


$('.editable-plan').editable({
    validate: function(value) {
      if ($.isNumeric(value) == '') {
          return 'Number Only';
      }

      var id          = $(this).data('pk');
      var product_id  = $(this).data('product_id');   
      var shift       = $(this).data('shift');
      var category    = $(this).data('category');
      var day         = $(this).data('day');

      $.ajax({
          url: site_url+"ajax/submitplandaily", 
          data: {'id' : id, 'product_id' : product_id, 'volume' : value, 'shift': shift, 'type': category},
          success: function(result){
            console.log('Oke updated');
          }
      });

    },
    type: 'text',
    title: 'Rubah Data'
  });
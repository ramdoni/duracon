
var objProduct;

function batal_spm(spm_id)
{
  $('#modal_batal_spm').modal("show");

  $('#modal_batal_spm input.spm_id').val(spm_id);
}


$('.btn-proccess').click(function(){
  
  bootbox.confirm({
      title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
      message: "Buat (SPM) Surat Perintah Muat ?",
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
          $('form#form-quotation').submit();
        }          
      }
    });
});

$("label.submit_pembatalan").click(function(){

  var catatan = $('textarea.catatan_spm').val();
  var spm_id = $('input.spm_id').val();

  if(catatan == "") 
  {
    _alert("Alasan Pembatalan harus diisi!");

    return false;
  }

  $.ajax({
      url: site_url +"ajax/submitpembatalanspm", 
      data: {'spm_id' : spm_id, 'catatan' : catatan },
      type: 'POST',
      success: function(result){

        location.reload();
      }
  });
});

$('select.select_tipe_mobil').on('change', function(){

  var tipe_mobil = $(this).val();

  if(tipe_mobil == 'Colt Diesel')
  {
    beban_maksimal = 6;
  } 

  if(tipe_mobil == 'Fuso')
  {
    beban_maksimal = 18;
  }

  if(tipe_mobil == 'Tronton')
  {
    beban_maksimal = 30;
  } 

  if(tipe_mobil == 'Trailer')
  {
    beban_maksimal = 40;
  } 
  
  $('.label_beban_maksimal').html("Beban Maksimal : "+ beban_maksimal +" Ton");
});

$('select.select_produk').on('change', function(){

  var id_product = $(this).val();
  var sik_id = $('input.sik_id').val();

  $.ajax({
        url: site_url +"ajax/getproduksik", 
        data: {'product_id' : id_product, 'sik_id' : sik_id },
        type: 'POST',
        success: function(result){

          objProduct = JSON.parse(result); 

          var html_ = '<option value=""> - Volume - </option>';

          for(var a = 1; a <= objProduct.volume_yang_dikirim; a++)
          {
            html_ += '<option>'+a+'</option>';
          } 
          
          $('.volume_yang_dikirim').html(html_);
        }
    });

});
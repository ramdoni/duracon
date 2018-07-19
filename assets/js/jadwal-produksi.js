function hapus_plan_item(id)
{
  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
    message: "Hapus produk ini ?",
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
        $.ajax({
          url: site_url+ "ajax/deleteprodukplan", 
          data: {id : id},
          type: "POST",
          success: function(result){
            $('.product-plan'+id).remove();
          }
        });
      }
      
    }
  });
}

$("select[name='jadwal[plan]']").on('change', function(){

  cek_exist_schedule($(this));

});

$("select[name='bulan']").on('change', function(){
  cek_exist_schedule($(this));

});

$("select[name='minggu']").on('change', function(){
  
  cek_exist_schedule($(this));

});

function cek_exist_schedule(ini)
{
  var plan = $("#plan").val();
  var bulan = $("select[name='bulan']").val();
  var minggu = $("select[name='minggu'").val();

  $.ajax({
      url: site_url+ "ajax/cekschedule", 
      data: {'plan' : plan, 'bulan': bulan, 'minggu': minggu},
      type: "POST",
      success: function(result){
        if(result == 'yes')
        {
          
          ini.val("");

          _alert('Schedule sudah dibuat');
        }
      }
    });
}

$("select#plan").on('change', function(){
  
  cek_exist_schedule();

  var plan_id = $(this).val();
  
  $.ajax({
      url: site_url+ "ajax/getscheduleplan", 
      data: {'id' : plan_id},
      type : "POST",
      success: function(result){

        if(result == null) {
          $('tbody.content').html("");
          return false;

        }

        obj = JSON.parse(result);

        console.log(obj);

        var html = "";
        
        $(obj).each(function(key, val){

          bg = "";

          if(val.pengecoran == 4)
          {
            bg = 'bgred';
          }else if(val.pengecoran == 3){
            bg = 'bgblue';
          }

          var total_shift1 = 0;
          var total_shift2 = 0;

          total_shift1 = parseInt(val.day1_shift1)+parseInt(val.day2_shift1)+parseInt(val.day3_shift1)+parseInt(val.day4_shift1)+parseInt(val.day5_shift1)+parseInt(val.day6_shift1);
          total_shift2 = parseInt(val.day1_shift2)+parseInt(val.day2_shift2)+parseInt(val.day3_shift2)+parseInt(val.day4_shift2)+parseInt(val.day5_shift2)+parseInt(val.day6_shift2);

          html += "<tr class=\"temp"+key+" "+ bg +"\" >";
          html += '<td><input type="hidden" name="product_id[]" class="form-control" value="'+ val.product_id +'" />'+ val.product +'</td>';
          html += '<td class="total_cetakan">'+ val.cetakan +'</td>';
          html += '<td><input type="text" name="day1_shift1[]" class="form-control" value="'+ val.day1_shift1 +'" /></td>';
          html += '<td><input type="text" name="day1_shift2[]" class="form-control" value="'+ val.day1_shift2 +'" /></td>';
          html += '<td><input type="text" name="day2_shift1[]" class="form-control" value="'+ val.day2_shift1 +'" /></td>';
          html += '<td><input type="text" name="day2_shift2[]" class="form-control" value="'+ val.day2_shift2 +'" /></td>';
          html += '<td><input type="text" name="day3_shift1[]" class="form-control" value="'+ val.day3_shift1 +'" /></td>';
          html += '<td><input type="text" name="day3_shift2[]" class="form-control" value="'+ val.day3_shift2 +'" /></td>';
          html += '<td><input type="text" name="day4_shift1[]" class="form-control" value="'+ val.day4_shift1 +'" /></td>';
          html += '<td><input type="text" name="day4_shift2[]" class="form-control" value="'+ val.day4_shift2 +'" /></td>';
          html += '<td><input type="text" name="day5_shift1[]" class="form-control" value="'+ val.day5_shift1 +'" /></td>';
          html += '<td><input type="text" name="day5_shift2[]" class="form-control" value="'+ val.day5_shift2 +'" /></td>';
          html += '<td><input type="text" name="day6_shift1[]" class="form-control" value="'+ val.day6_shift1 +'" /></td>';
          html += '<td><input type="text" name="day6_shift2[]" class="form-control" value="'+ val.day6_shift2 +'" /></td>';
          html += '<td><input type="text" name="day7_shift1[]" class="form-control" value="'+ val.day7_shift1 +'" /></td>';
          html += '<td><input type="text" name="day7_shift2[]" class="form-control" value="'+ val.day7_shift2 +'" /></td>';
          html += '<td><span class="total_shift1">'+ (total_shift1) +'</span></td>';
          html += '<td><span class="total_shift2">'+ (total_shift2) +'</span></td>';
          html += '<td><a href="javascript:;" onclick="hapus_plan_temp('+ key +')" class="btn btn-danger btn-xs" title="Hapus data ini"><i class="fa fa-close"></i></a></td>';

          html += '<input type="hidden" name="pengecoran[]" value="'+ val.pengecoran +'" />';
          html += '<input type="hidden" name="cetakan[]" value="'+ val.cetakan +'" />';

          html += "</tr>";

        });

        $('tbody.content').html(html);
      }
  });


});

$('.btn-add-modal').click(function(){

  var jumlah_cetakan  = $('.jumlah_cetakan').val();
  var jumlah_cor      = $('.jumlah_cor').val(); 
  

  if($("select[name='jadwal[plan]']").val() == "")
  {
    _alert("Plan harus dipilih terlebih dahulu !");
    
    $('#myModal').modal('hide');

    return false;
  }

  if($('form#modal-product select').val() == ""){

    _alert("Pilih Produk !");

    return false;
  }
  
  if(jumlah_cetakan ==0 || jumlah_cetakan =="" )
  {
    _alert("Jumlah Cetakan harus diisi !");
    return false;
  }

  if(jumlah_cor ==0 || jumlah_cor =="" )
  {
    _alert("Jumlah Cetak / Cor harus diisi !");
    return false;
  }

  var total_cetak     = parseInt(jumlah_cetakan) * parseInt(jumlah_cor);
  var shift           = Math.ceil(total_cetak / 2);

  var html = "";
  var total_shift1 = shift * 5; 
  var total_shift2 = shift * 5;

  var tanggal = new Date();
  var idRandom = tanggal.getTime();

  bg ="";
  
  if(jumlah_cor == 3) 
    bg = ' bgblue';

  if(jumlah_cor >= 4) 
    bg = ' bgred';


  html += "<tr class=\"temp"+idRandom+" "+ bg +"\" >";
  html += '<td><input type="hidden" name="product_id[]" class="form-control" value="'+ $("select#select-kode :selected").val() +'" />'+ $("select#select-kode :selected").html() +'</td>';
  html += '<td class="total_cetakan">'+ jumlah_cetakan +'</td>';
  html += '<td><input type="text" name="day1_shift1[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day1_shift2[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day2_shift1[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day2_shift2[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day3_shift1[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day3_shift2[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day4_shift1[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day4_shift2[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day5_shift1[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day5_shift2[]" class="form-control" value="'+ shift +'" /></td>';
  html += '<td><input type="text" name="day6_shift1[]" class="form-control" value="'+ Math.ceil(shift / 2) +'" /></td>';
  html += '<td><input type="text" name="day6_shift2[]" class="form-control" value="'+ Math.ceil(shift / 2) +'" /></td>';
  html += '<td><input type="text" name="day7_shift1[]" class="form-control" value="" /></td>';
  html += '<td><input type="text" name="day7_shift2[]" class="form-control" value="" /></td>';
  html += '<td><span class="total_shift1">'+ (total_shift1 + (Math.ceil(shift / 2))) +'</span></td>';
  html += '<td><span class="total_shift2">'+ (total_shift2 + (Math.ceil(shift / 2))) +'</span></td>';
  html += '<td><a href="javascript:;" onclick="hapus_plan_temp('+ idRandom +')" class="btn btn-danger btn-xs" title="Hapus data ini"><i class="fa fa-close"></i></a></td>';

  html += '<input type="hidden" name="pengecoran[]" value="'+ jumlah_cor +'" />';
  html += '<input type="hidden" name="cetakan[]" value="'+ jumlah_cetakan +'" />';

  html += "</tr>";


  if(jumlah_cor == 3)
  { 
    if(!$('tbody.content tr').hasClass('bgred')){
      $('.content').append(html);
    }else{
      $('.bgred').after(html);
    }
  }
  else if(jumlah_cor >= 4)
  {
    $('.content').prepend(html);    
  }
  else
  {
    $('.content').append(html);    
  }

  $("label.label-modal-uraian, label.label-modal-stock").html("");
  $("select#select-kode, .spv-pengecoran, .jumlah_cetakan").val("");

});

function hapus_plan_temp(id)
{
  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
    message: "Hapus produk ini ?",
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
        $('tr.temp'+ id).remove();
      }
    }
  });
}

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
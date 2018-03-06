$('.generate-po').click(function(){

    var qo = $('.select-qo').val();

    if(qo == "")
    {
      _alert('No Quotation harus pilih!');

      return false;
    }
    
    $("input#no_po").val($('.select-qo option:selected').text());

  /*
    $.ajax({
        url: site_url +"ajax/generatenoso", 
        data: {id : qo},
        type: 'POST',
        success: function(result){
          $("input#no_po").val(result);
        }
    });
  */
 
  });

  $('.btn-proccess').click(function(){
    
    if($("select[name='Employee_so[quotation_order_id']").val() =="" || $("input[name='Employee_so[no_po]']").val() =="" ){
        
      _alert('Data belum lengkap');

      return false;
    }

    bootbox.confirm({
        title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
        message: "Proccess Order ?",
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
            $("input[name='Employee_so[proccess]']").val(1);

            setTimeout(function(){
              $('form#form-quotation').submit();
            }, 500);
          }          
        }
      });
  });

    $("select[name='proyek_id']").on("change", function(){

      var proyek = $(this).val();

      if(proyek != ""){

        $.ajax({
            url: site_url +"ajax/getnoquotationproyek", 
            data: {'proyek' : proyek},
            success: function(result){

              if(result == null || result == "") return false;

              obj = JSON.parse(result);

              var str_select_qo = '<option value=""> - Quotation - </option>';

              $(obj).each(function(key, val){
                str_select_qo += "<option value=\""+ val.id +"\">"+ val.no_po +"</option>";
              });

              $("select[name='Employee_so[quotation_order_id]']").html(str_select_qo);
            
            }
        });
      }
    });

    $("select[name='Employee_so[quotation_order_id]']").on("change", function(){

      var id_select = $(this).val();
      if(id_select != ""){

        $.ajax({
            url: site_url +"ajax/getquotation", 
            data: {id : id_select},
            type: 'POST',
            success: function(result){

              if(result == null) return false;

              obj = JSON.parse(result);
            
              $("label#label-sales").html(obj.sales);
              $("label#label-customer").html(obj.customer);
              $("label#label-proyek").html(obj.proyek);
              $("label#label-sistem_pembayaran").html(obj.sistem_pembayaran);
              $("label#label-area_kirim").html(obj.area_kirim);
              $("label#label-marketing").html(obj.marketing);
              $("label#label-tipe_pekerjaan").html(obj.tipe_pekerjaan);
            }
        });

        $.ajax({
            url: site_url +"ajax/getquotationproducts", 
            data: {id : id_select},
            success: function(result){

              if(result == null) return false;

              obj = JSON.parse(result);
              
              var str = "";
              var total = 0;
              
              $.each(obj.data, function(index, value){
              
                var harga_diskon = value.harga_satuan * value.disc_ppn / 100;
                var harga_diskon = value.harga_satuan - harga_diskon;

                str += "<tr>";
                str += "<td>"+(index+1)+"</td>";
                str += "<td>"+value.kode+"</td>";
                str += "<td>"+value.uraian+"</td>";
                str += "<td>"+value.vol+"</td>";
                str += "<td>"+value.satuan+"</td>";
                str += "<td>Rp. "+numberWithComma(value.harga_satuan)+"</td>";
                str += "<td>"+value.disc_ppn+"%</td>";
                str += "<td>Rp. "+numberWithComma(harga_diskon)+"</td>";
                str += "<td>Rp. "+numberWithComma((harga_diskon * value.vol))+"</td>";
                str += "</tr>";
                total += harga_diskon * value.vol;
              });

              str += '<tr><th colspan="8" style="text-align:right;">Total</th><th>Rp. '+ numberWithComma(total) +'</th></tr>';
              
              $('tbody.content-products').html(str);
            }
        });
      }
  }); 
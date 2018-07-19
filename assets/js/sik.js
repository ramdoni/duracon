
$('.btn-proccess').click(function(){
  
  bootbox.confirm({
      title : "<i class=\"fa fa-warning\"></i> DURACON SYSTEM",
      message: "Buat (SIK) Surat Izin Kirim ?",
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



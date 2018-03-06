<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Input Pembayaran</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Customer <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="input[customer_id]" class="form-control customer_id" required="true">
                <option value=""> - Customer - </option>
                <?php
                  $customer = $this->db->get_where('customer', ['active' => 1])->result_array();
                  foreach($customer as $i):
                ?>
                  <option value="<?=$i['id']?>"><?=$i['name']?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Sales Order <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="input[sales_order_id]" class="form-control select_sales_order"></select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Invoice <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="input[invoice_id]" class="form-control select_invoice_id"></select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Nominal <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="input[nominal]" class="form-control idr nominal"  />
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="#" onclick="history.back()" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <button class="btn btn-primary btn-sm" type="reset"><i class="fa fa-refresh"></i> Reset</button>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Submit Pembayaran</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(".customer_id").on('change', function(){

    var id_customer = $(this).val();

     $.ajax({
      url: site_url+"ajax/getsalesorderbycustomer", 
      data: {'id' : id_customer},
      type: 'POST',
      success: function(result){

        if(result == null  || result == "") return false;

        obj = JSON.parse(result); 

        var so = '<option value=""> - No Sales Order -</option>';
        $(obj).each(function(k, v){
          so += '<option value="'+ v.id +'">'+ v.no_so +'</option>';
        })

        $('.select_sales_order').html(so);
      }
    });
  });

  $('.select_sales_order').on('change', function(){
    var id_so = $(this).val();

     $.ajax({
      url: site_url+"ajax/getinvoicebyso", 
      data: {'id' : id_so},
      type: 'POST',
      success: function(result){

        if(result == null || result == "") return false;

        obj = JSON.parse(result); 

        var invoice = '<option value=""> - No Invoice -</option>';
        $(obj).each(function(k, v){
          invoice += '<option value="'+ v.id +'">'+ v.no_invoice +'</option>';
        })

        $('.select_invoice_id').html(invoice);
      }
    });
  });

  $('.select_invoice_id').on('change', function(){

    var id_invoice = $(this).val();
    
    $.ajax({
      url: site_url+"ajax/getnominalinvoiceid", 
      data: {'id' : id_invoice},
      type: 'POST',
      success: function(result){
        $('.nominal').val(result);
      }
    });

  })
</script>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Tanda Terima Tagihan</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="demo-form2" method="post" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Pilih Invoice <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Tandaterima[invoice_id]" class="form-control selectinvoice" required>
                <option value=""> - INVOICE - </option>
                <?php 
                  $invoice = $this->db->get("invoice")->result_array();
                  foreach($invoice as $i):

                    $tanda_terima = $this->db->get_where('tanda_terima', ['invoice_id' => $i['id']])->num_rows();
                    
                    if($tanda_terima > 0) continue;

                ?>
                  <option value="<?=$i['id']?>"><?=$i['no_invoice']?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Faktur Pajak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" name="Tandaterima[faktur_pajak]" />
            </div>
          </div>
          <div class="form-group">
            <h4>Surat Jalan</h4>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Surat Jalan</th>
                  <th>Nama Supir</th>
                  <th>No Telepon</th>
                  <th>Kenek</th>
                  <th>Masa Berlaku</th>
                </tr>
              </thead>
              <tbody class="tbody-suratjalan">
                
              </tbody>
            </table>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="#" onclick="history.back()" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Buat Tanda Terima Tagihan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  $(".selectinvoice").on("change", function(){

    var id = $(this).val();

    $.ajax({
      url: site_url+"ajax/getsuratjalanbyinvoice", 
      data: {'id' : id},
      type: 'POST',
      success: function(result){

        if(result == null) return false;

        obj = JSON.parse(result); 

        console.log(obj);

        var html_ = "";
        $.each(obj, function(key, val){
          
          html_ += "<tr>";
          html_ += "<td>"+ (key +1 ) +"</td>";
          html_ += "<td>"+ val.no_surat_jalan +"</td>";
          html_ += "<td>"+ val.nama_supir +"</td>";
          html_ += "<td>"+ val.no_telepon +"</td>";
          html_ += "<td>"+ val.kenek +"</td>";
          html_ += "<td>"+ val.date +"</td>";
          html_ += "</tr>";

        });

        $('.tbody-suratjalan').html(html_)
      }
    });
  });
</script>

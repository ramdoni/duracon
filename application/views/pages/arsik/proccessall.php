 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Surat Izin Kirim</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Products </h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-hover">
                  <thead>
                      <tr>
                        <tH>No</th>
                        <tH>No. SIK</th>
                        <tH>Sales</th>
                        <tH>Customer</th>
                        <tH>Alamat Pengiriman</th>
                        <tH>Deskripsi Produk</th>
                        <th>Jumlah</th>
                        <th>Ton</th>
                        <th>Keterangan</th>
                        <th>Feedback SIK</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $all_sik = $this->db->get_where('surat_izin_kirim', ['position' => 1])->result_array();

                      foreach($all_sik as $key => $item)
                      {
                          #$so = $this->Salesorder_model->get_by_id($item['sales_order_id']);

                          $product = $this->db->get_where('quotation_order_products', ['quotation_order_id'=> $so['quotation_order_id']]); 
                          $num_row = $product->num_rows(); 
                        ?>
                        <tr>
                          <td rowspan="<?=($num_row+1)?>">1</td>
                          <td rowspan="<?=($num_row+1)?>"><?=$so['no_po']?></td>
                          <td rowspan="<?=($num_row+1)?>"><?=$so['sales']?></td>
                          <td rowspan="<?=($num_row+1)?>"><?=$so['customer']?></td>
                          <td rowspan="<?=($num_row+1)?>"><?=$data['alamat_pengiriman']?></td>
                        </tr>
                        <?php 

                          foreach($product->result_array() as $key => $item){
                        ?>
                          <tr>
                            <td><?=$item['uraian']?></td>
                            <td style="text-align: right;"><?=$item['vol']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        <?php } ?>
                      <?php } ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('employeepo')?>" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Cancel</a>
              <a class="btn btn-success btn-proccess">Buat SIK <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/sik.js?rand=<?=date('His')?>"></script>



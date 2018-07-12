 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Sales Order</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Employee_so[proccess]" value="0" />

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_so">No SO</label>
            <div class="col-md-6">
              <input type="text" id="no_so" required="required" name="Employee_so[no_so]" value="<?=$no_so?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>

          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select-qo" required name="Employee_so[quotation_order_id]">
                <option value=""> - Quotation - </option>
                <?php
                  $this->db->from('quotation_order');
                  
                  $this->db->where('position >= 5');
                  
                  $select_proyek = $this->db->get();
      
                  foreach($select_proyek->result_array() as $i):
                    
                    if($this->db->get_where('sales_order',['quotation_order_id' => $i['id']])->num_rows() > 0) continue;
                    
                    $selected = ''; 
                    
                    if(isset($data['quotation_order_id']))
                    {
                      if($data['quotation_order_id'] == $i['id'])
                      {
                        $selected = ' selected';
                      }
                    }
                ?>
                  <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_po']?></option>
                <?php endforeach;?>
              </select>
            </div>
            <?php if(!isset($data['id'])):?>
             <div class="col-md-2 col-sm-2 col-xs-2">
              <label class="btn btn-info btn-xs generate-po"><i class="fa fa-clipboard"></i> Copy </label>
            </div>
          <?php endif; ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No PO <span class="required">*</span>
            </label>
            <div class="col-md-6">
              <input type="text" id="no_po" required="required" <?=(isset($data['id']) ? ' readonly="true"' : '')?> name="Employee_so[no_po]" value="<?=(isset($data['no_po']) ? $data['no_po'] : '')?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-sales" style="text-align: left;"><?=(isset($data['sales']) ? $data['sales'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Marketing : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-marketing" style="text-align: left;"><?=(isset($data['marketing']) ? $data['marketing'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-customer" style="text-align: left;"><?=(isset($data['customer']) ? $data['customer'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-proyek" style="text-align: left;"><?=(isset($data['proyek']) ? $data['proyek'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-sistem_pembayaran" style="text-align: left;"><?=(isset($data['sistem_pembayaran']) ? $data['sistem_pembayaran'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-area_kirim" style="text-align: left;"><?=(isset($data['area']) ? $data['area'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe Pekerjaan : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-tipe_pekerjaan" style="text-align: left;"><?=(isset($data['tipe_pekerjaan']) ? $data['tipe_pekerjaan'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Jadwal Mulai</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" readonly="true" value="<?=(isset($data['jadwal_mulai']) ? $data['jadwal_mulai'] : date('Y-m-d'));?>"  required="required" name="Employee_so[jadwal_mulai]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Jadwal Selesai</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" value="<?=(isset($data['jadwal_selesai']) ? $data['jadwal_selesai'] : date('Y-m-d'))?>"  required="required" name="Employee_so[jadwal_selesai]" class="form-control col-md-7 col-xs-12 tanggal">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="penerima_lapangan">Penerima Lapangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" value="<?=(isset($data['penerima_lapangan']) ? $data['penerima_lapangan'] : '')?>"  required="required" name="Employee_so[penerima_lapangan]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">No Telepon</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" value="<?=(isset($data['no_telepon']) ? $data['no_telepon'] : '')?>"  required="required" name="Employee_so[no_telepon]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
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
                      <th>No</th>
                      <th>Kode</th>
                      <th>Uraian</th>
                      <th>Volume</th>
                      <th>Price List</th>
                      <th>Transport</th>
                      <th>Harga Awal</th>
                      <th>Disc</th>
                      <th>Harga Akhir</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody class="content-products">
                  <?php 
                    if(isset($data['quotation_order_id']))
                    {
                      $data_products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['quotation_order_id']])->result_array();
                      foreach($data_products as $key => $value)
                      {
                        $harga_diskon = $i['harga_akhir'] * $i['disc_ppn'] / 100;
                        $harga_diskon = $i['harga_akhir'] - $harga_diskon;

                        echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>{$value['kode']}</td>";
                        echo "<td>{$value['uraian']}</td>";
                        echo "<td>{$value['vol']}</td>";
                        echo "<td>Rp. ". number_format($value['harga_satuan']) ."</td>";
                        echo "<td>Rp. ". number_format($value['transport']) ."</td>";
                        echo "<td>{$value['disc_ppn']}%</td>";
                        echo "<td>Rp. ". number_format($harga_diskon)."</td>";
                        echo "<td>Rp. ". number_format(($harga_diskon * $value['vol']))."</td>";
                        echo "</tr>";
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a href="<?=site_url('employeepo')?>" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Cancel</a>
              <button class="btn btn-primary btn-sm" type="reset"> <i class="fa fa-refresh"></i> Reset</button>
              <a class="btn btn-success btn-proccess btn-sm">Proccess Sales Order <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/js/sales_order.js?rand=<?=date('His')?>"></script>



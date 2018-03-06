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
          <input type="hidden" name="Sik[sales_order_id]" value="<?=$data['id']?>" />

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No SIK 
            </label>
            <div class="col-md-6">
              <input type="text" id="no_sik" required="required" readonly="true" name="Sik[no_sik]" value="<?=(isset($data['no_sik']) ? $data['no_sik'] : '')?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="proyek" required class="form-control select-proyek" disabled="true" name="proyek_id">
                <option value=""> - Proyek - </option>
              <?php 
                $this->db->from('quotation_order');
                $this->db->group_by('proyek');

                $select_proyek = $this->db->get();
    
                foreach($select_proyek->result_array() as $i) {
                  
                  $selected = ''; 
                  if(isset($data['proyek']))
                  {
                    if($data['proyek'] == $i['proyek'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                  <option value="<?=$i['proyek']?>" <?=$selected?>><?=$i['proyek']?></option>
                  <?php } ?>
                </select>
            </div>
          </div>
          <div class="form-group ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select-qo" disabled="true" name="Employee_so[quotation_order_id]">
                <option value=""> - Quotation - </option>
                <?php
                if(isset($data['id'])):
                  
                  $this->db->from('quotation_order');
                  $this->db->like('proyek', $data['proyek']);

                  $select_proyek = $this->db->get();
      
                  foreach($select_proyek->result_array() as $i):
                    
                    if($this->db->get_where('sales_order',['quotation_order_id' => $i['id']])->num_rows() == 0 and $data['quotation_order_id'] != $i['id']) continue;
                    
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
                <?php
                  endforeach;
                endif;
                ?>
              </select>
            </div>
            <?php if(!isset($data['id'])):?>
             <div class="col-md-2 col-sm-2 col-xs-2">
              <label class="btn btn-info btn-xs generate-po"><i class="fa fa-clipboard"></i> Copy </label>
            </div>
          <?php endif; ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No PO 
            </label>
            <div class="col-md-6">
              <input type="text" id="no_po" required="required" readonly="true" name="Employee_so[no_po]" value="<?=(isset($data['no_po']) ? $data['no_po'] : '')?>"  class="form-control col-md-7 col-xs-10">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT : </label>
            <label class="control-label col-md-6 col-sm-6 col-xs-12" id="label-customer" style="text-align: left;"><?=(isset($data['customer']) ? $data['customer'] : '')?></label>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="penerima_lapangan">Penerima Lapangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" disabled="true" value="<?=(isset($data['penerima_lapangan']) ? $data['penerima_lapangan'] : '')?>" name="Employee_so[penerima_lapangan]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_telepon">No Telepon</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal"  readonly="true" value="<?=(isset($data['no_telepon']) ? $data['no_telepon'] : '')?>"  name="Employee_so[no_telepon]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">Alamat Pengirimin <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control" required name="Sik[alamat_pengiriman]"><?=$data['proyek']?></textarea>
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
                      <th>Satuan</th>
                      <th>Harga Satuan</th>
                      <th>Disc</th>
                      <th>Harga Satuan + Disc</th>
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
                        $harga_diskon = $value['harga_satuan'] * $value['disc_ppn'] / 100;
                        $harga_diskon = $value['harga_satuan'] - $harga_diskon;

                        echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>{$value['kode']}</td>";
                        echo "<td>{$value['uraian']}</td>";
                        echo "<td>{$value['vol']}</td>";
                        echo "<td>{$value['satuan']}</td>";
                        echo "<td>Rp. ". number_format($value['harga_satuan']) ."</td>";
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



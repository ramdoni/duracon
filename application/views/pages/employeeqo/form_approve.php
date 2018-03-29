  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Approve Quotation</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="form-quotation" method="post" class="form-horizontal form-label-left">
          <input type="hidden" name="Employee_po[proccess]" value="0" />
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_po">No Quotation <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_po" readonly="true" value="<?=(isset($data['no_po']) ? $data['no_po'] : '')?>" name="Employee_po[no_po]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Sales <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control sales_id" disabled="true" name="Employee_po[sales_id]">
                <option value=""> - Sales - </option>
                <?php
                $sales = $this->db->get_where('user', ['user_group_id' => 3]);
                foreach($sales->result_array() as $i):
                  $selected = '';

                  if(isset($data['sales_id']))
                  {
                    if($data['sales_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option value="<?=$i['id']?>" <?=$selected?> data-code="<?=$i['sales_code']?>"><?=$i['name']?></option>
              <?php
                endforeach;
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Marketing <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control marketing_id" disabled="true" name="Employee_po[marketing_id]">
                <option value=""> - Marketing - </option>
                <?php
                //$marketing = $this->db->get('marketing');
                $marketing = $this->db->get_where('user', ['user_group_id' => 4]);

                foreach($marketing->result_array() as $i):
                  $selected = '';

                  if(isset($data['marketing_id']))
                  {
                    if($data['marketing_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option value="<?=$i['id']?>" <?=$selected?>><?=$i['name']?></option>
              <?php
                endforeach;
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sales">Customer / PT <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control"  disabled="true" name="Employee_po[customer_id]">
                <option value=""> - Customer - </option>
                <?php
                $customer = $this->db->get('customer');

                foreach($customer->result_array() as $i):
                  $selected = '';

                  if(isset($data['customer_id']))
                  {
                    if($data['customer_id'] == $i['id'])
                    {
                      $selected = ' selected';
                    }
                  }

                  if($i['tipe_customer'] == 'Perusahaan')
                  {
                    $nama_customer = (!empty($i['name']) ? $i['name'].' - ' : '') .$i['company'];
                    
                    $nama_customer = ($i['name'] == $i['company'] ? $i['company'] : $nama_customer);
                  }
                  else
                    $nama_customer = $i['name']; 
              ?>
                <option value="<?=$i['id']?>" <?=$selected?>><?=$nama_customer?></option>
              <?php
                endforeach;
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proyek">Proyek <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="proyek"  disabled="true" value="<?=(isset($data['proyek']) ? $data['proyek'] : '')?>" name="Employee_po[proyek]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_kirim">Area Kirim </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[area_id]" id="area_id" disabled="true" class="form-control">
                <option value=""> - Area Kirim - </option>
                <?php 
                  $area = $this->db->get('area')->result_array();
                  foreach($area as $i):

                    $selected = '';
                    if(isset($data['area_id']))
                    {
                      if($data['area_id'] == $i['id'])
                      {
                        $selected = ' selected';
                      }
                    }
                ?>
                <option <?=$selected?> value="<?=$i['id']?>"><?=$i['area']?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sistem_pembayaran">Sistem Pembayaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[sistem_pembayaran]" disabled="true" id="sistem_pembayaran" class="form-control">
                <option value=""> - Pembayaran - </option>
                <?php 
                  foreach(['Cash', 'Kredit', 'SCF'] as $i):

                    $selected = '';
                    if(isset($data['sistem_pembayaran']))
                    {
                      if($data['sistem_pembayaran'] == $i)
                      {
                        $selected = ' selected';
                      }
                    }
                ?>
                <option <?=$selected?>><?=$i?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tanggal <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="tanggal" readonly="" value="<?=(isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d'))?>"  required="required" name="Employee_po[tanggal]" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Penurunan Barang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[penurunan_barang]" id="select-penurunan-barang" disabled="true" class="form-control" required>
                <option value=""> - Penurunan Barang - </option>
                <?php 
                $setting = ['Setting', 'Tidak Setting'];
                foreach($setting as $i):

                  $selected = '';
                  if(isset($data['penurunan_barang'])){
                    if($data['penurunan_barang'] == $i)
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option <?=$selected?>><?=$i?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal">Tipe Pekerjaan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="Employee_po[tipe_pekerjaan]" disabled="true" class="form-control" required>
                <option value=""> - Tipe Pekerjaan - </option>
                <?php 
                $setting = ['Education','Office','Apartement','Warehouse','Factory','Power Plant','Oil dan Gas','Toll/Road','Railway','Tunnel','Bridge','Dam/Channel','Drainage','Irrigation','Road','Rail Way','Airport','Ship Harbour','Real Estate','Ruko','Shopping Building','Hotel','Hospital','Cemetery'];
                foreach($setting as $i):

                  $selected = '';
                  if(isset($data['tipe_pekerjaan'])){
                    if($data['tipe_pekerjaan'] == $i)
                    {
                      $selected = ' selected';
                    }
                  }
                ?>
                <option <?=$selected?>><?=$i?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div>
            <div class="x_panel">
              <div class="x_title">
                <h2>Products</h2>
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
                      <th>Price List</th>
                      <th>Disc</th>
                      <th>Harga Satuan</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody class="add-table-product">
                    <?php 
                    $total = 0;
                      if(isset($data['id'])){

                        $products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['id']])->result_array();
                        
                        foreach($products as $key =>  $i):

                          $harga_diskon = $i['harga_satuan'] * $i['disc_ppn'] / 100;
                          $harga_diskon = $i['harga_satuan'] - $harga_diskon;
                    ?>
                        <tr class="tr-<?=$i['id']?> list-product">
                          <td><?=($key+1)?>
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][product_id]" value="<?=$i['product_id']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][kode]" value="<?=$i['kode']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][uraian]" value="<?=$i['uraian']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][vol]" class="input-hidden-vol" value="<?=$i['vol']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][satuan]" value="<?=$i['satuan']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][harga_satuan]" class="input-hidden-harga" value="<?=$i['harga_satuan']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][disc_ppn]" class="input-hidden-disc_ppn" value="<?=$i['disc_ppn']?>" />
                            <input type="hidden" name="ProductFormTemp[<?=$key?>][weight]" class="input-hidden-weight" value="<?=$i['weight']?>" />
                          </td>
                          <td class="kode"><?=$i['kode']?></td>
                          <td class="uraian"><?=$i['uraian']?></td>
                          <td class="vol">
                            <a href="#" class="editable-vol" data-type="text" data-url="<?=site_url()?>/ajax/savequotationproductvol" data-pk="<?=$i['id']?>" ><?=($i['vol'])?></a>
                          </td>
                          <td class="satuan"><?=$i['satuan']?></td>
                          <td class="harga_satuan">Rp. <?=number_format($i['harga_satuan'])?></td>
                          <td class="disc_ppn">
                            <a href="#" class="editable-disc" data-type="text" data-url="<?=site_url()?>/ajax/savequotationproductvol" data-pk="<?=$i['id']?>" ><?=($i['disc_ppn'])?></a>%</td>
                          <td class="disc_harga_satuan">Rp. <?=number_format($harga_diskon)?></td>
                          <td class="subtotal">Rp. <?=number_format($harga_diskon*$i['vol'])?></td>
                        </tr>
                    <?php
                        $total += $harga_diskon*$i['vol'];
                        endforeach;
                      }
                    ?>
                  </tbody>
                  <tfoot class="footer-date-total">
                    <tr>
                      <th colspan="8" style="text-align: right;">Total</th>
                      <th colspan="2" class="total_">Rp. <?=number_format($total)?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div>
              <a onclick="history.back()" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
              <span class="btn btn-success btn-proccess btn-sm">Approve Quotation <i class="fa fa-arrow-right"></i></span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(".btn-proccess").click(function(){

    _confirm('Approve Quotation ini lewati semua proses approval dari AR dan Manager?', '<?=site_url('employeeqo/submitapprove/'. $data['id'])?>')

  });
</script>

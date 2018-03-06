<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Izin Kirim</h2> &nbsp;
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="11">
                  <form metho="get" action="" class="form-horizontal form-label-left filter-form">
                    <label>Filter </label>
                      <select class="form-control" name="customer_id">
                        <option value=""> - All Customer - </option>
                        <?php 
                          $customer = $this->db->get_where('customer', ['active' => 1])->result_array();
                          foreach($customer as $i) { 
                            if($i['tipe_customer'] == 'Perorangan')
                              $name = $i['name'];
                            else
                              $name = $i['company'];

                            $selected = "";

                            if(isset($_GET['customer_id']) and !empty($_GET['customer_id']) and $_GET['customer_id'] == $i['id'])
                            {
                              $selected = " selected";
                            }

                        ?>
                            <option value="<?=$i['id']?>" <?=$selected?>><?=$name?></option>
                        <?php } ?>
                      </select>
                      <select class="form-control" name="sales_order_id">
                        <option value=""> - All Sales Order - </option>
                          <?php
                            $so = $this->db->get_where('sales_order', ['position' => 5])->result_array();

                            if(isset($_GET['customer_id']) and !empty($_GET['customer_id']))
                              $so = $this->db->query("SELECT so.* FROM sales_order so inner join quotation_order qo on qo.id=so.quotation_order_id WHERE qo.customer_id={$_GET['customer_id']} and so.position=5")->result_array();
                          ?>
                          <?php foreach($so as $i):?>
                            <?php
                              $selected = "";

                              if(isset($_GET['sales_order_id']) and !empty($_GET['sales_order_id']) and $_GET['sales_order_id'] == $i['id'])
                              {
                                $selected = " selected";
                              } 
                            ?>
                            <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_so']?></option>
                          <?php endforeach;?>
                      </select>
                      <select class="form-control" name="surat_izin_kirim_id">
                        <option value=""> - All SIK - </option>
                        <?php $sik = $this->db->get('surat_izin_kirim')->result_array(); ?>
                        <?php 
                          if(isset($_GET['sales_order_id']) and !empty($_GET['sales_order_id']))
                            $sik = $this->db->get_where('surat_izin_kirim',['sales_order_id' => $_GET['sales_order_id']])->result_array();
                        ?>
                        <?php foreach($sik as $i):?>
                          <option value="<?=$i['id']?>"><?=$i['no_sik']?></option>
                        <?php endforeach; ?>
                      </select>
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                  </form>
                </th>
              </tr>
              <tr class="headings">
                <th>No</th>
                <th class="column-title">Customer</th>
                <th class="column-title">No SO</th>
                <th class="column-title">No PO</th>
                <th class="column-title">No. SIK</th>
                <th class="column-title">Proyek</th>
                <th class="column-title">Sales</th>
                <th class="column-title">Alamat Pengiriman</th>
                <th class="column-title">Nominal SIK</th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"></th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data as  $key => $item):?>
                      <tr>
                        <td><?=($key+1)?></td>
                        <td>
                          <?php 
                            if($item['tipe_customer'] == 'Perorangan')
                              echo $item['name'];
                            else
                              echo $item['company'];
                          ?>  
                        </td>
                        <td><?=$item['no_so']?></td>
                        <td><?=$item['no_po']?></td>
                        <td><?=$item['no_sik']?></td>
                        <td><?=$item['proyek']?></td>
                        <td><?=$item['sales']?></td>
                        <td><?=$item['alamat_pengiriman']?></td>
                        <th>Rp. <?=number_format(total_nominal_sik($item['id']))?></th>
                        <td><?=position_sik($item['position'])?></td>
                        <td>

                          <?php if($this->session->userdata('access_id') == 10): ?>
                            <?php if($item['position'] == 1):?>
                            <a href="<?=site_url("arsik/proccess/{$item['id']}")?>" title="Proccess" class="btn btn-success btn-xs">Proses <i class="fa fa-arrow-right"></i></a>
                            <?php endif; ?>
                          <?php endif; ?>                            

                          <span onclick="detail_sik(<?=$item['id']?>,'<?=$item['no_sik']?>')" target="_blank" class="btn btn-default btn-xs" title="Detail Surat Izin Kirim"><i class="fa fa-search-plus"></i> Detail</span>
                        </td>
                      </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
       </div>        
      </div>
    </div>
</div>
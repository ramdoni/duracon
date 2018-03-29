 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Jalan</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="6">
                  <form method="get" action="" class="form-horizontal form-label-left filter-form">
                    <select class="form-control" name="status">
                          <option value=""> - Status Surat Jalan</option>
                          <option value="proses" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $_GET['status'] == 'proses'){ echo ' selected';};?>> On Progress </option>
                          <option value="selesai" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $_GET['status'] == 'lunas'){ echo ' selected';};?>> Selesai </option>
                      </select>
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
                      <select class="form-control no_so" name="invoice_id">
                        <option value=""> - All Surat Jalan - </option>
                          <?php $invoice = $this->db->get('surat_jalan')->result_array(); ?>
                          <?php 
                            if(isset($_GET['surat_jalan_id']) and $_GET['surat_jalan_id'] != '')
                            {
                              $invoice = $this->db->get_where('surat_jalan', ['surat_jalan_id' => $_GET['surat_jalan_id']])->result_array();
                            }
                          ?>

                          <?php foreach($invoice as $i):?>
                            <?php
                              $selected = "";

                              if(isset($_GET['surat_jalan_id']) and !empty($_GET['surat_jalan_id']) and $_GET['surat_jalan_id'] == $i['id'])
                              {
                                $selected = " selected";
                              } 
                            ?>
                            <option value="<?=$i['id']?>" <?=$selected?>><?=$i['no_surat_jalan']?></option>
                          <?php endforeach;?>
                      </select>
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                  </form>
                </th>
              </tr>
              <tr>
                <th>No</th>
                <th>Customer</th>
                <th>No SO</th>
                <th>No Surat Jalan</th>
                <th>Masa Berlaku</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?php 
                foreach($data as $key => $item)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".(nama_customer($item['customer_id']))."</td>";
                  echo "<td>".($item['no_so'])."</td>";
                  echo "<td>".($item['no_surat_jalan'])."</td>".

                      "<td>". $item['date'] ."</td>".
                      "<td>". status_spm($item['status']).'<br />'
                      ;
                ?>  
                  </td> 
                <?php 
                  echo "</tr>";
                }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

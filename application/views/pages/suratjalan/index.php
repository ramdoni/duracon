 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Surat Jalan</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form method="post" action="" class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-3" for="area">Filter Range Tanggal
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" required="required" name="tanggal"  value="<?=(isset($tanggal) ? $tanggal : '')?>" class="form-control col-md-7 col-xs-12 date-range2">
              </div>
              <button type="submit" class="btn btn-sm btn-success"> Filter </button>
            </div>
        </form>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>No Surat Jalan</th>
                <th>Masa Berlaku</th>
                <th>Status</th>
                <th>Catatan</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="content-products">
            <?php 
                foreach($data as $key => $item)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".($item['no_surat_jalan'])."</td>".

                      "<td>". $item['date'] ."</td>".
                      "<td>". status_spm($item['status']) ."</td>".
                      "<td>{$item['catatan']}</td>"
                      ;
                ?>
                  <td>
                    <a href="<?=site_url()?>suratjalan/detail/<?=$item['id']?>" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i> Detail</a>
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

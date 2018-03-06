<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Import Products</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="close-link" href="<?=site_url('products')?>"><i class="fa fa-close"></i></a></li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br>
      <form id="demo-form2" method="post" enctype="multipart/form-data"  class="form-horizontal form-label-left">
        <input type="hidden" name="status" value="1" />
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">File ( .xls ) <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" id="first-name" required="required" name="file" class="form-control col-md-7 col-xs-12">
            <p>sample excel <a href="<?=base_url('assets/contoh-import-products.xls')?>" class="link"> <i class="fa fa-cloud-download"></i> Download</a></p>
          </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <a href="<?=site_url('products')?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Cancel</a>
            <button type="submit" class="btn btn-success" >Import <i class="fa fa-arrow-right"></i></button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
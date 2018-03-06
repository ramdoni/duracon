
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>User Detail</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
          <div class="profile_img">
            <div id="crop-avatar">
              <!-- Current avatar -->
              <?php if(empty($profile['foto'])){?>
              <img src="<?=base_url()?>assets/images/people.png" alt="...">
              <?php } else { ?>
              <img src="<?=base_url()?>upload/photo/<?=$profile['id']?>/<?=$profile['foto']?>" style="width: 100%;">
              <?php } ?>
            </div>
          </div>
          <a href="#modal-foto" class="btn btn-xs btn-default" data-toggle="modal"> <i class="fa fa-image"></i> Ganti Foto</a>
          <h3><?=$profile['name']?></h3>

          <ul class="list-unstyled user_data">
            <li><i class="fa fa-briefcase user-profile-icon"></i> <?=$profile['user_group']?>
            </li>
          </ul>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">

          <div class="profile_title">
            <div class="col-md-6">
              <h2>User Profile</h2>
            </div>
          </div>
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Data Pribadi</a>
              </li>
              <!-- <li role="presentation"><a href="#tab_content_password" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Rubah Password</a>
              </li> -->
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                <form id="demo-form2" class="form-horizontal form-label-left" method="POST">
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Username Login</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" readonly="true" class="form-control col-md-7 col-xs-12" value="<?=$profile['username']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" readonly="true" class="form-control col-md-7 col-xs-12" value="<?=$profile['user_group']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="User[name]" value="<?=$profile['name']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" class="form-control col-md-7 col-xs-12" name="User[email]" value="<?=$profile['email']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">No Telepon</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="User[phone]" value="<?=$profile['phone']?>">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    </div>
                  </form>
              </div>

              <div role="tabpanel" class="tab-pane fade" id="tab_content_password" aria-labelledby="home-tab">
                <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="<?=site_url()?>site/changepassword">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Password Sebelumnya</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="password" class="form-control col-md-7 col-xs-12" required name="User[password_lama]">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Password Baru</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="password" class="form-control col-md-7 col-xs-12" required name="User[password_baru]">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketik Ulang Password Baru</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="password" class="form-control col-md-7 col-xs-12" required name="User[password_baru2]">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan Password Baru</button>
                    </div>
                  </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
  <div class="modal fade" id="modal-foto" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ganti Foto Profil</h4>
        </div>
        <div class="modal-body">
          
          <form id="modal-product" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=site_url()?>site/changephoto">
            <input type="hidden" name="id" value="<?=$profile['id']?>" />
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume">Pilih Foto : </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" required="required" name="foto" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="<?=site_url('products')?>" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</a>
              <button type="submit" class="btn btn-success btn-add-modal" ><i class="fa fa-save"></i> Ganti Foto</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
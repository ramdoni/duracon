<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$this->session->userdata('group');?> - <?=$this->session->userdata('name');?> - <?=$this->session->userdata('meta_title');?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <!-- <link href="<?=base_url()?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet"> -->
    
    <!-- bootstrap-progressbar -->
    <link href="<?=base_url()?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <!--
    <link href="<?=base_url()?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  -->
    <!-- bootstrap-daterangepicker -->
    <link href="<?=base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=base_url()?>assets/build/css/custom.min.css?range=<?=date('His')?>" rel="stylesheet">

    <!--<link href="<?=base_url()?>assets/css/custom-2.css" rel="stylesheet">-->

    <!-- jQuery -->
    <script src="<?=base_url()?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url()?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- bootstrap-datetimepicker -->
    <link href="<?=base_url()?>assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">


    <link href="<?=base_url()?>assets/jqueryui-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="<?=base_url()?>assets/jqueryui-editable/js/bootstrap-editable.min.js"></script>

    <!-- Datatables -->
    <link href="<?=base_url()?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="<?=base_url()?>assets/daterange/moment.js"></script>

    <link href="<?=base_url()?>assets/daterange2/daterangepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?=base_url()?>assets/daterange2/jquery.daterangepicker.min.js"></script>
    <script type="text/javascript">
      var site_url = '<?=site_url()?>';
      var base_url = '<?=base_url()?>';
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116069041-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-116069041-1');
    </script>


  </head>
<?php 
  $controller = $this->uri->segment('1');
  $action = $this->uri->segment('2');

  //if($controller =='pabrikjadwalproduksi' and $action == 'lembarkerja'){
    echo '<body class="nav-sm">';
  //}else{
?>
  <!-- <body class="nav-md"> -->
<?php // } ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; background: white; height: 66px;">
              <a href="<?=site_url()?>" class="site_title" style="padding: 5px 10px 20px 10px;">
                <!--<span><?=$this->session->userdata('meta_title');?></span>-->
                <img src="<?=base_url()?>assets/images/logo.png" style="width: 100%;" />
              </a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <?php 
                $foto = $this->session->userdata('foto');
                if(empty($foto)){?>
                <img src="<?=base_url()?>assets/images/people.png" alt="..." class="img-circle profile_img">
                <?php } else { ?>
                <img src="<?=base_url()?>upload/photo/<?=$this->session->userdata('user_id')?>/<?=$this->session->userdata('foto')?>" class="img-circle profile_img">
                <?php } ?>
              </div>
              <div class="profile_info">
                <span><?=$this->session->userdata('group');?>,</span>
                <h2><?=$this->session->userdata('name');?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <?php $this->load->view('layouts/menu');?>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a href="<?=site_url('site/setting')?>" data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=site_url('user/signout')?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu" style="height: 67px;">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <?php 
                    if(empty($foto)){?>
                    <img src="<?=base_url()?>assets/images/people.png" alt="...">
                    <?php } else { ?>
                    <img src="<?=base_url()?>upload/photo/<?=$this->session->userdata('user_id')?>/<?=$this->session->userdata('foto')?>" >
                    <?php } ?>
                  <?=$this->session->userdata('name');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!--<li><a href="<?=site_url('user/profile')?>"> Profile</a></li>-->
                    <li>
                      <a href="<?=site_url('site/setting')?>">
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="<?=site_url('user/signout')?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
        <?php 
          $messages = $this->session->flashdata('messages');
          if(!empty($messages)):
        ?>
            <div class="x_content bs-example-popovers">
              <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <?=$messages?>
              </div>
            </div>
        <?php endif; ?>

        <?php 
          $error = $this->session->flashdata('error');
          if(!empty($error)):
        ?>
            <div class="x_content bs-example-popovers">
              <div class="alert alert-error alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <?=$error?>
              </div>
            </div>
        <?php endif; ?>
        
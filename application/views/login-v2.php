<?php 
  $config = $this->db->get_where('setting',['id' =>  1])->row_array();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Duracon - Login - <?=$config['meta_title']?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?=base_url()?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=base_url()?>assets/build/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
      button.submit, button.submit:hover, button.submit:focus {
        padding-left: 0;
        background: transparent;
        color: rgb(55, 155, 159);
        border: 1px solid white;
        cursor: pointer;
      }
      .login_wrapper {
        margin-left: 6%;
        margin-top: 12%;
      }
      .login_wrapper h2 {
        text-align: left; color: rgb(55, 155, 159);
        font-size: 28px;
      }
      .copyright {
        position: absolute;
        right: 20px;
        bottom: 0;
      }
      .msg-error {
        text-align: left;
        color: red;
      }
      .col-md-3 {
        background: rgb(55, 155, 159); 
        height: 100vh;
        padding: 0;
        text-align: center;
      }
      .col-md-3 img {
        margin-top: 70%;
        background: white;
      }
    </style>
  </head>
  <body class="login"  style="background: white;">
    
    <div class="col-md-3">
      <img src="<?=base_url()?>assets/login/2.jpg" />
    </div>
    <div class="col-md-9">
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?=form_open('login', ['autocomplete' => 'off'])?>
            <?php echo validation_errors(); ?>
              <h2>Duracon System</h2>
                <br />
              <?php
                if(isset($incorrect_login)):
                    echo '<div class="msg-error"><p>Incorrect username or password , try again.</p></div>';
                endif;
                ?>
              <div style="text-align: left;">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="Username" name="username"  required />
              </div>
              <div style="text-align: left;">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password"  autocomplete="off" required />
              </div>
              <div style="text-align: left;">
                <button class="btn submit" title="Login System" style=""> <i class="fa fa-arrow-circle-o-right" style="font-size: 16px;" aria-hidden="true"></i> sign in</button>
              </div>
              <div class="clearfix"></div>
            </form>
          </section>
          <br style="clear: both;" />
        </div>
      </div>

    </div>
    <p class="copyright"><?=$config['meta_description']?></p>
  </body>
</html>
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
  </head>

  <body class="login"  style="background: white;">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
              <img src="<?=base_url()?>/assets/images/logo.png" style="width: 100%;" />

          <section class="login_content">
            <?=form_open('login')?>
            <?php echo validation_errors(); ?>
              <h3>Login System</h5>
                <br />
              <?php
                if(isset($incorrect_login)):
                    echo '<div class="msg-error"><p>Incorrect username or password , try again.</p></div>';
                endif;
                ?>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required />
              </div>
              <div>
                <button class="btn btn-default submit">Log in</button>
                <a class="forget_login" href="#signup">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><?=$config['meta_title']?></h1>
                  <p><?=$config['meta_description']?></p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="forget_login" class="animate form registration_form">
          <section class="login_content">
            <form method="post">
              <h1>Forget Password</h1>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <button class="btn btn-default submit">Submit</button>
              </div>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><?=$config['meta_title']?></h1>
                  <p><?=$config['meta_description']?></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
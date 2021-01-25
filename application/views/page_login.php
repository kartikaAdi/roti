<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MDR Information Organizer">
    <meta name="author" content="Aldila">

 <title>Roti Warna Kartika</title>  

    
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/font-awesome.min.css">
  
    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/admin/css/login.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/skins/_all-skins.min.css">	
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/iCheck/square/blue.css">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="shortcut icon" href="<?php echo base_url();?>/assets/admin/img/mio_ver2.ico">
</head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?= site_url();?>">
		<img src="<?= base_url();?>assets/admin/img/roti.jpg" width=200px>
		<p><b> Warna Roti </b></p>
		</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to continue</p>
        <form action="<?= site_url();?>login/logon" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="username" required>
            <span class="fa fa-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <span class="fa fa-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="#">I forgot my password</a>
		<?php
		if(isset($errVar))
		{
		?>
		<p>
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Cannot sign in ! </h4>
                    Check your Username or Password.
                  </div>
		</p>
		<?php
		}
		?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

		<!-- jQuery 2.1.4 -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/admin/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>


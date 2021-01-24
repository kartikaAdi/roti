
<!DOCTYPE html>
<html lang="en">


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Tes">
    <title>Admin</title>

	<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap.css">  
	<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/datepicker.css"> 
    <link href="<?php echo base_url();?>assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/admin/DataTables-1.10.10/media/css/jquery.dataTables.css" rel="stylesheet">
	 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/skins/_all-skins.min.css">
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/select2/select2.min.css">
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bootstrap-fileinput-master/css/fileinput.css">
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/fullcalendar.print.css" media="print">
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/fileinput/css/fileinput.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/summernote/dist/summernote.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/iconpicker/dist/css/fontawesome-iconpicker.css">
	
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/morris/morris.css">
	
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/img/mio_ver2.ico">


  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="<?= site_url();?>" class="logo">
		
          <span class="logo-mini"><b>EXP</b></span>
		  
          <span class="logo-lg"><b>Admin</b></span>
        </a>

		
        <nav class="navbar navbar-static-top" role="navigation">
		
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
		  
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
			
			
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= base_url();?>assets/admin/img/avatar/thumb/<?= $this->session->userdata('picUser');?>"  class="user-image" alt="User Image">
                  <span class="hidden-xs">
                      <?= $this->session->userdata('name');?>
					  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= base_url();?>assets/admin/img/avatar/thumb/<?= $this->session->userdata('picUser');?>"  class="img-circle" alt="User Image">
                    <p>
                      <?= $this->session->userdata('name');?>
                    </p>
                  </li>
				  
                  <li class="user-footer">
                    <div class="col-md-6">
                      <a href="#" class="btn btn-success btn-flat btn-block">Profile</a>
                    </div>
                    <div class="col-md-6">
                      <a href="<?= site_url();?>login/logout" class="btn btn-danger btn-flat  btn-block">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
			  
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>

        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
		  
            <li class="header">MAIN MENU</li>
			
            <li><a href="<?= site_url();?>admin"><i class="fa fa-user text-aqua"></i> <span>Profile</span></a></li>
			
			<!-- menu -->
			<li class="treeview">
				<a href="#"><i class="fa fa-book text-red"></i><span>Data Master</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">		
					<li><a href="<?= site_url();?>User"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Data User</span></a></li> 
					<li><a href="<?= site_url();?>Bahan"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Data Bahan</span></a></li> 
					<li><a href="<?= site_url();?>kariyawan"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Data Kariyawan</span></a></li>
					<li><a href="<?= site_url();?>Overheadtetap"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Data Overhead Tetap</span></a></li>
					<li><a href="<?= site_url();?>Overheadvariabel"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Data Overhead Variabel</span></a></li>
				</ul>
			</li>
			<li><a href="<?= site_url();?>produksi"><i class="fa fa-cubes text-red"></i> <span>Produksi</span></a></li>
			<!-- menu -->
		   <!-- <li class="treeview">
				<a href="#"><i class="fa fa-book text-red"></i><span>Produksi</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">	
					<li><a href="<?= site_url();?>produksi"><i class="fa fa-user text-yellow"></i> <span>Data Produksi</span></a></li>
								</ul>
			</li> -->
			
			<!-- menu -->
			<li class="treeview">
				<a href="#"><i class="fa fa-exchange text-red"></i><span>Proses Produksi</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">		
					<li><a href="<?= site_url();?>bbb"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Penggunaan BBB</span></a></li> 
					<li><a href="<?= site_url();?>btk"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Penggunaan BTK</span></a></li> 
					<li><a href="<?= site_url();?>bopt"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Penggunaan BOPt</span></a></li>
					<li><a href="<?= site_url();?>bopv"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Penggunaan BOPv</span></a></li>
				</ul>
			</li>
           
			<!-- menu -->
		   <li class="treeview">
				<a href="#"><i class="fa fa-dollar text-red"></i><span>Harga pokok </span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">	
					<li><a href="<?= site_url();?>hpp"><i class="fa fa-dot-circle-o text-yellow"></i> <span>HPP</span></a></li> 
					<li><a href="<?= site_url();?>hps"><i class="fa fa-dot-circle-o text-yellow"></i> <span>HPS</span></a></li>				
				</ul>
			</li>
			
			<!-- menu -->
		   <li class="treeview">
				<a href="#"><i class="fa fa-calculator text-red"></i><span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">	
				<li><a href="<?= site_url();?>penjualan"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Transaksi Penjualan</span></a></li>
				</ul>
			</li>
		   
		   <!-- menu -->
		   <li class="treeview">
				<a href="#"><i class="fa fa-bar-chart text-red"></i><span>Laporan</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
				<li><a href="<?= site_url();?>laporan_laba_rugi"><i class="fa fa-dot-circle-o text-yellow"></i> <span>Laporan Laba/Rugi Kotor</span></a></li>
				</ul>
			</li>
			
            <!-- <li class="header">SHORTCUT</li>
			
				<li>
					<a href="<?= site_url();?>Users"><i class="fa fa-user text-yellow"></i> <span>user</span></a>
				</li>       -->
			
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
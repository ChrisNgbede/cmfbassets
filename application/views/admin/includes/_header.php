<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->general_settings['application_name']; ?> - <?= isset($title)? $title.' - ' : '' ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/dist/css/adminlte.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/dist/css/modern.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/summernote/summernote-bs4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/morris/morris.css">
  <!-- jvectormap -->
   <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" type="text/css" type="text/css" href="<?= base_url() ?>assets/plugins/select2/css/select2.css">
   <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet"  type="text/css" href="<?= base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

 
  <!-- DropZone -->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/dropzone/dropzone.css">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().getSettings()->favicon;?>">
  <!-- Google Font: Source Sans Pro -->
  <!-- jQuery -->
  <script src="<?= base_url()?>assets/plugins/jquery/jquery.min.js"></script>
 


</head>

<body class="hold-transition sidebar-mini <?=  (isset($bg_cover)) ? 'bg-cover' : '' ?>">

<!-- Main Wrapper Start -->
<div class="wrapper">

  <!-- Navbar -->

  <?php if(!isset($navbar)): ?>

  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
     
    </ul>
    <!-- SEARCH FORM -->
   <!--  <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     <!--  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
      <?php 
        $user = getloggedinuserdata(); 
        if($user):
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link user-dropdown-toggle" data-toggle="dropdown" href="#">
          <div class="user-avatar-circle">
            <?= strtoupper(substr($user->firstname ?? 'A', 0, 1).substr($user->lastname ?? 'D', 0, 1)) ?>
          </div>
          <span class="user-name-label d-none d-md-inline">
            <?= $user->firstname ?>
          </span>
          <i class="fas fa-angle-down ml-1" style="font-size: 0.7rem; opacity: 0.5;"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-user-menu">
          <div class="dropdown-header text-left">
            <h6 class="mb-0 font-weight-bold"><?= $user->firstname ?> <?= $user->lastname ?></h6>
            <small class="text-muted"><?= $user->email ?></small>
          </div>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('admin/profile') ?>" class="dropdown-user-item">
            <i class="fas fa-user-circle"></i> My Profile
          </a>
          <a href="<?= base_url('admin/profile/change_pwd') ?>" class="dropdown-user-item">
            <i class="fas fa-lock text-warning"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('admin/auth/logout') ?>" class="dropdown-user-item text-danger">
            <i class="fas fa-power-off"></i> Logout
          </a>
        </div>
      </li>
      <?php else: ?>
      <li class="nav-item">
          <a href="<?= base_url('admin/auth/logout') ?>" class="btn btn-danger mr-2"><i class="fa fa-power-off"></i></a>
      </li>
      <?php endif; ?>
    </ul>
  </nav>

  <?php endif; ?>

  <!-- /.navbar -->


  <!-- Sideabr -->

  <?php if(!isset($sidebar)): ?>

  <?php $this->load->view('admin/includes/_sidebar'); ?>

  <?php endif; ?>

  <!-- / .Sideabr -->

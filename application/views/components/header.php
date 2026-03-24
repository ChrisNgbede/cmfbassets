<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= isset($title)? $title.' - ' : '' ?> <?= $this->general_settings['application_name']; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/adminlte.css">

  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css">

 
  <!-- DropZone -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/dropzone/dropzone.css">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().getSettings()->favicon;?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- jQuery -->
  <script src="<?= base_url()?>assets/plugins/jquery/jquery.min.js"></script>


</head>

<body class="hold-transition sidebar-mini <?=  (isset($bg_cover)) ? 'bg-cover' : '' ?>">

<!-- Main Wrapper Start -->
<div class="wrapper">

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= isset($title)? $title.' - ' : '' ?> <?= $this->general_settings['application_name']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url().getSettings()->favicon; ?>">
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/adminlte.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/modern.css">
  <script src="<?= base_url()?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body class="auth-wrapper">
<div class="auth-card <?= isset($auth_card_lg) ? 'auth-card-lg' : '' ?>">
  <div class="auth-card-body">
    <div class="auth-logo">
      <img src="<?= base_url($this->general_settings['favicon']); ?>" alt="Logo">
      <h2><?= $this->general_settings['application_name']; ?></h2>
    </div>

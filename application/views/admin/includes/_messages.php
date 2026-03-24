<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!--print error messages-->
    <?php if($this->session->flashdata('errors')): ?>
      <div class="alert alert-danger">
        <?= $this->session->flashdata('errors')?>
      </div>
    <?php endif; ?>

    <!--print custom error message-->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="m-b-15">
            <div class="alert alert-danger alet-dismissable">
                    <?php echo $this->session->flashdata('error'); ?>
            </div>
        </div>
    <?php endif; ?>

     <?php if ($this->session->flashdata('warning')): ?>
        <div class="m-b-15">
            <div class="alert alert-warning alet-dismissable">
                    <?php echo $this->session->flashdata('warning'); ?>
            </div>
        </div>
    <?php endif; ?>

     <?php if ($this->session->flashdata('primary')): ?>
        <div class="m-b-15">
            <div class="alert alert-primary alet-dismissable">
                    <?php echo $this->session->flashdata('primary'); ?>
            </div>
        </div>
    <?php endif; ?>

    <!--print custom success message-->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="m-b-15">
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        </div>
    <?php endif; ?>
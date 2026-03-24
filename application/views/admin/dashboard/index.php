<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0 text-dark">Welcome,
            <?php echo $this->session->userdata('username')?>
          </h5>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">
                <?= trans('home')?>
              </a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Welcome Card -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4">
               <div class="row align-items-center">
                 <div class="col-md-8">
                   <h2 class="font-weight-bold mb-2">Hello, <?php echo $this->session->userdata('username')?>!</h2>
                   <p class="mb-0 opacity-8">Management console is ready for your operations. Use the sidebar to navigate through available modules.</p>
                 </div>
                 <div class="col-md-4 text-right d-none d-md-block">
                   <i class="fas fa-user-shield fa-4x opacity-2"></i>
                 </div>
               </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Compact Stat Cards -->
      <div class="row">
        <?php if ($this->rbac->check_module_permission('asset')): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="stat-card bg-success-soft">
            <div class="stat-content">
              <h3 class="mb-1"><?php echo countwhere('assets'); ?></h3>
              <p class="mb-0 font-weight-bold opacity-8">Total Assets</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-boxes fa-2x"></i>
            </div>
            <a href="<?php echo base_url('asset_list')?>" class="stat-footer mt-3 d-block">
              View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($this->rbac->check_module_permission('asset')): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="stat-card bg-warning-soft">
            <div class="stat-content">
              <h3 class="mb-1"><?php echo countwhere('collaterals')?></h3>
              <p class="mb-0 font-weight-bold opacity-8">Total Collaterals</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-shield-alt fa-2x"></i>
            </div>
            <a href="<?php echo base_url('admin/asset/listcollaterals')?>" class="stat-footer mt-3 d-block">
              View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($this->rbac->check_module_permission('staff')): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="stat-card bg-info-soft">
            <div class="stat-content">
              <h3 class="mb-1"><?php echo countwhere('staff')?></h3>
              <p class="mb-0 font-weight-bold opacity-8">Total Staff</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-users fa-2x"></i>
            </div>
            <a href="<?php echo base_url('admin/staff/index')?>" class="stat-footer mt-3 d-block">
              View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </section>
</div>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="mod-card">
        <div class="card-header border-0 bg-transparent pt-4 px-4">
          <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title font-weight-bold"> 
                <i class="fas fa-user-edit text-primary mr-2"></i>
                <?= trans('profile') ?> 
              </h3>
              <a href="<?= base_url('admin/profile/change_pwd'); ?>" class="btn btn-outline-primary rounded-pill shadow-sm">
                <i class="fas fa-key mr-1"></i> <?= trans('change_password') ?>
              </a>
          </div>
        </div>
        <div class="card-body px-4 pb-4">   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open(base_url('admin/profile'), 'class="form-horizontal"' )?> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username" class="font-weight-600"><?= trans('username') ?></label>
                    <input type="text" name="username" value="<?= $admin['username']; ?>" class="form-control rounded-pill" id="username">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="font-weight-600"><?= trans('email') ?></label>
                    <input type="email" name="email" value="<?= $admin['email']; ?>" class="form-control rounded-pill" id="email">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstname" class="font-weight-600"><?= trans('firstname') ?></label>
                    <input type="text" name="firstname" value="<?= $admin['firstname']; ?>" class="form-control rounded-pill" id="firstname">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastname" class="font-weight-600"><?= trans('lastname') ?></label>
                    <input type="text" name="lastname" value="<?= $admin['lastname']; ?>" class="form-control rounded-pill" id="lastname">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone" class="font-weight-600"><?= trans('phone') ?></label>
                    <input type="number" name="phone" value="<?= $admin['phone']; ?>" class="form-control rounded-pill" id="phone">
                  </div>
                </div>
              </div>

              <div class="mt-4 text-right">
                  <button type="submit" name="submit" value="submit" class="btn btn-primary btn-lg shadow-sm px-5 rounded-pill">
                    <i class="fas fa-save mr-2"></i> <?= trans('update_profile') ?>
                  </button>
              </div>
            <?php echo form_close(); ?>
        </div>
      </div>
    </section>
  </div> 
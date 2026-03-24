  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="mod-card">
        <div class="card-header border-0 bg-transparent pt-4 px-4">
          <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title text-dark"> 
                <i class="fas fa-edit text-primary mr-2"></i>
                <?= $title ?> 
              </h3>
              <a href="<?= base_url('admin/admin_roles/module'); ?>" class="btn btn-outline-secondary rounded-pill shadow-sm">
                <i class="fas fa-list mr-1"></i> <?= trans('module_list') ?>
              </a>
          </div>
        </div>
        <div class="card-body px-4 pb-4">
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open(base_url('admin/admin_roles/module_edit/'.$module['module_id']), 'class="form-horizontal"');  ?> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="module_name"><?= trans('module_name') ?></label>
                    <input type="text" name="module_name" value="<?= $module['module_name']; ?>" class="form-control rounded-pill" id="module_name">
                    <small class="text-muted"><?= trans('lang_index_message') ?></small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="controller_name"><?= trans('controller_name') ?></label>
                    <input type="text" name="controller_name" value="<?= $module['controller_name']; ?>" class="form-control rounded-pill" id="controller_name">
                  </div>
                </div>
              </div>
              
              <div class="row mt-2">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fa_icon"><?= trans('fa_icon') ?></label>
                    <input type="text" name="fa_icon" value="<?= $module['fa_icon']; ?>" class="form-control rounded-pill" id="fa_icon">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="operation"><?= trans('operations') ?></label>
                    <input type="text" name="operation" value="<?= $module['operation']; ?>" class="form-control rounded-pill" id="operation" placeholder="eg. add|edit|delete">
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="sort_order"><?= trans('sort_order') ?></label>
                    <input type="number" name="sort_order" value="<?= $module['sort_order']; ?>" class="form-control rounded-pill" id="sort_order">
                  </div>
                </div>
              </div>

              <div class="mt-4 text-right border-top pt-4">
                  <button type="submit" name="submit" value="submit" class="btn btn-primary btn-lg shadow-sm px-5 rounded-pill">
                    <i class="fas fa-check-circle mr-2"></i> <?= trans('update_module') ?>
                  </button>
              </div>
            <?php echo form_close( ); ?>
        </div>
      </div>
    </section> 
  </div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-pencil"></i>
              <?= trans('edit_admin') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/admin'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('admin_list') ?></a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>
              
            <?php echo form_open(base_url('admin/admin/edit/'.$admin['admin_id']), 'class="form-horizontal"' )?> 
                <input type="hidden" name="username" value="<?= $admin['username']; ?>" class="form-control" id="username">
              <div class="form-group">
                <label for="email" class="col-md-2 control-label"><?= trans('email') ?></label>

                <div class="col-md-12">
                  <input type="email" name="email" value="<?= $admin['email']; ?>" class="form-control" id="email" placeholder="" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="phone" class="col-md-2 control-label"><?= trans('phone') ?></label>

                <div class="col-md-12">
                  <input type="number" name="phone" value="<?= $admin['phone']; ?>" class="form-control" id="phone" placeholder="" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="role" class="col-md-2 control-label"><?= trans('select_status') ?></label>

                <div class="col-md-12">
                  <select name="status" class="form-control">
                    <option value=""><?= trans('select_status') ?></option>
                    <option value="1" <?= ($admin['is_active'] == 1)?'selected': '' ?> ><?= trans('active') ?></option>
                    <option value="0" <?= ($admin['is_active'] == 0)?'selected': '' ?>><?= trans('inactive') ?></option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="col-md-12 control-label"><?= trans('password') ?></label>
                <div class="col-md-12">
                  <input type="password" name="password" class="form-control" id="password" placeholder="">
                </div>
              </div>
                  
              <div class="form-group">
                <label for="role" class="col-md-2 control-label"><?= trans('select_admin_role') ?>*</label>

                <div class="col-md-12">
                  <select name="role" class="form-control">
                    <option value=""><?= trans('select_role') ?></option>
                    <?php foreach($admin_roles as $role): ?>
                      <?php if($role['admin_role_id'] == $admin['admin_role_id']): ?>
                        <option value="<?= $role['admin_role_id']; ?>" selected><?= $role['admin_role_title']; ?></option>
                        <?php else: ?>
                          <option value="<?= $role['admin_role_id']; ?>"><?= $role['admin_role_title']; ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12">
                    <input type="submit" name="submit" value="Update" class="btn btn-primary pull-right">
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
              <!-- /.box-body -->
            </div>
    </section>
  </div>
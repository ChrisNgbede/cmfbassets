  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <div class="d-inline-block">
              <h4>Create New User</h4>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/admin'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('admin_list') ?></a>
          </div>
        </div>
        <div class="card-body">
                           <!-- For Messages -->
                  <?php $this->load->view('admin/includes/_messages.php') ?>

                  <?php echo form_open(base_url('admin/admin/add'));  ?> 
                 <div class="row">
                  <div class="form-group col-md-4">
                    <label for="username" ><?= trans('username') ?></label>
                      <input type="text" name="username" class="form-control" id="username">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="firstname" ><?= trans('firstname') ?></label>
                      <input type="text" name="firstname" class="form-control" id="firstname">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="lastname" ><?= trans('lastname') ?></label>
                      <input type="text" name="lastname" class="form-control" id="lastname">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="email" ><?= trans('email') ?></label>
                      <input type="email" name="email" class="form-control" id="email">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="phone" ><?= trans('phone') ?></label>
                      <input type="number" name="phone" class="form-control" id="phone">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="password" ><?= trans('password') ?></label>
                      <input type="password" name="password" class="form-control" id="password">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="role" ><?= trans('select_admin_role') ?>*</label>
                      <select name="role" class="form-control">
                        <option value=""><?= trans('select_role') ?></option>
                        <?php foreach($admin_roles as $role): ?>
                          <option value="<?= $role['admin_role_id']; ?>"><?= $role['admin_role_title']; ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="form-group col-md-12">
                      <input type="submit" name="submit" value="<?= trans('add_admin') ?>" class="btn btn-primary pull-right">
                  </div>
                </div>
                  <?php echo form_close(); ?>
                </div>
            
      </div>
    </section> 
  </div>
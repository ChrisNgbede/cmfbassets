<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="mod-card">
        <div class="card-header border-0 bg-transparent pt-4 px-4">
          <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title text-dark"> 
                <i class="fas fa-edit text-primary mr-2"></i>
                Edit Sub Module 
              </h3>
              <a href="<?= base_url('admin/admin_roles/sub_module/'.$module['parent']); ?>" class="btn btn-outline-secondary rounded-pill shadow-sm">
                <i class="fas fa-list mr-1"></i> Sub Module List
              </a>
          </div>
        </div>
        
        <div class="card-body px-4 pb-4">
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open(base_url('admin/admin_roles/sub_module_edit/'.$module['id']), 'class="form-horizontal"');  ?> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="module_name" class="font-weight-600">Parent Module</label>
                    <?php 
                      $menu = get_sidebar_menu();
                      $others = array('class' => 'form-control rounded-pill select2', 'id' => 'module_name');
                      $options =  array_column($menu, 'module_name','module_id');
                      echo form_dropdown('module_name',$options,$module['parent'],$others);
                    ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="sub_module_name" class="font-weight-600">Sub Module Name</label>
                    <input type="text" name="sub_module_name" value="<?= $module['name']; ?>" class="form-control rounded-pill" id="sub_module_name">
                    <small class="text-muted">Language index as per your language file</small>
                  </div>
                </div>
              </div>
              
              <div class="row mt-2">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="operation" class="font-weight-600">Link</label>
                    <input type="text" name="operation" value="<?= $module['link']; ?>" class="form-control rounded-pill" id="operation" placeholder="eg. about_us">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="sort_order" class="font-weight-600">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= $module['sort_order']; ?>" class="form-control rounded-pill" id="sort_order">
                  </div>
                </div>
              </div>

              <div class="mt-4 text-right border-top pt-4">
                  <button type="submit" name="submit" value="Update Sub Module" class="btn btn-primary btn-lg shadow-sm px-5 rounded-pill">
                    <i class="fas fa-check-circle mr-2"></i> Update Sub Module
                  </button>
              </div>
            <?php echo form_close( ); ?>
        </div>
      </div>
    </section> 
  </div>
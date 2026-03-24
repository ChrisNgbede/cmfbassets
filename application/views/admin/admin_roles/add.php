<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="mod-card">
            <div class="card-header border-0 bg-transparent pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-dark"> 
                        <i class="fas fa-plus-circle text-primary mr-2"></i>
                        <?= $title ?> 
                    </h3>
                    <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-outline-secondary rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i> <?= trans('back') ?>
                    </a>
                </div>
            </div>
            
            <div class="card-body px-4 pb-4">
                <!-- For Messages -->
                <?php $this->load->view('admin/includes/_messages.php') ?>

                <?php echo form_open(base_url('admin/admin_roles/add'), 'id="frmvalidate"');  ?> 
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="font-weight-600"><?= trans('admin_role') ?></label>
                            <input class="form-control rounded-pill" type="text" name="admin_role_title" value="<?=isset($record['admin_role_title'])?$record['admin_role_title']:''?>" required="" placeholder="e.g. Manager">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="font-weight-600 d-block"><?= trans('admin_role') ?> <?= trans('status') ?></label>
                            <div class="d-flex align-items-center mt-2">
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" id="status_active" name="admin_role_status" class="custom-control-input" value="1" <?php if(isset($record['admin_role_status']) && $record['admin_role_status']==1 ){echo 'checked';}?> checked="checked">
                                    <label class="custom-control-label" for="status_active">Active</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="status_inactive" name="admin_role_status" class="custom-control-input" value="0" <?php if(isset($record['admin_role_status']) && $record['admin_role_status']==0 ){echo 'checked';}?>>
                                    <label class="custom-control-label" for="status_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>

                <div class="mt-4 text-right border-top pt-4">
                    <input type="hidden" name="submit" value="submit"  />
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5 rounded-pill">
                        <i class="fas fa-check-circle mr-2"></i> <?= trans('submit') ?>
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>

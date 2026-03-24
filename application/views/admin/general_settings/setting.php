<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-default color-palette-bo">
            <div class="card-header">
              <div class="d-inline-block">
                  <h3 class="card-title"> <i class="fa fa-plus"></i>
                  <?= trans('general_settings') ?> </h3>
              </div>
            </div>
            <div class="card-body px-4 pb-4">   
                 <!-- For Messages -->
                <?php $this->load->view('admin/includes/_messages.php') ?>

                <?php echo form_open_multipart(base_url('admin/general_settings/add')); ?>	
                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active mb-2 shadow-sm" id="v-pills-general-tab" data-toggle="pill" href="#main" role="tab" aria-selected="true">
                                <i class="fas fa-cog mr-2"></i> General Settings
                            </a>
                            <a class="nav-link mb-2 shadow-sm" id="v-pills-email-tab" data-toggle="pill" href="#email" role="tab" aria-selected="false">
                                <i class="fas fa-envelope mr-2"></i> Email Config
                            </a>
                            <a class="nav-link mb-2 shadow-sm" id="v-pills-sms-tab" data-toggle="pill" href="#sms" role="tab" aria-selected="false">
                                <i class="fas fa-sms mr-2"></i> SMS Gateway
                            </a>
                            <a class="nav-link mb-2 shadow-sm" id="v-pills-recaptcha-tab" data-toggle="pill" href="#reCAPTCHA" role="tab" aria-selected="false">
                                <i class="fab fa-google mr-2"></i> Google reCAPTCHA
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content no-padding" id="v-pills-tabContent">
                            <!-- General Setting -->
                            <div class="tab-pane fade show active" id="main" role="tabpanel">
                                <div class="card border shadow-none mb-4">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold"><i class="fas fa-branding mr-2"></i> Branding Assets</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="font-weight-bold small text-muted text-uppercase mb-2">Favicon (25x25)</label>
                                                <div class="mb-2 p-3 bg-light rounded text-center" style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <?php if(!empty($general_settings['favicon'])): ?>
                                                        <img src="<?= base_url($general_settings['favicon']); ?>" class="img-fluid" style="max-height: 40px;">
                                                    <?php else: ?>
                                                        <i class="fas fa-image fa-2x text-muted opacity-5"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="file" name="favicon" class="form-control-file small">
                                                <input type="hidden" name="old_favicon" value="<?php echo html_escape($general_settings['favicon']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="font-weight-bold small text-muted text-uppercase mb-2">Main Logo</label>
                                                <div class="mb-2 p-3 bg-light rounded text-center" style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <?php if(!empty($general_settings['logo'])): ?>
                                                        <img src="<?= base_url($general_settings['logo']); ?>" class="img-fluid" style="max-height: 60px;">
                                                    <?php else: ?>
                                                        <i class="fas fa-image fa-2x text-muted opacity-5"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="file" name="logo" class="form-control-file small">
                                                <input type="hidden" name="old_logo" value="<?php echo html_escape($general_settings['logo']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="font-weight-bold small text-muted text-uppercase mb-2">Header BG</label>
                                                <div class="mb-2 p-3 bg-light rounded text-center" style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <?php if(!empty($general_settings['header_image'])): ?>
                                                        <img src="<?= base_url($general_settings['header_image']); ?>" class="img-fluid" style="max-height: 60px;">
                                                    <?php else: ?>
                                                        <i class="fas fa-image fa-2x text-muted opacity-5"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="file" name="header_image" class="form-control-file small">
                                                <input type="hidden" name="old_header_image" value="<?php echo html_escape($general_settings['header_image']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-none">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold"><i class="fas fa-info-circle mr-2"></i> Application Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Application Name</label>
                                                <input type="text" class="form-control" name="application_name" value="<?php echo html_escape($general_settings['application_name']); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Catch Phrase</label>
                                                <input type="text" class="form-control" name="catchphrase" value="<?php echo html_escape($general_settings['catchphrase']); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Vision Statement</label>
                                                <textarea name="vision" class="form-control" rows="3"><?php echo html_escape($general_settings['vision']); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Mission Statement</label>
                                                <textarea name="mission" class="form-control" rows="3"><?php echo html_escape($general_settings['mission']); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Default Timezone</label>
                                                <input type="text" class="form-control" name="timezone" value="<?php echo html_escape($general_settings['timezone']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Currency Symbol</label>
                                                <input type="text" class="form-control" name="currency" value="<?php echo html_escape($general_settings['currency']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Language</label>
                                                <?php 
                                                    $options = array_column($languages, 'name','id');
                                                    echo form_dropdown('language',$options,$general_settings['default_language'],'class="form-control"');
                                                ?>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Copyright Footer</label>
                                                <input type="text" class="form-control" name="copyright" value="<?php echo html_escape($general_settings['copyright']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Setting -->
                            <div class="tab-pane fade" id="email" role="tabpanel">
                                <div class="card border shadow-none h-100">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold"><i class="fas fa-paper-plane mr-2"></i> SMTP Server Settings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Email From Name/Email</label>
                                                <input type="text" class="form-control" name="email_from" value="<?php echo html_escape($general_settings['email_from']); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>SMTP Host</label>
                                                <input type="text" class="form-control" name="smtp_host" value="<?php echo html_escape($general_settings['smtp_host']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>SMTP Port</label>
                                                <input type="text" class="form-control" name="smtp_port" value="<?php echo html_escape($general_settings['smtp_port']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>SMTP Username</label>
                                                <input type="text" class="form-control" name="smtp_user" value="<?php echo html_escape($general_settings['smtp_user']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>SMTP Password</label>
                                                <input type="password" class="form-control" name="smtp_pass" value="<?php echo html_escape($general_settings['smtp_pass']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SMS Setting -->
                            <div class="tab-pane fade" id="sms" role="tabpanel">
                                <div class="card border shadow-none h-100">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold"><i class="fas fa-sms mr-2"></i> SMS Gateway Config</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Sender ID</label>
                                                <input type="text" class="form-control" name="sms_senderid" value="<?php echo ($general_settings['sms_senderid']); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Gateway Username</label>
                                                <input type="text" class="form-control" name="sms_username" value="<?php echo ($general_settings['sms_username']); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Gateway Password</label>
                                                <input type="password" class="form-control" name="sms_password" value="<?php echo ($general_settings['sms_password']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- reCAPTCHA -->
                            <div class="tab-pane fade" id="reCAPTCHA" role="tabpanel">
                                <div class="card border shadow-none h-100">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold"><i class="fab fa-google mr-2"></i> reCAPTCHA Settings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Site Key</label>
                                                <input type="text" class="form-control" name="recaptcha_site_key" value="<?php echo ($general_settings['recaptcha_site_key']); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Secret Key</label>
                                                <input type="text" class="form-control" name="recaptcha_secret_key" value="<?php echo ($general_settings['recaptcha_secret_key']); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Language code</label>
                                                <input type="text" class="form-control" name="recaptcha_lang" value="<?php echo ($general_settings['recaptcha_lang']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" name="submit" value="<?= trans('save_changes') ?>" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i> Save All Settings
                    </button>
                </div>	
                <?php echo form_close(); ?>

            </div>
        </div>
    </section>
</div>

<script>
    $("#setting").addClass('active');
    $('#myTabs a').click(function (e) {
     e.preventDefault()
     $(this).tab('show')
 })
</script>


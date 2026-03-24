    <p class="auth-description">Create a new secure password for your account.</p>
    
    <?php $this->load->view('admin/includes/_messages.php') ?>
    
    <?php echo form_open(base_url('admin/auth/reset_password/'.$reset_code), 'class="login-form mt-3" '); ?>
      <div class="form-group mb-3">
        <label for="password" class="font-weight-600 mb-1">New Password</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-lock text-muted"></i></span>
          </div>
          <input type="password" name="password" id="password" class="form-control border-left-0 pl-0" placeholder="New password" required autofocus>
        </div>
      </div>
      
      <div class="form-group mb-3">
        <label for="confirm_password" class="font-weight-600 mb-1">Confirm Password</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-check-circle text-muted"></i></span>
          </div>
          <input type="password" name="confirm_password" id="confirm_password" class="form-control border-left-0 pl-0" placeholder="Confirm new password" required>
        </div>
      </div>
      
      <div class="form-group mt-4">
           <button type="submit" name="submit" value="Reset" id="submit" class="btn btn-primary btn-block shadow-sm">
             <i class="fas fa-key mr-2"></i> Update Password
           </button>
      </div>
    <?php echo form_close(); ?>

    <div class="auth-footer-links text-center mt-4">
      <p>Back to <a href="<?= base_url('admin/auth/login'); ?>">Sign In</a></p>
    </div>

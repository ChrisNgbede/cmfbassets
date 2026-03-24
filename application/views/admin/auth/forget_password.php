    <p class="auth-description">Enter your email and we'll send you instructions to reset your password.</p>
    
    <?php $this->load->view('admin/includes/_messages.php') ?>
    
    <?php echo form_open(base_url('admin/auth/forgot_password'), 'class="login-form mt-3" '); ?>
      <div class="form-group mb-3">
        <label for="email" class="font-weight-600 mb-1">Email Address</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-envelope text-muted"></i></span>
          </div>
          <input type="email" name="email" id="email" class="form-control border-left-0 pl-0" placeholder="Enter your email" required autofocus>
        </div>
      </div>
      
      <div class="form-group mt-4">
           <button type="submit" name="submit" value="Recover" id="submit" class="btn btn-primary btn-block shadow-sm">
             <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
           </button>
      </div>
    <?php echo form_close(); ?>

    <div class="auth-footer-links text-center mt-4">
      <p>Remember your password? <a href="<?= base_url('admin/auth/login'); ?>">Sign In</a></p>
    </div>
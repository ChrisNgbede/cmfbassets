<p class="auth-description">Sign in to start your secure session</p>

<?php $this->load->view('admin/includes/_messages.php')?>

<?php echo form_open(base_url('admin/auth/login'), 'class="login-form mt-3" '); ?>
<div class="form-group mb-3">
  <label for="username" class="font-weight-600 mb-1">Username</label>
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-user text-muted"></i></span>
    </div>
    <input type="text" name="username" id="name" class="form-control border-left-0 pl-0"
      placeholder="<?= trans('username')?>" required autofocus>
  </div>
</div>
<div class="form-group mb-3">
  <label for="password" class="font-weight-600 mb-1 d-flex justify-content-between">
    Password
    <a href="<?= base_url('admin/auth/forgot_password'); ?>" class="small font-weight-600">Forgot?</a>
  </label>
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-lock text-muted"></i></span>
    </div>
    <input type="password" name="password" id="password" class="form-control border-left-0 pl-0"
      placeholder="<?= trans('password')?>" required>
  </div>
</div>
<div class="form-group mt-4">
  <button type="submit" name="submit" value="Login" id="submit" class="btn btn-primary btn-block shadow-sm">
    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
  </button>
</div>
<?php echo form_close(); ?>
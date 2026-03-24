<?php if($this->session->has_userdata('is_admin_login')): ?>
<div class="content-wrapper">
    <section class="error-page-container">
        <div class="error-code-bg">404</div>
        <div class="error-content-box">
             <h1 class="text-primary font-weight-bold">404</h1>
             <h3 class="font-weight-bold mb-3">Oops! Page not found.</h3>
             <p class="text-muted">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
             <div class="mt-4">
                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-primary btn-lg shadow-sm px-5 rounded-pill">
                    <i class="fas fa-home mr-2"></i> Return to Dashboard
                </a>
                <button onclick="window.history.back()" class="btn btn-outline-secondary btn-lg ml-3 px-5 rounded-pill">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </button>
             </div>
        </div>
    </section>
</div>
<?php else: ?>
 <style type="text/css">
    body.light .navbar.nochan *{
      color: black;
    }
  </style>
 <section class="error-split">
     <div class="container">
         <div class="row">
             <div class="col-md-12 align-items-center mt-5">
                 <div class="text-center full-width">
                     
                     <h1 style="font-size: 8rem; font-weight: 900; color: #f8f9fa;">404</h1>

                     <h6 class="fw-400">Oops! The page you are looking for does not exist. <br> It might have been moved or deleted.</h6>
                     <div class="sub-title fw-700 mb-0">
                         <a href="<?= base_url() ?>" class="go-more sub-title mb-0 mt-40 btn btn-primary">Go to Homepage</a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
<?php endif; ?>
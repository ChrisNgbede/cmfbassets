    <div class="auth-header text-center mb-5">
        <div class="success-icon-wrapper mb-4">
            <i class="fas fa-check-circle text-success fa-4xl"></i>
        </div>
        <h3 class="font-weight-bold mb-0">Registration Successful!</h3>
        <p class="text-muted">Welcome to the <?= $this->general_settings['application_name']; ?> community</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Membership Banner -->
            <div id="membershipBanner" class="membership-banner-card overflow-hidden rounded-xl shadow-lg border-0 mb-5">
                <div class="banner-header p-3 d-flex justify-content-between align-items-center">
                    <img src="<?= base_url($this->general_settings['favicon']); ?>" height="40" alt="Logo">
                    <span class="badge badge-light px-3 py-2">Official Member</span>
                </div>
                
                <div class="banner-body text-center py-5 px-4 position-relative">
                    <div class="member-photo-wrapper mb-4">
                        <img src="<?= base_url('uploads/'.$memberphoto); ?>" class="member-photo-lg shadow-md" alt="<?= $membername; ?>">
                    </div>
                    
                    <div class="member-info-overlay">
                        <span class="i-am-tag">I AM</span>
                        <h2 class="member-name-display mb-3"><?= strtoupper($membername); ?></h2>
                    </div>

                    <div class="member-meta-grid row mt-4 no-gutters">
                        <?php 
                            $state = empty(getbyid($member->state,'states')) ? "" : getbyid($member->state,'states')->name;
                            $lga = empty(getbyid($member->lga,'lgas')) ? "" : getbyid($member->lga,'lgas')->name;
                        ?>
                        <div class="col-6 border-right py-2">
                            <small class="d-block text-muted text-uppercase font-weight-bold">State</small>
                            <span class="h6 mb-0"><?= $state; ?></span>
                        </div>
                        <div class="col-6 py-2">
                            <small class="d-block text-muted text-uppercase font-weight-bold">LGA</small>
                            <span class="h6 mb-0"><?= $lga; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="banner-footer text-center p-3">
                    <p class="mb-0 font-weight-bold text-white"><?= $this->general_settings['catchphrase']; ?></p>
                </div>
            </div>

            <div class="text-center">
                <button type="button" id="downloadBanner" class="btn btn-primary btn-lg px-5 shadow-sm mb-4">
                    <i class="fas fa-download mr-2"></i> Download My Banner
                </button>
                
                <div class="social-share-wrapper mb-4">
                    <p class="text-muted small mb-2">Share your membership</p>
                    <?php $this->load->view('components/socialshare'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-footer-links text-center mt-4">
        <p>Want to join? <a href="<?= base_url('admin/auth/register')?>" class="font-weight-bold">Register here</a></p>
        <p class="mt-2"><a href="<?= base_url()?>" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Back to Website</a></p>
    </div>

<style>
    .success-icon-wrapper i {
        font-size: 5rem;
        filter: drop-shadow(0 4px 12px rgba(16, 185, 129, 0.2));
    }

    .membership-banner-card {
        background: #fff;
        background-image: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }

    .banner-header {
        background: var(--primary);
    }

    .banner-footer {
        background: var(--primary);
    }

    .member-photo-lg {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 6px solid #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .i-am-tag {
        display: inline-block;
        background: var(--primary);
        color: #fff;
        padding: 4px 12px;
        border-radius: 4px;
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .member-name-display {
        color: var(--secondary);
        letter-spacing: 1px;
        font-weight: 900;
        text-shadow: 1px 1px 0 rgba(0,0,0,0.05);
    }

    .member-meta-grid {
        background: rgba(var(--primary-rgb), 0.03);
        border-radius: var(--radius-lg);
    }

    .rounded-xl {
        border-radius: 1.5rem;
    }
</style>

<script src="<?= base_url();?>assets1/js/html2canvas.min.js"></script>
<script>
    document.getElementById("downloadBanner").onclick = function(e){
        e.preventDefault();
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating...';
        btn.disabled = true;

        html2canvas(document.querySelector("#membershipBanner"), {
            scale: 2,
            useCORS: true,
            backgroundColor: null
        }).then(canvas => {
            const a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpeg", 0.9);
            a.download = '<?= str_replace(' ', '_', $membername); ?>_membership.jpg';
            a.click();
            
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    };
</script>
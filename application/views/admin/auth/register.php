    <div class="auth-loading-overlay" id="authLoading">
        <div class="auth-loading-spinner"></div>
        <h4 class="text-white font-weight-bold">Creating your account...</h4>
        <p class="text-white-50">Please wait while we process your request</p>
    </div>

    <div class="auth-header text-center mb-5">
        <h4 class="font-weight-bold mb-0">Become a Member</h4>
        <p class="text-muted small">Join <?= $this->general_settings['application_name']; ?> community today</p>
    </div>

    <?php $this->load->view('admin/includes/_messages.php') ?>
    
    <?php echo form_open_multipart(base_url('admin/auth/register'), 'class="registration-form" id="registerForm"'); ?>
        <div class="row">
            <!-- Membership & Personal Info -->
            <div class="col-md-12">
                <h6 class="form-section-title">Membership Details</h6>
            </div>
            
            <div class="col-md-6 mb-4">
                <label class="font-weight-600 mb-2">Membership Type</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-id-card text-muted"></i></span>
                    </div>
                    <select class="form-control border-left-0 pl-0" name="memtype" id="membershiptype">
                        <option value="individual" <?= (isset($_REQUEST['memtype']) && $_REQUEST['memtype'] == 'individual') ? 'selected' : ''?>>Individual Membership</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6 mb-4 individual">
                <label class="font-weight-600 mb-2">Group <small class="text-muted">(Optional)</small></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-users text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0 pl-0" placeholder="Enter Group Name" name="supportgroupname">
                </div>
            </div>

            <div class="col-md-6 mb-4 individual">
                <label class="font-weight-600 mb-2">First Name <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-user text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0 pl-0" placeholder="First Name" name="firstname" required>
                </div>
            </div>

            <div class="col-md-6 mb-4 individual">
                <label class="font-weight-600 mb-2">Last Name <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-user-tag text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0 pl-0" placeholder="Last Name" name="lastname" required>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <label class="font-weight-600 mb-2">Email Address <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                    </div>
                    <input type="email" class="form-control border-left-0 pl-0" placeholder="Email" name="email" required>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <label class="font-weight-600 mb-2">Phone Number <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-phone text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0 pl-0" placeholder="Phone" name="phone" required>
                </div>
            </div>

            <!-- Location Info -->
            <div class="col-md-12 mt-4">
                <h6 class="form-section-title">Location & Demographics</h6>
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">State <span class="text-danger">*</span></label>
                <select name="state" class="form-control select2" id="state" required>
                    <?php foreach($states as $state): ?>
                        <option value="<?= $state->id ?>"><?= $state->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">LGA <span class="text-danger">*</span></label>
                <select name="lga" class="form-control select2" id="lga" required>
                    <?php foreach($lgas as $lga): ?>
                        <option value="<?= $lga->id ?>"><?= $lga->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">Polling Unit</label>
                <input type="text" class="form-control" placeholder="Polling Unit" name="pollingunit">
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">Home Town <span class="text-danger">*</span></label>
                <input type="text" name="hometown" class="form-control" placeholder="Home Town" required>
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">Political Ward</label>
                <input type="text" name="ward" class="form-control" placeholder="Ward">
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">Occupation</label>
                <input type="text" name="occupation" class="form-control" placeholder="Occupation">
            </div>

            <!-- Security & Media -->
            <div class="col-md-12 mt-4">
                <h6 class="form-section-title">Security & Media</h6>
            </div>

            <div class="col-md-6 mb-4">
                <label class="font-weight-600 mb-2">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Create password" required>
            </div>

            <div class="col-md-6 mb-4">
                <label class="font-weight-600 mb-2">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm password" required>
            </div>

            <div class="col-md-4 mb-4">
                <label class="font-weight-600 mb-2">Voter's Card? <span class="text-danger">*</span></label>
                <select name="hasvoterscard" class="form-control">
                    <option value="1">Yes, I have</option>
                    <option value="0">No, I don't</option>
                </select>
            </div>

            <div class="col-md-8 mb-4">
                <div class="photo-preview-box" id="photoPreviewBox">
                    <img id="photo-preview" src="">
                </div>
                <div class="custom-file-upload" id="fileUploadLabel">
                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                    <p class="mb-0 font-weight-600">Click to upload photo</p>
                    <p class="text-muted small mb-0">JPEG or PNG, Max 512kb</p>
                    <input type="file" name="photo" id="photo" accept="image/*" onchange="showPreview(event);" style="display:none">
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <button type="submit" name="submit" id="submitBtn" value="Register" class="btn btn-primary btn-block btn-lg shadow-sm py-3">
                    <i class="fas fa-user-plus mr-2"></i> Join The Community
                </button>
            </div>
        </div>
    <?php echo form_close(); ?>

    <div class="auth-footer-links text-center mt-4">
        <p>Already a member? <a href="<?= base_url('admin/auth/login')?>" class="font-weight-bold">Sign in here</a></p>
        <p class="mt-2"><a href="<?= base_url()?>" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Back to Website</a></p>
    </div>

<script>
    function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("photo-preview");
            var previewBox = document.getElementById("photoPreviewBox");
            preview.src = src;
            previewBox.style.display = "block";
            document.getElementById("fileUploadLabel").querySelector('p').innerText = "Change Photo";
        }
    }

    document.getElementById("fileUploadLabel").onclick = function() {
        document.getElementById("photo").click();
    };

    document.getElementById("registerForm").onsubmit = function() {
        document.getElementById("authLoading").style.display = 'flex';
    };
</script>

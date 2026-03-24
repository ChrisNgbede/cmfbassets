<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>

<div class="content-wrapper mt-4">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-transparent pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 font-weight-bold">
                                    <?= $asset->id ? 'Edit' : 'Create'?> Asset
                                </h4>
                                <p class="text-muted mb-0 small">Enter asset information and configuration details</p>
                            </div>
                            <div>
                                <a href="<?= base_url('admin/asset'); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left mr-2"></i> Asset List
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <?php $this->load->view('admin/includes/_messages.php')?>
                        <?php echo form_open_multipart("admin/asset/create", 'class="validation form-sm" name="myform" id="myform"'); ?>
                        <input type="hidden" name="id" id="assetid" value="<?php echo $asset->id; ?>" />

                        <div class="row">


                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Category <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="Select the primary classification for this asset"></i></label>
                                <select name="category" class="form-control" id="category" required>
                                    <option value="">--select category--</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id?>" <?php echo $asset->category ==
                                        $category->id ? 'selected' : ''?>>
                                        <?php echo $category->name?>
                                    </option>
                                    <?php
endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Is IT Asset <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="Mark as Yes if this is a computer, software, or networking equipment"></i></label>
                                <select name="isit" class="form-control" id="isit">
                                    <option value="0" <?php echo $asset->isit == 0 ? 'selected' : ''?>>No</option>
                                    <option value="1" <?php echo $asset->isit == 1 ? 'selected' : ''?>>Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3" style="display: none;" id="ittype-section">
                                <label>Hardware or Software</label>
                                <select name="ittype" class="form-control" id="ittype">
                                    <option value="software" <?php echo $asset->ittype == 'software' ? 'selected' : ''
                                       ?>>Software</option>
                                    <option value="hardware" <?php echo $asset->ittype == 'hardware' ? 'selected' : ''
                                       ?>>Hardware</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Owner <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="The staff member currently responsible for this asset"></i></label>
                                <select name="owner" class="form-control" id="owner" required>
                                    <option value="">select owner</option>
                                    <?php foreach ($staffs as $staff): ?>
                                    <option value="<?php echo $staff->id?>" <?php echo $asset->owner == $staff->id ?
                                        'selected' : ''?>>
                                        <?php echo $staff->firstname . ' ' . $staff->lastname?>
                                    </option>
                                    <?php
endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Department <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="The department that owns or manages this asset"></i></label>
                                <select name="department" class="form-control" id="department" required>
                                    <option value="">--select department--</option>
                                    <?php foreach ($departments as $department): ?>
                                    <option value="<?php echo $department->id?>" <?php echo $asset->department ==
                                        $department->id ? 'selected' : ''?>>
                                        <?php
echo $department->name?>
                                    </option>
                                    <?php endforeach ?>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Name of asset <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="The descriptive name of the asset"></i></label>
                                <?= form_input('name', $asset->name, 'class="form-control" id="name" required'); ?>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Code <span class="text-danger">*</span> <span class="badge badge-primary btn-link py-1" id="generateCode" style="cursor:pointer">generate
                                        code</span> <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="Unique identification code for the asset"></i></label>
                                <?= form_input('code', $asset->assetcode, 'class="form-control" id="code" required'); ?>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="serialno">Serial No <i class="fas fa-info-circle text-info ml-1"
                                        data-toggle="tooltip"
                                        title="Manufacturer serial number if available"></i></label>
                                <?= form_input('serialno', $asset->serialno, 'class="form-control" id="serialno"'); ?>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="supplier">Supplier</label>
                                <?= form_input('supplier', $asset->supplier, 'class="form-control" id="supplier"'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="font-weight-600" for="assetvalue">Asset Value (₦) <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1"
                                        data-toggle="tooltip" title="Original purchase value of the asset"></i></label>
                                <?= form_input('assetvalue', $asset->assetvalue, 'class="form-control" id="assetvalue" required type="number" step="0.01" min="0"'); ?>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Date Acquired <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="The date the asset was purchased or received"></i></label>
                                <input type="date" class="form-control" name="dateacquired"
                                    value="<?php echo !empty($asset->dateacquired) ? date('Y-m-d', strtotime($asset->dateacquired)) : ''?>"
                                    id="dateacquired" required>
                            </div>


                            <div class="form-group col-md-3">
                                <label class="font-weight-600">Depreciation Start Date <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1"
                                        data-toggle="tooltip" title="Date from which depreciation begins"></i></label>
                                <input type="date" class="form-control" name="depreciationstartdate"
                                    value="<?php echo !empty($asset->depreciationstartdate) ? date('Y-m-d', strtotime($asset->depreciationstartdate)) : ''?>"
                                    id="depreciationstartdate" required>
                            </div>

                            <div class="form-group col-md-2 ">
                                <label class="font-weight-600" for="depreciationrate">Depreciation Rate (%) <span class="text-danger">*</span> <i
                                        class="fas fa-info-circle text-info ml-1" data-toggle="tooltip"
                                        title="Annual percentage rate of depreciation"></i></label>
                                <?= form_input('depreciationrate', $asset->depreciationrate, 'class="form-control" id="depreciationrate" type="number" required step="0.1" min="0" max="100"'); ?>
                            </div>
                            <div class="form-group col-md-2 ">
                                <label class="font-weight-600" for="usefullife">Useful life (Years) <span class="text-danger">*</span> <i class="fas fa-info-circle text-info ml-1"
                                        data-toggle="tooltip"
                                        title="Estimated number of years the asset will be useful"></i></label>
                                <?= form_input('usefullife', $asset->usefullife, 'class="form-control" id="usefullife" type="number" required min="1"'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <?= form_input('location', $asset->location, 'class="form-control" id="location"'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="condition">Condition</label>
                                <select class="form-control" name="condition" id="condition">
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="poor">Poor</option>
                                </select>
                            </div>


                            <div class="form-group col-md-2">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="active" <?php echo $asset->status == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?php echo $asset->status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="obsolete" <?php echo $asset->status == 'obsolete' ? 'selected' : '' ?>>Obsolete</option>
                                    <option value="disposed" <?php echo $asset->status == 'disposed' ? 'selected' : '' ?>>Disposed</option>
                                </select>
                            </div>



                             <div class="form-group col-md-12">
                                <label for="description">Description</label>
                                <?= form_textarea('description', $asset->description, 'class="form-control" id="description" cols="40" rows="3"'); ?>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Asset Physical Image</label>
                                <div class="custom-file-container p-4 border rounded bg-light text-center" style="border-style: dashed !important; border-width: 2px !important;">
                                    <div id="image-preview-container" class="mb-3 <?= empty($asset->attachment) ? 'd-none' : '' ?>">
                                        <img id="image-preview" src="<?= !empty($asset->attachment) ? base_url('uploads/'.$asset->attachment) : '#' ?>" 
                                             alt="Asset Preview" class="img-thumbnail shadow-sm" style="max-height: 200px; object-fit: contain;">
                                    </div>
                                    <div class="upload-placeholder <?= !empty($asset->attachment) ? 'd-none' : '' ?>" id="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Click to upload or drag and drop</p>
                                        <small class="text-secondary small small">JPG, PNG or JPEG (Max 2MB)</small>
                                    </div>
                                    <input type="file" name="attachment" id="asset_image" class="d-none" accept="image/*">
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-outline-dark btn-sm px-4" onclick="document.getElementById('asset_image').click()">
                                            <i class="fas fa-image mr-2"></i> <?= empty($asset->attachment) ? 'Select Image' : 'Change Image' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="waranty">Waranty</label>
                                <?= form_textarea('waranty', $asset->waranty, 'class="form-control" id="waranty" cols="40" rows="3"'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="insurance">Insurance</label>
                                <?= form_textarea('insurance', $asset->insurance, 'class="form-control" id="insurance" cols="40" rows="3"'); ?>
                            </div>

                            <div class="form-group col-12 mt-4">
                                <button type="submit" name="save_asset" value="Save"
                                    class="btn btn-primary btn-lg px-5 shadow-sm">
                                    <i class="fas fa-save mr-2"></i> Save Asset
                                </button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    $('#isit').on('change', function (e) {
        if ($(this).val() == "1") {
            $('#ittype-section').slideDown();
        } else {
            $('#ittype-section').slideUp();
        }
    });

    var itAssetType = document.querySelector('#ittype');
    itAssetType.addEventListener('change', function () {
        console.log(this.value);
    });

    const generateCode = document.querySelector('#generateCode');
    generateCode.addEventListener('click', function (e) {
        e.preventDefault();
        const randomNumber = Math.floor(Math.random() * 1000000) + 1;
        document.getElementById('code').value = randomNumber;
    })

    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // Image Preview Logic
    if (document.getElementById('asset_image')) {
        document.getElementById('asset_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('d-none');
                    document.getElementById('upload-placeholder').classList.add('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
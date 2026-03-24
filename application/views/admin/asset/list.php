<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">
<!-- Custom Select2 Styling -->
<style>
    /* Force Select2 to match bootstrap-sm exact dimensions */
    span.select2-container--bootstrap4 .select2-selection--single {
        height: 31px !important;
        line-height: 1.5 !important;
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        border-radius: 0.2rem !important;
        border: 1px solid #ced4da !important;
    }

    span.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        padding-left: 0 !important;
        padding-right: 20px !important;
        line-height: 1.5 !important;
        color: #495057 !important;
    }

    span.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 29px !important;
        top: 0 !important;
        right: 3px !important;
    }

    .select2-container {
        width: 100% !important;
        vertical-align: middle !important;
    }

    /* Clickable rows */
    #grouptable tbody tr {
        cursor: pointer;
    }

    #grouptable tbody tr td:last-child {
        cursor: default;
    }

    /* Print styling */
    @media print {
        body * {
            visibility: hidden;
        }

        #printableTag,
        #printableTag * {
            visibility: visible;
        }

        #printableTag {
            position: absolute;
            left: 0;
            top: 0;
            width: 50mm;
            height: 25mm;
            border: 1px solid #000;
            padding: 2mm;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
        <div class="card card-default">
            <div class="card-header border-0 bg-transparent pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 font-weight-bold">Manage Assets</h4>
                        <p class="text-muted mb-0 small">View and manage all registered company assets</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary shadow-sm" data-toggle="modal"
                            data-target="#bulkUploadModal">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Bulk Upload
                        </button>
                        <a href="<?= base_url('admin/asset/create'); ?>" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus mr-2"></i> Create Asset
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Advanced Filters -->
                <div class="px-4 py-3 bg-light border-bottom mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="small font-weight-bold text-muted text-uppercase mb-1">Category</label>
                            <select id="filter_category" class="form-control form-control-sm">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->id?>" <?=($this->input->get('category') == $cat->id) ? 
        'selected' : ''?>>
                                    <?= $cat->name?>
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-muted text-uppercase mb-1">Status</label>
                            <select id="filter_status" class="form-control form-control-sm">
                                <option value="">All Statuses</option>
                                <option value="active" <?=($this->input->get('status') == 'active') ? 'selected' :
                                    ''?>>Active</option>
                                <option value="inactive" <?=($this->input->get('status') == 'inactive') ? 'selected' :
    ''?>>Inactive</option>
                                <option value="obsolete" <?=($this->input->get('status') == 'obsolete') ? 'selected' :
    ''?>>Obsolete</option>
                                <option value="disposed" <?=($this->input->get('status') == 'disposed') ? 'selected' :
    ''?>>Disposed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-muted text-uppercase mb-1">IT Asset</label>
                            <select id="filter_it" class="form-control form-control-sm">
                                <option value="">Any</option>
                                <option value="1" <?=($this->input->get('isit') === '1') ? 'selected' : ''?>>IT Assets
                                    Only</option>
                                <option value="0" <?=($this->input->get('isit') === '0') ? 'selected' : ''?>>Non-IT
                                    Assets</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-muted text-uppercase mb-1">Tagging</label>
                            <select id="filter_tagged" class="form-control form-control-sm">
                                <option value="">Any</option>
                                <option value="1" <?=($this->input->get('istagged') === '1') ? 'selected' : ''?>>Tagged
                                    Only</option>
                                <option value="0" <?=($this->input->get('istagged') === '0') ? 'selected' : ''?>>Not
                                    Tagged Only</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="button" id="apply_filters"
                                class="btn btn-primary btn-sm flex-grow-1 shadow-sm">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button type="button" id="reset_filters"
                                class="btn btn-outline-secondary btn-sm flex-grow-1 shadow-sm">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="dataTables_wrapper dt-bootstrap4 table-responsive px-4 pb-4">
                    <?php $this->load->view('admin/includes/_messages.php')?>
                    <table id="grouptable" class="table table-hover table-sm">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="border-0">Asset Name</th>
                                <th class="border-0">Code</th>
                                <th class="border-0">Category</th>
                                <th class="border-0">Owner</th>
                                <th class="border-0">Location</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Date Created</th>
                                <th class="border-0 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($assets)): ?>
                            <?php foreach ($assets as $asset): ?>
                            <tr class="nk-tb-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($asset->attachment)): ?>
                                        <div class="mr-3 shadow-sm rounded border bg-white d-flex align-items-center justify-content-center overflow-hidden view-details-link"
                                            style="width: 45px; height: 45px; cursor: pointer;"
                                            data-url="<?= base_url('admin/asset/asset_details/' . $asset->id) ?>"
                                            onclick="event.stopPropagation(); showZoomedImage('<?= base_url('uploads/' . $asset->attachment) ?>', '<?= addslashes($asset->name) ?>')">
                                            <img src="<?= base_url('uploads/' . $asset->attachment)?>"
                                                alt="<?= $asset->name?>"
                                                style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                        </div>
                                        <?php
        else: ?>
                                        <div class="mr-3 shadow-sm rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                            style="width: 45px; height: 45px; opacity: 0.6;">
                                            <i class="fas fa-image text-muted small"></i>
                                        </div>
                                        <?php
        endif; ?>
                                        <div class="d-flex flex-column">
                                            <a href="<?php echo base_url('admin/asset/asset_details/' . $asset->id)?>"
                                                class="text-dark font-weight-bold">
                                                <?php echo $asset->name?>
                                            </a>
                                            <div class="d-flex gap-1 flex-wrap mt-1">
                                                <?php if (isset($asset->isit) && $asset->isit == 1): ?>
                                                <span class="badge badge-warning shadow-sm it-badge"
                                                    style="font-size: 9px; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                    <i class="fas fa-laptop mr-1"></i> IT Asset
                                                </span>
                                                <?php
        else: ?>
                                                <span class="d-none">Non-IT</span>
                                                <?php
        endif; ?>

                                                <?php if (property_exists($asset, 'istagged') && $asset->istagged == 1): ?>
                                                <span class="badge badge-success shadow-sm tagged-badge"
                                                    style="font-size: 9px; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                    <i class="fas fa-check-circle mr-1"></i> Tagged
                                                </span>
                                                <?php
        else: ?>
                                                <span class="badge badge-danger shadow-sm tagged-badge"
                                                    style="font-size: 9px; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                    <i class="fas fa-times-circle mr-1"></i> Not Tagged
                                                </span>
                                                <?php
        endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="small font-weight-bold text-muted">
                                        <?php
        echo getbyid($asset->department, 'departments')->shortname . '-' . $asset->assetcode . '-' . getbyid(getbyid($asset->owner, 'staff')->designation, 'designations')->shortname . '-' . date('ym', strtotime($asset->dateacquired));
?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="cat-name">
                                            <?php echo getbyid($asset->category, 'asset_categories')->name?>
                                        </span>
                                        <span class="small text-muted font-italic">
                                            <?php echo getbyid($asset->category, 'asset_categories')->code?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs mr-2 bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 24px; height: 24px; font-size: 0.7rem; font-weight: 700;">
                                            <?= substr(getbyid($asset->owner, 'staff')->firstname, 0, 1) . substr(getbyid($asset->owner, 'staff')->lastname, 0, 1)?>
                                        </div>
                                        <span>
                                            <?php echo getbyid($asset->owner, 'staff')->firstname . ' ' . getbyid($asset->owner, 'staff')->lastname?>
                                        </span>
                                    </div>
                                </td>
                                <td><span class="text-muted small">
                                        <?php echo ucwords($asset->location)?>
                                    </span></td>
                                <td>
                                    <a href="javascript:void(0)" class="status-update-btn"
                                        data-id="<?php echo $asset->id?>" data-status="<?php echo $asset->status?>"
                                        data-name="<?php echo $asset->name?>">
                                        <?php if ($asset->status == 'active'): ?>
                                        <span class="badge badge-success shadow-sm status-badge">Active</span>
                                        <?php
        elseif ($asset->status == 'inactive'): ?>
                                        <span class="badge badge-danger shadow-sm status-badge">Inactive</span>
                                        <?php
        elseif ($asset->status == 'pending_approval'): ?>
                                        <span class="badge badge-warning shadow-sm status-badge">Requires Approval</span>
                                        <?php
        elseif ($asset->status == 'disposed'): ?>
                                        <span class="badge badge-secondary shadow-sm status-badge">Disposed</span>
                                        <?php
        elseif ($asset->status == 'obsolete'): ?>
                                        <span class="badge badge-warning shadow-sm status-badge">Obsolete</span>
                                        <?php
        else: ?>
                                        <span class="badge badge-dark shadow-sm status-badge">
                                            <?php echo ucfirst($asset->status)?>
                                        </span>
                                        <?php
        endif ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="small text-muted">
                                        <?php echo date('M d, Y', strtotime($asset->datecreated))?>
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" type="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                                            <a class="dropdown-item py-2"
                                                href="<?php echo base_url('admin/asset/asset_details/' . $asset->id)?>">
                                                <i class="fas fa-eye mr-2 text-info"></i> View Details
                                            </a>
                                            <a class="dropdown-item py-2"
                                                href="<?php echo base_url('admin/asset/create/' . $asset->id)?>">
                                                <i class="fas fa-edit mr-2 text-primary"></i> Edit Asset
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item py-2 text-warning tag-asset-btn text-dark"
                                                href="javascript:void(0)" data-id="<?php echo $asset->id?>"
                                                data-name="<?php echo $asset->name?>">
                                                <i class="fas fa-tag mr-2"></i> Tag Asset
                                            </a>
                                            <a class="dropdown-item py-2 text-dark status-update-btn"
                                                href="javascript:void(0)" data-id="<?php echo $asset->id?>"
                                                data-status="<?php echo $asset->status?>"
                                                data-name="<?php echo $asset->name?>">
                                                <i class="fas fa-sync-alt mr-2"></i> Change Status
                                            </a>
                                            <div class="dropdown-divider border-light"></div>
                                            <?php 
                                                $full_asset_code = getbyid($asset->department, 'departments')->shortname . '-' . $asset->assetcode . '-' . getbyid(getbyid($asset->owner, 'staff')->designation, 'designations')->shortname . '-' . date('ym', strtotime($asset->dateacquired));
                                            ?>
                                            <a class="dropdown-item py-2 text-dark" href="javascript:void(0)"
                                                onclick="printAssetTag('<?php echo $full_asset_code?>', '<?php echo addslashes($asset->name)?>')">
                                                <i class="fas fa-print mr-2 text-success"></i> Print Tag
                                            </a>
                                            <div class="dropdown-divider border-light"></div>
                                            <a class="dropdown-item py-2 text-danger"
                                                href="<?php echo base_url('admin/asset/delete/' . $asset->id)?>"
                                                onclick="return confirm('Are you sure you want to delete this asset?')">
                                                <i class="fas fa-trash mr-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
    endforeach ?>
                            <?php
endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- DataTables Scripts -->
<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- Tagging Modal -->
<div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title font-weight-bold text-white" id="tagModalLabel">
                    <i class="fas fa-tag mr-2"></i> Tag Asset: <span id="modalAssetName"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/asset/tag_asset')?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="tagAssetId">

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Has this asset been tagged?</label>
                        <select name="istagged" class="form-control form-control-lg border-primary" required
                            style="font-size: 1rem;">
                            <option value="1">Yes, Tagged</option>
                            <option value="0">No, Not Tagged</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Tagging Officer</label>
                        <select name="tagging_officer" class="form-control form-control-lg" required
                            style="width: 100%;">
                            <option value="">-- Select Officer --</option>
                            <?php foreach ($staffs as $staff): ?>
                            <option value="<?= $staff->id?>">
                                <?= $staff->firstname . ' ' . $staff->lastname?>
                            </option>
                            <?php
endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Tagging Date & Time</label>
                        <input type="datetime-local" name="tagging_date" class="form-control form-control-lg" required
                            value="<?= date('Y-m-d\TH:i')?>">
                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle mr-1"></i> Record when the
                            physical tagging was completed</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">
                        <i class="fas fa-check mr-2"></i> Update Tagging Info
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-succes text-white border-0">
                <h5 class="modal-title font-weight-bold text-status text-white" id="statusModalLabel">
                    <i class="fas fa-sync-alt mr-2"></i> Update Status: <span id="statusModalAssetName"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/asset/update_status')?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="statusAssetId">

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">New Asset Status</label>
                        <select name="status" id="statusSelect" class="form-control form-control-lg border-dark"
                            required style="font-size: 1rem;">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="obsolete">Obsolete</option>
                            <option value="disposed">Disposed</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Status Change Notes</label>
                        <textarea name="notes" class="form-control form-control-lg" rows="3"
                            placeholder="Explain why the status is being changed..." required></textarea>
                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle mr-1"></i> These notes will
                            be saved to the asset's history.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark px-4 font-weight-bold shadow-sm">
                        <i class="fas fa-save mr-2"></i> Save Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Upload Modal -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1" role="dialog" aria-labelledby="bulkUploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title font-weight-bold text-white" id="bulkUploadModalLabel">
                    <i class="fas fa-cloud-upload-alt mr-2"></i> Bulk Asset Upload
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/asset/bulk_upload')?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 shadow-sm small">
                        <i class="fas fa-info-circle mr-2"></i> <strong>Pro Tip:</strong> Use our official template to
                        ensure all columns are correctly mapped. Missing or incorrectly named columns may cause the
                        upload to fail.
                    </div>

                    <div class="text-center my-4 py-4 border rounded bg-light"
                        style="border-style: dashed !important; border-width: 2px !important;">
                        <i class="fas fa-file-csv fa-3x text-muted mb-3"></i>
                        <div class="form-group mb-0 px-4">
                            <label class="btn btn-outline-primary btn-sm px-4 mb-2">
                                <i class="fas fa-search mr-2"></i> Select CSV File
                                <input type="file" name="bulk_file" id="bulk_file_input" class="d-none" accept=".csv"
                                    required
                                    onchange="document.getElementById('file-name-display').innerText = this.files[0].name">
                            </label>
                            <p id="file-name-display" class="small text-muted mb-0 font-italic">No file chosen</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                        <span class="small font-weight-bold"><i class="fas fa-download mr-2 text-primary"></i> Need the
                            template?</span>
                        <a href="<?= base_url('admin/asset/export_template')?>"
                            class="btn btn-primary btn-xs px-3 shadow-sm">Download Template</a>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">
                        <i class="fas fa-upload mr-2"></i> Start Bulk Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg bg-transparent">
            <div class="modal-header border-0 p-0">
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                    style="position: absolute; right: -30px; top: -30px; opacity: 1; font-size: 2rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="zoomedImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
                <h5 id="zoomedImageTitle" class="text-white mt-3 font-weight-bold"></h5>
            </div>
        </div>
    </div>
</div>

<!-- Initialize DataTable with Export CSV -->
<script>
    function showZoomedImage(url, title) {
        $('#zoomedImage').attr('src', url);
        $('#zoomedImageTitle').text(title);
        $('#imageZoomModal').modal('show');
    }

    function printAssetTag(code, name) {
        var tagHtml = `
            <div style="width: 50mm; height: 25mm; padding: 2mm; box-sizing: border-box; display: flex; align-items: center; justify-content: space-between; border: 1px solid #000; background: #fff; font-family: sans-serif;">
                <div style="flex: 1; min-width: 0; padding-right: 2mm;">
                    <div style="font-size: 10pt; font-weight: bold; margin-bottom: 2mm; word-break: break-all;">${code}</div>
                    <div style="font-size: 6pt; color: #444; line-height: 1.1; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">${name}</div>
                </div>
                <div style="flex-shrink: 0;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&margin=0&data=${code}" style="width: 18mm; height: 18mm; display: block;">
                </div>
            </div>
        `;

        var win = window.open('', 'PrintAssetTag', 'width=450,height=300');
        win.document.write('<html><head><title>Print Asset Tag</title><style>body{margin:0;padding:0;}</style></head><body>' + tagHtml + '</body></html>');
        win.document.close();

        setTimeout(function () {
            win.focus();
            win.print();
            win.close();
        }, 600);
    }

    $(function () {
        var table = $("#grouptable").DataTable({
            dom: '<"top"lBf>rt<"bottom"ip>',
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            order: [[6, "desc"]],
            buttons: [
                {
                    text: '<i class="fas fa-file-csv mr-2"></i> Export All to CSV',
                    className: 'btn btn-warning shadow-sm font-weight-bold',
                    action: function (e, dt, node, config) {
                        var category = $('#filter_category').val();
                        var status = $('#filter_status').val();
                        var it = $('#filter_it').val();
                        var tagged = $('#filter_tagged').val();
                        var url = window.location.pathname + '?export=csv';
                        if (category) url += '&category=' + encodeURIComponent(category);
                        if (status) url += '&status=' + encodeURIComponent(status);
                        if (it !== '') url += '&isit=' + encodeURIComponent(it);
                        if (tagged !== '') url += '&istagged=' + encodeURIComponent(tagged);
                        window.location.href = url;
                    }
                }
            ],
            pageLength: 20
        });

        // Make rows clickable except for links and buttons
        $('#grouptable tbody').on('click', 'tr', function (e) {
            if ($(e.target).closest('a, button, .dropdown, .status-update-btn, .tag-asset-btn, .view-details-link').length) return;
            var url = $(this).find('a.text-dark.font-weight-bold').attr('href');
            if (url) window.location.href = url;
        });

        // Re-draw table on filter change or button click
        $('#apply_filters').on('click', function () {
            var category = $('#filter_category').val();
            var status = $('#filter_status').val();
            var it = $('#filter_it').val();
            var tagged = $('#filter_tagged').val();
            var url = window.location.pathname + '?';
            if (category) url += '&category=' + encodeURIComponent(category);
            if (status) url += '&status=' + encodeURIComponent(status);
            if (it !== '') url += '&isit=' + encodeURIComponent(it);
            if (tagged !== '') url += '&istagged=' + encodeURIComponent(tagged);
            window.location.href = url;
        });

        // Reset filters
        $('#reset_filters').on('click', function () {
            window.location.href = window.location.pathname;
        });

        // Tagging Modal Logic
        $('.tag-asset-btn').on('click', function () {
            var assetId = $(this).data('id');
            var assetName = $(this).data('name');

            $('#tagAssetId').val(assetId);
            $('#modalAssetName').text(assetName);
            $('#tagModal').modal('show');
        });

        // Status Update Modal Logic
        $('.status-update-btn').on('click', function () {
            var assetId = $(this).data('id');
            var assetName = $(this).data('name');
            var currentStatus = $(this).data('status');

            $('#statusAssetId').val(assetId);
            $('#statusModalAssetName').text(assetName);
            $('#statusSelect').val(currentStatus);
            $('#statusModal').modal('show');
        });
    });
</script>
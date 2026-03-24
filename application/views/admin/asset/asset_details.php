<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<style>
    :root {
        --primary-navy: #1e3a8a;
        --secondary-navy: #1e40af;
        --accent-blue: #3b82f6;
        --success-green: #10b981;
        --danger-red: #ef4444;
        --bg-light: #f8fafc;
        --border-color: rgba(226, 232, 240, 0.8);
    }

    .asset-container {
        padding: 2rem;
        background: var(--bg-light);
        min-height: 100vh;
    }

    .premium-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        margin-bottom: 1.5rem;
        transition: transform 0.2s ease;
    }

    .card-header-premium {
        background: transparent;
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.75rem;
        width: 32px;
        height: 32px;
        background: rgba(30, 58, 138, 0.1);
        color: var(--primary-navy);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 500;
        color: #1e293b;
    }

    .badge-premium {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .asset-qr-card {
        background: linear-gradient(135deg, var(--primary-navy) 0%, var(--secondary-navy) 100%);
        color: white;
        text-align: center;
        padding: 2rem;
    }

    .qr-container {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .approval-trail-item {
        position: relative;
        padding-left: 2rem;
        padding-bottom: 1.5rem;
        border-left: 2px solid var(--border-color);
    }

    .approval-trail-item::before {
        content: '';
        position: absolute;
        left: -7px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-navy);
        border: 2px solid white;
    }

    .approval-trail-item.pending::before {
        background: #cbd5e1;
    }

    .approval-trail-item:last-child {
        border-left: none;
        padding-bottom: 0;
    }

    .btn-action-sticky {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
        display: flex;
        gap: 0.5rem;
        background: white;
        padding: 0.75rem;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
    }

    .tag-status-box {
        padding: 1rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .tag-status-box.tagged {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
    }

    .tag-status-box.not-tagged {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
    }

    .tag-icon {
        font-size: 1.5rem;
    }

    .asset-image-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
    }

    .asset-image-container {
        width: 100%;
        height: 250px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .asset-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .asset-image-container img:hover {
        transform: scale(1.05);
    }

    .no-image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #94a3b8;
    }
</style>

<?php
// Data Safety Checks
$is_tagged = property_exists($asset, 'istagged') ? $asset->istagged : 0;
$tag_officer_id = property_exists($asset, 'taggingofficer') ? $asset->taggingofficer : 0;
$tag_date = property_exists($asset, 'taggingdate') ? $asset->taggingdate : null;
$is_active = property_exists($asset, 'is_active') ? $asset->is_active : (isset($asset->status) && $asset->status == 'active' ? 1 : 0);
?>

<div class="content-wrapper asset-container">
    <div class="container-fluid">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/asset')?>">Assets</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
                <h2 class="font-weight-bold mb-0">
                    <?php echo $asset->name?>
                </h2>
                <span class="text-muted small">ID: #
                    <?php echo $asset->id?> | Created on
                    <?= $asset->datecreated ? date('M d, Y', strtotime($asset->datecreated)) : 'N/A'?>
                </span>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('admin/asset/index'); ?>" class="btn btn-secondary btn-sm px-3 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <a href="<?= base_url('admin/asset/create/' . $asset->id)?>"
                    class="btn btn-primary btn-sm px-3 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Edit Asset
                </a>
            </div>
        </div>

        <?php $this->load->view('admin/includes/_messages.php')?>

        <div class="row">
            <!-- Left Column: Primary Details -->
            <div class="col-lg-8">
                <!-- Tagging Information (NEW) -->
                <div class="premium-card p-4">
                    <div class="tag-status-box <?= $is_tagged ? 'tagged' : 'not-tagged'?>">
                        <div class="tag-icon">
                            <i class="fas <?= $is_tagged ? 'fa-check-circle' : 'fa-exclamation-circle'?>"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 font-weight-bold">
                                <?= $is_tagged ? 'Asset Successfully Tagged' : 'Awaiting Physical Tagging'?>
                            </h5>
                            <?php if ($is_tagged && !empty($tag_officer_id)): ?>
                            <?php $officer = getbyid($tag_officer_id, 'staff'); ?>
                            <p class="mb-0 small">Tagged by <strong>
                                    <?= $officer ? $officer->firstname . ' ' . $officer->lastname : 'Unknown Officer'?>
                                </strong> on <strong>
                                    <?= $tag_date ? date('M d, Y | H:i', strtotime($tag_date)) : 'N/A'?>
                                </strong></p>
                            <?php
else: ?>
                            <p class="mb-0 small">Please proceed to tag the asset and update the records accordingly.
                            </p>
                            <?php
endif; ?>
                        </div>
                        <button type="button"
                            class="btn <?= $is_tagged ? 'btn-success' : 'btn-danger'?> btn-sm px-4 shadow-sm"
                            data-toggle="modal" data-target="#tagModal">
                            <i class="fas fa-tag mr-2"></i>
                            <?= $is_tagged ? 'Update Tag' : 'Tag Asset Now'?>
                        </button>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="premium-card">
                    <div class="card-header-premium">
                        <div class="section-title mb-0">
                            <i><i class="fas fa-info"></i></i> Basic Information
                        </div>
                        <?php if ($asset->status == 'active'): ?>
                        <span class="badge badge-success badge-premium tracking-wider">ACTIVE</span>
                        <?php elseif ($asset->status == 'inactive'): ?>
                        <span class="badge badge-danger badge-premium tracking-wider">INACTIVE</span>
                        <?php elseif ($asset->status == 'pending_approval'): ?>
                        <span class="badge badge-warning badge-premium tracking-wider text-dark">REQUIRES APPROVAL</span>
                        <?php elseif ($asset->status == 'obsolete'): ?>
                        <span class="badge badge-warning badge-premium tracking-wider text-dark">OBSOLETE</span>
                        <?php elseif ($asset->status == 'disposed'): ?>
                        <span class="badge badge-secondary badge-premium tracking-wider text-white">DISPOSED</span>
                        <?php else: ?>
                        <span class="badge badge-dark badge-premium tracking-wider">
                            <?= strtoupper($asset->status)?>
                        </span>
                        <?php endif ?>
                    </div>
                    <div class="card-body p-4">
                        <div class="detail-grid">
                            <div class="info-item">
                                <div class="info-label">Asset Name</div>
                                <div class="info-value">
                                    <?php echo $asset->name?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Asset Code</div>
                                <div class="info-value font-weight-bold text-primary">
                                    <?php
$dept = getbyid($asset->department, 'departments');
$owner = getbyid($asset->owner, 'staff');
$desig = $owner ? getbyid($owner->designation, 'designations') : null;
echo ($dept ? $dept->shortname : 'N/A') . '-' . $asset->assetcode . '-' . ($desig ? $desig->shortname : 'N/A') . '-' . ($asset->dateacquired ? date('ym', strtotime($asset->dateacquired)) : '0000');
?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Category</div>
                                <div class="info-value">
                                    <?php $cat = getbyid($asset->category, 'asset_categories');
echo $cat ? $cat->name : 'N/A'?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Department</div>
                                <div class="info-value">
                                    <?php $dept = getbyid($asset->department, 'departments');
echo $dept ? $dept->name : 'N/A'?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Current Owner</div>
                                <div class="info-value">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs mr-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 24px; height: 24px; font-size: 0.7rem;">
                                            <?= $owner ? substr($owner->firstname, 0, 1) : '?'?>
                                        </div>
                                        <?php echo $owner ? $owner->firstname . ' ' . $owner->lastname : 'Unknown'?>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Location</div>
                                <div class="info-value">
                                    <?php echo $asset->location ?: 'Not specified'?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Data -->
                <div class="premium-card">
                    <div class="card-body p-4">
                        <div class="section-title">
                            <i><i class="fas fa-calculator"></i></i> Financial Information
                        </div>
                        <div class="detail-grid">
                            <div class="info-item">
                                <div class="info-label">Purchase Value</div>
                                <div class="info-value h5 font-weight-bold">
                                    <?php echo formatMoney($asset->assetvalue)?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Current Valuation</div>
                                <div class="info-value h5 font-weight-bold text-success">
                                    <?php if (!empty($asset->assetvalue) && !empty($asset->depreciationstartdate) && !empty($asset->depreciationrate) && !empty($asset->usefullife)): ?>
                                    <?php echo formatMoney(assetCurrentValue($asset->assetvalue, $asset->depreciationstartdate, $asset->depreciationrate, $asset->usefullife))?>
                                    <?php
else: ?>
                                    Calculating...
                                    <?php
endif ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Depreciation Rate</div>
                                <div class="info-value">
                                    <?php echo $asset->depreciationrate?>% p.a.
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Useful Life</div>
                                <div class="info-value">
                                    <?php echo $asset->usefullife?> Years
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descriptions -->
                <div class="premium-card">
                    <div class="card-body p-4">
                        <div class="section-title">
                            <i><i class="fas fa-align-left"></i></i> Additional Descriptions
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="info-label">General Description</div>
                                <div class="info-value text-muted">
                                    <?php echo $asset->description ?: 'No description provided'?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-label">Warranty Details</div>
                                <div class="info-value text-muted">
                                    <?php echo $asset->waranty ?: 'N/A'?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-label">Insurance Policy</div>
                                <div class="info-value text-muted">
                                    <?php echo $asset->insurance ?: 'N/A'?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Metadata & QR -->
            <div class="col-lg-4">
                <!-- Asset Physical Image -->
                <div class="asset-image-card shadow-sm border-0">
                    <div class="asset-image-container">
                        <?php if (!empty($asset->attachment) && file_exists('./uploads/' . $asset->attachment)): ?>
                        <img src="<?= base_url('uploads/' . $asset->attachment)?>" alt="<?= $asset->name?>"
                            data-toggle="modal" data-target="#imageModal" style="cursor: zoom-in;">
                        <?php
else: ?>
                        <div class="no-image-placeholder">
                            <i class="fas fa-image fa-4x mb-2 opacity-50"></i>
                            <span class="small font-weight-bold">No Physical Image</span>
                        </div>
                        <?php
endif; ?>
                    </div>
                    <?php if (!empty($asset->attachment)): ?>
                    <div class="p-3 text-center bg-white border-top">
                        <button class="btn btn-link btn-sm text-primary p-0 font-weight-bold" data-toggle="modal"
                            data-target="#imageModal">
                            <i class="fas fa-search-plus mr-1"></i> View Full Image
                        </button>
                    </div>
                    <?php
endif; ?>
                </div>

                <!-- QR Identification -->
                <div class="premium-card asset-qr-card border-0">
                    <div class="qr-container shadow-sm">
                        <img id='barcode'
                            src="<?php echo 'https://api.qrserver.com/v1/create-qr-code/?data=' . base_url('dashboard/personnelform?p=' . $asset->assetcode) . '&amp;size=230x230'?>"
                            alt="Asset QR Code" class="img-fluid" style="max-width: 140px" />
                    </div>
                    <h5 class="font-weight-bold mb-1 text-white">Asset Digital Identity</h5>
                    <p class="small opacity-75 mb-0">Scan for instant verification</p>
                </div>

                <!-- Approval Trail -->
                <div class="premium-card p-4">
                    <div class="section-title">
                        <i><i class="fas fa-history"></i></i> Approval Trail
                    </div>
                    <div class="mt-4">
                        <!-- Created -->
                        <div class="approval-trail-item">
                            <div class="info-label">Asset Registered</div>
                            <div class="info-value small">
                                <?php echo $asset->createdby ? nameofuser($asset->createdby) : 'System'?>
                            </div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                <?= $asset->datecreated ? date('M d, Y | H:i', strtotime($asset->datecreated)) : 'N/A'?>
                            </div>
                        </div>

                        <!-- Approved -->
                        <div class="approval-trail-item <?= empty($asset->approvedby) ? 'pending' : ''?>">
                            <div class="info-label">Final Approval</div>
                            <?php if (!empty($asset->approvedby)): ?>
                            <div class="info-value small text-success font-weight-bold">APPROVED</div>
                            <div class="small text-muted mb-1">
                                <?php echo nameofuser($asset->approvedby)?>
                            </div>
                            <div class="text-muted mb-2" style="font-size: 0.75rem;">
                                <?= $asset->dateapproved ? date('M d, Y | H:i', strtotime($asset->dateapproved)) : 'N/A'?>
                            </div>
                            <?php if ($asset->approvalcomment): ?>
                            <div class="p-2 bg-light rounded small italic">"
                                <?= $asset->approvalcomment?>"
                            </div>
                            <?php
    endif; ?>
                            <?php
else: ?>
                            <div class="info-value small text-warning font-weight-bold">PENDING APPROVAL</div>
                            <div class="mt-3">
                                <button class="btn btn-navy btn-sm btn-block shadow-sm"
                                    style="background: var(--primary-navy); color: white;" id="showApprovalForm">
                                    <i class="fas fa-check-double mr-2"></i> Approve Now
                                </button>
                            </div>
                            <div id="approvalFormContainer" style="display: none;" class="mt-3 border-top pt-3">
                                <form action="<?= base_url('admin/asset/approve')?>" method="POST">
                                    <input type="hidden" name="id" value="<?= $asset->id?>">
                                    <div class="form-group">
                                        <textarea class="form-control form-control-sm" name="approvalComment"
                                            placeholder="Add approval remarks..." rows="3"></textarea>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="submit"
                                            class="btn btn-success btn-xs px-3 shadow-sm">Confirm</button>
                                        <button type="button" class="btn btn-secondary btn-xs px-3 shadow-sm"
                                            id="hideApprovalForm">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <?php
endif; ?>
                        </div>
                    </div>
                </div>

                <!-- System Audit -->
                <div class="premium-card p-4 bg-light border-0">
                    <div class="section-title" style="font-size: 0.9rem;">
                        <i><i class="fas fa-cog"></i></i> System Audit
                    </div>
                    <div class="small">
                        <div class="mb-2"><strong>Record Status:</strong> <span
                                class="text-<?= $is_active ? 'success' : 'danger'?>">
                                <?= $is_active ? 'ENABLED' : 'DISABLED'?>
                            </span></div>
                        <div class="mb-2"><strong>Last Modified:</strong>
                            <?= $asset->datemodified ? date('M d, Y | H:i', strtotime($asset->datemodified)) : 'Never'?>
                        </div>
                        <div class="mb-0"><strong>Modified By:</strong>
                            <?= $asset->modifiedby ? nameofuser($asset->modifiedby) : 'N/A'?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Action Bar -->
<div class="btn-action-sticky shadow-lg border-primary">
    <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#tagModal" title="Update Tagging">
        <i class="fas fa-tag"></i>
    </button>
    <a href="<?= base_url('admin/asset/create/' . $asset->id)?>" class="btn btn-info shadow-sm" title="Edit Asset">
        <i class="fas fa-edit text-white"></i>
    </a>
    <a href="<?= base_url('admin/asset/delete/' . $asset->id)?>" class="btn btn-danger shadow-sm"
        onclick="return confirm('Delete this asset?')" title="Delete Asset">
        <i class="fas fa-trash"></i>
    </a>
</div>

<!-- Tagging Modal -->
<div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-tag mr-2"></i> Update Tagging
                    Record</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('admin/asset/tag_asset')?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" value="<?= $asset->id?>">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Has this asset been tagged?</label>
                        <select name="istagged" class="form-control" required>
                            <option value="1" <?=$is_tagged==1 ? 'selected' : ''?>>Yes, Tagged</option>
                            <option value="0" <?=$is_tagged==0 ? 'selected' : ''?>>No, Not Tagged</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Tagging Officer</label>
                        <select name="tagging_officer" class="form-control" required>
                            <option value="">-- Select Officer --</option>
                            <?php if (!empty($staffs)): ?>
                            <?php foreach ($staffs as $staff): ?>
                            <option value="<?= $staff->id?>" <?=$tag_officer_id==$staff->id ? 'selected' : ''?>>
                                <?= $staff->firstname . ' ' . $staff->lastname?>
                            </option>
                            <?php
    endforeach; ?>
                            <?php
endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Tagging Date & Time</label>
                        <input type="datetime-local" name="tagging_date" class="form-control" required
                            value="<?= $tag_date ? date('Y-m-d\TH:i', strtotime($tag_date)) : date('Y-m-d\TH:i')?>">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold shadow">Save Tagging
                        Progress</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center">
                <button type="button" class="close text-white mb-2" data-dismiss="modal" aria-label="Close"
                    style="float: none; font-size: 2rem; opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img src="<?= !empty($asset->attachment) ? base_url('uploads/' . $asset->attachment) : ''?>"
                    class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<script>

    $(function () {
        $('#showApprovalForm').click(function () {
            $(this).fadeOut(function () {
                $('#approvalFormContainer').slideDown();
            });
        });

        $('#hideApprovalForm').click(function () {
            $('#approvalFormContainer').slideUp(function () {
                $('#showApprovalForm').fadeIn();
            });
        });
    });
</script>
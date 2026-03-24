<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    :root {
        --primary-navy: #1e3a8a;
        --secondary-navy: #1e40af;
        --accent-blue: #3b82f6;
        --success-green: #10b981;
        --danger-red: #ef4444;
        --warning-orange: #f59e0b;
        --bg-light: #f8fafc;
        --border-color: rgba(226, 232, 240, 0.8);
    }

    .collateral-container {
        padding: 2rem;
        background: var(--bg-light);
        min-height: 100vh;
    }

    .premium-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        margin-bottom: 2rem;
        transition: transform 0.2s ease;
    }

    .card-header-premium {
        background: transparent;
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-premium i {
        background: var(--bg-light);
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 0.75rem;
        color: var(--primary-navy);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        border-radius: 12px;
        background: var(--bg-light);
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .info-item:hover {
        border-color: var(--accent-blue);
        background: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .info-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 500;
    }

    .badge-premium {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Approval Trail Styling */
    .approval-trail {
        position: relative;
        padding-left: 2rem;
    }

    .approval-trail::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .approval-trail-item {
        position: relative;
        margin-bottom: 2rem;
    }

    .approval-trail-item::after {
        content: '';
        position: absolute;
        left: -1.25rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: white;
        border: 2px solid var(--accent-blue);
        z-index: 1;
    }

    .approval-trail-item.pending::after {
        border-color: #cbd5e1;
    }

    .approval-trail-item.success::after {
        border-color: var(--success-green);
        background: var(--success-green);
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

    .collateral-img-preview {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .comment-bubble {
        background: var(--bg-light);
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        border-left: 3px solid var(--accent-blue);
    }
</style>

<div class="content-wrapper collateral-container">
    <div class="container-fluid">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/asset/listcollateral')?>">Collaterals</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
                <h2 class="font-weight-bold mb-0">
                    <?php echo property_exists($collateral, 'name') ? $collateral->name : 'Unnamed Collateral'?>
                </h2>
                <span class="text-muted small">ID: #
                    <?php echo $collateral->id?> | Registered on
                    <?= property_exists($collateral, 'dateregistered') && $collateral->dateregistered ? date('M d, Y', strtotime($collateral->dateregistered)) : 'N/A'?>
                </span>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('admin/asset/listcollateral'); ?>"
                    class="btn btn-secondary btn-sm px-3 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <?php if ($collateral->status != 'retrieved'): ?>
                <a href="<?php echo base_url('admin/asset/editcollateral/' . $collateral->id)?>"
                    class="btn btn-primary btn-sm px-3 shadow-sm" data-toggle="ajax-modal">
                    <i class="fas fa-edit mr-2"></i>Edit Info
                </a>
                <?php
endif ?>
            </div>
        </div>

        <?php $this->load->view('admin/includes/_messages.php')?>

        <div class="row">
            <!-- Left Column: Primary Details -->
            <div class="col-lg-8">
                <!-- Status & Identification -->
                <div class="premium-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary mr-3 fa-2x"></i>
                            <div>
                                <h5 class="mb-0 font-weight-bold">Collateral Status Tracking</h5>
                                <p class="text-muted small mb-0">Current lifecycle stage of this collateral record</p>
                            </div>
                        </div>
                        <?php
$status_class = 'badge-secondary';
if ($collateral->status == 'registered')
    $status_class = 'badge-danger';
elseif ($collateral->status == 'approved')
    $status_class = 'badge-success';
elseif ($collateral->status == 'pending_approval')
    $status_class = 'badge-warning';
elseif ($collateral->status == 'retrieved')
    $status_class = 'badge-info';
?>
                        <span class="badge <?= $status_class?> badge-premium text-uppercase px-4">
                            <?=($collateral->status == 'pending_approval') ? 'Requires Approval' : $collateral->status?>
                        </span>
                    </div>
                </div>

                <!-- Basic Information Grid -->
                <div class="premium-card">
                    <div class="card-header-premium">
                        <div class="font-weight-bold">
                            <i><i class="fas fa-file-contract"></i></i> Essential Information
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="detail-grid">
                            <div class="info-item">
                                <div class="info-label">Customer Name</div>
                                <div class="info-value">
                                    <?php echo property_exists($collateral, 'customername') ? $collateral->customername : 'N/A'?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Facility Amount</div>
                                <div class="info-value font-weight-bold text-dark">
                                    <?php echo property_exists($collateral, 'facilityamount') ? formatMoney($collateral->facilityamount) : 'N/A'?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Valuation</div>
                                <div class="info-value h6 mb-0 text-success font-weight-bold">
                                    <?php echo property_exists($collateral, 'valuation') ? formatMoney($collateral->valuation) : 'N/A'?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Officer In Charge</div>
                                <div class="info-value">
                                    <?php
$officer_id = property_exists($collateral, 'officerincharge') ? $collateral->officerincharge : null;
$officer = $officer_id ? getbyid($officer_id, 'staff') : null;
echo $officer ? $officer->firstname . ' ' . $officer->lastname : 'Unknown Officer';
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Image -->
                <div class="row">
                    <div class="col-md-7">
                        <div class="premium-card h-100">
                            <div class="card-header-premium">
                                <div class="font-weight-bold">
                                    <i><i class="fas fa-align-left"></i></i> Collateral Description
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted" style="line-height: 1.6;">
                                    <?php echo $collateral->description ?: 'No detailed description provided.'?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($collateral->image_path)): ?>
                    <div class="col-md-5">
                        <div class="premium-card h-100">
                            <div class="card-header-premium">
                                <div class="font-weight-bold">
                                    <i><i class="fas fa-image"></i></i> Collateral Document/Image
                                </div>
                            </div>
                            <div class="card-body p-4 text-center">
                                <div class="collateral-img-preview">
                                    <img src="<?php echo base_url('uploads/') . $collateral->image_path?>"
                                        class="img-fluid" alt="Collateral image">
                                </div>
                                <a href="<?php echo base_url('uploads/') . $collateral->image_path?>" target="_blank"
                                    class="btn btn-link btn-sm mt-3">
                                    <i class="fas fa-expand mr-1"></i> View Full Image
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
endif; ?>
                </div>

                <!-- Comments Section -->
                <div class="premium-card">
                    <div class="card-header-premium">
                        <div class="font-weight-bold">
                            <i><i class="fas fa-comments"></i></i> Communication & Internal Notes
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php echo form_open('admin/asset/collateralcomment', ['class' => 'mb-4'])?>
                        <input type="hidden" name="collateralid" value="<?php echo $collateral->id?>">
                        <div class="form-group mb-2">
                            <textarea class="form-control" name="comment"
                                placeholder="Add a comment or internal note..." rows="2" required></textarea>
                        </div>
                        <button class="btn btn-primary btn-sm px-4 shadow-sm">Post Comment</button>
                        <?php echo form_close()?>

                        <div class="mt-4">
                            <?php $notes = getalldata('collateralnotes', ['collateralid' => $collateral->id], 'id', 'desc')?>
                            <?php if (!empty($notes)): ?>
                            <?php foreach ($notes as $note): ?>
                            <div class="comment-bubble">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="font-weight-bold small">
                                        <?= nameofuser($note->commentby)?>
                                    </span>
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        <?= time_elapsed($note->created_at)?>
                                    </span>
                                </div>
                                <div class="small text-dark">
                                    <?= $note->comment?>
                                </div>
                            </div>
                            <?php
    endforeach ?>
                            <?php
else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-comment-slash fa-2x mb-2 opacity-25"></i>
                                <p class="small mb-0">No comments recorded yet.</p>
                            </div>
                            <?php
endif ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Stats & Approval Trail -->
            <div class="col-lg-4">
                <!-- Main Actions (New Section) -->
                <div class="premium-card p-4">
                    <h6 class="font-weight-bold mb-3">Lifecycle Actions</h6>
                    <?php if ($collateral->status == 'registered'): ?>
                    <a href="<?php echo base_url('admin/asset/collateralapproval/' . $collateral->id . '?action=approval')?>"
                        class="btn btn-success btn-block py-2 shadow-sm font-weight-bold mb-3" data-toggle="ajax-modal">
                        <i class="fas fa-check-circle mr-2"></i> Approve Collateral
                    </a>
                    <?php
elseif ($collateral->status == 'approved'): ?>
                    <a href="<?php echo base_url('admin/asset/collateralapproval/' . $collateral->id . '?action=retrieval-request')?>"
                        class="btn btn-warning btn-block py-2 shadow-sm font-weight-bold mb-3" data-toggle="ajax-modal">
                        <i class="fas fa-hand-holding mr-2"></i> Request Retrieval
                    </a>
                    <?php
elseif ($collateral->status == "retrieval request"): ?>
                    <a href="<?php echo base_url('admin/asset/collateralapproval/' . $collateral->id . '?action=retrieval')?>"
                        class="btn btn-danger btn-block py-2 shadow-sm font-weight-bold mb-3" data-toggle="ajax-modal">
                        <i class="fas fa-box-open mr-2"></i> Complete Retrieval
                    </a>
                    <?php
endif ?>
                    <p class="text-muted small mb-0 text-center">Available actions depend on current status</p>
                </div>

                <!-- Approval Journey -->
                <div class="premium-card">
                    <div class="card-header-premium">
                        <div class="font-weight-bold">
                            <i><i class="fas fa-history"></i></i> Approval Trail
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="approval-trail">
                            <!-- Registration -->
                            <div class="approval-trail-item success">
                                <div class="info-label">Recorded by</div>
                                <div class="info-value small">
                                    <?php echo property_exists($collateral, 'registeredby') && $collateral->registeredby ? nameofuser($collateral->registeredby) : 'System'?>
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    <?= property_exists($collateral, 'dateregistered') && $collateral->dateregistered ? formatDate($collateral->dateregistered) : 'N/A'?>
                                </div>
                            </div>

                            <!-- Approval status -->
                            <?php if ($collateral->status == 'approved' || $collateral->status == 'retrieval request' || $collateral->status == 'retrieved' || (!empty($collateral->approvalby))): ?>
                            <div class="approval-trail-item success">
                                <div class="info-label">Final Approval</div>
                                <div class="info-value small text-success font-weight-bold">APPROVED</div>
                                <div class="small text-muted mb-1">
                                    <?php echo !empty($collateral->approvalby) ? nameofuser($collateral->approvalby) : 'Authorized Officer'?>
                                </div>
                                <div class="text-muted mb-2" style="font-size: 0.75rem;">
                                    <?=!empty($collateral->approvaldate) ? formatDate($collateral->approvaldate) : 'N/A'?>
                                </div>
                                <?php if (property_exists($collateral, 'approvalcomment') && $collateral->approvalcomment): ?>
                                <div class="p-2 bg-light rounded small italic">"
                                    <?= $collateral->approvalcomment?>"
                                </div>
                                <?php
    endif; ?>
                            </div>
                            <?php
else: ?>
                            <div class="approval-trail-item pending">
                                <div class="info-label">Compliance Approval</div>
                                <div class="info-value small text-muted">Awaiting Verification</div>
                            </div>
                            <?php
endif; ?>

                            <!-- Retrieval steps (only if applicable) -->
                            <?php if (property_exists($collateral, 'retrievalrequestby') && !empty($collateral->retrievalrequestby) && ($collateral->status == 'retrieval request' || $collateral->status == 'retrieved')): ?>
                            <div
                                class="approval-trail-item <?= $collateral->status == 'retrieved' ? 'success' : 'pending'?>">
                                <div class="info-label">Retrieval Request</div>
                                <div class="info-value small">
                                    <?php echo nameofuser($collateral->retrievalrequestby)?>
                                </div>
                                <div class="text-muted small">
                                    <?= formatDate($collateral->retrievalrequestdate)?>
                                </div>
                                <?php if (property_exists($collateral, 'retrievalrequestcomment') && $collateral->retrievalrequestcomment): ?>
                                <div class="p-2 bg-light rounded small mt-1">"
                                    <?= $collateral->retrievalrequestcomment?>"
                                </div>
                                <?php
    endif; ?>
                            </div>
                            <?php
endif; ?>

                            <?php if (!property_exists($collateral, 'retrievalrequestapprovalby'))
    $collateral->retrievalrequestapprovalby = null; ?>
                            <?php if (!empty($collateral->retrievalrequestapprovalby)): ?>
                            <div class="approval-trail-item success">
                                <div class="info-label">Retrieval Completed</div>
                                <div class="info-value small text-info font-weight-bold">RETRIEVED</div>
                                <div class="small text-muted mb-1">
                                    <?php echo nameofuser($collateral->retrievalrequestapprovalby)?>
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    <?= property_exists($collateral, 'retrievalrequestapprovaldate') ? formatDate($collateral->retrievalrequestapprovaldate) : 'N/A'?>
                                </div>
                            </div>
                            <?php
endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Audit info -->
                <div class="premium-card p-4">
                    <div class="font-weight-bold mb-3">
                        <i class="fas fa-cog mr-2"></i> System Audit
                    </div>
                    <div class="small text-muted">
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Last Sync:</span>
                            <span class="text-dark font-weight-bold">System Managed</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Record Identity:</span>
                            <span class="text-dark font-weight-bold">UUID-
                                <?= $collateral->id?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Bar for Quick Access -->
<div class="btn-action-sticky shadow-lg d-none d-md-flex">
    <?php if ($collateral->status != 'retrieved'): ?>
    <a href="<?php echo base_url('admin/asset/editcollateral/' . $collateral->id)?>" class="btn btn-primary shadow-sm"
        data-toggle="ajax-modal" title="Edit Collateral">
        <i class="fas fa-edit"></i>
    </a>
    <?php
endif ?>

    <?php if ($collateral->status == 'registered'): ?>
    <a href="<?php echo base_url('admin/asset/collateralapproval/' . $collateral->id . '?action=approval')?>"
        class="btn btn-success shadow-sm" data-toggle="ajax-modal" title="Approve Info">
        <i class="fas fa-check-double"></i>
    </a>
    <?php
elseif ($collateral->status == 'approved'): ?>
    <a href="<?php echo base_url('admin/asset/collateralapproval/' . $collateral->id . '?action=retrieval-request')?>"
        class="btn btn-warning shadow-sm" data-toggle="ajax-modal" title="Request Retrieval">
        <i class="fas fa-hand-holding-usd"></i>
    </a>
    <?php
elseif ($collateral->status == "retrieval request"): ?>
    <a href="<?php echo base_url('admin/asset/collateralapproval/' . $collateral->id . '?action=retrieval')?>"
        class="btn btn-danger shadow-sm" data-toggle="ajax-modal" title="Complete Retrieval">
        <i class="fas fa-box-open"></i>
    </a>
    <?php
endif ?>
    <a href="<?= base_url('admin/asset/listcollateral'); ?>" class="btn btn-secondary shadow-sm" title="Back to List">
        <i class="fas fa-list"></i>
    </a>
</div>
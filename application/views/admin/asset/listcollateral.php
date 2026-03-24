<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style>
    #grouptable tbody tr {
        cursor: pointer;
    }

    #grouptable tbody tr td:last-child {
        cursor: default;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
        <div class="card card-default">
            <div class="card-header">
                <div class="d-inline-block">
                    <h5 class="">Manage Collateral</h5>
                </div>
                <div class="d-inline-block float-right">
                    <a href="<?= base_url('admin/asset/createcollateral'); ?>" class="btn btn-success">Register
                        Collateral</a>
                    <button id="exportCollateral" class="btn btn-warning">Export CSV </button>
                </div>
            </div>

            <div class="card-body">
                <!-- Filter Section -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <label class="small text-muted font-weight-bold">Status</label>
                        <select id="filter_status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="registered" <?= $this->input->get('status') == 'registered' ? 'selected' :
                                ''?>>Registered</option>
                            <option value="approved" <?= $this->input->get('status') == 'approved' ? 'selected' :
                                ''?>>Approved</option>
                            <option value="retrieval request" <?= $this->input->get('status') == 'retrieval request' ? 
    'selected' : ''?>>Retrieval Request</option>
                            <option value="retrieved" <?= $this->input->get('status') == 'retrieved' ? 'selected' :
                                ''?>>Retrieved</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted font-weight-bold">Officer in Charge</label>
                        <select id="filter_officer" class="form-control ">
                            <option value="">All Officers</option>
                            <?php foreach ($staffs as $staff): ?>
                            <option value="<?= $staff->id?>" <?= $this->input->get('officer') == $staff->id ? 'selected'
        : ''?>>
                                <?= $staff->firstname . ' ' . $staff->lastname?>
                            </option>
                            <?php
endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted font-weight-bold">From</label>
                        <input type="date" id="filter_from" class="form-control"
                            value="<?= $this->input->get('from')?>">
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted font-weight-bold">To</label>
                        <input type="date" id="filter_to" class="form-control" value="<?= $this->input->get('to')?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="apply_filters" class="btn btn-primary mr-2 flex-grow-1">Filter</button>
                        <button id="reset_filters" class="btn btn-secondary flex-grow-1">Reset</button>
                    </div>
                </div>

                <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                    <?php $this->load->view('admin/includes/_messages.php')?>
                    <table id="grouptable" class="table table-hover table-sm table-striped">
                        <thead>
                            <tr class="">
                                <th class="">Name</th>
                                <th class="">Customer</th>
                                <th>Acct No</th>
                                <th class="">Facility</th>
                                <th class="">Date Registered</th>
                                <th class="">Account Officer</th>
                                <th class="">Status</th>
                                <th></th>
                            </tr><!-- .nk-tb-item -->
                        </thead>
                        <tbody>
                            <?php if (!empty($collaterals)): ?>
                            <?php foreach ($collaterals as $collateral): ?>
                            <tr class="">

                                <td class="">
                                    <?php echo !empty($collateral->name) ? $collateral->name : '<span class="badge badge-danger">no name</span>'?>
                                </td>

                                <td class="">
                                    <?php echo $collateral->customername?>
                                </td>
                                <td>
                                    <?php echo $collateral->nuban?>
                                </td>

                                <td>
                                    <?php echo formatMoney($collateral->facilityamount)?>
                                </td>

                                <td class="">
                                    <?php echo formatDate($collateral->dateregistered)?>
                                </td>
                                <td class="">
                                    <?php echo !empty(getbyid($collateral->officerincharge, 'staff')) ? getbyid($collateral->officerincharge, 'staff')->firstname . ' ' . getbyid($collateral->officerincharge, 'staff')->lastname : 'unknown'?>
                                </td>
                                <td>
                                    <?php if ($collateral->status == 'registered'): ?>
                                    <span class="badge badge-danger">registered</span>
                                    <?php
        elseif ($collateral->status == 'approved'): ?>
                                    <span class="badge badge-success">approved</span>
                                    <?php
        elseif ($collateral->status == 'pending_approval'): ?>
                                    <span class="badge badge-warning">Requires Approval</span>
                                    <?php
        elseif ($collateral->status == 'retrieved'): ?>
                                    <span class="badge badge-info">retrieved</span>
                                    <?php
        elseif ($collateral->status == 'retrieval request'): ?>
                                    <span class="badge badge-warning">retrieval request</span>
                                    <?php
        else: ?>
                                    <span class="badge badge-secondary">
                                        <?php echo $collateral->status?>
                                    </span>
                                    <?php
        endif ?>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" type="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                                            <a class="dropdown-item py-2"
                                                href="<?php echo base_url('admin/asset/collateraldetails/' . $collateral->id)?>">
                                                <i class="fas fa-eye mr-2 text-info"></i> View Details
                                            </a>
                                            <a class="dropdown-item py-2"
                                                href="<?php echo base_url('admin/asset/editcollateral/' . $collateral->id)?>" data-toggle="ajax-modal">
                                                <i class="fas fa-edit mr-2 text-primary"></i> Edit Info
                                            </a>
                                            <div class="dropdown-divider border-light"></div>
                                            
                                            <?php if ($collateral->status == 'registered'): ?>
                                                <a class="dropdown-item py-2 text-success" href="<?php echo base_url('admin/asset/collateralapproval/'.$collateral->id.'?action=approval') ?>" data-toggle="ajax-modal">
                                                    <i class="fas fa-check-circle mr-2"></i> Approve Collateral
                                                </a>
                                            <?php elseif($collateral->status == 'approved'): ?>
                                                <a class="dropdown-item py-2 text-warning" href="<?php echo base_url('admin/asset/collateralapproval/'.$collateral->id.'?action=retrieval-request') ?>" data-toggle="ajax-modal">
                                                    <i class="fas fa-hand-holding mr-2"></i> Request Retrieval
                                                </a>
                                            <?php elseif($collateral->status == "retrieval request"): ?>
                                                <a class="dropdown-item py-2 text-danger" href="<?php echo base_url('admin/asset/collateralapproval/'.$collateral->id.'?action=retrieval') ?>" data-toggle="ajax-modal">
                                                    <i class="fas fa-box-open mr-2"></i> Complete Retrieval
                                                </a>
                                            <?php endif ?>

                                            <div class="dropdown-divider border-light"></div>
                                            <a class="dropdown-item py-2 text-danger"
                                                href="<?php echo base_url('admin/asset/delete_collateral/' . $collateral->id)?>"
                                                onclick="return confirm('Are you sure you want to delete this collateral?')">
                                                <i class="fas fa-trash mr-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr><!-- .nk-tb-item -->
                            <?php
    endforeach ?>
                            <?php
endif ?>
                        </tbody>
                    </table><!-- .nk-tb-list -->
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
</div>


<!-- DataTables -->
<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>

    $(function () {
        $("#grouptable").DataTable({
            "order": [[4, "desc"]]
        });

        // Make rows clickable
        $('#grouptable tbody').on('click', 'tr', function (e) {
            if ($(e.target).closest('a, button, .dropdown').length) return;
            var url = $(this).find('a[href*="collateraldetails"]').attr('href');
            if (url) window.location.href = url;
        });

        // Filter handling
        $('#apply_filters').click(function () {
            const status = $('#filter_status').val();
            const officer = $('#filter_officer').val();
            const from = $('#filter_from').val();
            const to = $('#filter_to').val();

            let url = window.location.origin + window.location.pathname + '?';
            if (status) url += 'status=' + encodeURIComponent(status) + '&';
            if (officer) url += 'officer=' + encodeURIComponent(officer) + '&';
            if (from) url += 'from=' + encodeURIComponent(from) + '&';
            if (to) url += 'to=' + encodeURIComponent(to) + '&';

            window.location.href = url.slice(0, -1);
        });

        $('#reset_filters').click(function () {
            window.location.href = window.location.origin + window.location.pathname;
        });

        // Export handling
        $('#exportCollateral').click(function () {
            const status = $('#filter_status').val();
            const officer = $('#filter_officer').val();
            const from = $('#filter_from').val();
            const to = $('#filter_to').val();

            let exportUrl = window.location.origin + window.location.pathname + '?export=csv&';
            if (status) exportUrl += 'status=' + encodeURIComponent(status) + '&';
            if (officer) exportUrl += 'officer=' + encodeURIComponent(officer) + '&';
            if (from) exportUrl += 'from=' + encodeURIComponent(from) + '&';
            if (to) exportUrl += 'to=' + encodeURIComponent(to) + '&';

            window.location.href = exportUrl.slice(0, -1);
        });
    });

</script>
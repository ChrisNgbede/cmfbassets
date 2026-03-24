<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="mod-card">
            <div class="card-header border-0 bg-transparent pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                    <h3 class="card-title text-dark">
                        <i class="fas fa-user-shield text-primary mr-2"></i> Role Permissions
                    </h3>
                    <a href="#" onclick="window.history.go(-1); return false;"
                        class="btn btn-outline-secondary rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <?= trans('back')?>
                    </a>
                </div>
                <div class="mt-3">
                    <h4 class="mb-0 text-primary font-weight-bold">
                        <small class="text-muted d-block mb-1">Configuring Access for:</small>
                        <?= isset($record['admin_role_title']) ? strtoupper($record['admin_role_title']) : 'Unknown Role'?>
                    </h4>
                </div>
            </div>

            <div class="card-body px-4 py-4">
                <!-- Role Designations Section -->
                <div class="role-designations mb-5 p-4 rounded-lg shadow-sm border bg-white">
                    <h5 class="mb-4 font-weight-bold text-primary"><i class="fas fa-id-badge mr-2"></i> Special Role
                        Designations</h5>
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <p class="font-weight-bold mb-3 text-muted small uppercase letter-spacing-1">ASSETS MODULE
                            </p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input designation_checkbox"
                                            id="asset_init" data-column="is_asset_initiator"
                                            <?=(isset($record['is_asset_initiator']) && $record['is_asset_initiator'])
                                            ? 'checked' : ''?>>
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="asset_init">Initiator</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input designation_checkbox"
                                            id="asset_app" data-column="is_asset_approver"
                                            <?=(isset($record['is_asset_approver']) && $record['is_asset_approver'])
                                            ? 'checked' : ''?>>
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="asset_app">Approver</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input designation_checkbox"
                                            id="asset_tag" data-column="is_asset_tagger"
                                            <?=(isset($record['is_asset_tagger']) && $record['is_asset_tagger'])
                                            ? 'checked' : ''?>>
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="asset_tag">Tagger</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-4">
                            <p class="font-weight-bold mb-3 text-muted small uppercase letter-spacing-1">COLLATERALS
                                MODULE</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input designation_checkbox"
                                            id="coll_init" data-column="is_collateral_initiator"
                                            <?=(isset($record['is_collateral_initiator']) &&
                                            $record['is_collateral_initiator']) ? 'checked' : ''?>>
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="coll_init">Initiator</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input designation_checkbox"
                                            id="coll_app" data-column="is_collateral_approver"
                                            <?=(isset($record['is_collateral_approver']) &&
                                            $record['is_collateral_approver']) ? 'checked' : ''?>>
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="coll_app">Approver</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input designation_checkbox"
                                            id="coll_tag" data-column="is_collateral_tagger"
                                            <?=(isset($record['is_collateral_tagger']) &&
                                            $record['is_collateral_tagger']) ? 'checked' : ''?>>
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="coll_tag">Tagger</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">
                        <i class="fas fa-info-circle mr-1"></i> These designations determine who receives email
                        notifications and who can authorize specific actions in Assets/Collaterals.
                    </div>
                </div>

                <h5 class="mb-4 font-weight-bold text-dark px-2"><i class="fas fa-tasks mr-2 text-primary"></i>
                    Module-Level Access</h5>

                <?php foreach ($modules as $kk => $module): ?>
                <div class="module-access-row mb-4 p-3 rounded shadow-sm border bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="m-0 font-weight-bold text-dark">
                                <i class="fas fa-cube text-primary mr-2"></i>
                                <?= $module['module_name']?>
                            </h5>
                            <small class="text-muted d-block mt-1 font-italic">
                                <?= ucfirst($module['controller_name'])?> Controller
                            </small>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <?php
    $manual_ops = explode("|", $module['operation']);
    $discovered = $module['discovered_methods'] ?? [];
 
    // Map discovered methods to their raw names for the merge
    $disc_raw = array_column($discovered, 'raw');
    $all_ops_raw = array_unique(array_merge($manual_ops, $disc_raw));
    sort($all_ops_raw);
 
    foreach ($all_ops_raw as $k => $op_raw):
        if (empty($op_raw))
            continue;
 
        // Find display name
        $display = ucwords(str_replace(['_', '-'], ' ', $op_raw));
        $is_discovered = !in_array($op_raw, $manual_ops);
 
        if ($is_discovered) {
            foreach ($discovered as $d) {
                if ($d['raw'] == $op_raw) {
                    $display = $d['display'];
                    break;
                }
            }
        }
?>
                                <div class="col-md-4 col-lg-3 py-2">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input tgl_checkbox"
                                            id='cb_<?= $kk . $k?>' data-module='<?= $module['controller_name']?>'
                                        data-operation='<?= $op_raw; ?>'
                                        <?php if (in_array($module['controller_name'] . '/' . $op_raw, $access))
            echo 'checked="checked"'; ?>>
                                        <label
                                            class="custom-control-label font-weight-600 <?=!$is_discovered ? 'text-dark' : 'text-primary'?>"
                                            for='cb_<?= $kk . $k?>' style="font-size: 0.85rem;">
                                            <?= $display?>
                                            <?php if ($is_discovered): ?>
                                            <i class="fas fa-cog small text-primary ml-1" title="Discovered Method"
                                                style="opacity: 0.6;"></i>
                                            <?php
        endif; ?>
                                        </label>
                                    </div>
                                </div>
                                <?php
    endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
endforeach; ?>
            </div>
        </div>
    </section>
</div>


<script>
    // Main Module Permissions Toggle
    $("body").on("change", ".tgl_checkbox", function () {
        $.post('<?= base_url("admin/admin_roles/set_access")?>',
            {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                module: $(this).data('module'),
                operation: $(this).data('operation'),
                admin_role_id: <?= isset($record['admin_role_id']) ? $record['admin_role_id'] : 0?>,
                status: $(this).is(':checked') == true ? 1 : 0
            },
            function (data) {
                $.notify("Permission Updated Successfully", "success");
            });
    });

    // Special Role Designations Toggle
    $("body").on("change", ".designation_checkbox", function () {
        $.post('<?= base_url("admin/admin_roles/set_role_designation")?>',
            {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                column: $(this).data('column'),
                admin_role_id: <?= isset($record['admin_role_id']) ? $record['admin_role_id'] : 0?>,
                status: $(this).is(':checked') == true ? 1 : 0
            },
            function (data) {
                $.notify("Role Designation Updated", "success");
            });
    });
</script>
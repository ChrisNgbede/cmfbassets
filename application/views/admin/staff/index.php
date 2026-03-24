
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css"> 
<style>
    .avatar-sm { width: 32px; height: 32px; font-size: 0.8rem; }
    .badge-success-soft { background-color: #e1f7ec; color: #00864e; }
    .badge-danger-soft { background-color: #ffe5e5; color: #d63031; }
    .badge-primary-soft { background-color: #eef2ff; color: #4f46e5; }
    .badge-pill-custom { border-radius: 50px; font-weight: 600; padding: 4px 10px; }
    #grouptable tbody tr { cursor: pointer; transition: background 0.2s; }
    #grouptable tbody tr:hover { background-color: #f8fafc; }
    .dropdown-item i { width: 20px; }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
      <div class="card card-default border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
              <div>
                <h3 class="card-title font-weight-bold mb-0">Staff Directory</h3>
                <p class="text-muted small mb-0">Manage employees, departments and access roles</p>
              </div>
              <a href="<?= base_url('admin/staff/create'); ?>" class="btn btn-primary px-4 shadow-sm">
                <i class="fas fa-user-plus mr-2"></i>Add Member
              </a>            
          </div> 
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
          <?php $this->load->view('admin/includes/_messages.php') ?>
          <table id="grouptable" class="table table-hover table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">Staff Member</th>
                            <th class="border-0 py-3">Position</th>
                            <th class="border-0 py-3">Contact</th>
                            <th class="border-0 py-3">Admin Role</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 text-right px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($staffs)): ?>
                          <?php foreach ($staffs as $staff): ?>
                            <tr class="nk-tb-item" data-url="<?= base_url('admin/staff/create/'.$staff->id) ?>"> 
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center font-weight-bold">
                                            <?= strtoupper(substr($staff->firstname ?? 'S', 0, 1) . substr($staff->lastname ?? 'T', 0, 1)) ?>
                                        </div>
                                        <div class="lh-1">
                                            <div class="font-weight-bold text-dark"><?php echo $staff->firstname.' '.$staff->lastname ?></div>
                                            <div class="small text-muted"><?php echo $staff->email ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <?php 
                                        $dept = getbyid($staff->department,'departments');
                                        $desg = getbyid($staff->designation,'designations');
                                    ?>
                                    <div class="font-weight-bold small text-dark"><?php echo $dept ? $dept->name : 'N/A' ?></div>
                                    <div class="small text-muted"><?php echo $desg ? $desg->name : 'N/A' ?></div>
                                </td>
                                <td class="py-3">
                                    <div class="small text-dark"><i class="fas fa-phone-alt mr-2 text-muted"></i><?php echo $staff->phone ?></div>
                                </td>
                                <td class="py-3">
                                    <?php if (!empty($staff->role_name)): ?>
                                        <span class="badge badge-primary-soft badge-pill-custom small"><?= $staff->role_name ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-light text-muted small border">Guest Access</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <?php if ($staff->is_active == 1): ?>
                                        <span class="badge badge-success-soft badge-pill-custom small">
                                            <i class="fas fa-circle mr-1" style="font-size: 6px; vertical-align: middle;"></i> Active
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger-soft badge-pill-custom small">
                                            <i class="fas fa-circle mr-1" style="font-size: 6px; vertical-align: middle;"></i> Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right px-4 py-3">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                            <a class="dropdown-item py-2" href="<?php echo base_url('admin/staff/create/'.$staff->id) ?>">
                                                <i class="fas fa-edit mr-2 text-info"></i> Edit Details
                                            </a>
                                            <a class="dropdown-item py-2" href="<?php echo base_url('admin/staff/access/'.$staff->id) ?>" data-toggle="ajax-modal">
                                                <i class="fas fa-shield-alt mr-2 text-warning"></i> Access Control
                                            </a>
                                            <div class="dropdown-divider border-light"></div>
                                            <a class="dropdown-item py-2 text-danger" href="<?php echo base_url('admin/staff/delete/'.$staff->id) ?>" onclick="return confirm('Archive this staff member?')">
                                                <i class="fas fa-user-slash mr-2"></i> Deactivate Profile
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?> 
                      <?php endif ?>
                    </tbody>
                </table>
          </div>
        </div>
      </div>
  </section>  
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(function () {
      const table = $("#grouptable").DataTable({
          "pageLength": 25,
          "order": [[0, "asc"]],
          "language": {
              "search": "",
              "searchPlaceholder": "Search staff..."
          }
      });

      // Search box styling
      $('.dataTables_filter input').addClass('form-control form-control-sm border-0 bg-light px-3').css('border-radius', '20px');

      // Row click functionality
      $('#grouptable tbody').on('click', 'tr', function(e) {
          if ($(e.target).closest('a, button, .dropdown').length) return;
          const url = $(this).data('url');
          if (url) window.location.href = url;
      });
  });
</script>
     
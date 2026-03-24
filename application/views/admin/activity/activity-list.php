<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content mt-3">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php')?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h5 class="card-title">
            <?= trans('users_activity_log')?>
          </h5>
        </div>
      </div>
    </div>
    <div class="card card-default">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <label class="small text-muted font-weight-bold">Activity Type</label>
            <select id="filter_status" class="form-control">
              <option value="">All Activities</option>
              <?php foreach ($statuses as $status): ?>
              <option value="<?= $status->id?>">
                <?= $status->description?>
              </option>
              <?php
endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="small text-muted font-weight-bold">User</label>
            <select id="filter_admin" class="form-control">
              <option value="">All Users</option>
              <?php foreach ($users as $user): ?>
              <option value="<?= $user->admin_id?>">
                <?= $user->username?>
              </option>
              <?php
endforeach; ?>
            </select>
          </div>
          <div class="col-md-2">
            <label class="small text-muted font-weight-bold">From</label>
            <input type="date" id="filter_from" class="form-control">
          </div>
          <div class="col-md-2">
            <label class="small text-muted font-weight-bold">To</label>
            <input type="date" id="filter_to" class="form-control">
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button id="apply_filters" class="btn btn-primary mr-2 flex-grow-1">Filter</button>
            <button id="reset_filters" class="btn btn-secondary flex-grow-1">Reset</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-hover table-sm table-striped" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>
                <?= trans('username')?>
              </th>
              <th>
                <?= trans('activity')?>
              </th>
              <th>IP Address</th>
              <th>Device/Agent</th>
              <th>
                <?= trans('date')?>/
                <?= trans('time')?>
              </th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>
</div>


<!-- DataTables -->
<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(function () {
    var table = $('#na_datatable').DataTable({
      "processing": true,
      "serverSide": false,
      "ajax": {
        "url": "<?= base_url('admin/activity/datatable_json')?>",
        "data": function (d) {
          d.status = $('#filter_status').val();
          d.admin_id = $('#filter_admin').val();
          d.from = $('#filter_from').val();
          d.to = $('#filter_to').val();
        }
      },
      "order": [[6, 'desc']],
      "columnDefs": [
        { "targets": 0, "name": "id", 'searchable': true, 'orderable': true },
        { "targets": 1, "name": "username", 'searchable': true, 'orderable': true },
        { "targets": 2, "name": "description", 'searchable': true, 'orderable': true },
        { "targets": 3, "name": "ip_address", 'searchable': true, 'orderable': true },
        { "targets": 4, "name": "user_agent", 'searchable': true, 'orderable': true },
        { "targets": 5, "name": "created_at_display", 'searchable': true, 'orderable': true },
        { "targets": 6, "name": "created_at", 'visible': false, 'searchable': false, 'orderable': true },
      ]
    });

    $('#apply_filters').click(function () {
      table.ajax.reload();
    });

    $('#reset_filters').click(function() {
        $('#filter_status').val('');
        $('#filter_admin').val('');
        $('#filter_from').val('');
        $('#filter_to').val('');
        table.ajax.reload();
    });
  });
</script>
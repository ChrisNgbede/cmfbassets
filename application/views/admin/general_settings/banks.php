<!-- DataTables -->

<!-- DataTables -->
<link type="text/css" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link type="text/css" href="<?= base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link type="text/css" href="<?= base_url()?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="card mt-3">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> All Banks </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/general_settings/createbank'); ?>" class="btn btn-success"
            data-toggle="ajax-modal">New Bank </a>

        </div>

      </div>
      <div class="card-body table-responsive">
        <?php $this->load->view('admin/includes/_messages.php')?>
        <table id="grouptable" class="table table-striped ">
          <thead>
            <tr>
              <th>Bank</th>
              <th>Code</th>
              <th>Short Name</th>
              <th width="80" class="text-right">
                <?= trans('action')?>
              </th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($banks as $bank): ?>
            <tr>
              <td>
                <?= $bank->name; ?>
              </td>
              <td>
                <?php echo $bank->code?>
              </td>
              <td>
                <?php echo $bank->shortname?>
              </td>
              <td>
                <div class="btn-group pull-right">
                  <a href="<?= base_url('admin/general_settings/createbank/' . $bank->id); ?>" data-toggle="ajax-modal"
                    class="btn btn-warning">
                    <i class="fa fa-edit"></i>
                  </a>
                </div>
              </td>
            </tr>
            <?php
endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.box -->
  </section>
</div>


<!-- DataTables -->
<script type="text/javascript" src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/plugins/jszip/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#grouptable").DataTable();
  });
</script>
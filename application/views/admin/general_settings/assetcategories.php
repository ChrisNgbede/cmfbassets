<!-- DataTables -->
<link type="text/css" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link type="text/css" href="<?= base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link type="text/css" href="<?= base_url()?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="card border-0 shadow-sm mt-3">
      <div class="card-header border-0 bg-transparent pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h4 class="mb-0 font-weight-bold">Asset Categories</h4>
            <p class="text-muted mb-0 small">Manage classification categories for tracking and reporting</p>
          </div>
          <div>
            <a href="<?= base_url('admin/general_settings/createassetcategory'); ?>" class="btn btn-primary shadow-sm"
              data-toggle="ajax-modal">
              <i class="fas fa-plus mr-2"></i> New Category
            </a>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive">
        <?php $this->load->view('admin/includes/_messages.php')?>
        <table id="categorytable" class="table  table-striped ">
          <thead>
            <tr>
              <th>Name</th>
              <th>Code</th>
              <th>Date Created</th>
              <th width="120" class="text-right">
                <?= trans('action')?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($categories)):
  foreach ($categories as $category): ?>
            <tr>
              <td>
                <?= $category->name; ?>
              </td>
              <td>
                <?= $category->code; ?>
              </td>
              <td>
                <?= formatDate($category->created_at); ?>
              </td>
              <td class="text-right">
                <div class="btn-group">
                  <a href="<?= base_url('admin/general_settings/createassetcategory/' . $category->id); ?>"
                    data-toggle="ajax-modal" class="btn btn-light btn-sm text-primary" title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="<?= base_url('admin/general_settings/deleteassetcategory/' . $category->id); ?>"
                    onclick="return confirm('Are you sure you want to delete this category?')"
                    class="btn btn-light btn-sm text-danger" title="Delete">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
            <?php
  endforeach;
endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- DataTables -->
<script type="text/javascript" src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript"
  src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(function () {
    $("#categorytable").DataTable();
  });
</script>
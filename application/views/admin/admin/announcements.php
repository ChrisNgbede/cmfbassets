<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables/dataTables.bootstrap4.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title">Announcements</h3>

        </div>
        <a href="<?php echo base_url('admin/admin/addannouncement')?>" data-toggle="ajax-modal"
          class="btn btn-success pull-right">Create Announcement</a>
      </div>
      <div class="card-body">

        <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php')?>

        <div class="row">
          <?php if (empty($announcements)): ?>
          <h6 class="alert alert-danger"><span class="fa fa-times"></span> None yet</h6>
          <?php
else: ?>
          <div id="announcements" class="table-responsive">
            <table id="<?= empty($announcements) ? '' : 'grouptable'?>" class="table table-striped ">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Date Created</th>
                  <th width="150" class="text-right">
                    <?= trans('action')?>
                  </th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($announcements as $announcement): ?>
                <tr>
                  <td><img src="<?php echo base_url() . 'uploads/' . $announcement->image?>" width="100" class=""></td>
                  <td>
                    <?php echo $announcement->title?>
                  </td>
                  <td>
                    <?php echo $announcement->description?></span>
                  </td>
                  <td>
                    <?php echo $announcement->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">In-Active</span>'?>
                  </td>
                  <td>
                    <?= date('d-M-Y', strtotime($announcement->datecreated)); ?>
                  </td>
                  <td>
                    <div class="btn-group pull-right">
                      <a href="<?= base_url('admin/admin/addannouncement/' . $announcement->id); ?>" class="btn btn-info"
                        data-toggle="ajax-modal"><i class="fa fa-edit"></i></a>
                      <a href="<?= base_url("admin/admin/delete_announcement/" . $announcement->id . ""); ?>"
                        onclick="return confirm('are you sure to delete?')" class="btn btn-danger btn-xs"><i
                          class="fa fa-trash-o"></i></a>

                    </div>
                  </td>
                </tr>
                <?php
  endforeach ?>

              </tbody>
            </table>
          </div>
          <?php
endif ?>
        </div>
      </div>
  </section>
</div>

<!-- DataTables -->
<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#grouptable").DataTable();
  });
</script>
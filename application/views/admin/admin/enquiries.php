<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables/dataTables.bootstrap4.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title">Contacts and Enquiries</h3>

        </div>

      </div>
      <div class="card-body">

        <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php')?>

        <div class="row">
          <?php if (empty($enquiries)): ?>
          <h6 class="alert alert-danger"><span class="fa fa-times"></span> None yet</h6>
          <?php
else: ?>
          <div id="enquiries" class="table-responsive">
            <table id="<?= empty($enquiries) ? '' : 'grouptable'?>" class="table table-striped ">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th>User IP</th>
                  <th>Date Created</th>
                  <th width="150" class="text-right">
                    <?= trans('action')?>
                  </th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($enquiries as $enquiry): ?>
                <tr>

                  <td>
                    <?php echo $enquiry->name?>
                  </td>
                  <td>
                    <?php echo $enquiry->email?>
                  </td>
                  <td>
                    <?php echo $enquiry->phone?>
                  </td>
                  <td>
                    <?php echo $enquiry->title?>
                  </td>
                  <td>
                    <?php echo $enquiry->body?>
                  </td>
                  <td>
                    <?php echo $enquiry->status?>
                  </td>
                  <td>
                    <?php echo $enquiry->ipaddress?>
                  </td>
                  <td>
                    <?= date('D-M-Y H:i:s', strtotime($enquiry->datecreated)); ?>
                  </td>
                  <td>
                    <div class="btn-group pull-right">
                      <a href="#" class="btn btn-info"><i class="fa fa-arrow-circle-right"></i></a>
                      <a href="#" class="btn btn-warning btn-xs"><i class="fa fa-thumbs-o-up"></i></a>

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
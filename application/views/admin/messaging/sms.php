<!-- DataTables -->
<link href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link href="<?= base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link href="<?= base_url()?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-3">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> Sms Transactions </h3>
        </div>

        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/messaging/createsms'); ?>" class="btn btn-success"> New SMS </a>

        </div>
        <?php $this->load->view('admin/includes/_messages.php')?>

      </div>
      <div class="card-body table-responsive">
        <table id="example1" class="table table-striped ">
          <thead>
            <tr>
              <th>Sender</th>
              <th>Receiver </th>
              <th>Message</th>
              <th>SMS Cost</th>
              <th>Date </th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($smss as $sms): ?>
            <?php

  $deliveryreport = json_decode($sms->deliveryreport);
?>
            <tr>
              <td>
                <?= $sms->sender; ?>
              </td>
              <td>
                <?= $sms->receiver?>
              </td>
              <td>
                <?= $sms->message; ?>
                <?php if ($sms->delivery == "failed"): ?>
                <span class="badge badge-danger">failed </span>
                <?php
  elseif ($deliveryreport->status == "success"): ?>
                <span class="badge badge-success">Delivered </span>
                <?php
  else: ?>
                <span class="badge badge-primary">unknown</span>
                <?php
  endif ?>
              </td>
              <td>
                <?php echo empty($deliveryreport->cost) ? 'unknown' : formatMoney($deliveryreport->cost)?>
              </td>
              <td>
                <?= formatDate($sms->date)?>
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

<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
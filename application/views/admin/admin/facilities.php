<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables/dataTables.bootstrap4.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title">Manage Facilities</h3>
        </div>

      </div>
      <div class="card-body">

        <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php')?>

        <?php echo form_open(base_url('admin/admin/facilities')); ?>
        <input type="hidden" name="id" value="<?php echo $facility->id; ?>" />
        <div class="row container">
          <!-- /.card-header -->
          <div class="form-group col-md-4">
            <label for="name">Facility Name</label>
            <?= form_input('name', $facility->name, 'class="form-control" id="name"'); ?>
          </div>
          <div class="form-group col-md-2">
            <label for="icon">Icon</label>
            <?= form_input('icon', $facility->icon, 'class="form-control" id="icon"'); ?>
          </div>
          <div class="form-group col-2 mb-2">
            <label for="email">Show on Website</label>
            <select name="showonwebsite" class="form-control">
              <option value="1" <?= $facility->showonwebsite == '1' ? "selected" : ""?>>Yes</option>
              <option value="0" <?= $facility->showonwebsite == '0' ? "selected" : ""?>>No</option>
            </select>
          </div>
          <div class="form-group col-2 mb-2">
            <label>Image</label><br>
            <?php if (!empty($facility->image)): ?>
            <div>
              <img src="<?= base_url() . 'uploads/' . $facility->image; ?>" style="width:30%;" class="image-fluid" alt="">
            </div>
            <?php
endif ?>

            <input type="file" name="image" id="image">
          </div>
          <div class="form-group col-2 mb-2">
            <label for="email">Available?</label>
            <select name="available" class="form-control">
              <option value="1" <?= $facility->available == '1' ? "selected" : ""?>>Yes</option>
              <option value="0" <?= $facility->available == '0' ? "selected" : ""?>>No</option>
            </select>
          </div>

          <div class="form-group col-12 mb-4">
            <label for="description"> Description</label>
            <?php

$options = array(
  'name' => 'description',
  'class' => 'form-control',
  'id' => 'description',
  'rows' => '2',
  'cols' => '50',
  'value' => $facility->description
);
echo form_textarea($options);

?>
          </div>


          <div class="col-md-12">
            <input type="submit" name="submit" value="Save Facility" class="btn btn-warning">
          </div>
        </div>
        <?php echo form_close(); ?>
        <br><br>
        <div class="row">
          <div id="facilities" class="table-responsive container">
            <table id="<?= empty($facilities) ? '' : 'grouptable'?>" class="table table-striped ">
              <thead>
                <tr>
                  <th>Facility</th>
                  <th>Icon</th>
                  <th>Description</th>
                  <th>Show on Website</th>
                  <th>Is Available</th>
                  <th width="150" class="text-right">
                    <?= trans('action')?>
                  </th>

                </tr>
              </thead>
              <tbody>
                <?php if (empty($facilities)): ?>
                <tr>
                  <td colspan="2">
                    <h6 class="text-danger">No Facilities yet</h6>
                  </td>
                </tr>
                <?php
else: ?>
                <?php foreach ($facilities as $facility): ?>
                <tr>
                  <td>
                    <?php echo $facility->name?>
                  </td>
                  <td>
                    <?php echo $facility->icon?>
                  </td>
                  <td>
                    <?php echo $facility->description?>
                  </td>
                  <td>
                    <?php if ($facility->showonwebsite == 1): ?>
                    Yes
                    <?php
    else: ?>
                    No
                    <?php
    endif ?>

                  </td>
                  <td>
                    <?php if ($facility->available == 1): ?>
                    Yes
                    <?php
    else: ?>
                    No
                    <?php
    endif ?>

                  </td>
                  <td>
                    <div class="btn-group pull-right">
                      <a href="<?= base_url('admin/admin/facilities/' . $facility->id); ?>" class="btn btn-info"><i
                          class="fa fa-edit"></i></a>

                    </div>
                  </td>
                </tr>
                <?php
  endforeach ?>
                <?php
endif ?>
              </tbody>
            </table>
          </div>
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
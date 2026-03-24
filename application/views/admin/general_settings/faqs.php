<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables/dataTables.bootstrap4.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title">
            <?php echo $faq->id ? 'EDIT' : 'ADD'?> FAQs
          </h3>
        </div>

      </div>
      <div class="card-body">

        <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php')?>

        <?php echo form_open(base_url('admin/general_settings/faqs')); ?>
        <input type="hidden" name="id" value="<?php echo $faq->id; ?>" />
        <div class="row">
          <!-- /.card-header -->
          <div class="col-md-4">
            <div class="form-group">
              <label for="question">Question</label>
              <?= form_input('question', $faq->question, 'class="form-control" id="question"'); ?>
            </div>
            <div class="form-group">
              <label for="answer">Answer</label>
              <?= form_textarea('answer', $faq->answer, 'class="form-control" id="answer" row="3"'); ?>
            </div>

            <div class="col-md-12">
              <input type="submit" name="submit" value="<?php echo $faq->id ? 'Edit' : 'Add'?>"
                class="btn btn-warning">
            </div>
          </div>
          <div class="col-md-1">

          </div>
          <div class="col-md-7">
            <div id="faqs" class="table-responsive">
              <div>
                <h5>List of FAQs</h5>
              </div>
              <table id="<?= empty($faqs) ? '' : 'grouptable'?>" class="table table-striped ">
                <thead>
                  <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th width="150" class="text-right">
                      <?= trans('action')?>
                    </th>

                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($faqs)): ?>
                  <tr>
                    <td colspan="2">
                      <h6 class="text-danger">No faqs yet</h6>
                    </td>
            
     </tr>
                  <?php
else: ?>
                  <?php foreach ($faqs as $faq): ?>
                  <tr>
                    <td>
                      <?php echo $faq->question?>
                    </td>
                    <td>
                      <?php echo $faq->answer?>
                    </td>
                    <td>
                      <div class="btn-group pull-right">
                        <a href="<?= base_url('admin/general_settings/faqs/' . $faq->id); ?>" class="btn btn-info"><i
                            class="fa fa-edit"></i></a>
                        <a href="<?= base_url('admin/general_settings/deletefaq/' . $faq->id); ?>" class="btn btn-danger"
                          onclick="return confirm('Are you sure about deleting?')"><i class="fa fa-trash"></i></a>

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
        <?php echo form_close(); ?>

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
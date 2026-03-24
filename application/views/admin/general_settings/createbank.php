
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1"> <?= $bank->id ? 'Edit' : 'Create' ?> Bank</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart('admin/general_settings/createbank', 'id="bank-form"'); ?>
        <input type="hidden" name="id" value="<?php echo $bank->id; ?>" />

      <div class="modal-body">
               <div class="form-body">
            <div class="row">
             
               
              <div class="form-group col-12 mb-2">
                <label for="code"> Bank Code</label>
                 <?= form_input('code', $bank->code, 'class="form-control" id="bank_no"'); ?>
              </div>
              <div class="form-group col-12 mb-2">
                <label for="name"> Name</label>
                 <?= form_input('name', $bank->name, 'class="form-control" id="name"'); ?>
              </div>
               <div class="form-group col-12 mb-2">
                <label for="shortname">Short Name</label>
                 <?= form_input('shortname', $bank->shortname, 'class="form-control" id="shortname"'); ?>
              </div>
             
          </div>
        <div class="box-footer">
          <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
        </div>
        <?= form_close();?>
      </div>
    </div>
</div>
</div>
<script type="text/javascript">
  function clearImage (a) {
    a.preventDefault();
     $(this).replaceWith($(this).val('').clone(true));
  }
 
</script>

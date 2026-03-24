
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1"> <?= $smstemplate->id ? 'Edit' : 'Create' ?> SMS Template</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart('admin/general_settings/createsmstemplate', 'id="smstemplate-form"'); ?>
        <input type="hidden" name="id" value="<?php echo $smstemplate->id; ?>" />

      <div class="modal-body">
               <div class="form-body">
            <div class="row">
             
               
              <div class="form-group col-12 mb-2">
                <label for="name"> Name</label>
                 <?= form_input('name', $smstemplate->name, 'class="form-control" id="name"'); ?>
              </div>
              <div class="form-group col-12 mb-2">
                <label for="message"> Message</label>
                 <?= form_textarea('message', $smstemplate->message, 'class="form-control" id="message"'); ?>
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

<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel1"> <?= $category->id ? 'Edit' : 'Create' ?> Asset Category</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?= form_open_multipart('admin/general_settings/createassetcategory', 'id="category-form"'); ?>
      <input type="hidden" name="id" value="<?php echo $category->id; ?>" />

    <div class="modal-body">
      <div class="form-body">
        <div class="row">
          <div class="form-group col-12 mb-2">
            <label for="name"> Category Name</label>
            <?= form_input('name', $category->name, 'class="form-control" id="name" required'); ?>
          </div>
          <div class="form-group col-12 mb-2">
            <label for="code"> Category Code</label>
            <?= form_input('code', $category->code, 'class="form-control" id="code" required'); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
      </div>
      <?= form_close();?>
    </div>
  </div>
</div>

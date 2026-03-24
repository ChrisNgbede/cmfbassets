<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel1"> <?= $group->id ? 'Edit' : 'Create' ?> Asset Group</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?= form_open_multipart('admin/general_settings/createassetgroup', 'id="group-form"'); ?>
      <input type="hidden" name="id" value="<?php echo $group->id; ?>" />

    <div class="modal-body">
      <div class="form-body">
        <div class="row">
          <div class="form-group col-12 mb-2">
            <label for="name"> Group Name</label>
            <?= form_input('name', $group->name, 'class="form-control" id="name" required'); ?>
          </div>
          <div class="form-group col-12 mb-2">
            <label for="cat_id"> Asset Category</label>
            <select name="cat_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->id; ?>" <?= ($group->cat_id == $category->id) ? 'selected' : ''; ?>><?= $category->name; ?></option>
                <?php endforeach; ?>
            </select>
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

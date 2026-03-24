
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1"> <?= $announcement->id ? 'Edit' : 'Create' ?> Announcement</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart('admin/admin/addannouncement', 'id="announcement-form"'); ?>
        <input type="hidden" name="id" value="<?php echo $announcement->id; ?>" />

      <div class="modal-body">
               <div class="form-body">
            <div class="row">
             
               
              <div class="form-group col-12 mb-2">
                <label for="title"> Title</label>
                 <?= form_input('title', $announcement->title, 'class="form-control" id="announcement_no"'); ?>
              </div>
              <div class="form-group col-12 mb-2">
                <label for="description"> Description</label>
                 <?= form_textarea('description', $announcement->description, 'class="form-control summernote" rows="4" id="description"'); ?>
              </div>  
               
                <div class="form-group col-2 mb-2">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                  <option value="1" <?= $announcement->status == '1' ? "selected" : ""?>>Active</option>
                  <option value="0" <?= $announcement->status == '0' ? "selected" : ""?>>In-Active</option>
                </select>
              </div>
               <div class="form-group col-2 mb-2">
                <label for="latest">Latest</label>
                <select name="latest" class="form-control">
                  <option value="0" <?= $announcement->latest == '0' ? "selected" : ""?>>No</option>
                  <option value="1" <?= $announcement->latest == '1' ? "selected" : ""?>>Yes</option>        
                </select>
              </div>
              
               <div class="form-group col-6 mb-2">
                <label for="actionlink"> Action Link</label>
                 <?= form_input('actionlink', $announcement->actionlink, 'class="form-control" id="actionlink"'); ?>
              </div>
               <div class="form-group col-6 mb-2">
                <label for="registerlink"> Register Link</label>
                 <?= form_input('registerlink', $announcement->registerlink, 'class="form-control" id="registerlink"'); ?>
              </div>
               <div class="form-group col-6 mb-2">
                <label for="loginlink"> Login Link</label>
                 <?= form_input('loginlink', $announcement->loginlink, 'class="form-control" id="loginlink"'); ?>
              </div>
            
                <div class="form-group col-12 mb-2">
                  <label>Announcement Image</label><br>
                  <?php if (!empty($announcement->image)): ?>
                    <div>
                      <img src="<?= base_url().'uploads/'.$announcement->image;?>" style="width:100%;" class="image-fluid" alt="">
                    </div>
                  <?php endif ?>
                  
                  <input type="file" name="image" id="image">
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

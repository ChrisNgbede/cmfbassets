
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Collateral <?php echo ucwords(preg_replace('/[^A-Za-z0-9 ]/', '', $action)) ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('admin/asset/collateralapproval', 'id="approval-form"'); ?>
      <div class="modal-body">
        
          <div class="row">
              <input type="hidden" name="collateralid" value="<?php echo $collateral->id ?>">
              <input type="hidden" name="action" value="<?php echo $action ?>">
              <div class="alert alert-warning">
                Approving this means you have sighted the collateral
              </div>
             <div class="col-md-12">
                <blockquote>
                  <b> Name:</b> <?php echo $collateral->name ?>
                </blockquote>
             </div>
             <div class="col-md-12">
                 <label for="comment">Comment</label>
                 <textarea name="comment" placeholder="write a comment" id="comment" class="form-control"></textarea>
             </div>
            </div>
      
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <div class="float-right">
             <button type="submit" class="btn btn-success" id="submit_approve" name="approve" onclick="return confirm('Are you sure you want to approve this collateral?')" value="1" >Proceed</button>
         </div>
      </div>
       <?= form_close();?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

     
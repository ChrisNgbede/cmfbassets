
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1"> <?= $collateral->id ? 'Edit' : 'Create' ?> Collateral</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart('admin/asset/editcollateral', 'id="collateral-form"'); ?>
        <input type="hidden" name="id" value="<?php echo $collateral->id; ?>" />

      <div class="modal-body">
               <div class="form-body">
            <div class="row">
                 <div class="form-group col-md-6">
                  <label class="font-weight-600">Account Officer <span class="text-danger">*</span></label>
                    <select name="officerincharge" class="form-control" id="owner" required>
                        <option value="">officer in charge</option>
                        <?php foreach ($staffs as $staff): ?>
                            <option value="<?php echo $staff->id ?>" <?php echo $collateral->officerincharge == $staff->id ? 'selected' : '' ?>><?php echo $staff->firstname.' '.$staff->lastname ?></option>
                        <?php endforeach ?>
                    </select>
             </div> 
           
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Collateral Code <span class="text-danger">*</span></label>
                <?= form_input('collateral_code', $collateral->collateral_code, 'class="form-control" id="collateral_code" required'); ?>
            </div>
            
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Name of Collateral <span class="text-danger">*</span></label>
                <?= form_input('name',$collateral->name, 'class="form-control" placeholder="eg house in ikoyi" id="name" required'); ?>
            </div>

             <div class="form-group col-md-6">
                 <label class="font-weight-600">Account Number <span class="text-danger">*</span></label>
                <?= form_input('nuban',$collateral->nuban, 'class="form-control" placeholder="" id="nuban" required'); ?>
            </div>
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Customer Name <span class="text-danger">*</span></label>
                <?= form_input('customername', $collateral->customername, 'class="form-control" id="customername" required'); ?>
            </div>
            
             <div class="form-group col-md-6">
                 <label class="font-weight-600" for="facilityamount">Facility Amount (₦) <span class="text-danger">*</span></label>
                  <?= form_input('facilityamount', $collateral->facilityamount, 'class="form-control" id="facilityamount" required type="number" step="0.01" min="0"'); ?>
            </div>
           
          
            <div class="form-group col-md-6">
                 <label class="font-weight-600" for="valuation">Collateral Value (₦) <span class="text-danger">*</span></label>
                  <?= form_input('valuation', $collateral->valuation, 'class="form-control" id="valuation" required type="number" step="0.01" min="0"'); ?>
            </div>
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Date Registered <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="dateregistered" value="<?php echo !empty($collateral->dateregistered) ? date('Y-m-d', strtotime($collateral->dateregistered)) : '' ?>" id="dateregistered" required>
            </div>

             <div class="form-group col-12">
                  <label>Upload File</label><br>              
                  <input type="file" name="image" id="image">
              </div>
          

                                   
         <div class="form-group col-md-12">
            <label for="description" >Description</label>
            <textarea class="form-control" id="description" cols="40" rows="2" name="description"><?php echo !empty($collateral->description) ? $collateral->description : '' ?></textarea>
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

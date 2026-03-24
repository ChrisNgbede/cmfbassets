<?php  

$staffs = getalldata('staff');

?>
    <h5>Fill Collateral Information below to create new:</h5>   
    <hr>   
    <div class="row pl-4 pr-4">
         <div class="form-group col-md-6">
                 <label class="font-weight-600">Account Officer <span class="text-danger">*</span></label>
                    <select name="officerincharge" class="form-control" id="owner" required>
                        <option value="">officer in charge</option>
                        <?php foreach ($staffs as $staff): ?>
                            <option value="<?php echo $staff->id ?>"><?php echo $staff->firstname.' '.$staff->lastname ?></option>
                        <?php endforeach ?>
                    </select>
             </div> 
           
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Name of Collateral <span class="text-danger">*</span></label>
                <?= form_input('name',set_value('name'), 'class="form-control" placeholder="eg house in ikoyi" id="name" required'); ?>
            </div>
            
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Customer Name <span class="text-danger">*</span></label>
                <?= form_input('customername', set_value('customername'), 'class="form-control" id="customername" required'); ?>
            </div>
            
             <div class="form-group col-md-6">
                 <label class="font-weight-600" for="facilityamount">Facility Amount (₦) <span class="text-danger">*</span></label>
                 <?= form_input('facilityamount', set_value('facilityamount'), 'class="form-control" id="facilityamount" required type="number" step="0.01" min="0"'); ?>
            </div>
           
          
            <div class="form-group col-md-6">
                 <label class="font-weight-600" for="valuation">Collateral Value (₦) <span class="text-danger">*</span></label>
                  <?= form_input('valuation', set_value('valuation'), 'class="form-control" id="valuation" required type="number" step="0.01" min="0"'); ?>
            </div>
             <div class="form-group col-md-6">
                 <label class="font-weight-600">Date Registered <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="dateregistered" value="<?= set_value('dateregistered') ?>" id="dateregistered" required>
            </div>

             <div class="form-group col-12">
                  <label>Upload File</label><br>              
                  <input type="file" name="image" id="image">
          

                                   
         <div class="form-group col-md-12">
            <label for="description" >Description</label>
            <textarea class="form-control" id="description" cols="40" rows="2" name="description"></textarea>
          </div>
         
        <div class="form-group col-12">
            <?= form_submit('save_collateral', 'Save', 'class="btn btn-success btn-lg"'); ?>
        </div>
    </div>                           
        

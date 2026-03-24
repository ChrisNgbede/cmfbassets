<style type="text/css">
  #photo-preview{
    width: 400px;
  }
</style>


<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datepicker/datepicker3.css">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-5">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"><?= $staff->id ? 'Edit' : 'Create' ?> Staff</h3>
          </div>
          <div class="d-inline-block float-right">
             <a href="<?= base_url('admin/staff/'); ?>" class="btn btn-success">List Staff</a>
          </div>
        </div>
        <div class="card-body">
   <div class="row">
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open_multipart(base_url('admin/staff/create'),'id="staff-form"'); ?>
             <input type="hidden" name="id" value="<?php echo $staff->id; ?>" />
               <div class="row">
                 
                      <div class="form-group col-md-3">
                        <label for="firstname" >Frist Name</label>
                         <?= form_input('firstname', $staff->firstname, 'class="form-control" id="firstname"'); ?>
                      </div>
                       <div class="form-group col-md-3">
                        <label for="lastname" >Last Name</label>
                         <?= form_input('lastname', $staff->lastname, 'class="form-control" id="lastname"'); ?>
                      </div>
                       <div class="form-group col-md-3">
                        <label for="email" >Email</label>
                         <?= form_input('email', $staff->email, 'class="form-control" id="email"'); ?>
                      </div>
                       <div class="form-group col-md-3">
                        <label for="phone" >Phone</label>
                         <?= form_input('phone', $staff->phone, 'class="form-control" id="phone"'); ?>
                      </div>
                       <div class="form-group col-md-3">
                        <label for="staffno" >Staff No</label>
                         <?= form_input('staffno', $staff->staffno, 'class="form-control" id="staffno"'); ?>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Department</label>
                         <select name="department" class="form-control" id="department">
                              <option value="">--select department--</option>
                              <?php foreach ($departments as $department): ?>
                                  <option value="<?php echo $department->id ?>" <?php echo $staff->department == $department->id ? 'selected' : '' ?>><?php echo $department->name?></option>
                              <?php endforeach ?>
                          </select>
                      </div> 
                       <div class="form-group col-md-3">
                        <label>Designation</label>
                        <select name="designation" class="form-control" id="designation">
                            <option value="">--select designation--</option>
                            <?php foreach ($designations as $designation): ?>
                                <option value="<?php echo $designation->id ?>" <?php echo $staff->designation == $designation->id ? 'selected' : '' ?>><?php echo $designation->name?></option>
                            <?php endforeach ?>
                        </select>
                      </div> 
                      
                     
                        <div class="col-md-12">
                          <input type="submit" name="submit" class="btn btn-success btn-lg" id="publish" value="Save">
                        </div>
                   </div>
                <?php echo form_close(); ?>

        </div>  
    </section> 
</div>

 <!-- bootstrap datepicker -->
 

 
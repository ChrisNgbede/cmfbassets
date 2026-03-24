<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css"> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="container mt-4">
      <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title">Manage Departments</h3>
          </div>
         
        </div>
        <div class="card-body">
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <div class="row">
               <div class="col-md-6">
                  <div class="row">
                                
                      <?php echo form_open( base_url('admin/admin/departments')); ?>
                       <input type="hidden" name="id" value="<?php echo $department->id; ?>" />
                      <div class="row container">
                        <!-- /.card-header -->
                            <div class="form-group col-md-6">
                              <label for="name" >Department Name</label>
                               <?= form_input('name', $department->name, 'class="form-control" id="name"'); ?>
                            </div>
                             <div class="form-group col-md-6">
                              <label for="shortname" >Shortname</label>
                               <?= form_input('shortname', $department->shortname, 'class="form-control" id="icon"'); ?>
                            </div>
                            
                         
                            <div class="col-md-12">
                                  <input type="submit" name="submit" value="Save Department" class="btn btn-warning">
                          </div>
                    </div>
                    <?php echo form_close(); ?>
                  </div>
               </div>
               <div class="col-md-6"> 
                   <div class="table-responsive container p-3">
                      <table id="<?=empty($departments) ? '' : 'grouptable'?>" class="table table-sm table-striped">
                        <thead>
                        <tr>
                          <th>Department</th>
                          <th>Short Name</th>
                       
                          <th width="150" class="text-right"><?= trans('action') ?> </th>
                          
                        </tr>
                        </thead>
                        <tbody>
                           <?php if (empty($departments)): ?>
                              <tr><td colspan="2"><h6 class="text-danger">No Departments yet</h6></td></tr>
                          <?php else: ?>
                             <?php foreach ($departments as $department): ?>
                                <tr>
                                  <td><?php echo $department->name ?></td>
                                  <td><?php echo $department->shortname ?></td>
                                 
                                  <td><div class="btn-group pull-right">
                                         <a href="<?= base_url('admin/admin/departments/'.$department->id); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  
                                       </div>
                                     </td>
                                </tr>
                            <?php endforeach ?>
                           <?php endif ?>
                        </tbody>
                      </table>
                  </div>
                 
               </div>
            </div>
           <!-- For Messages -->

        
        </div>  
    </section>
    </div> 
</div>

<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
   
  $(function () {
     $("#grouptable").DataTable({
      });
      
  });

</script> 
 
 
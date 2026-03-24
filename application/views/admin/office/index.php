<!-- DataTables -->
<link  href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link  href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link  href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title">Offices</h3>
          </div>
          <div class="d-inline-block float-right">
             <a href="<?= base_url('admin/office/create'); ?>" class="btn btn-primary">Create New </a>            
          </div> 
          
        </div>
       <div class="card-body">
           <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
          <?php $this->load->view('admin/includes/_messages.php') ?>
          <table id="grouptable" class="table table-hover table-condensed table-striped">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="">Code</th>
                            <th class="">Ministry</th>
                            <th class="">Agency</th>
                            <th class="">Department</th>
                            <th class="">Website</th>
                            <th></th>
                        </tr><!-- .nk-tb-item -->
                    </thead>
                    <tbody>
                      <?php if (!empty($offices)): ?>
                          <?php foreach ($offices as $office): ?>
                            <tr class="nk-tb-item"> 
                              
                                <td class=""> <?php echo $office->code ?></td>
                                <td class=""><?php echo $office->ministry ?></td>
                                <td class=""><?php echo $office->agency ?></td>
                                <td class=""><?php echo $office->department ?></td>
                                <td class=""><?php echo $office->website ?></td>
                                <td class=""><a href="<?php echo base_url('admin/office/create/'.$office->id) ?>" data-toggle="ajax-modal"><i class="fa fa-edit"></i></a></td>
                            </tr><!-- .nk-tb-item -->
                       <?php endforeach ?> 
                      <?php endif ?>
                    </tbody>
                </table><!-- .nk-tb-list -->
        </div>
       </div>
      </div>
    <!-- /.box -->
  </section>  
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
   
  $(function () {
     $("#grouptable").DataTable({
      });
      
  });

</script> 
     
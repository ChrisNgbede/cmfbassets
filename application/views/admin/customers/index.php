<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/all.css">
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    $(function(){
         $('input[type="checkbox"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
        })
    })
    
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
    

    <div class="card">
      <div class="card-body table-responsive"> 
        <?php echo form_open("/",'id="user_search"') ?>
        <div class="row">
         
          <div class="col-md-3">
            <label>Last Checked From:</label><input name="lastchecked_from" type="text" class="form-control form-control-inline datepicker" id="" />
          </div>
          <div class="col-md-3"> 
            <label>Last Checked To:</label><input name="lastchecked_to" type="text" class="form-control form-control-inline datepicker" id="" /> 
          </div>
          <div class="col-md-3">
              <label>Remita Status</label>
              <select class="form-control" name="onremita">
                  <option value="1">On Remita</option>
                  <option value="2"> Suspended</option>
                  <option value="3">Waiting</option>
              </select>
            </div>
          <div class="col-md-2"> 
            <button type="submit" style="margin-top:30px;" class="btn btn-info btn-block">Filter</button>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>  


      <div class="card">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title">Customers on Remita</h3>
          </div>
          <div class="d-inline-block float-right row">
            
                       
             <a href="<?= base_url('admin/customers/getAllCustomers?export=csv') ?>" class="btn btn-success">Export as CSV</a>
          </div> 
          
        </div>
       <div class="card-body">
           <div class="">
          <?php $this->load->view('admin/includes/_messages.php') ?>
         
          <table id="na_datatable" class="display table table-hover table-condensed table-striped dataTable dtr-inline">
                 <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Office</th>
                    <th>Salary</th>
                    <th>Loans</th>
                    <th>On Remita</th>
                    <th>Last Checked</th>
                    <th>
                        
                         <div class="float-right">
                            <label for="select">
                                  Select All
                             </label>
                             <input type="checkbox" name="select-multiple" class="flat-red" id="select-multiple" > 
                          </div>
                    </th>  

                 </thead>             
          </table>
        </div>
       </div>
      </div>
    <!-- /.box -->
  </section>  
</div>

<script src="<?= base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
  $('.datepicker').datepicker({
    autoclose: true
  });
</script>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('admin/customers/get_customers_data'); ?>",
                "type": "POST"
            },
            "columns": [
                // Define your table columns here
                { "data":"id" },
                { "data":"fullname" },
                // ... add more columns as needed
            ],
            "order": [[0, 'asc']], // Default sorting column and order
            "searching": true, // Enable multi-column searching
            "paging": false, // Enable pagination
            "lengthMenu": [10, 25, 50, 75, 100], // Number of rows to show per page
            "dom": 'lBfrtip', // Add export buttons and search input to the DOM
            "buttons": [
                'csv', 'excel', 'pdf'
            ]
        });
    });

</script> -->


 <!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script>
//---------------------------------------------------
var table = $('#na_datatable').DataTable( {
  "processing": true,
  "serverSide": true,
  "ajax": {
    url:"<?=base_url('admin/customers/getAllCustomers')?>",
    type:"POST"
  },
  "order": [[0,'desc']],
  "columnDefs": [
      {"targets": 0, "name": "id", "visible": false },
      {"targets": 1, "name": "fullname", 'searchable':true, 'orderable':true},
      {"targets": 2, "name": "phone", 'searchable':true, 'orderable':true},
      {"targets": 3, "name": "office", 'searchable':true, 'orderable':true},
      {"targets": 4, "name": "salary", 'searchable':true, 'orderable':true},
      {"targets": 5, "name": "loans", 'searchable':true, 'orderable':true},
      {"targets": 6, "name": "onremita", 'searchable':true, 'orderable':true},
      {"targets": 7, "name": "datecreated", 'searchable':false, 'orderable':false},

  ],

});


</script>



     
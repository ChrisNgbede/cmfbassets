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
              <h3 class="card-title">Repayment Notification Log</h3>
          </div>  
        </div>
       <div class="card-body">
           <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
          <?php $this->load->view('admin/includes/_messages.php') ?>
          <table id="grouptable" class="table table-hover table-condensed table-striped dataTable dtr-inline">
          <thead>
          <tr>

<!--     "id": "9232510684",
    "customerId": "{{customerId}}",
    "requestId": null,
    "paymentDate": "2022-04-07 17: 14: 08.0",
    "amount": 113333.33,
    "paymentStatus": "NEW",
    "statusReason": null,
    "statusCode": null,
    "modulename": "PAYDAYLOAN",
    "notificationSent": false,
    "dateNotificationSent": "2022-04-07",
    "firstNotificationSent": true,
    "dateFirstNotificationSent": "2022-04-20",
    "netSalary": 90066.67,
    "totalCredit": 113333.33,
    "customerPhoneNumber": "234937005461",
    "mandateRef": "{{mandateReference}}",
    "merchantId": "{{merchantId_DD}}",
    "balanceDue": 566666.67,
    "paymentRef": "495515645",
    "trycount": 0 -->

            <th>Id/Customer id</th>
            <th>Amount</th>
            <th>Status Code</th>
            <th>Notification Sent</th>
            <th>Net Salary</th>
            <th>Total Credit</th>
            <th>Man Ref</th>
            <th>Phone</th>
            <th>Balance Due</th>
            <th>Payment Date</th>
            <th>Payment Ref</th>
            <th>Payment Status</th>
             <th>Action</th>            
          </tr>
          </thead>
          <tbody>
            <?php if (!empty($collections)): ?>
                  <?php foreach($collections as $collection): ?>
                 
                      <tr>
                        <td>
                          
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td class="">
                          
                        </td>
                            
                        <td>
                           <?php echo formatDate($collection->id); ?> 
                        </td>
                          
                           
                        <td>
                         
                             

                        </td> 
                      
                       
                      </tr>
                      <?php endforeach; ?>
            <?php endif ?>
          
          </tbody>
          </table>
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
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
   
  $(function () {
     $("#grouptable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#grouptable_wrapper .col-md-6:eq(0)');
      
  });

</script> 
     
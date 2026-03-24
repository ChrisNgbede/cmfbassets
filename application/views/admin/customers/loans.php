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
              <h3 class="card-title">Loans</h3>
          </div>
          <div class="d-inline-block float-right">
            
            
          </div> 
          
        </div>
       <div class="card-body">
           <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
          <?php $this->load->view('admin/includes/_messages.php') ?>
          <table id="grouptable" class="table table-hover table-condensed table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Loan</th>
                                            <th>Customer</th>
                                            <th>Date Created</th>
                                            <th>Principal</th>
                                            <th>Tenor</th>
                                            <th>Interest</th>
                                            <th>Repayment</th>
                                            <th>Date Disbursed</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($loans as $loan): ?>
                                            <tr>
                                                <td>
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                                                        <i class="fa fa-arrow-circle-right"></i>
                                                      </button>
                                                      <div class="dropdown-menu" role="menu">
                                                            <a class="dropdown-item" href="<?php echo base_url('admin/customers/loan_offer_letter/'.$loan->id) ?>">Offer Letter</a>
                                                        <?php if (empty($loan->mandateref)): ?>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo base_url('admin/customers/approveloan/'.$loan->id) ?>"  data-toggle="ajax-modal">Approve Loan</a>
                                                          <?php else: ?>
                                                           <?php if ($loan->status != "closed"): ?>
                                                             <div class="dropdown-divider"></div>
                                                             <a class="dropdown-item" href="<?php echo base_url('admin/customers/stoploan/'.$loan->id) ?>"  data-toggle="ajax-modal">Terminate Loan</a>
                                                             
                                                           <?php endif ?>

                                                        <?php endif ?>
                                                        <a class="dropdown-item" href="<?php echo base_url('admin/customers/salary_loan_details/'.$loan->phone) ?>">Salary Details</a>
                                                    
                                                     
                                                      </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    ID: <?php echo $loan->id ?><br>
                                                    <small>Man Ref: <br><a href="#"><?php echo empty($loan->mandateref) ?  'none' : $loan->mandateref?></a></small>
                                                </td>
                                                 <td>
                                                  <?php $customer = !empty($customer = getby(['phone'=>$loan->phone],'customers')) ? $customer : null?>
                                                  <?php echo ucfirst($customer->fullname) ?>
                                                </td>
                                                <td>
                                                    <?php echo formatDate($loan->datecreated) ?><br> 
                                                    <small><i class="fa fa-user"></i> <?php echo nameofuser($loan->createdby) ?></small>     
                                                </td>
                                                <td><?php echo formatMoney($loan->loanamount) ?></td>
                                                <td><?php echo $loan->numberofrepayments ?></td>
                                                <td>
                                                    Monthly: <?php echo formatMoney(($loan->rate/100 ) * $loan->loanamount) ?> <br>
                                                    Total: <?php echo formatMoney((($loan->rate/100 ) * $loan->loanamount) * $loan->numberofrepayments) ?>
                                                </td>
                                                <td>
                                                     Monthly: <?php echo formatMoney($loan->collectionamount) ?><br>
                                                     Total: <?php echo formatMoney($loan->totalcollectionamount) ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($loan->datedisbursed)): ?>
                                                            <span class="badge badge-danger">Not disbursed</span>
                                                        <?php else: ?>
                                                            <?php echo formatDate($loan->datedisbursed) ?>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if ($loan->status == "created"): ?>
                                                        <span class="badge badge-primary"><?php echo $loan->status ;?></span>
                                                       <?php elseif($loan->status == "approved"):?>
                                                        <span class="badge badge-warning"><?php echo $loan->status ;?></span>
                                                       <?php elseif($loan->status == "disbursed"):?>
                                                        <span class="badge badge-success"><?php echo $loan->status ;?></span>

                                                       <?php elseif($loan->status == "closed"):?>
                                                        <span class="badge badge-danger"><?php echo $loan->status ;?></span>
                                                    <?php endif ?>
                                                </td>
                                                
                                            </tr>
                                        <?php endforeach ?>
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
     
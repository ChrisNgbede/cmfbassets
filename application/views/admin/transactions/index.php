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
              <h3 class="card-title">Wallet Statement</h3>
          </div>
          <div class="d-inline-block float-right">
             <a href="<?= base_url('admin/transactions/fund_wallet'); ?>" data-toggle="ajax-modal" class="btn btn-primary">Fund</a>            
          </div> 
          
        </div>
       <div class="card-body">
           <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
          <?php $this->load->view('admin/includes/_messages.php') ?>
          <table id="grouptable" class="table table-hover table-condensed table-striped dataTable dtr-inline">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col">Amount</th>
                            <th class="nk-tb-col">Transaction Type</th>
                            <th class="nk-tb-col">Narration</th>
                            <th class="nk-tb-col">Ref</th>
                            <th class="nk-tb-col">Method </th>
                            <th class="nk-tb-col">Date </th>
                            <th class="nk-tb-col">Done By </th>
                            <th class="nk-tb-col nk-tb-col-tools text-end">
                               
                            </th>
                        </tr><!-- .nk-tb-item -->
                    </thead>
                    <tbody>
                      <?php if (!empty($transactions)): ?>
                          <?php foreach ($transactions as $transaction): ?>
                            <tr class="nk-tb-item"> 
                              
                                <td class="nk-tb-col tb-col-lg">
                                    <?= formatMoney($transaction->amount) ?>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                   <?php if ($transaction->creditordebit == 'cr'): ?>
                                        <span class="text-success">Credit</span>
                                    <?php elseif($transaction->creditordebit == 'dr') :?>
                                         <span class="text-danger">Debit</span>
                                    <?php endif ?> 
                                </td>
                                 <td class="nk-tb-col tb-col-lg">
                                     <?php echo $transaction->narration ?>
                                 </td>
                                <td class="nk-tb-col tb-col-lg">
                                   <?php echo $transaction->reference ?>
                                </td>
                                <td class="nk-tb-col tb-col-lg"><?php echo $transaction->channel ?></td>
                                <td class="nk-tb-col tb-col-lg"><?php echo formatDate($transaction->datecreated) ?></td>
                                <td class="nk-tb-col tb-col-lg">
                                 
                                    <?php echo nameofuser($transaction->createdby) ?>
                                </td> 
                             
                               
                                <td class="nk-tb-col nk-tb-col-tools">
                                   
                                </td>
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
     
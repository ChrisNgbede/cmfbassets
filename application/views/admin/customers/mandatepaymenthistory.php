  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        
      <div class="container">
          <div class="row">
              <div class="col-md-4 mt-4">
                   <div class="card">
                      <div class="card-header"><h6> Mandate Payment History</h6></div>
                      <div class="card-body">
                        <?php $this->load->view('admin/includes/_messages.php') ?>
                        <?= form_open(site_url('admin/customers/get_mandate_payment_history'))  ?>
                            <div class="row">
                               <div class="form-group col-md-12">
                                  <label>Mandate Reference </label>
                                   <input type="text" class="form-control" name="mandateref" required>
                                </div>
                                <div class="form-group col-md-12"> 
                                  <label>Customer ID</label>
                                   <input type="text" class="form-control" name="customerid" required>
                                </div>
                                <div class="form-group col-md-12"> 
                                  <label>Auth Code</label>
                                   <input type="text" class="form-control" name="authcode" required>
                                </div>

                                <div class="col-md-12">
                                  <input type="submit" class="btn btn-primary" value="Check">
                                </div>
                            </div>
                             
                          <?= form_close() ?>
                      </div>
                     
                   </div>
               
              </div>
              <div class="col-md-8 mt-4">
                
                <?php if (!empty($response = $this->session->tempdata('customer'))): ?>
                       <div class="row mb-3">
                         <div class="col-md-12"> 
                            <h6>Repayment Details 
                              <div class="float-right">
                                <a href="#" class="btn btn-primary btn-sm">Print</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">Export CSV</a>
                              </div>
                            </h6>
                          </div>
                       </div>
                       <div class="card">
                         <div class="card-header"><h6>Customer Details</h6></div>
                         <div class="card-body">
                           <dl class="row">
                              <dt class="col-sm-3">Name</dt>
                              <dd class="col-sm-9"><?php echo $response->data->firstName.' '.$response->data->lastName ?></dd>
                              <dt class="col-sm-3">Customer ID</dt>
                              <dd class="col-sm-9"><?php echo $response->data->customerId ?></dd>
                              <dt class="col-sm-3">Phone</dt>
                              <dd class="col-sm-9"><?php echo $response->data->phoneNumber ?></dd>
                              <dt class="col-sm-3">Office</dt>
                              <dd class="col-sm-9"><?php echo $response->data->employerName ?></dd>
                              <dt class="col-sm-3">Salary Act</dt>
                              <dd class="col-sm-9"><?php echo $response->data->salaryBankCode ?> - <?php echo $response->data->salaryAccount ?></dd>
                            </dl>
                         </div>
                        
                      </div>
                       <div class="card">
                           <div class="card-header">
                              <h6>
                                Loan Details
                                <?php if ($response->data->status == "NEW"): ?>
                                    <span class="badge badge-success float-right"> <?php echo $response->data->status ?></span>
                                <?php elseif($response->data->status == "STOP"): ?>
                                    <span class="badge badge-dange float-right"> <?php echo $response->data->status ?></span>
                                <?php else: ?>
                                    <?php echo $response->data->status ?>
                                <?php endif ?>
                              </h6>
                              
                           </div>
                           <div class="card-body">
                              <dl class="row">
                                  <dt class="col-sm-3">Mandate Ref</dt>
                                  <dd class="col-sm-9"><?php echo $response->data->loanMandateReference ?></dd>
                                  <dt class="col-sm-3">Loan Amount</dt>
                                  <dd class="col-sm-9"><?php echo formatMoney($response->data->totalDisbursed) ?></dd>
                                  <dt class="col-sm-3">Date Disbursed</dt>
                                  <dd class="col-sm-9"><?php echo formatDate($response->data->dateOfDisbursement) ?></dd>
                                  <dt class="col-sm-3">Collection Start Date</dt>
                                  <dd class="col-sm-9"><?php echo formatDate($response->data->collectionStartDate) ?></dd>
                                  <dt class="col-sm-3">Total Repayment</dt>
                                  <dd class="col-sm-9"><?php echo $response->data->employerName ?></dd>
                                  <dt class="col-sm-3">Loan Balance </dt>
                                  <dd class="col-sm-9"><?php echo formatMoney($response->data->outstandingLoanBal) ?>
                                  <dt class="col-sm-3">Paid Into</dt>                              
                                  <dd class="col-sm-9"><?php echo $response->data->disbursementAccountBank.' - '.$response->data->disbursementAccount ?>
                                  </dd>
                                </dl>
                           </div>
                       </div>

                       <div class="card">
                         <div class="card-header"><h6>Repayment Details </h6></div>
                         <div class="card-body">
                            <?php if(!empty($repayments = $response->data->repayment)): ?>
                              <table class="table table-hover">
                               <thead>
                                  <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Ref</th>
                                  </tr>
                               </thead>
                               <tbody>
                                 <?php foreach ($repayments as $repayment): ?>
                                   <tr>
                                     <td><?php echo formatDate($repayment->deductiondate) ?></td>
                                     <td><?php echo formatMoney($repayment->transactionamount) ?></td>
                                     <td>
                                        <?php if ($repayment->paymentstatus == "paid"): ?>
                                            <span class="badge badge-success">Paid</span>
                                        <?php else: ?>
                                            <?php echo  $repayment->paymentstatus ?>
                                        <?php endif ?>
                                      </td>
                                      <td></td>
                                   </tr>
                                 <?php endforeach ?>
                               </tbody>
                              </table>
                            <?php else: ?>
                              <h6 class="">Great! Customer has no loans</h6>
                            <?php endif ?>
                         </div>    
                      </div>
                <?php endif ?>
                  
              </div>

             
          </div>
      </div>
    <!-- /.box -->
  </section>  
</div>

     
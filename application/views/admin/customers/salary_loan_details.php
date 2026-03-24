
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        
      <div class="container">

          <div class="row">
           
            <div class="col-md-8 mt-3 conatiner_certificate">
              <h5 class="mb-3">Salay History Details</h5>
              <?php if (!empty($customer)): ?>
                 <div class="row mb-2"> 
                    <div class="col-md-4 float-left">
                      <?php if ($customer->onremita == 1): ?>
                            <span class="badge badge-success float-left">on remita</span>
                          <?php else: ?>
                            <span class="badge badge-danger float-left">not on remita</span>
                        <?php endif ?>
                    </div>
                    <div class="col-md-8">
                      <div class="float-right">Checked on: <?php echo formatDate($customer->lastchecked) ?> 
                        <span class="badge badge-warning"><?php echo days_ago($customer->lastchecked) ?></span>
                      </div>
                    </div>
                 </div>
                 <div class="card">
                   <div class="card-header"><h6>Basic Details</h6></div>
                   <div class="card-body">
                     <dl class="row">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9"><?php echo $customer->fullname ?></dd>
                        <dt class="col-sm-3">CustomerID</dt>
                        <dd class="col-sm-9"><?php echo $customer->remitacustomerid ?></dd>
                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9"><?php echo $customer->phone ?></dd>
                        <dt class="col-sm-3">Office</dt>
                        <dd class="col-sm-9"><?php echo $customer->organization ?></dd>
                        <dt class="col-sm-3">BVN</dt>
                        <dd class="col-sm-9"><?php echo !empty($customer->bvn) ? $customer->bvn : "not returned" ?>
                        <dt class="col-sm-3">Account</dt>
                        <dd class="col-sm-9"><?php echo $customer->accountno ?>
                        <dt class="col-sm-3">Bank</dt>
                        
                        <dd class="col-sm-9"><?php echo !empty(getby(['code'=>$customer->bankcode],'banks')) ? getby(['code'=>$customer->bankcode],'banks')->name : 'unknown' ?>
                        </dd>
                      </dl>
                   </div>
                  
                </div>
                <div class="card">
                   <div class="card-header"><h6>Salary Details <span class="badge badge-warning float-right"><?php echo empty($salaries) ? 0 : sizeof($salaries) ?> payments</span></h6></div>
                   <div class="card-body">
                    <?php if(!empty($salaries)): ?>
                       <table class="table table-hover">
                         <thead>
                           <tr>
                             <th>Month</th>
                             <th>Net Salary</th>
                             <th>Payment Date</th>
                           </tr>
                         </thead>
                         <tbody>
                           <?php foreach ($salaries as $salary): ?>
                              <tr>
                                <td>
                                  <?php echo date('M Y',strtotime($salary->paymentDate)) ?>
                                </td>
                                <td>
                                  <?php echo formatMoney($salary->amount); ?>
                                </td>
                                <td>
                                  <?php echo formatDate($salary->paymentDate) ?>
                                </td>
                              </tr>
                           <?php endforeach ?>
                         </tbody>
                       </table>
                       <?php else: ?>
                         <h6 class="text-danger"> No salary data</h6>
                       <?php endif ?>
                     </div>
                      
                     <div class="card-footer">
                       <h6 class="float-right"> Total Salary Payments: <span class="badge badge-warning"><?php echo empty($salaries) ? 0 : sizeof($salaries) ?></span></h6>
                     </div>
                  
                  
                </div>
                <div class="card">
                   <div class="card-header"><h6>Loan Details  <span class="badge badge-danger float-right"><?php echo empty($loans) ? 0 : sizeof($loans) ?> loans</span></h6></div>
                   <div class="card-body">
                      <?php if(!empty($loans)): ?>
                        <table class="table table-hover">
                         <thead>
                            <tr>
                              <th>Provider</th>
                              <th>Loan Amount</th>
                              <th>Repayment</th>
                              <th>Outstanding</th>
                              <th>Status</th>
                              <th>Disbursed On</th>

                            </tr>
                         </thead>
                         <tbody>
                           <?php foreach ($loans as $loan): ?>
                             <tr class="<?php echo $loan->loanProvider == "CONSUMER MICROFINANCE BANK LTD" ? "table-warning" : "" ?>">
                               <td><?php echo $loan->loanProvider ?></td>
                               <td><?php echo formatMoney($loan->loanAmount) ?></td>
                               <td><?php echo formatMoney($loan->repaymentAmount) ?> <small><?php echo $loan->repaymentFreq ?></small></td>
                               <td><?php echo formatMoney($loan->outstandingAmount) ?></td>
                               <td>
                                  <?php if ($loan->status == "NEW"): ?>
                                      <span class="badge badge-success"> <?php echo $loan->status ?></span>
                                  <?php elseif($loan->status == "STOP"): ?>
                                      <span class="badge badge-danger"> <?php echo $loan->status ?></span>
                                  <?php else: ?>
                                      <?php echo  $loan->status ?>
                                  <?php endif ?>
                                </td>
                               <td><?php echo formatDate($loan->loanDisbursementDate) ?></td>
                             </tr>
                           <?php endforeach ?>
                         </tbody>
                        </table>
                      <?php else: ?>
                        <h6 class="">Great! No loans</h6>
                      <?php endif ?>
                   </div>
                  <div class="card-footer">
                     <h6 class="float-right"> Debt to Income Ratio: </h6>
                   </div>
                  
                </div>
              <?php else: ?>
                <div class="alert alert-danger ">
                   Customer not found
                </div>
              <?php endif ?>
             
            </div>

            <div class="col-md-4 mt-5">
              <button class="btn btn-outline-primary" id="btn-generate"> Download</button> 
              <a href="<?php echo base_url('admin/messaging/createsms/'.$customer->phone) ?>" class="btn btn-outline-primary">SMS</a> 
              <a href="<?php echo base_url('admin/customers/search') ?>" class="btn btn-outline-success">New</a>
              <a href="<?php echo base_url('admin/customers/search/'.$customer->phone) ?>" onclick="return confirm('Are you sure you want to check remita at this time?')" class="btn btn-outline-success">Re-Check</a> 
              <a href="<?php echo base_url('admin/customers/createloan?phone='.$customer->phone) ?>" class="btn btn-outline-secondary mt-3">Create Loan</a> 
            </div>   
          </div>
     
      </div>
    <!-- /.box -->
  </section>  
</div>
 <script>
        var buttonElement = document.querySelector("#btn-generate");
        buttonElement.addEventListener('click', function() {
            var pdfContent = document.querySelector(".conatiner_certificate");
            var optionArray = {
              margin:       1,
              padding: 3,
              filename:     '<?php echo str_replace(" ","_",$customer->fullname).strtotime(date('Y-d-m H:i:s')) ?>'+'_CMFB.pdf',
              format:'a4',
              image: {type: 'jpeg', quality: 1},
              jsPDF:        { orientation: 'portrait' },
              html2canvas:{ allowTaint: false, useCORS: true }
            };
            html2pdf().set(optionArray).from(pdfContent).save();
        });
    </script>


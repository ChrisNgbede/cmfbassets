<!-- DataTables -->
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
      <div class="container">
       
            <h4 class="pt-3 pb-3 ">Create a Loan</h4>
            <?php $this->load->view('admin/includes/_messages.php') ?>
            <div class="row">
                  
                    
                        <div class="col-md-8">
                             <?= form_open('admin/customers/saveloan') ?>
                                <div class="row">
                                    <input type="hidden" name="rid" id="rid">
                                    <input type="hidden" name="acode" id="acode">
                                     <div class="form-group col-md-4">
                                        <label for="phone" >Customer Phone</label>
                                        <input type="text" name="phone" class="form-control" value="<?php echo empty($phone) ? '' : $phone ?>" <?php echo empty($phone) ? '' : 'readonly' ?>>
                                      </div>
                                   
                                      <div class="form-group col-md-4 offer">
                                            <label>Principal</label>
                                            <input type="number" class="form-control" name="principal" value="" id="principal" required>
                                        </div>
                                        <div class="form-group col-md-4 offer">
                                            <label>Interest Rate</label>
                                            <input type="text" class="form-control" name="rate" value="" id="interest" required>
                                        </div>
                                         <div class="form-group col-md-4 offer">
                                            <label>Tenor in Months</label>
                                            <input type="number" class="form-control" name="tenor" value="" id="tenor" required>
                                        </div>
                                         <div class="form-group col-md-4 offer">
                                            <label>Monthly Repayment</label>
                                            <input type="number" class="form-control" name="repayment" value="" readonly id="repaymentAmount" required>
                                        </div>
                                        <div class="form-group col-md-4 offer">
                                            <label>Total Repayment</label>
                                            <input type="number" class="form-control" name="totalrepayment" value="" readonly id="totalRepayment" required>
                                        </div>
                                   
                    
                                    <div class="col-md-12">
                                        <input type="submit" name="createloan" class="btn btn-success" value="Save Loan">
                                    </div>
                                </div> 
                               <?= form_close() ?>

                        </div>
                        
                    
                     <div class="col-md-4" style="background:#efefef; padding: 20px; border: 1px solid lightgray; ">
                          <dl class="row">
                            <dt class="col-sm-3">Name:</dt>
                            <dd class="col-sm-9 name"> <span id="customername"><?php echo empty($name) ? '' :$name ?></span></dd>
                            <dt class="col-sm-3">Customer ID:</dt>
                            <dd class="col-sm-9 customerId"> <span id="customerid"><?php echo empty($customerid) ? '' :$customerid ?></span></dd>
                            <dt class="col-sm-3">Office:</dt>
                            <dd class="col-sm-9 office"> <span id="customeroffice"><?php echo empty($office) ? '' :$office ?></span></dd>
                            <dt class="col-sm-3">BVN:</dt>
                            <dd class="col-sm-9 bvn"> <span id="customerbvn"><?php echo empty($bvn) ? '' :$bvn ?></span></dd>
                            <dt class="col-sm-3">Last Checked:</dt>
                            <dd class="col-sm-9 bvn"> <span id="customerlastchecked"><?php echo empty($lastchecked) ? '' :formatDate($lastchecked) ?></span></dd>
                        </dl>
                    </div>

                    <div class="col-md-12 mt-4"> 
                        <?php if (empty($loans)): ?>
                            <div class="alert alert-success">
                                <h5>Customer has no loans existing on this platform</h5>
                            </div>
                            <?php else: ?>
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Loan Id</th>
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
                                                        <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo base_url('admin/customers/approveloan/'.$loan->id) ?>"  data-toggle="ajax-modal">Approval</a>
                                                        <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo base_url('admin/customers/stoploan/'.$loan->id) ?>"  data-toggle="ajax-modal">Terminate</a>
                                                     
                                                      </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $loan->id ?><br>
                                                    <small>Mandate Ref: <br><a href="#"><?php echo empty($loan->mandateref) ?  'none' : $loan->mandateref?></a></small>
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

                        <?php endif ?>
                    </div>

            </div>
       
      </div>
    <!-- /.box -->
  </section>  
</div>


<!-- DataTables -->
<script>
  $(function(){
      var d = new Date();

      $("#principal, #interest, #tenor").on("input", calculateRepayment);
      $("#rid").val(d.getTime());
      $("#acode").val(Math.floor(Math.random() * 110123389098));
  });


   function calculateRepayment(){
        var principal = parseFloat($("#principal").val());
        var interest = parseFloat($("#interest").val()) / 100;
        var tenor = parseFloat($("#tenor").val());

        // Calculate repayment amount using the formula for monthly payments
        var repaymentAmount = ((principal * interest) + (principal/tenor));
        var totalRepayment = ((principal * interest) + (principal/tenor)) * tenor;

        // Update the UI with the calculated repayment amount
        $("#repaymentAmount").val(repaymentAmount.toFixed(2));
        $("#totalRepayment").val(totalRepayment.toFixed(2));
    }


</script> 
     
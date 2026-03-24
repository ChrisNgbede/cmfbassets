
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Stop Loan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php if (empty($loan->mandateref)): ?>
                <div class="alert alert-danger m-5">
                    no active mandate
                </div>
                <?php else: ?>
                    <?= form_open('admin/customers/savestoploan', 'id="approval-form"'); ?>
                    <div class="modal-body">
                      
                        <div class="row">
                                     <input type="hidden" name="loanid" value="<?php echo $loan->id ?>">
                                     <input type="hidden" name="phone" value="<?php echo $loan->phone ?>">  
                                     <input type="hidden" name="rid" value="" id="rid1"> 
                                     <input type="hidden" name="mandateref" value="<?php echo $loan->mandateref ?>" id="mandaterefn">  
                                     <input type="hidden" name="acode" value="<?php echo $loan->authcode ?>" id="acode1">                 
                                     <div class="col-md-12">
                                          <ul class="list-unstyled"> 
                                            <li><b>Name: </b><?php echo $customer->fullname ?></li> 
                                            <li>
                                                <b>Loan Details:</b> <?php echo formatMoney($loan->loanamount) ?> for <?php echo $loan->numberofrepayments ?> months <br>
                                                <b>Monthly Repayment: </b> <?php echo formatMoney($loan->collectionamount) ?> <br>
                                                <b>Total Repayment: </b><?php echo formatMoney($loan->totalcollectionamount) ?>
                                            </li>
                                          </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="comment">Comment</label>
                                        <textarea name="comment" placeholder="write a comment" id="comment" class="form-control"></textarea>
                                    </div>
                          </div>
                    
                    </div>
                    <div class="modal-footer justify-content-between">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       <div class="float-right">
                           <button type="submit" class="btn btn-success" id="submit_approve" name="approve" onclick="return confirm('Are you sure you want to terminate this mandate? A termination notification will be sent to remita')" value="1" >Proceed</button>
                       </div>
                    </div>
                     <?= form_close();?>
            <?php endif ?>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

        <script type="text/javascript">
            $(function(){
                var d = new Date();
                $('#rid1').val(d.getTime());
              
            })
        </script>
     
<!-- DataTables -->
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        
      <div class="container">
          
          <div class="row">
              <div class="col-md-8 mt-5">
                <h5 class="mb-3">Search with bank account</h5>
                 <div class="row">
                   <div class="col-md-6 form-group">
                      <label for="accountno">Account No</label>
                      <input type="text" class="form-control" id="accountno" placeholder="NUBAN">
                      <div class="account-val-msg"></div>                
                    </div>
                    <div class="col-md-6 form-group">
                      <label>Bank</label>
                      <select name="bank" class="form-control" id="bank">
                        <?php foreach ($banks as $bank): ?>
                          <option value="<?php echo $bank->code ?>"><?php echo $bank->name ?></option>
                        <?php endforeach ?>
                      </select>
                      <div class="bank-val-msg"></div>
                    </div>
                 </div>
                 <button type="button" class="btn btn-primary" id="searchphone">Get Salary History</button>
                <div id="loading-container" style="display:none">
                  <img src="<?php echo base_url().'assets/dist/img/Running dog.gif' ?>"> Searching...
                </div>
                <span class="val-msg mt-4 ml-1"></span>
                <div class="row">
                    <div class="col-md-12 mt-4">
                      <div class="result card mt-4 p-4" style="display: none;">
                         <dl class="row">
                            <dt class="col-sm-3">Name</dt>
                            <dd class="col-sm-9 name"></dd>
                            <dt class="col-sm-3">Customer ID</dt>
                            <dd class="col-sm-9 customerId"></dd>
                            <dt class="col-sm-3">Office</dt>
                            <dd class="col-sm-9 office"></dd>
                            <dt class="col-sm-3">BVN</dt>
                            <dd class="col-sm-9 bvn"></dd>
                        </dl>
                        <a href="" id="salarydetails" class="btn btn-primary btn-sm">View Salary Details</a>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mt-3">

                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Recent Salary Search</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <ul class="products-list product-list-in-card pl-2 pr-2">
                        <?php foreach ($customer_searchs as $customer_search): ?>
                          <?php 
                            $customer = getby(['phone'=>$customer_search->phone],'customers');
                            $salary = getby(['phone'=>$customer_search->phone],'customer_salary_loan'); 
                            
                          ?>

                          <li class="item">
                         
                            <div class="product-info">
                              <a href="<?php echo base_url('admin/customers/salary_loan_details/'.$customer->phone) ?>" class="product-title"><?php echo $customer->fullname ?>
                                 <?php if ($customer->onremita == 1): ?>
                                    <span class="badge badge-success float-right">on remita</span>
                                  <?php else: ?>
                                    <span class="badge badge-danger float-right">not on remita</span>
                                <?php endif ?>
                              </a>
                                <span class="product-description">
                                
                                
                                 
                                  <?php echo $customer->phone ?> - 
                                    <a href="<?php echo base_url('admin/customers/salary_loan_details/'.$customer->phone) ?>" class="text-dark">Salary:
                                     <?php if (!empty($salary)): ?>
                                        <?php $sal = json_decode($salary->salary); ?>
                                            <?php echo formatMoney($sal[0]->amount) ?>
                                            <span class="badge badge-warning"><?php echo sizeof($sal) ?> Ms</span>
                                        <?php else: ?>
                                          <span class="badge badge-danger">no salary</span>
                                    <?php endif ?>
                                      
                                      
                                    </a>
                                  <br>
                                  <small><b>Office:</b> <?php echo $customer->organization ?></small>
                                </span>
                                <?php if (!empty($salary->loan)): ?>
                                      <a href="<?php echo base_url('admin/customers/salary_loan_details') ?>"><span class="badge badge-warning"><?php echo sizeof(json_decode($salary->loan)) ?> Loans</span></a>
                                   <?php else: ?>
                                      <span class="badge badge-secondary badge-secondary">No Loans</span>
                                <?php endif ?>
                                <small class="float-right"><?php echo formatDate($customer->lastchecked) ?></small>

                            </div>
                          </li>
                        <?php endforeach ?>
                        
                        <!-- /.item -->
                      
                       
                      </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                      <a href="<?php echo base_url('admin/customers/search_batch') ?>" class="btn btn-secondary btn-sm"><i class="fa fa-upload"></i> Batch </a>
                      <a href="<?php echo base_url('admin/customers/search_alt') ?>" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i> Alternative </a>
                      <a href="<?php echo base_url('admin/customers') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <!-- /.card-footer -->
                  </div>
              </div>

             
          </div>
      </div>
    <!-- /.box -->
  </section>  
</div>


<!-- DataTables -->
<script>
   $("body").on("click","#searchphone",function(){
      if ($('#accountno').val() == ""){
          $(".account-val-msg").text('kindly input NUBAN first').addClass('text-danger');
      }else if($('#bank').val() == ""){
         $(".bank-val-msg").text('kindly select bank').addClass('text-danger');
      }else{

          $(".account-val-msg").text(""); 
          $(".bank-val-msg").text(""); 
          var d = new Date();   
          var accountno = $('#accountno').val();    
          var bank = $('#bank').val();     
          $.post('<?=base_url("admin/customers/get_salary_history")?>',
          {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
            accountno : accountno,
            bank : bank,
            altsearch : true,
            rid: d.getTime(),
            acode: Math.floor(Math.random() * 110123389098),

          },
          function(data){
            var response = JSON.parse(data);            
            if (response.status == 91){
                $.notify(response.msg, "error");
                $('.val-msg').text(response.responseMsg).addClass('text-danger');
            }else if(response.status == "success"){
                $.notify("Yay! Customer found", "success");
                $('.val-msg').html('<i class="fa fa-check"></i> Customer found').removeClass('text-danger').addClass('text-success');
                $(".result").show();
                $('.name').text(response.data.customerName);
                $('.customerId').text(response.data.customerId);
                $('.office').text(response.data.companyName);
                $('.bvn').text(response.data.bvn);
                $("#salarydetails").attr("href",'<?= base_url("admin/customers/salary_loan_details/") ?>' + phone); 
            }else{
                $.notify(response.responseMsg, "error");
            }
           
            // response.responseMsg
            
          });
      }
      
    });
</script> 
     
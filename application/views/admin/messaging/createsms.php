<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="content-wrapper mt-5">
    <!-- Main content -->
    <section class="content">
      <div class="row">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                      <div class="d-inline-block">
                          <h3 class="card-title">Send SMS</h3>
                      </div>
                      <div class="d-inline-block float-right">
                         <a href="<?= base_url('admin/messaging/sms'); ?>" class="btn btn-success">SMS Transactions</a>
                      </div>
                    </div>
                    <div class="card-body">
               
                        <?php $this->load->view('admin/includes/_messages.php') ?>
                         <?php echo form_open("admin/messaging/createsms", 'class="validation" name="myform" id="myform"'); ?>
                        <div class="row">
                              <!-- /.card-header -->
                        
                                   <div class="form-group col-md-6">
                                      <label>Message Category</label>
                                         <select class="form-control" name="recipientcategory" id="category">
                                            <option value="markteting">Marketing</option>
                                            <option value="offer">Loan Offer</option>
                                         </select>
                                       </div> 
                                     <div class="form-group col-md-6">
                                        <label>Template</label>
                                        <select name="template" class="form-control" id="template">
                                            <option value="">--select template--</option>
                                            <?php foreach ($templates as $template): ?>
                                                <option value="<?php echo $template->id ?>"><?php echo $template->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                     <div class="form-group col-md-4">
                                         <label>Account Officer</label>
                                            <select name="staff" class="form-control" id="staff">
                                                <option value="">--select staff--</option>
                                                <?php foreach ($staffs as $staff): ?>
                                                    <option value="<?php echo $staff->id ?>"><?php echo $staff->firstname.' '.$staff->lastname ?></option>
                                                <?php endforeach ?>
                                            </select>
                                     </div> 
                                     <div class="form-group col-md-4 offer">
                                        <label>Principal</label>
                                        <input type="number" class="form-control" name="principal" value="" id="principal">
                                    </div>
                                    <div class="form-group col-md-4 offer">
                                        <label>Rate</label>
                                        <input type="number" class="form-control" name="rate" value="" id="interest">
                                    </div>
                                     <div class="form-group col-md-4 offer">
                                        <label>Tenor</label>
                                        <input type="number" class="form-control" name="tenor" value="" id="tenor">
                                    </div>
                                     <div class="form-group col-md-4 offer">
                                        <label>Monthly Repayment</label>
                                        <input type="number" class="form-control" name="repayment" value="" readonly id="repaymentAmount">
                                    </div>
                                    <div class="form-group col-md-4 offer">
                                        <label>Total Repayment</label>
                                        <input type="number" class="form-control" name="totalrepayment" value="" readonly id="totalRepayment">
                                    </div>

                                    <?php if (!empty($_GET['phone']) || !empty($phone)): ?>
                                       <?php if (!empty($_GET['phone'])): ?>
                                          <?php $phone = $_GET['phone']; ?>
                                       <?php elseif(!empty($phone)): ?>
                                            <?php $phone = $phone; ?>
                                       <?php endif ?>
                                        <div class="form-group col-md-12">
                                            <label>Recipient</label>
                                            <input type="text" class="form-control" name="recipient[]" value="<?php echo $phone ?>" readonly>
                                        </div>
                                    <?php else: ?>
                                         <div class="form-group col-md-12">
                                          <label>Recipient</label>
                                              <select name="recipient[]" class="form-control select2bs4" multiple="multiple" style="width:100%">
                                                  <?php foreach ($customers as $customer): ?>
                                                      <option value="<?php echo $customer->phone ?>"><?php echo $customer->fullname.' - '.$customer->phone; ?></option>
                                                  <?php endforeach ?>
                                              </select>
                                        </div> 

                                    <?php endif ?>
                                   
                                
                               
                                
                                                           
                                 <div class="form-group col-md-12">
                                    <label for="content" >Message</label>
                                     <span id="msgparams">
                                              <?php
                                                foreach ($shortcodes as $shortcode) {
                                                    ?>
                                                    <input type="button" name="myBtn" class="btn btn-outline-secondary btn-sm mb-2" value="<?php echo $shortcode->name; ?>" onClick="addtext1(this);">
                                                   
                                                    <?php
                                                }
                                                ?>
                                          </span> 
                                     <textarea name="message" cols="40" rows="3" class="form-control tip textinput" id="message" required></textarea>
                                  </div>
                                 
                            <div class="form-group col-12">
                                <button onclick="window.history.back()" class="btn btn-outline-danger">Go Back</button>
                                <?= form_submit('send_message', 'Send Message', 'class="btn btn-success float-right" id="send_btn"'); ?>
                            </div>
                      </div>
                      <?php echo form_close(); ?>
                    </div> 
                   </div>
            </div> 
      </div> 
    </section> 
</div>




<script>
    function addtext1(ele) {
        var fired_button = ele.value;
        document.myform.message.value += fired_button;
    }
</script>
<script>
    $(document).ready(function () {
         $(".offer").hide();
        $('#send_btn').attr('disabled','disabled');
        $('#template').on('change', function () {
            var iid = $(this).val();
            var type = 'sms';
            if (!iid){
                $('#send_btn').attr('disabled','disabled');
            }else{
                $('#send_btn').removeAttr('disabled');
                $('#message').val("");
            }
            $.ajax({
                url: '<?php echo base_url('admin/messaging/getManualSMSTemplateMessageboxText') ?>' + '?id=' + iid + '&type=' + type,
                method: 'GET',
                data: '',
                dataType: 'json',
                success:function(response)
                {
                   $('#myform').find('[name="message"]').val(response.template.message).end();    
                 
                }
            })
        });

        $("#principal, #interest, #tenor").on("input", calculateRepayment);
    });

     $(document).on('change','#category',function(){
      if(this.value == 'offer'){
        $(".offer").slideDown();
      }else{
         $(".offer").slideUp();
      }
      
    });

    $(document).on('change','#group',function(){
      if(this.value == ''){
        $('#customer').html('<option value="">Select Option</option>');
        return false;
      }
      var data =  { group : this.value }
      data['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({
        type: "POST",
        url: "<?= base_url('admin/messaging/getgroupcustomers') ?>",
        data: data,
        dataType: "json",
        success: function(obj) {
          $('#customer').html(obj.msg);
       },

      });
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

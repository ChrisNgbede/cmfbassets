<!-- DataTables -->
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <!-- Main content -->
    <section class="content">
       
      <div class="container">
          <div class="row">
              <div class="col-md-8 mt-5">
                <div class="row">
                    <input type="hidden" name="rid" id="rid">
                    <input type="hidden" name="acode" id="acode">
                     <div class="form-group col-md-4">
                        <label for="phone" >Customer Phone</label>
                        <input type="text" name="phone" class="form-control">
                      </div>
                    <!--  <div class="form-group col-md-4">
                        <label for="title" > Tenure</label>
                        <select name="no" class="form-control">
                          <?php for ($i=1; $i < 48; $i++) { ?>

                            <option value="<?php echo $i ;?>"> <?php echo $i ;?> Month<?php echo $i == 1 ? '' : 's'  ;?></option>
                            
                          <?php } ?>
                        </select>
                      </div> -->
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
                   
                    <div id="loading-container" style="display:none">
                      <img src="<?php echo base_url().'assets/dist/img/Running dog.gif' ?>"> Disbursing...
                    </div>                   
                </div>
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
     
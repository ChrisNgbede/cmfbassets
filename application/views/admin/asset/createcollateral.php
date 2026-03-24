<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="content-wrapper mt-4">
    <!-- Main content -->
    <section class="content">
      <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                      <div class="d-inline-block">
                          <h5>Register a Collateral</h5>
                      </div>
                      <div class="d-inline-block float-right">
                         <a href="<?= base_url('admin/asset/listcollateral'); ?>" class="btn btn-success">Collateral List</a>
                      </div>
                    </div>
                    <div class="card-body">
               
                        <?php $this->load->view('admin/includes/_messages.php') ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Enter customer account number to start</h5>
                            </div> 
                            <div class="col-md-6">
                                <div class="input-group input-group-lg">
                                      <input type="text" class="form-control" id="nuban" placeholder="eg 11002990309" value="" >
                                  <span class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-flat" id="searchnuban">Search</button>

                                  </span>
                                </div>
                                <div class="val-msg"></div>
                            </div>
                        </div>
                         <?php echo form_open_multipart("admin/asset/createcollateral", 'class="validation form-sm" name="myform" id="myform"'); ?>
                           <input type="hidden" name="nuban" value="" id="form-nuban"/>

                        <div class="row mt-3">
                            <div class="create-collateral col-md-6">
                                
                            </div>
                            <div class="col-md-1">
                                
                            </div>
                            <div class="col-md-5" id="listOfCOllaterals">
                                
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
   $("body").on("click","#searchnuban",function(e){
      if (document.getElementById('nuban').value == ""){
          $(".val-msg").text('kindly input customer account no').addClass('text-danger');
      }else{
          $(".val-msg").text("");          
            $.post('<?=base_url("admin/asset/findcollateral")?>',
            {
              '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
              nuban : $('#nuban').val(),
            },
            function(data){
                var response = JSON.parse(data);
                var base_url = '<?php echo base_url() ?>';
                $('#form-nuban').val(document.getElementById('nuban').value);
                 if (response.status == 91) {
                      $('.val-msg').html(response.msg).addClass('text-danger');
                      $(".create-collateral").html("");
                      $("#listOfCOllaterals").html("");

                  }else{            
                      $.notify("Yay! Collateral found", "success");
                      $('.alert').text('Found some collaterals. Manage them below...').addClass('alert-success');
                      $('.val-msg').html('<i class="fa fa-check"></i>Yippe!! Found some collaterals...See below.').removeClass('text-danger').addClass('text-success');

                      const collaterals = response.collateralData;
                      console.log(collaterals);
                      const collateralList = collaterals.map((collateral)=>
                        `<div class="card border-1 border-secondary rounded-3">
                            <div class="card-body">
                                <h5 class="card-title collateral-name">${collateral.name}</h5>
                                <p class="card-text collateral-desc">${collateral.description.substring(0, 100) + '...'}</p>
                                <span class="card-text date-registered"><small class="text-muted"><b class="text-dark">Registered on: </b> ${collateral.dateregistered}</small></span>
                                <span class="badge badge-warning">${collateral.status}</span>
                                <a href="${base_url + 'admin/asset/collateraldetails/' + collateral.id}" class="btn btn-primary btn-sm manage-collateral float-right">Manage</a>
                            </div>
                        </div>`);
                      document.getElementById('listOfCOllaterals').innerHTML = 
                          `<div class="row">
                             <div class="col-md-12">
                                 <div class="alert alert-success">
                                    List of Collaterals found
                                 </div>
                             </div>
                              <div class="col-md-12" >
                                 <div>
                                     ${collateralList}
                                 </div>
                              </div>
                           
                        </div>`;

                     
                      
                }  

                $(".create-collateral").html(`<?php $this->load->view('admin/asset/createcollateralform') ?>`);         
            });

      }
      
    });

    // Auto-trigger search if we are returning from a failed validation
    <?php if($this->input->post('save_collateral')): ?>
    $(document).ready(function() {
        var prefilledNuban = '<?= $this->input->post('nuban') ?>';
        if(prefilledNuban) {
            $('#nuban').val(prefilledNuban);
            $('#searchnuban').trigger('click');
        }
    });
    <?php endif; ?>

  
</script>

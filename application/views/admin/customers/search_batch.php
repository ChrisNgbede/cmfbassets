<!-- DataTables -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        
      <div class="container">
          <div class="row">
              <div class="col-md-8 mt-4">
                   <div class="card">
                      <div class="card-header"><h6> Batch Customers Upload</h6></div>
                      <div class="card-body">
                        <?php $this->load->view('admin/includes/_messages.php') ?>
                        <?= form_open_multipart(site_url('admin/customers/upload'),'id="myform"')  ?>
                            <input type="hidden" name="acode" value="" id="acode">
                            <div class="row">
                              
                                <div class="form-group col-md-6"> 
                                  <label>Mode</label>
                                  <select name="mode" class="form-control">
                                    <option value="2">Upload & Search</option>
                                    <option value="1">Upload Only (Search Manually)</option>
                                  </select>
                                </div>
                                 <div class="form-group col-md-6"> 
                                  <label>Include Office </label>
                                  <select name="office" class="form-control select2" id="include_office">
                                     <option value="no">No</option>
                                     <option value="others">Others</option>
                                      <?php foreach ($offices as $office): ?>
                                        <?php 
                                             $department = !empty($office->department) ? 'Dep: '.$office->department : '';
                                             $agency = !empty($office->ageny) ? 'Agen: '.$office->agency : '';
                                             $ministry = !empty($office->ministry) ? 'Min: '.$office->ministry : '';
                                         ?>

                                         <option value="<?php echo $office->id ?>"><?php echo $ministry.' '.$department.' '.$agency ?></option>
                                      <?php endforeach ?>
                                      <option value="others">Others</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-6" id="other_office" style="display:none">
                                  <label for="others">Other Office</label>
                                  <input type="text" name="other_office" class="form-control" placeholder="enter office name">
                                </div>
                                 <div class="form-group col-md-6">
                                  <label>Select CSV <small class="text-danger">** Max records 500 & File size 2mb**</small></label>
                                   <input type="file" class="form-control" name="csv_file" accept=".csv" required>
                                   <label class="float-right"><small><a href="<?php echo base_url('uploads/templates/batch_customers.csv') ?>" class="text-primary">Download Upload template</a></small></label>
                                </div>

                                <div class="col-md-12">
                                  <input type="submit" class="btn btn-primary" value="Upload File" name="submit" id="upload-btn">
                                </div>
                            </div>
                             
                          <?= form_close() ?>
                      </div>
                     
                   </div>
               
              </div>
              <div class="col-md-4">

                  
              </div>

             
          </div>
      </div>
    <!-- /.box -->
  </section>  
</div>


<!-- DataTables -->
<script>
   $(function(){
      $('#acode').val(Math.floor(Math.random() * 110123389098));
      $('#include_office').change(function(){
        if ($(this).val() == "others") {
            $('#other_office').show();
        }else{
            $('#other_office').hide();
        }
      })
   });
</script> 

<script>
    $('#myform').on('submit',function(event){
      $("#upload-btn").attr("disabled",true);
      $(".form-group").hide();
        $("#upload-btn").val("processing upload. please wait...");
    })   
</script>

     
<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title">Create SMS Template</h3>
          </div>
          <div class="d-inline-block float-right">
             <a href="<?= base_url('admin/messaging/smstemplates'); ?>" class="btn btn-success">SMS Templates</a>
          </div>
        </div>
        <div class="card-body">
   
            <?php $this->load->view('admin/includes/_messages.php') ?>
            
            <?php echo form_open_multipart("messaging/newtemplate", 'class="validation" name="myform"'); ?>
            <div class="row">
                  <!-- /.card-header -->
            
                       <div class="form-group col-md-3">
                          <label>Recipient Group</label>
                            <?php
                              $grp[''] = "select group";
                              $grp['all'] = "All Groups";
                              foreach($groups as $group) {
                                  $grp[$group->id] = $group->name;
                              }
                              ?>
                              <?= form_dropdown('group', $grp,set_value('group'), 'class="form-control select2" id="group" style="width:100%;"'); ?>
                           </div> 
                   
                        <div class="form-group col-md-3">
                            <label for="firstname" class="col-md-12 control-label">Recipient Member</label>
                            <div class="col-md-12">
                              <select name="member" class="form-control" id="member">
                                <option value="">Select Option</option>
                                <option value="all">All Members</option>
                                <option value="selectedmembers">*Selected Members*</option>

                              </select>
                            </div>
                          </div>
                        <div class="form-group col-md-3" style="display:none" id="showselectedmembers">
                          <label>Choose Members</label>
                            <?php
                              foreach($members as $member) {
                                  $mem[$member->id] = $member->firstname.' '.$member->lastname;
                              }
                              ?>
                              <?= form_dropdown('selectedmembers', $mem,set_value('selectedmembers'), 'class="form-control select2" multiple="multiple" id="selectedmembers" style="width:100%;"'); ?>
                        </div> 
                    
                       <div class="form-group col-md-3">
                            <label>Template</label>
                            <?php foreach($templates as $template){ $tem[$template->id] = $template->name; } ?>
                            <?= form_dropdown('template', $tem, set_value('template', $template->name), 'id="template" data-placeholder="' . 'Select Template'. '" class="form-control select2" style="width:100%;"'); ?>
                        </div>
                    
                                               
                     <div class="form-group col-md-12">
                        <label for="content" >Message</label>
                        <span id="msgparams">
                                  <?php
                                    $count = 0;
                                    foreach ($shortcodes as $shortcode) {
                                        ?>
                                        <input type="button" name="myBtn" class="btn btn-default btn-sm mb-2" value="<?php echo $shortcode->name; ?>" onClick="addtext1(this);">
                                        <?php
                                        $count+=1;
                                        if ($count === 3) {
                                            ?>
                                            <br>
                                            <?php
                                        }
                                    }
                                    ?>
                              </span>
                         <textarea name="message" cols="40" rows="3" class="form-control tip textinput" id="message" required></textarea>
                      </div>
                     
                    <div class="form-group">
                          <button onclick="window.history.back()" class="btn btn-danger">Go Back</button>
                            <?= form_submit('send_message', 'Send Message', 'class="btn btn-success"'); ?>
                        </div>
          </div>
          <?php echo form_close(); ?>
        </div>  
    </section> 
</div>






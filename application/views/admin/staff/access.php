  
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="myModalLabel1"> Manage Staff Access</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('admin/staff/access', 'id="wallet-form"'); ?>
      <input type="hidden" name="id" id="id" value="<?= empty($user->admin_id) ? "" : $user->admin_id ?>">
      <input type="hidden" name="staffid" id="staffid" value="<?= $staff->id?>">
      <div class="modal-body">
            <div class="form-body">
                <div class="row">
                  <div class="form-group col-12 mb-2">
                    <label for="username"> Username</label>
                     <?= form_input('username', empty($user->username) ? set_value('username', strtolower(mb_substr($staff->firstname,0,1).$staff->lastname)) : $user->username, 'class="form-control" id="username"'); ?>
                  </div>
                  <div class="form-group col-6 mb" style="display: none;">
                    <label for="email"> Email</label>
                     <?= form_input('email', empty($user->email) ? set_value('email',strtolower($staff->email)) : $user->email, 'class="form-control" id="email"'); ?>
                  </div>
                 <div class="form-group col-md-12">
                    <label for="password" >Password</label>
                      <input type="password" name="password" class="form-control" id="password">
                  </div>
                  <?php if (empty($user)): ?>
                      <div class="form-group col-md-12">
                        <label for="confirm_password" >Confirm Password</label>
                          <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                      </div>

                  <?php endif ?>
                   
                  <div class="form-group col-md-12">
                    <label for="role" >Role</label>
                      <select name="role" class="form-control" id="role">
                        <option value="">select role</option>
                        <?php foreach($roles as $role): ?>
                          <option value="<?= $role->admin_role_id; ?>" <?= !empty($user) && $user->admin_role_id == $role->admin_role_id ? 'selected' : '' ?> ><?= $role->admin_role_title; ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                 
              </div>
        <div class="box-footer">
          <button type="button" class="btn grey btn-danger" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary float-right" id="submit">Submit</button>
        </div>
        <?= form_close();?>
      </div>
    </div>
</div>
</div>
<script type="text/javascript">
  $('#submit').click(function (e){
     e.preventDefault();
     $.post('<?=base_url("admin/staff/access")?>',
      {
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
        username: $('#username').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        confirm_password: $('#confirm_password').val(),
        role: $('#role').val(),
        submit: 1,
        id: $('#id').val(),
        staffid: $('#staffid').val()

      },
      function(data){
        var response = JSON.parse(data);            
        if (response.status == 91){
            $.notify(response.msg, "error");
        }else if(response.status == 0){
            $.notify(response.msg, "success");
            $('.modal').modal('toggle');
        }else{
            $.notify(response.msg, "error");
        }            
      });      

  })
</script>


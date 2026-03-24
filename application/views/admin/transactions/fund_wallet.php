
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1"> Set Wallet Limit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('admin/transactions/fund_wallet', 'id="wallet-form"'); ?>

      <div class="modal-body">
               <div class="form-body">
            <div class="row">
             
               
              <div class="form-group col-6 mb-2">
                <label for="amount"> Amount</label>
                 <?= form_input('amount', set_value('amount'), 'class="form-control" id="amount"'); ?>
              </div>
              <div class="form-group col-6 mb-2">
                <label for="type">Credit or Debit</label>
                <select class="form-control" name="type" id="type">
                  <option value="cr">Credit</option>
                  <option value="dr">Debit</option>
                </select>
              </div>
              <div class="form-group col-6 mb-2">
                 <label for="user">User</label>
                 <select class="form-control" name="userid" id="userid">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user->admin_id ?>"><?php echo $user->firstname.' '.$user->lastname ?></option>
                    <?php endforeach ?>
                 </select>
              </div>
               <div class="form-group col-12 mb-2">
                <label for="narration">Narration</label>
                <textarea name="narration" class="form-control" placeholder="Enter narration" id="narration"></textarea>
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
     if ($('#amount').val() != ""){
         $.post('<?=base_url("admin/transactions/fund_wallet")?>',
          {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
            amount : $('#amount').val(),
            narration: $('#narration').val(),
            userid: $("#userid").val(),
            type: $('#type').val(),
            submit: 1

          },
          function(data){
            var response = JSON.parse(data);            
            if (response.status == 91){
                $.notify(response.msg, "error");
                $('#amount').val("");
                $('#narration').val("");
            }else if(response.status == 0){
                $.notify(response.msg, "success");
                $('#wallet_balance').text(response.balance);
                $('.modal').modal('toggle');
            }else{
                $.notify(response.msg, "error");
            }            
          });      
     }else{
        $.notify('please enter an amount', "error");
     }


  })
</script>

<script>
$(document).ready(function() {
  $('#amount').on('input', function() {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });
});
</script>

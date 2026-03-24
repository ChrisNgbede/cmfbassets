<?php if(!isset($footer)): ?>

  <footer class="main-footer">
    <strong><?= $this->general_settings['copyright']; ?></strong>
    <div class="float-right d-none d-sm-inline-block">
     
    </div>
  </footer>

  <?php endif; ?>  
  <div class="modal" id="myModal" role="dialog" aria-labelledby="myModalLabel2"></div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  
</div>


<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/fastclick/fastclick.js"></script>
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/notify/notify.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>




<script>

var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';

var csfr_token_value = '<?php echo $this->security->get_csrf_hash(); ?>';

$(function(){
  $('.datepicker').datepicker({
    autoclose: true,
    format:"yyyy-mm-dd"
  });

   $('.select2').select2({
      theme: 'bootstrap4'
    })
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $(document).ajaxStart(function () {
        $('#loading-container').show();
    }).ajaxStop(function () {
        $('#loading-container').hide();
    });

    // Global Form Submission Processing Feedback
    $(document).on('submit', 'form', function(e) {
        var $form = $(this);
        
        // Skip for forms that have specific handling or no-processing class
        if ($form.hasClass('no-processing')) return;

        var $btn = $form.find('button[type="submit"], input[type="submit"]');
        
        // Only trigger if native validation passes
        if (this.checkValidity()) {
            // Delay slightly to allow the click event to finish (important for some browsers)
            setTimeout(function() {
                $btn.each(function() {
                    var $this = $(this);
                    if ($this.is('input')) {
                        $this.val('Processing...');
                    } else {
                        // Keep width to prevent jumping
                        var width = $this.outerWidth();
                        $this.css('min-width', width + 'px');
                        $this.html('<i class="fas fa-spinner fa-spin mr-1"></i> Processing...');
                    }
                    $this.addClass('disabled').prop('disabled', true);
                });
            }, 10);
        }
    });

    // Processing feedback for specific action buttons (links or non-submits)
    $(document).on('click', '.btn-process', function() {
        var $this = $(this);
        if (!$this.hasClass('disabled')) {
            var width = $this.outerWidth();
            $this.css('min-width', width + 'px');
            $this.html('<i class="fas fa-spinner fa-spin"></i>');
            $this.addClass('disabled').prop('disabled', true);
        }
    });
    
  $(document).on("click", '[data-toggle="ajax-modal"]', function(t) {
    t.preventDefault();
    var e = $(this).attr("href");
    return $.get(e).done(function(t) {
     $("#myModal").html(t).modal({
      backdrop: "static"
     })
    }), !1
   })
 
  $('[data-toggle="popover"]').popover();

  $(document).on('click', '.cancelpop', function(){
         $('[data-toggle="popover"]').popover('hide');
  })
});
</script>



</body>
</html>

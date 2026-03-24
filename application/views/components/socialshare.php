 <?php 

  ?>
   <h6 class="mt-3">Share on Social Media</h6>

<div class="tp-ct-info pt-10 pb-50">
    <div class="tp-ct-info-icons">
        <span><a href='//www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>' class="social"><i class="fab fa-facebook-f"></i></a></span>
        <span><a href='//twitter.com/intent/tweet?text=<?= $headline ? $headline : '' ?>&url=<?php echo $link; ?>' class="social"><i class="fab fa-twitter"></i></a></span>
        <span><a href='whatsapp://send?text=<?php echo $link ?>" data-action="share/whatsapp/share' class="social"><i class="fab fa-whatsapp"></i></a></span>
    </div>
</div>

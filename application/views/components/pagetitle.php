 <style type="text/css">
   body.light .navbar.nochan *{
     color: #1D2D7A;
   }
 </style>
      <main>
           <div class="vline tline"></div>
          <header class="pg-header">
                <div class="container-xxl">
                    <div class="row">
                        <div class="col-lg-7 col-md-10">
                            <div class="cont mb-80">
                                <?php if (!empty($pageintro)): ?>
                                     <h3 class="fw-700"><?= $pageintro; ?></h3>
                                     <h5 class="fw-100"><?= $pagedescription; ?></h5>

                                <?php endif ?>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="background bg-img parallaxie" data-background="<?php echo base_url().getSettings()->header_image;?>" data-overlay-dark="4" style="background-image: url(&quot;<?php echo base_url().getSettings()->header_image;?>&quot;); background-size: cover; background-repeat: no-repeat; background-attachment: fixed; background-position: center 32.6167px;">
                    <div class="under">
                        <h4 class="stroke fw-800"><?= $pagetitle; ?></h4>
                    </div>
                    <div class="up">
                        <h4 class="stroke fw-800"><?= $pagetitle; ?></h4>
                    </div>
                    <div class="bg-img dots-bg" data-background="assets/img/dots-glitch.png" style="background-image: url(&quot;<?php echo base_url().getSettings()->header_image;?>&quot;);"></div>
                </div>
            </header>
      </main>
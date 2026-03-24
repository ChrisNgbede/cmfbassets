<!-- DataTables -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-3">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title">FHUB Loan Tenures </h3>
          <?php
?>
        </div>

      </div>
      <div class="card-body">

        <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php')?>

        <div class="row">

          <div id="tenures" class="table-responsive">

            <table id="<?= empty($tenures) ? '' : 'grouptable'?>" class="table table-striped ">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Tenures</th>

                </tr>
              </thead>
              <tbody>
                <?php if (!empty($tenures)): ?>
                <?php foreach ($tenures as $tenure): ?>
                <tr>
                  <td>
                    <?php echo $tenure->productName?>
                  </td>
                  <td>
                    <?php if (empty($tenure->loanProducts)): ?>
                    <span class="badge badge-danger">no defined tenures</span>
                    <?php
    else: ?>
                    <?php foreach ($tenure->loanProducts as $producttenure): ?>
                    <div class="well">
                      <ul class="list-unstyled">
                        <li>id :
                          <?php echo $producttenure->id?>
                        </li>
                        <li>name :
                          <?php echo $producttenure->name?>
                        </li>
                        <li>Minimum Amount :
                          <?php echo $producttenure->minimumAmount?>
                        </li>
                        <li>Maximum Amount:
                          <?php echo $producttenure->maximumAmount?>
                        </li>
                        <li>Minimum Duration :
                          <?php echo $producttenure->minimumDuration?>
                        </li>
                        <li>Maximum Duration :
                          <?php echo $producttenure->maximumDuration?>
                        </li>
                        <li>Interest Rate :
                          <?php echo $producttenure->interestRate?>
                        </li>
                        <li>Created On :
                          <?php echo $producttenure->date_created?>
                        </li>
                        <li>Status :
                          <?php if ($producttenure->status): ?>
                          <span class="badge badge-success">active</span>
                          <?php
        else: ?>
                          <span class="badge badge-danger">in active</span>
                          <?php
        endif ?>
                        </li>

                      </ul>
                    </div>
                    <?php
      endforeach ?>
                    <?php
    endif ?>
                  </td>

                </tr>
                <?php
  endforeach ?>
                <?php
endif ?>
              </tbody>
            </table>
          </div>



        </div>

      </div>
  </section>
</div>
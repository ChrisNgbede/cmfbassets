<!-- DataTables -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-3">
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title">FHUB Loan Params </h3>
          <?php
?>
        </div>

      </div>
      <div class="card-body">

        <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php')?>

        <div class="row">

          <div id="products" class="table-responsive">

            <table id="<?= empty($products) ? '' : 'grouptable'?>" class="table table-striped ">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Loan Type</th>
                  <th>Shortname</th>
                  <th>Status</th>

                </tr>
              </thead>
              <tbody>
                <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <tr>
                  <td>
                    <?php echo $product->name?>
                  </td>
                  <td>
                    <?php echo $product->description?>
                  </td>
                  <td>
                    <?php echo $product->loanType?>
                  </td>
                  <td>
                    <?php echo $product->shortName?>
                  </td>
                  <td>
                    <?php if ($product->status): ?>
                    <span class="badge badge-success">active</span>
                    <?php
    else: ?>
                    <span class="badge badge-danger">in active</span>
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
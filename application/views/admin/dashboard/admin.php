<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0 text-dark">Welcome,
            <?php echo $this->session->userdata('username')?>
          </h5>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">
                <?= trans('home')?>
              </a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Modern Stat Cards -->
      <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="stat-card bg-success-soft">
            <div class="stat-content">
              <h3 class="mb-1">
                <?php echo countwhere('assets'); ?>
              </h3>
              <p class="mb-0 font-weight-bold opacity-8">Total Assets</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-boxes fa-2x"></i>
            </div>
            <a href="<?php echo base_url('asset_list')?>" class="stat-footer mt-3 d-block">
              Manage Assets <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="stat-card bg-info-soft">
            <div class="stat-content">
              <h3 class="mb-1">
                <?php echo countwhere('staff')?>
              </h3>
              <p class="mb-0 font-weight-bold opacity-8">Total Staff</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-users fa-2x"></i>
            </div>
            <a href="<?php echo base_url('admin/staff/index')?>" class="stat-footer mt-3 d-block">
              Manage Staff <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="stat-card bg-warning-soft">
            <div class="stat-content">
              <h3 class="mb-1">
                <?php echo countwhere('collaterals')?>
              </h3>
              <p class="mb-0 font-weight-bold opacity-8">Total Collaterals</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-shield-alt fa-2x"></i>
            </div>
            <a href="<?php echo base_url('listcollaterals')?>" class="stat-footer mt-3 d-block">
              Review Details <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="stat-card bg-danger-soft">
            <div class="stat-content">
              <h3 class="mb-1">
                <?php echo countwhere('departments')?>
              </h3>
              <p class="mb-0 font-weight-bold opacity-8">Departments</p>
            </div>
            <div class="stat-icon">
              <i class="fas fa-network-wired fa-2x"></i>
            </div>
            <a href="<?php echo base_url('departments')?>" class="stat-footer mt-3 d-block">
              View Org Chart <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Charts Row -->
      <div class="row mb-4">
        <div class="col-lg-8">
          <div class="chart-container chart-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h5 class="card-title mb-0">Asset Acquisition Trend</h5>
              <div class="badge badge-primary">Last 6 Months</div>
            </div>
            <canvas id="acquisitionTrendChart"></canvas>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="chart-container">
            <h5 class="card-title mb-4">Assets by Category</h5>
            <canvas id="categoryDistributionChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- Recent Assets -->
          <div class="card shadow-sm border-0">
            <div class="card-header border-0 bg-transparent py-3">
              <h5 class="card-title mb-0">Recently Added Assets</h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-items-center mb-0">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="border-0">Asset Name</th>
                      <th class="border-0">Status</th>
                      <th class="border-0">Owner</th>
                      <th class="border-0">Condition</th>
                      <th class="border-0 text-right">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($assets)): ?>
                    <?php foreach ($assets as $asset): ?>
                    <tr>
                      <td class="font-weight-600">
                        <a href="<?php echo base_url('admin/admin/asset_details/' . $asset->id)?>" class="text-dark">
                          <?php echo $asset->name?>
                        </a>
                      </td>
                      <td>
                        <?php if ($asset->status == 'active'): ?>
                        <span class="badge badge-success">Active</span>
                        <?php
    elseif ($asset->status == 'inactive'): ?>
                        <span class="badge badge-danger">Inactive</span>
                        <?php
    elseif ($asset->status == 'disposed'): ?>
                        <span class="badge badge-secondary">Disposed</span>
                        <?php
    endif ?>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <div
                            class="avatar-sm mr-2 bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: 700;">
                            <?= substr(getbyid($asset->owner, 'staff')->firstname, 0, 1) . substr(getbyid($asset->owner, 'staff')->lastname, 0, 1)?>
                          </div>
                          <span>
                            <?php echo getbyid($asset->owner, 'staff')->firstname . ' ' . getbyid($asset->owner, 'staff')->lastname?>
                          </span>
                        </div>
                      </td>
                      <td>
                        <span class="text-muted small italic">
                          <?= $asset->assetcondition?>
                        </span>
                      </td>
                      <td class="text-right">
                        <a href="<?php echo base_url('admin/asset/asset_details/' . $asset->id)?>" 
                           class="btn btn-primary btn-xs px-3 shadow-sm" style="font-size: 0.75rem; padding: 0.25rem 0.75rem;">
                          View
                        </a>
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
            <div class="card-footer bg-transparent border-0 pt-0 pb-4">
              <a href="<?php echo base_url('assetlist')?>" class="btn btn-outline-primary btn-sm px-4">See All
                Assets</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <!-- Quick Actions -->
          <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4">
              <h5 class="font-weight-bold mb-3 text-white">Quick Actions</h5>
              <div class="d-grid gap-2">
                <a href="<?= base_url('admin/asset/create'); ?>"
                  class="btn btn-light btn-block text-primary mb-2 text-left">
                  <i class="fas fa-plus mr-2"></i> Register New Asset
                </a>
                <a href="<?= base_url('admin/staff/create'); ?>"
                  class="btn btn-light btn-block text-primary mb-2 text-left">
                  <i class="fas fa-user-plus mr-2"></i> Add New Staff
                </a>
                <a href="<?= base_url('admin/asset/createcollateral'); ?>"
                  class="btn btn-light btn-block text-primary text-left">
                  <i class="fas fa-shield-alt mr-2"></i> New Collateral
                </a>
              </div>
            </div>
          </div>

          <!-- Status Summary -->
          <div class="chart-container chart-sm">
            <h5 class="card-title mb-4">Asset Status</h5>
            <canvas id="statusDistributionChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Chart.js and Data implementation -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Shared colors
    const colors = ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#0ea5e9', '#6366f1', '#ec4899'];
    const softColors = colors.map(c => c + '22'); // 0.13 opacity

    // 1. Asset Acquisition Trend
    const trendDataRaw = <?= json_encode($acquisition_trend)?>;
    const trendCtx = document.getElementById('acquisitionTrendChart').getContext('2d');
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: trendDataRaw.map(d => d.month),
        datasets: [{
          label: 'Assets Added',
          data: trendDataRaw.map(d => d.count),
          borderColor: '#4f46e5',
          backgroundColor: 'rgba(79, 70, 229, 0.1)',
          fill: true,
          tension: 0.4,
          pointRadius: 6,
          pointBackgroundColor: '#fff',
          pointBorderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true, grid: { borderDash: [5, 5] } }
        }
      }
    });

    // 2. Assets by Category
    const categoryDataRaw = <?= json_encode($assets_by_category)?>;
    const catCtx = document.getElementById('categoryDistributionChart').getContext('2d');
    new Chart(catCtx, {
      type: 'doughnut',
      data: {
        labels: categoryDataRaw.map(d => d.label),
        datasets: [{
          data: categoryDataRaw.map(d => d.value),
          backgroundColor: colors,
          hoverOffset: 15,
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
        },
        cutout: '75%'
      }
    });

    // 3. Status Distribution
    const statusDataRaw = <?= json_encode($assets_by_status)?>;
    const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(statusCtx, {
      type: 'bar',
      data: {
        labels: statusDataRaw.map(d => d.label.charAt(0).toUpperCase() + d.label.slice(1)),
        datasets: [{
          data: statusDataRaw.map(d => d.value),
          backgroundColor: ['#10b981', '#ef4444', '#64748b'],
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true, grid: { display: false } }
        }
      }
    });
  });
</script>
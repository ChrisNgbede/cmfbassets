<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css"> 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<!-- For Messages -->
   		<?php $this->load->view('admin/includes/_messages.php') ?>
		<div class="mod-card">
			<div class="card-header border-0 bg-transparent pt-4 px-4">
				<div class="d-flex justify-content-between align-items-center">
					<h3 class="card-title"><i class="fas fa-cubes text-primary mr-2"></i> <?= $title ?></h3>
					<a href="<?= base_url('admin/admin_roles/module_add'); ?>" class="btn btn-primary rounded-pill shadow-sm">
						<i class="fas fa-plus mr-1"></i> <?= trans('add_new_module') ?>
					</a>
				</div>
			</div>

			<div class="card-body px-4 pb-4">
				<table id="example1" class="table table-hover">
					<thead>
						<tr>
							<th width="120"><?= trans('action') ?></th>
							<th><?= trans('module_name') ?></th>
							<th><?= trans('controller_name') ?></th>
							<th><?= trans('fa_icon') ?></th>
							<th><?= trans('operations') ?></th>
							<th><?= trans('order_no') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($records as $record): ?>
							<tr>
								<td>
									<div class="table-actions">
										<a href="<?= base_url('admin/admin_roles/sub_module/'.$record['module_id']) ?>" class="btn btn-info" title="Sub Modules">
											<i class="fas fa-tasks"></i>
										</a>
										<a href="<?php echo site_url("admin/admin_roles/module_edit/".$record['module_id']); ?>" class="btn btn-warning" title="Edit">
											<i class="fas fa-edit"></i>
										</a>
										<a href="<?php echo site_url("admin/admin_roles/module_delete/".$record['module_id']); ?>" onclick="return confirm('Are you sure you want to delete this module?')" class="btn btn-danger" title="Delete">
											<i class="fas fa-trash"></i>
										</a>
									</div>
								</td>
								<td><span class="font-weight-bold text-dark"><?= $record['module_name']; ?></span></td>
								<td><code class="text-primary"><?= $record['controller_name']; ?></code></td>
								<td><i class="<?= $record['fa_icon']; ?> text-muted"></i> <small class="ml-1 text-muted"><?= $record['fa_icon']; ?></small></td>
								<td><span class="badge badge-secondary"><?= $record['operation']; ?></span></td>
								<td><span class="badge badge-primary px-3 rounded-pill"><?= $record['sort_order']; ?></span></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>

<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
   
  $(function () {
     $("#example1").DataTable({
      });
      
  });

</script> 

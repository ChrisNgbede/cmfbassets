<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<div class="mod-card">
			<div class="card-header border-0 bg-transparent pt-4 px-4">
				<div class="d-flex justify-content-between align-items-center">
					<h3 class="card-title"><i class="fas fa-user-shield text-primary mr-2"></i>
						<?= $title?>
					</h3>
					<div class="d-flex align-items-center">
						<a href="<?= base_url('admin/admin_roles/module'); ?>" class="btn btn-outline-primary rounded-pill shadow-sm mr-2">
							<i class="fas fa-layer-group mr-1"></i> Modules
						</a>
						<a href="<?= base_url('admin/admin_roles/add'); ?>" class="btn btn-primary rounded-pill shadow-sm">
							<i class="fas fa-plus mr-1"></i>
							<?= trans('add_new_role')?>
						</a>
					</div>
				</div>
			</div>

			<div class="card-body px-4 pb-4">
				<table id="example1" class="table table-hover">
					<thead>
						<tr>
							<th>
								<?= trans('admin_role')?>
							</th>
							<th>
								<?= trans('status')?>
							</th>
							<th>
								<?= trans('permission')?>
							</th>
							<th width="120" class="text-right">
								<?= trans('action')?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($records as $record): ?>
						<tr>
							<td><span class="font-weight-bold text-dark">
									<?php echo $record['admin_role_title']; ?>
								</span></td>
							<td>
								<?php if (!in_array($record['admin_role_id'], array(1))): ?>
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input tgl_checkbox" id='cb_<?= $record['admin_role_id']?>'
									data-id="<?php echo $record['admin_role_id']; ?>"
									<?php echo ($record['admin_role_status'] == 1) ? "checked" : ""; ?>>
									<label class="custom-control-label" for='cb_<?= $record['admin_role_id']?>'></label>
								</div>
								<?php
	else: ?>
								<span class="badge badge-success px-3 py-2 rounded-pill">System Default</span>
								<?php
	endif; ?>
							</td>
							<td>
								<?php if (!in_array($record['admin_role_id'], array(1))): ?>
								<a href="<?php echo site_url("admin/admin_roles/access/" . $record['admin_role_id']); ?>"
									class="btn btn-info btn-sm shadow-sm" title="Permissions">
									<i class="fas fa-key mr-1"></i> Access
								</a>
								<?php
	endif; ?>
							</td>
							<td>
								<?php if (!in_array($record['admin_role_id'], array(1))): ?>
								<div class="table-actions justify-content-end">
									<a href="<?php echo site_url("admin/admin_roles/edit/" . $record['admin_role_id']);
										?>" class="btn btn-warning" title="Edit">
										<i class="fas fa-edit"></i>
									</a>
									<a href="<?php echo site_url("admin/admin_roles/delete/" . $record['admin_role_id']);
										?>" onclick="return confirm('Are you sure you want to delete this role?')"
										class="btn btn-danger" title="Delete">
										<i class="fas fa-trash"></i>
									</a>
								</div>
								<?php
	endif; ?>
							</td>
						</tr>
						<?php
endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>

<script>
	$("body").on("change", ".tgl_checkbox", function () {
		$.post('<?= base_url("admin/admin_roles/change_status")?>',
			{
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
				id: $(this).data('id'),
				status: $(this).is(':checked') == true ? 1 : 0
			},
			function (data) {
				$.notify("Status Changed Successfully", "success");
			});
	});

</script>


<!-- DataTables -->
<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


<script>
	$(function () {
		$("#example1").DataTable();
	})
</script>
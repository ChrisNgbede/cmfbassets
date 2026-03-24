<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<!-- For Messages -->
		<?php $this->load->view('admin/includes/_messages.php')?>
		<div class="mod-card">
			<div class="card-header border-0 bg-transparent pt-4 px-4">
				<div class="d-flex justify-content-between align-items-center">
					<h3 class="card-title"><i class="fas fa-list-ul text-primary mr-2"></i> Sub Module Setting</h3>
					<?php $parent_module = $this->uri->segment(4); ?>
					<a href="<?= base_url('admin/admin_roles/sub_module_add/' . $parent_module); ?>"
						class="btn btn-primary rounded-pill shadow-sm">
						<i class="fas fa-plus mr-1"></i> Add New
					</a>
				</div>
			</div>

			<div class="card-body px-4 pb-4">
				<table id="example1" class="table table-hover">
					<thead>
						<tr>
							<th width="50">ID</th>
							<th>Name</th>
							<th>Link</th>
							<th>Menu Order</th>
							<th width="100" class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($records as $record): ?>
						<tr>
							<td>
								<?= $record['id']; ?>
							</td>
							<td><span class="font-weight-bold text-dark">
									<?= $record['name']; ?>
								</span></td>
							<td><code class="text-primary"><?= $record['link']; ?></code></td>
							<td><span class="badge badge-secondary">
									<?= $record['sort_order']?>
								</span></td>
							<td>
								<div class="table-actions justify-content-end">
									<a href="<?php echo site_url("admin/admin_roles/sub_module_edit/" . $record['id']);
?>" class="btn btn-warning" title="Edit">
										<i class="fas fa-edit"></i>
									</a>
									<a href="<?php echo site_url("admin/admin_roles/sub_module_delete/" . $record['id']
										. '/' . $record['parent']); ?>"
										onclick="return confirm('Are you sure you want to delete this sub-module?')"
										class="btn btn-danger" title="Delete">
										<i class="fas fa-trash"></i>
									</a>
								</div>
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


<!-- DataTables -->
<script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
	$(function () {
		$("#example1").DataTable();
	})
</script>
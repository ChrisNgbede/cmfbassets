<div class="datalist">
    <table id="grouptable" class="table table-hover">
        <thead>
            <tr>
                <th>
                    <?= trans('user')?>
                </th>
                <th>
                    <?= trans('username')?>
                </th>
                <th>
                    <?= trans('email')?>
                </th>
                <th>
                    <?= trans('role')?>
                </th>
                <th width="100">
                    <?= trans('status')?>
                </th>
                <th width="120">
                    <?= trans('action')?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($info as $row): ?>
            <?php
    $role = getby(array('admin_role_id' => $row['admin_role_id']), 'roles');
    $identity = 'unknown';
    if (is_null($row['groupid']) && is_null($row['memberid'])) {
        $identity = $row['username'];
    }
    else {
        if (!is_null($row['groupid'])) {
            $identity = getbyid($row['groupid'], 'supportgroups')->name;
        }
        else if (!is_null($row['memberid'])) {
            $identity = getbyid($row['memberid'], 'supportmembers')->firstname . ' ' . getbyid($row['memberid'], 'supportmembers')->firstname;
        }
    }


?>
            <tr>

                <td>
                    <h5 class="m0 mb5">
                        <?= $identity?>
                    </h5>
                    <small class="text-muted">
                        <?= empty($role) ? 'no role' : $role->admin_role_title?>
                    </small>
                </td>
                <td>
                    <?= $row['username']?>
                </td>
                <td>
                    <?= $row['email']?>
                </td>
                <td>
                    <span class="badge bg-warning">
                        <?= empty($role) ? 'no role' : $role->admin_role_title?>
                    </span>
                </td>
                <td>
                    <?php if ($row['admin_id'] != 1): ?>
                    <input class='tgl tgl-ios tgl_checkbox' data-id="<?= $row['admin_id']?>" id='cb_<?=$row['
                        id='cb_<?= $row['admin_id']?>'
                    type='checkbox'
                    <?php echo ($row['is_active'] == 1) ? "checked" : ""; ?> />
                    <label class='tgl-btn' for='cb_<?= $row[' admin_id']?>'></label>
                    <?php
    endif ?>
                </td>
                <td>

                    <?php if ($row['admin_id'] != 1): ?>
                    <a href="<?= base_url("admin/admin/edit/" . $row['admin_id']); ?>" class="btn btn-warning btn-xs mr5"
                        >
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="<?= base_url("admin/admin/delete_user/" . $row['admin_id']); ?>" onclick="return
                        confirm('are you sure to delete?')" class="btn btn-danger btn-xs"><i
                            class="fa fa-remove"></i></a>
                    <?php
    endif ?>

                </td>
            </tr>
            <?php
endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function () {
        $("#grouptable").DataTable();
    });

</script>
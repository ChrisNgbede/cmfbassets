<?php
$cur_tab = $this->uri->segment(2) == '' ? 'dashboard' : $this->uri->segment(2);
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-default">
  <!-- Brand Logo -->
  <a href="<?= base_url('admin'); ?>" class="brand-link" style="">
    <img src="<?= base_url($this->general_settings['favicon']); ?>" alt="Logo"
      class="brand-image img-circle elevation-4" style="opacity: .8">
    <span class="brand-text font-weight-light"><!-- <?= $this->general_settings['application_name']; ?> --> CMFB
      Assets</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
        data-accordion="false">

        <li class="nav-item">
          <a href="<?= base_url('admin/dashboard'); ?>"
            class="nav-link <?=($cur_tab == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-th-large"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php
$menu = get_sidebar_menu();

foreach ($menu as $nav):
  if ($nav['controller_name'] == 'dashboard')
    continue; // Already added above

  $sub_menu = get_sidebar_sub_menu($nav['module_id']);
  $has_submenu = (count($sub_menu) > 0) ? true : false;

  // Check if this module is active (Controller match is sufficient as sub-links share the controller)
  $is_active = ($cur_tab == $nav['controller_name']) ? true : false;
?>

        <?php if ($this->rbac->check_module_permission($nav['controller_name'])): ?>

        <li id="<?=($nav['controller_name'])?>"
          class="nav-item <?=($has_submenu) ? 'has-treeview' : ''?> <?=($is_active) ? 'menu-open' : ''?>">

          <a href="<?= base_url('admin/' . $nav['controller_name'])?>"
            class="nav-link <?=($is_active) ? 'active' : ''?>">
            <i class="nav-icon fas <?= $nav['fa_icon']?>"></i>
            <p>
              <?= $nav['module_name']?>
              <?=($has_submenu) ? '<i class="right fas fa-angle-left"></i>' : ''?>
            </p>
          </a>

          <?php if ($has_submenu): ?>
          <ul class="nav nav-treeview">
            <?php foreach ($sub_menu as $sub_nav):
        $sub_active = ($this->uri->segment(3) == $sub_nav['link'] && $cur_tab == $nav['controller_name']) ? 'active' : '';
?>
            <li class="nav-item">
              <a href="<?= base_url('admin/' . $nav['controller_name'] . '/' . $sub_nav['link']); ?>"
                class="nav-link <?= $sub_active?>">
                <p>
                  <?= $sub_nav['name']?>
                </p>
              </a>
            </li>
            <?php
      endforeach; ?>
          </ul>
          <?php
    endif; ?>
        </li>

        <?php
  endif; ?>
        <?php
endforeach; ?>
      </ul>
    </nav>
  </div>
</aside>
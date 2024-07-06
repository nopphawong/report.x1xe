  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= site_url() ?>" class="brand-link">
          <img src="<?= base_url() ?>assets/images/pie.png?" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 icon-rotation" style="opacity: .8">
          <span class="brand-text font-weight-light">UFA Dashboard <?= $version ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                  <li class="nav-item">
                      <a href="<?= site_url("") ?>" class="nav-link <?= $path == "" ? "active" : "" ?>">
                          <i class="nav-icon fas fa-th"></i>
                          <p>Home</p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
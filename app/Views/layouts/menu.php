<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="<?= route_to('dashboard_index') ?>" class="nav-link <?= isActive('dashboard') ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
                <!-- <span class="right badge badge-danger">New</span> -->
            </p>
        </a>
    </li>
    
    <li class="nav-item <?= isActive('user') == 'active' ? 'menu-is-opening menu-open' : '' ?>">
        <a href="#" class="nav-link <?= isActive('user') ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Pengguna
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= route_to('user_index', 'admin-kepsek') ?>" class="nav-link <?= isActive('admin-kepsek') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Admin & Kepsek</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= route_to('user_index', 'guru') ?>" class="nav-link <?= isActive('guru') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Guru</p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= route_to('user_index', 'siswa') ?>" class="nav-link <?= isActive('siswa') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Siswa</p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= route_to('user_index', 'ortu') ?>" class="nav-link <?= isActive('ortu') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ortu</p>
                </a>
            </li>
        </ul>
    </li>
    
    <?php
        $data_master_sub = [
            'tahunAjar'
        ];
    ?>
    <li class="nav-item <?= isActive($data_master_sub) == 'active' ? 'menu-is-opening menu-open' : '' ?>">
        <a href="#" class="nav-link <?= isActive($data_master_sub) ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Data Master
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= route_to('tahun_ajar_index') ?>" class="nav-link <?= isActive('tahunAjar') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tahun Ajar</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Forms
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="pages/forms/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>General Elements</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/forms/advanced.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Advanced Elements</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/forms/editors.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Editors</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/forms/validation.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Validation</p>
                </a>
            </li>
        </ul>
    </li> -->

</ul>
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="<?= route_to('dashboard_index') ?>" class="nav-link <?= isActive('dashboard') ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>

    <?php if (session()->get('level') == 'admin') : ?>
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
                    <a href="<?= route_to('user_index', 'admin') ?>" class="nav-link <?= isActive('admin') ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Admin</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= route_to('user_index', 'kepsek') ?>" class="nav-link <?= isActive('kepsek') ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kepala Sekolah</p>
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
    <?php endif; ?>

    <?php if (session()->get('level') == 'admin') : ?>
        <?php
        $data_master_sub = [
            'tahunAjar',
            'mapel',
            'kelas',
        ];
        ?>
        <li class="nav-item <?= isActive($data_master_sub) == 'active' ? 'menu-is-opening menu-open' : '' ?>">
            <a href="#" class="nav-link <?= isActive($data_master_sub) ?>">
                <i class="nav-icon fas fa-database"></i>
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

                <li class="nav-item">
                    <a href="<?= route_to('mapel_index') ?>" class="nav-link <?= isActive('mapel') ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Mata Pelajaran</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= route_to('kelas_index') ?>" class="nav-link <?= isActive('kelas') ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kelas</p>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a href="<?= route_to('akademik_index') ?>" class="nav-link <?= isActive('akademik') ?>">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                    Akademik
                </p>
            </a>
        </li>
    <?php endif; ?>

    <?php if (session()->get('level') == 'siswa' or session()->get('level') == 'ortu') : ?>
        <li class="nav-item">
            <a href="<?= route_to('jadwal_index') ?>" class="nav-link <?= isActive('jadwal') ?>">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Jadwal</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= route_to('nilai_index') ?>" class="nav-link <?= isActive('nilai') ?>">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Nilai</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= route_to('nilai_history') ?>" class="nav-link <?= isActive('history') ?>">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Riwayat Nilai</p>
            </a>
        </li>
    <?php endif; ?>
    <?php if (session()->get('level') == 'guru') : ?>
        <li class="nav-item">
            <a href="<?= route_to('jadwal_guru') ?>" class="nav-link <?= isActive('prestasi') ?>">
                <i class="nav-icon fas fa-award"></i>
                <p>Jadwal</p>
            </a>
        </li>
    <?php endif; ?>

    <li class="nav-item">
        <a href="<?= route_to('prestasi_index') ?>" class="nav-link <?= isActive('prestasi') ?>">
            <i class="nav-icon fas fa-award"></i>
            <p>Prestasi Akademik</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= route_to('agenda_index') ?>" class="nav-link <?= isActive('agenda') ?>">
            <i class="nav-icon far fa-calendar-minus"></i>
            <p>Agenda Kegiatan</p>
        </a>
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
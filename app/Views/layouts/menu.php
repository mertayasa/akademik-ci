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
    <?php //if (session()->get('level') == 'admin') : 
    ?>

    <?php if (!isAdmin()) : ?>
        <li class="nav-item <?= isActive('user') == 'active' ? 'menu-is-opening menu-open' : '' ?>">
            <a href="#" class="nav-link <?= isActive('user') ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Civitas
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                    <a href="<?= route_to('user_index', 'kepsek') ?>" class="nav-link <?= isActiveSub('kepsek') ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kepala Sekolah</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= route_to('user_index', 'guru') ?>" class="nav-link <?= isActiveSub('guru') ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Guru</p>
                    </a>
                </li>

                <?php if (!isSiswa()) : ?>
                    <li class="nav-item">
                        <a href="<?= route_to('user_index', 'siswa') ?>" class="nav-link <?= isActiveSub('siswa') ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Siswa (Profil Anak)</p>
                        </a>
                    </li>

                    <?php if (!isOrtu()) : ?>
                        <li class="nav-item">
                            <a href="<?= route_to('user_index', 'ortu') ?>" class="nav-link <?= isActiveSub('ortu') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ortu</p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

            </ul>
        </li>
    <?php endif; ?>

    <?php if (session()->get('level') == 'admin' or session()->get('level') == 'kepsek') : ?>
        <?php
        $data_master_sub = [
            'tahunAjar',
            'mapel',
            'kelas',
            'user',
            'profile',
            'kelasPerTahun',
            'pindah',
        ];
        ?>
        <?php if (!isKepsek()) : ?>
            <li class="nav-item <?= isActive($data_master_sub) == 'active' ? 'menu-is-opening menu-open' : '' ?>">
                <a href="#" class="nav-link <?= isActive($data_master_sub) ?>">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Data Master
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <?php if (isAdmin()) : ?>
                        <li class="nav-item">
                            <a href="<?= route_to('user_index', 'admin') ?>" class="nav-link <?= isActiveSub('admin') ?>">
                                <i class="fas fa-user-cog nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="<?= route_to('user_index', 'kepsek') ?>" class="nav-link <?= isActiveSub('kepsek') ?>">
                            <i class="fas fa-user-tie nav-icon"></i>
                            <p>Kepala Sekolah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= route_to('user_index', 'guru') ?>" class="nav-link <?= isActiveSub('guru') ?>">
                            <i class="fas fa-user-tie nav-icon"></i>
                            <p>Guru</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= route_to('user_index', 'siswa') ?>" class="nav-link <?= isActiveSub('siswa') ?>">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <p>Siswa</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= route_to('user_index', 'ortu') ?>" class="nav-link <?= isActiveSub('ortu') ?>">
                            <i class="fas fa-user-friends nav-icon"></i>
                            <p>Orang Tua</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= route_to('tahun_ajar_index') ?>" class="nav-link <?= isActive('tahunAjar') ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tahun Ajar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= route_to('kelas_index') ?>" class="nav-link <?= isActive('kelas') ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kelas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= route_to('kelas_per_tahun_index') ?>" class="nav-link <?= isActive('kelasPerTahun') ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kelas Per Tahun Ajar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= route_to('mapel_index') ?>" class="nav-link <?= isActive('mapel') ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Mata Pelajaran</p>
                        </a>
                    </li>

                    <li class="nav-item <?= isActive('pindah') == 'active' ? 'menu-is-opening menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isActive('pindah') ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Pindah Sekolah
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview" style="display: <?= isActive('pindah') == 'active' ? 'block' : 'none' ?>;">
                            <li class="nav-item">
                                <a href="<?= route_to('pindah_sekolah_index', 'masuk') ?>" class="nav-link <?= isActiveSub('masuk') ?>">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Pindah Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= route_to('pindah_sekolah_index', 'keluar') ?>" class="nav-link <?= isActiveSub('keluar') ?>">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Pindah Keluar</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </li>
        <?php endif; ?>

        <?php if (isKepsek()) : ?>
            <li class="nav-item <?= isActive('pindah') == 'active' ? 'menu-is-opening menu-open' : '' ?>">
                <a href="#" class="nav-link <?= isActive('pindah') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Pindah Sekolah
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview" style="display: <?= isActive('pindah') == 'active' ? 'block' : 'none' ?>;">
                    <li class="nav-item">
                        <a href="<?= route_to('pindah_sekolah_index', 'masuk') ?>" class="nav-link <?= isActiveSub('masuk') ?>">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Pindah Masuk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= route_to('pindah_sekolah_index', 'keluar') ?>" class="nav-link <?= isActiveSub('keluar') ?>">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Pindah Keluar</p>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a href="<?= route_to('akademik_index') ?>" class="nav-link <?= isActive('akademik') ?>">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                    Akademik
                </p>
            </a>
        </li>
    <?php endif; ?>

    <?php if (isSiswa() or isOrtu()) : ?>
        <li class="nav-item">
            <a href="<?= route_to('jadwal_index') ?>" class="nav-link <?= isActive('jadwal') ?>">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Jadwal</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= route_to('absensi_index') ?>" class="nav-link <?= isActive('absensi') ?>">
                <i class="nav-icon far fa-calendar-check"></i>
                <p>Absensi</p>
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

    <?php if (isGuru()) : ?>
        <li class="nav-item">
            <a href="<?= route_to('jadwal_index') ?>" class="nav-link <?= isActive('jadwal') ?>">
                <i class="nav-icon fas fa-award"></i>
                <p>Jadwal</p>
            </a>
        </li>
    <?php endif; ?>

    <?php if (isGuru() and session()->get('is_wali')) : ?>
        <li class="nav-item">
            <a href="<?= route_to('panel_wali_index') ?>" class="nav-link <?= isActive('panel_wali') ?>">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>Panel Wali</p>
            </a>
        </li>
    <?php endif; ?>

    <li class="nav-item">
        <a href="<?= route_to('prestasi_index') ?>" class="nav-link <?= isActive('prestasi') ?>">
            <i class="nav-icon fas fa-award"></i>
            <?php if (isAdmin()) : ?>
                <p>Prestasi Akademik</p>
            <?php else : ?>
                <p>Informasi Prestasi Akademik</p>
            <?php endif; ?>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= route_to('agenda_index') ?>" class="nav-link <?= isActive('agenda') ?>">
            <i class="nav-icon far fa-calendar-minus"></i>
            <p>Agenda Kegiatan</p>
        </a>
    </li>

    <?php if (isGuru()) : ?>
        <li class="nav-item <?= isActive('pindah') == 'active' ? 'menu-is-opening menu-open' : '' ?>">
            <a href="#" class="nav-link <?= isActive('pindah') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Pindah Sekolah
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview" style="display: <?= isActive('pindah') == 'active' ? 'block' : 'none' ?>;">
                <li class="nav-item">
                    <a href="<?= route_to('pindah_sekolah_index', 'masuk') ?>" class="nav-link <?= isActiveSub('masuk') ?>">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Pindah Masuk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('pindah_sekolah_index', 'keluar') ?>" class="nav-link <?= isActiveSub('keluar') ?>">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Pindah Keluar</p>
                    </a>
                </li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (isAdmin() or isGuru() or isKepsek()) : ?>
        <?php $hystory_sub = [
            'history-data'
        ]; ?>
        <li class="nav-item <?= isActive($hystory_sub) == 'active' ? 'menu-is-opening menu-open' : '' ?>">
            <a href="#" class="nav-link <?= isActive($hystory_sub) ?>">
                <i class="nav-icon fas fa-history"></i>
                <p>
                    History
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= route_to('history_data_index', 'akademik') ?>" class="nav-link <?= isActiveSub('akademik') ?>">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <p>Akademik</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('history_user', 'admin') ?>" class="nav-link <?= isActiveSub('admin') ?>">
                        <i class="fas fa-user-cog nav-icon"></i>
                        <p>Admin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('history_user', 'kepsek') ?>" class="nav-link <?= isActiveSub('kepsek') ?>">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Kepala Sekolah</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('history_user', 'guru') ?>" class="nav-link <?= isActiveSub('guru') ?>">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Guru</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('history_user', 'siswa') ?>" class="nav-link <?= isActiveSub('siswa') ?>">
                        <i class="fas fa-user-graduate nav-icon"></i>
                        <p>Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('history_user', 'ortu') ?>" class="nav-link <?= isActiveSub('ortu') ?>">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <p>Orang Tua</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= route_to('history_data_index', 'prestasi') ?>" class="nav-link <?= isActiveSub('prestasi') ?>">
                        <i class="fas fa-award nav-icon"></i>
                        <p>Prestasi Akademik</p>
                    </a>
                </li>
            </ul>
        </li>
    <?php endif; ?>

</ul>
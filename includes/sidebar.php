<div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

    <h4 class="text-white mb-4">
        Pelanggaran Siswa
    </h4>

    <!-- MENU UNTUK ADMIN -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="dashboard.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="data_siswa.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'siswa') ? 'active' : 'text-white'; ?>">
                Data Siswa
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="data_guru.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'guru') ? 'active' : 'text-white'; ?>">
                Data Guru
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="kelas.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                Kelas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="tahun_ajaran.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'tahun_ajaran') ? 'active' : 'text-white'; ?>">
                Tahun Ajaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="penepatan_siswa.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'penepatan_siswa') ? 'active' : 'text-white'; ?>">
                Penepatan Siswa
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="wali_kelas.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'wali_kelas') ? 'active' : 'text-white'; ?>">
                Wali Kelas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="kategori_pelanggaran.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'kategori_pelanggaran') ? 'active' : 'text-white'; ?>">
                Kategori Pelanggaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="jenis_pelanggaran.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'jenis_pelanggaran') ? 'active' : 'text-white'; ?>">
                Jenis Pelanggaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="laporan.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                Laporan
            </a>
        </li>

    

        <li class="nav-item mb-2">
            <a href="aboutme.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'about') ? 'active' : 'text-white'; ?>">
                About Me
            </a>
        </li>

        <hr class="text-secondary">

        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger">
                Logout
            </a>
        </li>

    </ul>

    <?php } ?>


    <!-- MENU UNTUK PETUGAS -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'petugas') { ?>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="dashboard.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="kelas.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                Kelas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="laporan.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                Laporan
            </a>
        </li>

        <hr class="text-secondary">

        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger">
                Logout
            </a>
        </li>

    </ul>

    <?php } ?>


    <!-- MENU UNTUK GURU -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'guru') { ?>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="dashboard.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="catatan_pelanggaran.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'catatan_pelanggaran') ? 'active' : 'text-white'; ?>">
                Catatan Pelanggaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="tindakan.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'tindakan') ? 'active' : 'text-white'; ?>">
                Tindakan
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="laporan.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                Laporan
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="Riwayat.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'riwayat') ? 'active' : 'text-white'; ?>">
                Riwayat
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="rekap_poin.php"
               class="nav-link <?php echo (isset($halaman) && $halaman == 'rekap_poin') ? 'active' : 'text-white'; ?>">
                Rekap Poin
            </a>
        </li>

        <hr class="text-secondary">

        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger">
                Logout
            </a>
        </li>

    </ul>

    <?php } ?>

</div>
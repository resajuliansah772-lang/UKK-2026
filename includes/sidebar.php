<?php
// Mengambil role dari session
$role = strtolower(trim($_SESSION['role'] ?? ''));

// Memastikan halaman aktif tersedia
$halaman = $halaman ?? '';
?>

<div class="col-md-3 col-lg-2 sidebar min-vh-100 p-3">

    <!-- Judul / Brand -->
    <h4 class="text-white mb-4 fw-bold fs-5 px-2">
        <i class="bi bi-shield-exclamation text-primary me-2"></i>
        Pelanggaran Siswa
    </h4>

    <!-- MENU UNTUK ADMIN -->
    <?php if ($role == 'admin') { ?>

    <ul class="nav nav-pills flex-column gap-1">

        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $halaman == 'dashboard' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="data_siswa.php" class="nav-link <?= $halaman == 'siswa' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-people me-2"></i> Data Siswa
            </a>
        </li>

        <li class="nav-item">
            <a href="data_guru.php" class="nav-link <?= $halaman == 'guru' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-person-badge me-2"></i> Data Guru
            </a>
        </li>

        <li class="nav-item">
            <a href="kelas.php" class="nav-link <?= $halaman == 'kelas' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-door-open me-2"></i> Kelas
            </a>
        </li>

        <li class="nav-item">
            <a href="tahun_ajaran.php" class="nav-link <?= $halaman == 'tahun_ajaran' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
            </a>
        </li>

        <li class="nav-item">
            <a href="penepatan_siswa.php" class="nav-link <?= $halaman == 'penepatan_siswa' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-journal-check me-2"></i> Penepatan Siswa
            </a>
        </li>

        <li class="nav-item">
            <a href="wali_kelas.php" class="nav-link <?= $halaman == 'wali_kelas' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-person-workspace me-2"></i> Wali Kelas
            </a>
        </li>

        <li class="nav-item">
            <a href="kategori_pelanggaran.php" class="nav-link <?= $halaman == 'kategori_pelanggaran' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-tags me-2"></i> Kategori Pelanggaran
            </a>
        </li>

        <li class="nav-item">
            <a href="jenis_pelanggaran.php" class="nav-link <?= $halaman == 'jenis_pelanggaran' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-list-task me-2"></i> Jenis Pelanggaran
            </a>
        </li>

        <li class="nav-item">
            <a href="laporan.php" class="nav-link <?= $halaman == 'laporan' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan
            </a>
        </li>

        <li class="nav-item">
            <a href="aboutme.php" class="nav-link <?= $halaman == 'about' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-info-circle me-2"></i> About Me
            </a>
        </li>

        <hr class="text-secondary my-3">

        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>

    </ul>

    <?php } ?>


    <!-- MENU UNTUK PETUGAS -->
    <?php if ($role == 'petugas') { ?>

    <ul class="nav nav-pills flex-column gap-1">

        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $halaman == 'dashboard' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="kelas.php" class="nav-link <?= $halaman == 'kelas' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-door-open me-2"></i> Kelas
            </a>
        </li>

        <li class="nav-item">
            <a href="laporan.php" class="nav-link <?= $halaman == 'laporan' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan
            </a>
        </li>

        <hr class="text-secondary my-3">

        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>

    </ul>

    <?php } ?>


    <!-- MENU UNTUK GURU -->
    <?php if ($role == 'guru') { ?>

    <ul class="nav nav-pills flex-column gap-1">

        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $halaman == 'dashboard' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="catatan_pelanggaran.php" class="nav-link <?= $halaman == 'catatan_pelanggaran' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran
            </a>
        </li>

        <li class="nav-item">
            <a href="tindakan.php" class="nav-link <?= $halaman == 'tindakan' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-hammer me-2"></i> Tindakan
            </a>
        </li>

        <li class="nav-item">
            <a href="laporan.php" class="nav-link <?= $halaman == 'laporan' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan
            </a>
        </li>

        <li class="nav-item">
            <a href="riwayat.php" class="nav-link <?= $halaman == 'riwayat' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-clock-history me-2"></i> Riwayat
            </a>
        </li>

        <li class="nav-item">
            <a href="rekap_poin.php" class="nav-link <?= $halaman == 'rekap_poin' ? 'active' : 'text-white'; ?>">
                <i class="bi bi-award me-2"></i> Rekap Poin
            </a>
        </li>

        <hr class="text-secondary my-3">

        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>

    </ul>

    <?php } ?>


    <style>
        /* Styling CSS khusus untuk sidebar */
        .sidebar {
            background: linear-gradient(180deg, #212529 0%, #1a1e21 100%);
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            padding-left: 15px;
        }

        @media print {
            aside, 
            nav, 
            .col-md-3, 
            .col-lg-2 {
                display: none !important;
            }
        }
    </style>

</div>
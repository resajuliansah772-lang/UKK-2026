<?php
// Mengambil role dari session
$role = strtolower(trim($_SESSION['role'] ?? ''));

// Memastikan halaman aktif tersedia
$halaman = $halaman ?? '';
?>

<div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

    <h4 class="text-white mb-4">
        Pelanggaran Siswa
    </h4>

    <!-- MENU UNTUK ADMIN -->
    <?php if ($role == 'admin') { ?>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="dashboard.php"
               class="nav-link <?= $halaman == 'dashboard' ? 'active' : 'text-white'; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="data_siswa.php"
               class="nav-link <?= $halaman == 'siswa' ? 'active' : 'text-white'; ?>">
                Data Siswa
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="data_guru.php"
               class="nav-link <?= $halaman == 'guru' ? 'active' : 'text-white'; ?>">
                Data Guru
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="kelas.php"
               class="nav-link <?= $halaman == 'kelas' ? 'active' : 'text-white'; ?>">
                Kelas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="tahun_ajaran.php"
               class="nav-link <?= $halaman == 'tahun_ajaran' ? 'active' : 'text-white'; ?>">
                Tahun Ajaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="penepatan_siswa.php"
               class="nav-link <?= $halaman == 'penepatan_siswa' ? 'active' : 'text-white'; ?>">
                Penepatan Siswa
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="wali_kelas.php"
               class="nav-link <?= $halaman == 'wali_kelas' ? 'active' : 'text-white'; ?>">
                Wali Kelas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="kategori_pelanggaran.php"
               class="nav-link <?= $halaman == 'kategori_pelanggaran' ? 'active' : 'text-white'; ?>">
                Kategori Pelanggaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="jenis_pelanggaran.php"
               class="nav-link <?= $halaman == 'jenis_pelanggaran' ? 'active' : 'text-white'; ?>">
                Jenis Pelanggaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="laporan.php"
               class="nav-link <?= $halaman == 'laporan' ? 'active' : 'text-white'; ?>">
                Laporan
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="aboutme.php"
               class="nav-link <?= $halaman == 'about' ? 'active' : 'text-white'; ?>">
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
    <?php if ($role == 'petugas') { ?>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="dashboard.php"
               class="nav-link <?= $halaman == 'dashboard' ? 'active' : 'text-white'; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="kelas.php"
               class="nav-link <?= $halaman == 'kelas' ? 'active' : 'text-white'; ?>">
                Kelas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="laporan.php"
               class="nav-link <?= $halaman == 'laporan' ? 'active' : 'text-white'; ?>">
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
    <?php if ($role == 'guru') { ?>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="dashboard.php"
               class="nav-link <?= $halaman == 'dashboard' ? 'active' : 'text-white'; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="catatan_pelanggaran.php"
               class="nav-link <?= $halaman == 'catatan_pelanggaran' ? 'active' : 'text-white'; ?>">
                Catatan Pelanggaran
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="tindakan.php"
               class="nav-link <?= $halaman == 'tindakan' ? 'active' : 'text-white'; ?>">
                Tindakan
            </a>
        </li>

        <!-- SUDAH DIUBAH KE laporan.php -->
        <li class="nav-item mb-2">
            <a href="laporan.php"
               class="nav-link <?= $halaman == 'laporan' ? 'active' : 'text-white'; ?>">
                Laporan
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="Riwayat.php"
               class="nav-link <?= $halaman == 'riwayat' ? 'active' : 'text-white'; ?>">
                Riwayat
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="rekap_poin.php"
               class="nav-link <?= $halaman == 'rekap_poin' ? 'active' : 'text-white'; ?>">
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

    <style>
@media print {
    /* Sembunyikan sidebar, tombol cetak, alert, dan navigasi */
    aside, 
    nav, 
    .mb-3, 
    .alert, 
    .col-md-3, 
    .col-lg-2 {
        display: none !important;
    }

    /* Ubah lebar konten utama (main) menjadi 100% penuh */
    main, 
    .col-md-9, 
    .col-lg-10 {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Bersihkan tampilan card agar pas di kertas */
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

</div>
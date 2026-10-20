<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif di sidebar
$halaman = 'about';

$nama = "Resa Juliansah";
$kelas = "XII RPL";
$sekolah = "SMK Muhammadiyah Tasikmalaya";
$jurusan = "Rekayasa Perangkat Lunak";
$hobi = "Main game";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me | <?php echo htmlspecialchars($nama); ?></title>

    <!-- BOOTSTRAP 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .profile-photo {
            border: 4px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
            object-fit: cover;
            object-position: top;
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR (Menggunakan struktur Bootstrap murni persis sama) -->
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
                    <a href="penempatan_siswa.php"
                       class="nav-link <?php echo (isset($halaman) && $halaman == 'penempatan_siswa') ? 'active' : 'text-white'; ?>">
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


        <!-- KONTEN UTAMA DI SEBELAH KANAN SIDEBAR -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- HEADER -->
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Tentang Saya</h2>
                <p class="text-muted small mb-0">
                    Mengenal lebih dekat dengan saya.
                </p>
            </div>

            <!-- PROFIL DI TENGAH -->
            <section class="card p-4 mb-4 shadow-sm border-1 border-secondary-subtle rounded-3 bg-white">
                <div class="text-center">
                    <div class="mb-3">
                        <img
                            src="resa.jpg.jpg"
                            alt="Foto Profil"
                            class="profile-photo rounded-circle"
                            width="130" height="130"
                            onerror="this.onerror=null;this.src='foto-profil.png';"
                        >
                    </div>

                    <h2 class="fw-bold mb-1">
                        <?php echo htmlspecialchars($nama); ?>
                    </h2>

                    <div class="text-muted mb-3">
                        <?php echo htmlspecialchars($jurusan); ?>
                    </div>
                </div>

                <p class="text-center text-secondary px-lg-4">
                    Halo, saya <?php echo htmlspecialchars($nama); ?>,
                    seorang pelajar kelas
                    <?php echo htmlspecialchars($kelas); ?> di
                    <?php echo htmlspecialchars($sekolah); ?>.
                    Saya memiliki ketertarikan pada teknologi,
                    pengembangan website, dan desain antarmuka.
                    Saya terus belajar untuk meningkatkan kemampuan
                    serta menciptakan website yang bermanfaat,
                    responsif, dan mudah digunakan.
                </p>

                <hr class="my-3 opacity-25">

                <div class="text-center">
                    <a href="dashboard.php" class="btn btn-primary btn-sm px-4 rounded-pill">
                        Kembali ke Dashboard
                    </a>
                </div>
            </section>

            <!-- INFORMASI PERSONAL -->
            <section class="mb-4">
                <h3 class="fs-5 fw-bold mb-3">Informasi Personal</h3>

                <div class="row g-3">
                    <div class="col-sm-6 col-xl-4">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm">
                            <div class="text-muted small fw-semibold">NAMA LENGKAP</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($nama); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm">
                            <div class="text-muted small fw-semibold">KELAS</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($kelas); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm">
                            <div class="text-muted small fw-semibold">HOBI</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($hobi); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-6">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm">
                            <div class="text-muted small fw-semibold">ASAL SEKOLAH</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($sekolah); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-6">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm">
                            <div class="text-muted small fw-semibold">JURUSAN</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($jurusan); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- DESKRIPSI DAN KEAHLIAN -->
            <section class="row g-3 mb-4">
                <div class="col-lg-7">
                    <div class="p-4 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
                        <h3 class="fs-5 fw-bold mb-3">Deskripsi Diri</h3>
                        <p class="mb-2 text-secondary">
                            Saya adalah seorang pelajar yang sedang
                            mendalami Rekayasa Perangkat Lunak. Saya
                            senang mempelajari teknologi, memahami
                            cara kerja website, dan mencoba hal-hal
                            baru dalam pemrograman.
                        </p>
                        <p class="mt-3 mb-0 text-secondary">
                            Saya ingin terus mengembangkan kemampuan
                            di bidang web development dan bercita-cita
                            menjadi seorang Web Developer yang mampu
                            menghasilkan karya digital berkualitas.
                        </p>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="p-4 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
                        <h3 class="fs-5 fw-bold mb-3">Bidang yang Dipelajari</h3>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">HTML</span>
                            <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">CSS</span>
                            <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">PHP</span>
                            <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">Bootstrap</span>
                            <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">MySQL</span>
                            <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">Web Development</span>
                        </div>

                        <hr class="my-3">

                        <p class="small text-muted mb-0">
                            Berfokus pada pengembangan website dengan
                            struktur yang rapi, desain yang konsisten,
                            dan pengalaman pengguna yang baik.
                        </p>
                    </div>
                </div>
            </section>

        </main>
    </div>
</div>

<!-- BOOTSTRAP 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
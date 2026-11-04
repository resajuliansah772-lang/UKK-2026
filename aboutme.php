<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif di sidebar
$halaman = 'about';
$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

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
    <title>About Me | <?php echo htmlspecialchars($nama); ?> - Sistem Informasi Pelanggaran Siswa</title>

    <!-- BOOTSTRAP 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            padding-left: 15px;
        }

        .profile-photo {
            border: 4px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
            object-fit: cover;
            object-position: top;
        }

        .card { border: none; border-radius: 12px; }
        .sidebar { background: linear-gradient(180deg, #212529 0%, #1a1e21 100%); min-height: 100vh; }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i> Pelanggaran Siswa
            </h4>

            <!-- MENU UNTUK ADMIN -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_siswa.php"
                       class="nav-link text-white">
                        <i class="bi bi-people me-2"></i> Data Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_guru.php"
                       class="nav-link text-white">
                        <i class="bi bi-person-badge me-2"></i> Data Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelas.php"
                       class="nav-link text-white">
                        <i class="bi bi-door-open me-2"></i> Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tahun_ajaran.php"
                       class="nav-link text-white">
                        <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penempatan_siswa.php"
                       class="nav-link text-white">
                        <i class="bi bi-journal-check me-2"></i> Penempatan Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="wali_kelas.php"
                       class="nav-link text-white">
                        <i class="bi bi-person-workspace me-2"></i> Wali Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kategori_pelanggaran.php"
                       class="nav-link text-white">
                        <i class="bi bi-tags me-2"></i> Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="jenis_pelanggaran.php"
                       class="nav-link text-white">
                        <i class="bi bi-list-task me-2"></i> Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php"
                       class="nav-link text-white">
                        <i class="bi bi-file-earmark-text me-2"></i> Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="aboutme.php"
                       class="nav-link active"
                       aria-current="page">
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
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'petugas') { ?>

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelas.php"
                       class="nav-link text-white">
                        <i class="bi bi-door-open me-2"></i> Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php"
                       class="nav-link text-white">
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
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'guru') { ?>

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="catatan_pelanggaran.php"
                       class="nav-link text-white">
                        <i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tindakan.php"
                       class="nav-link text-white">
                        <i class="bi bi-hammer me-2"></i> Tindakan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php"
                       class="nav-link text-white">
                        <i class="bi bi-file-earmark-text me-2"></i> Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="Riwayat.php"
                       class="nav-link text-white">
                        <i class="bi bi-clock-history me-2"></i> Riwayat
                    </a>
                </li>

                <li class="nav-item">
                    <a href="rekap_poin.php"
                       class="nav-link text-white">
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

        </div>


        <!-- KONTEN UTAMA DI SEBELAH KANAN SIDEBAR -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- HEADER -->
            <div class="card shadow-sm p-4 bg-white mb-4">
                <h2 class="fw-bold mb-1">Tentang Saya</h2>
                <p class="text-muted mb-0">
                    Mengenal lebih dekat dengan saya.
                </p>
            </div>

            <!-- PROFIL DI TENGAH -->
            <section class="card p-4 mb-4 shadow-sm bg-white">
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
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </section>

            <!-- INFORMASI PERSONAL -->
            <section class="mb-4">
                <h3 class="fs-5 fw-bold mb-3">Informasi Personal</h3>

                <div class="row g-3">
                    <div class="col-sm-6 col-xl-4">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
                            <div class="text-muted small fw-semibold">NAMA LENGKAP</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($nama); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
                            <div class="text-muted small fw-semibold">KELAS</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($kelas); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
                            <div class="text-muted small fw-semibold">HOBI</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($hobi); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-6">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
                            <div class="text-muted small fw-semibold">ASAL SEKOLAH</div>
                            <div class="fw-bold text-dark fs-6 mt-1">
                                <?php echo htmlspecialchars($sekolah); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-6">
                        <div class="p-3 border border-secondary-subtle rounded-3 bg-white shadow-sm h-100">
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
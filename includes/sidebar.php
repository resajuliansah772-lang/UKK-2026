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
    <title>About Me | Sistem Informasi Pelanggaran Siswa</title>

    <!-- BOOTSTRAP 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }
        
        .profile-photo {
            border: 4px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
            object-fit: cover;
            object-position: top;
        }

        .card { border: none; border-radius: 12px; }

        /* Mengatur agar konten utama bisa di-scroll sendiri dan sidebar tetap diam */
        .main-content {
            height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row flex-nowrap">

        <!-- SIDEBAR TERPUSAT -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- KONTEN UTAMA DI SEBELAH KANAN SIDEBAR -->
        <main class="col-md-9 col-lg-10 p-4 main-content">

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
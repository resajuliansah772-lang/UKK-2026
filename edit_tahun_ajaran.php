
<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Halaman aktif
$halaman = 'tahun_ajaran';

// Ambil ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: tahun_ajaran.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data tahun ajaran
$query = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: tahun_ajaran.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Tahun Ajaran</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

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

        .card {
            border: none;
            border-radius: 12px;
        }
    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3 min-vh-100">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i>
                Pelanggaran Siswa
            </h4>

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_siswa.php" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i>
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_guru.php" class="nav-link text-white">
                        <i class="bi bi-person-badge me-2"></i>
                        Data Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelas.php" class="nav-link text-white">
                        <i class="bi bi-door-open me-2"></i>
                        Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tahun_ajaran.php" class="nav-link active">
                        <i class="bi bi-calendar-range me-2"></i>
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penempatan_siswa.php" class="nav-link text-white">
                        <i class="bi bi-journal-check me-2"></i>
                        Penempatan Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="wali_kelas.php" class="nav-link text-white">
                        <i class="bi bi-person-workspace me-2"></i>
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-tags me-2"></i>
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-list-task me-2"></i>
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php" class="nav-link text-white">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="aboutme.php" class="nav-link text-white">
                        <i class="bi bi-info-circle me-2"></i>
                        About Me
                    </a>
                </li>

                <hr class="text-secondary my-3">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="fw-bold mb-1">
                Edit Tahun Ajaran
            </h2>

            <p class="text-muted mb-4">
                Silakan ubah informasi tahun ajaran.
            </p>

            <!-- FORM EDIT -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <form action="proses_edit_tahun_ajaran.php" method="POST">

                        <!-- ID -->
                        <input
                            type="hidden"
                            name="id"
                            value="<?= htmlspecialchars($data['id']); ?>"
                        >

                        <!-- NAMA TAHUN AJARAN -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Tahun Ajaran
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="<?= htmlspecialchars($data['nama']); ?>"
                                placeholder="Contoh: 2026/2027"
                                required
                            >

                        </div>

                        <!-- TANGGAL MULAI -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                class="form-control"
                                value="<?= htmlspecialchars($data['tanggal_mulai']); ?>"
                                required
                            >

                        </div>

                        <!-- TANGGAL SELESAI -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tanggal Selesai
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                class="form-control"
                                value="<?= htmlspecialchars($data['tanggal_selesai']); ?>"
                                required
                            >

                        </div>

                        <!-- STATUS -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select
                                name="status_aktif"
                                class="form-select"
                                required
                            >

                                <option value="1"
                                    <?= $data['status_aktif'] == 1 ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= $data['status_aktif'] == 0 ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                        <!-- TOMBOL -->
                        <div class="d-flex gap-2">

                            <a href="tahun_ajaran.php" class="btn btn-secondary">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

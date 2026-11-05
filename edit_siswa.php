
<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'data_siswa';

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

if ($id === '' || !ctype_digit((string)$id)) {
    header("Location: data_siswa.php");
    exit;
}

// Ambil data siswa berdasarkan ID
$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_siswa WHERE id = ?");

if (!$stmt) {
    die("Query gagal: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$query = mysqli_stmt_get_result($stmt);
$siswa = mysqli_fetch_assoc($query);

mysqli_stmt_close($stmt);

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons untuk Sidebar -->
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
                    <a href="data_siswa.php" class="nav-link active">
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
                    <a href="tahun_ajaran.php" class="nav-link text-white">
                        <i class="bi bi-calendar-range me-2"></i>
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penepatan_siswa.php" class="nav-link text-white">
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
                Edit Data Siswa
            </h2>

            <p class="text-muted mb-4">
                Silakan ubah data siswa.
            </p>


            <!-- FORM EDIT SISWA -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <form action="proses_edit_siswa.php" method="POST">

                        <!-- ID SISWA -->
                        <input
                            type="hidden"
                            name="id"
                            value="<?= htmlspecialchars($siswa['id']); ?>"
                        >


                        <!-- NIS -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                NIS
                            </label>

                            <input
                                type="text"
                                name="nis"
                                class="form-control"
                                placeholder="Masukkan NIS (15 digit)"
                                value="<?= htmlspecialchars($siswa['nis'] ?? ''); ?>"
                                maxlength="15"
                                minlength="15"
                                pattern="[0-9]{15}"
                                inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)"
                                title="NIS harus terdiri dari 15 digit angka"
                                required
                            >

                        </div>


                        <!-- NISN -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                NISN
                            </label>

                            <input
                                type="text"
                                name="nisn"
                                class="form-control"
                                placeholder="Masukkan NISN (10 digit)"
                                value="<?= htmlspecialchars($siswa['nisn'] ?? ''); ?>"
                                maxlength="10"
                                minlength="10"
                                pattern="[0-9]{10}"
                                inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                title="NISN harus terdiri dari 10 digit angka"
                                required
                            >

                        </div>


                        <!-- NAMA SISWA -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Siswa
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                placeholder="Masukkan nama siswa"
                                value="<?= htmlspecialchars($siswa['nama'] ?? ''); ?>"
                                required
                            >

                        </div>


                        <!-- JENIS KELAMIN -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="L"
                                    <?= ($siswa['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    <?= ($siswa['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>
                                    Perempuan
                                </option>

                            </select>

                        </div>


                        <!-- TANGGAL LAHIR -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="<?= htmlspecialchars($siswa['tanggal_lahir'] ?? ''); ?>"
                                required
                            >

                        </div>


                        <!-- ALAMAT -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"
                                placeholder="Masukkan alamat siswa"
                            ><?= htmlspecialchars($siswa['alamat'] ?? ''); ?></textarea>

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
                                    <?= ($siswa['status_aktif'] ?? '') == 1 ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= ($siswa['status_aktif'] ?? '') == 0 ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>


                        <!-- TOMBOL TANPA IKON -->
                        <div class="d-flex gap-2">

                            <a
                                href="data_siswa.php"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
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

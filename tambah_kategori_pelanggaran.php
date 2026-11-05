
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'kategori_pelanggaran';
$pesan = "";

// Nilai awal form
$nama_kategori = "";
$deskripsi = "";
$status = "1";

// Proses simpan data
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama_kategori = trim($_POST['nama_kategori'] ?? "");
    $deskripsi = trim($_POST['deskripsi'] ?? "");
    $status = $_POST['status'] ?? "1";

    if (
        $nama_kategori === "" ||
        $deskripsi === "" ||
        !in_array($status, ["0", "1"], true)
    ) {

        $pesan = "Semua data wajib diisi dengan benar.";

    } else {

        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO t_pelanggaran_kategori
                (nama, deskripsi, status_aktif)
             VALUES (?, ?, ?)"
        );

        if ($stmt) {

            $status_int = (int) $status;

            mysqli_stmt_bind_param(
                $stmt,
                "ssi",
                $nama_kategori,
                $deskripsi,
                $status_int
            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: kategori_pelanggaran.php?status=berhasil");
                exit;

            } else {

                $pesan = "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
            }

        } else {

            $pesan = "Query gagal diproses: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kategori Pelanggaran</title>

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

            <!-- MENU ADMIN -->
            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_siswa.php" class="nav-link text-white">
                            <i class="bi bi-people me-2"></i> Data Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_guru.php" class="nav-link text-white">
                            <i class="bi bi-person-badge me-2"></i> Data Guru
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kelas.php" class="nav-link text-white">
                            <i class="bi bi-door-open me-2"></i> Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tahun_ajaran.php" class="nav-link text-white">
                            <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="penepatan_siswa.php" class="nav-link text-white">
                            <i class="bi bi-journal-check me-2"></i> Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="wali_kelas.php" class="nav-link text-white">
                            <i class="bi bi-person-workspace me-2"></i> Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kategori_pelanggaran.php" class="nav-link active">
                            <i class="bi bi-tags me-2"></i> Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="jenis_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-list-task me-2"></i> Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="aboutme.php" class="nav-link text-white">
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

            <?php endif; ?>

            <!-- MENU PETUGAS -->
            <?php if (($_SESSION['role'] ?? '') === 'petugas'): ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kelas.php" class="nav-link text-white">
                            <i class="bi bi-door-open me-2"></i> Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
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

            <?php endif; ?>

            <!-- MENU GURU -->
            <?php if (($_SESSION['role'] ?? '') === 'guru'): ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="catatan_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tindakan.php" class="nav-link text-white">
                            <i class="bi bi-clipboard-check me-2"></i> Tindakan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="riwayat.php" class="nav-link text-white">
                            <i class="bi bi-clock-history me-2"></i> Riwayat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="rekap_poin.php" class="nav-link text-white">
                            <i class="bi bi-bar-chart me-2"></i> Rekap Poin
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            <?php endif; ?>

        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="fw-bold mb-1">
                Tambah Kategori Pelanggaran
            </h2>

            <p class="text-muted mb-4">
                Silakan isi data kategori pelanggaran dengan lengkap.
            </p>

            <!-- FORM CARD -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <?php if ($pesan !== ""): ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>

                        </div>

                    <?php endif; ?>

                    <form method="POST" action="">

                        <!-- NAMA KATEGORI -->
                        <div class="mb-3">

                            <label for="nama_kategori" class="form-label fw-semibold">
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                name="nama_kategori"
                                id="nama_kategori"
                                class="form-control"
                                placeholder="Masukkan nama kategori pelanggaran"
                                value="<?= htmlspecialchars($nama_kategori, ENT_QUOTES, 'UTF-8'); ?>"
                                required>

                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-3">

                            <label for="deskripsi" class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                name="deskripsi"
                                id="deskripsi"
                                class="form-control"
                                rows="4"
                                placeholder="Masukkan deskripsi kategori pelanggaran"
                                required><?= htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8'); ?></textarea>

                        </div>

                        <!-- STATUS -->
                        <div class="mb-3">

                            <label for="status" class="form-label fw-semibold">
                                Status
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                                required>

                                <option value="1" <?= $status === "1" ? "selected" : ""; ?>>
                                    Aktif
                                </option>

                                <option value="0" <?= $status === "0" ? "selected" : ""; ?>>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                        <!-- TOMBOL TANPA IKON -->
                        <div class="d-flex gap-2">

                            <a href="kategori_pelanggaran.php" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Simpan Kategori
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

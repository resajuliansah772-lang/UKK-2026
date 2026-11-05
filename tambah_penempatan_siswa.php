
<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'penepatan_siswa';
$pesan = "";

// Ambil data siswa aktif
$query_siswa = mysqli_query($koneksi, "
    SELECT id, nis, nama
    FROM t_siswa
    WHERE status_aktif = 1
    ORDER BY nama ASC
");

if (!$query_siswa) {
    die("Gagal mengambil data siswa: " . mysqli_error($koneksi));
}

// Ambil data tahun ajaran
$query_tahun = mysqli_query($koneksi, "
    SELECT id, nama
    FROM t_tahun_ajaran
    ORDER BY id DESC
");

if (!$query_tahun) {
    die("Gagal mengambil data tahun ajaran: " . mysqli_error($koneksi));
}

// Ambil data kelas
$query_kelas = mysqli_query($koneksi, "
    SELECT id, nama, tingkat, jurusan
    FROM t_kelas
    ORDER BY tingkat ASC, nama ASC
");

if (!$query_kelas) {
    die("Gagal mengambil data kelas: " . mysqli_error($koneksi));
}

// Proses penyimpanan
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $siswa_id = filter_input(INPUT_POST, "siswa_id", FILTER_VALIDATE_INT);
    $tahun_ajaran_id = filter_input(INPUT_POST, "tahun_ajaran_id", FILTER_VALIDATE_INT);
    $kelas_id = filter_input(INPUT_POST, "kelas_id", FILTER_VALIDATE_INT);

    $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = !empty($_POST['tanggal_selesai'])
        ? $_POST['tanggal_selesai']
        : null;

    $status_aktif = isset($_POST['status_aktif'])
        ? (int) $_POST['status_aktif']
        : 1;

    if (!$siswa_id || !$tahun_ajaran_id || !$kelas_id) {

        $pesan = "Siswa, tahun ajaran, dan kelas wajib dipilih.";

    } elseif (empty($tanggal_mulai)) {

        $pesan = "Tanggal mulai wajib diisi.";

    } else {

        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO t_kelas_siswa
            (siswa_id, kelas_id, tahun_ajaran_id, tanggal_mulai, tanggal_selesai, status_aktif)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "iiissi",
                $siswa_id,
                $kelas_id,
                $tahun_ajaran_id,
                $tanggal_mulai,
                $tanggal_selesai,
                $status_aktif
            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: penepatan_siswa.php?status=berhasil");
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

    <title>Tambah Penempatan Siswa</title>

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
                    <a href="tahun_ajaran.php" class="nav-link text-white">
                        <i class="bi bi-calendar-range me-2"></i>
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penepatan_siswa.php" class="nav-link active">
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
                Tambah Penempatan Siswa
            </h2>

            <p class="text-muted mb-4">
                Silakan isi data penempatan siswa dengan lengkap.
            </p>

            <!-- FORM -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <?php if ($pesan != ""): ?>

                        <div class="alert alert-danger alert-dismissible fade show">

                            <?= htmlspecialchars($pesan); ?>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>

                        </div>

                    <?php endif; ?>

                    <form method="POST" action="">

                        <!-- NAMA SISWA -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Siswa
                            </label>

                            <select name="siswa_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Siswa --
                                </option>

                                <?php while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>

                                    <option value="<?= (int)$siswa['id']; ?>">
                                        <?= htmlspecialchars($siswa['nis']); ?> -
                                        <?= htmlspecialchars($siswa['nama']); ?>
                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- TAHUN AJARAN -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Tahun Ajaran --
                                </option>

                                <?php while ($ta = mysqli_fetch_assoc($query_tahun)): ?>

                                    <option value="<?= (int)$ta['id']; ?>">
                                        <?= htmlspecialchars($ta['nama']); ?>
                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- KELAS -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Kelas
                            </label>

                            <select name="kelas_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Kelas --
                                </option>

                                <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>

                                    <option value="<?= (int)$kelas['id']; ?>">
                                        <?= htmlspecialchars($kelas['nama']); ?>
                                        (<?= htmlspecialchars($kelas['tingkat']); ?> -
                                        <?= htmlspecialchars($kelas['jurusan']); ?>)
                                    </option>

                                <?php endwhile; ?>

                            </select>

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
                                required>

                        </div>

                        <!-- TANGGAL SELESAI -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tanggal Selesai
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                class="form-control">

                        </div>

                        <!-- STATUS -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status_aktif" class="form-select" required>

                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                        <!-- TOMBOL -->
                        <div class="d-flex gap-2">

                            <a href="penepatan_siswa.php" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Simpan Penempatan Siswa
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

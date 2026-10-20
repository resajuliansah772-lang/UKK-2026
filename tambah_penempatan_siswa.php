<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'penepatan_siswa';

$pesan = "";
$jenis_pesan = "danger";

// Mengambil data siswa yang aktif
$sql_siswa = "SELECT id, nis, nama
             FROM t_siswa
             WHERE status_aktif = 1
             ORDER BY nama ASC";
$query_siswa = mysqli_query($koneksi, $sql_siswa);

if (!$query_siswa) {
    die("Gagal mengambil data siswa: " . mysqli_error($koneksi));
}

// Mengambil data kelas
$sql_kelas = "SELECT id, nama, tingkat, jurusan
             FROM t_kelas
             ORDER BY tingkat ASC, nama ASC";
$query_kelas = mysqli_query($koneksi, $sql_kelas);

if (!$query_kelas) {
    die("Gagal mengambil data kelas: " . mysqli_error($koneksi));
}

// Mengambil data tahun ajaran
$sql_tahun = "SELECT id, nama
              FROM t_tahun_ajaran
              ORDER BY id DESC";
$query_tahun = mysqli_query($koneksi, $sql_tahun);

if (!$query_tahun) {
    die("Gagal mengambil data tahun ajaran: " . mysqli_error($koneksi));
}

// Proses simpan penempatan siswa
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $siswa_id        = filter_input(INPUT_POST, "siswa_id", FILTER_VALIDATE_INT);
    $kelas_id        = filter_input(INPUT_POST, "kelas_id", FILTER_VALIDATE_INT);
    $tahun_ajaran_id = filter_input(INPUT_POST, "tahun_ajaran_id", FILTER_VALIDATE_INT);
    $tanggal_mulai   = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
    $status_aktif    = $_POST['status_aktif'] ?? 1;

    if (!$siswa_id || !$kelas_id || !$tahun_ajaran_id) {
        $pesan = "Siswa, kelas, dan tahun ajaran wajib dipilih.";
    } else {
        // Simpan penempatan ke t_kelas_siswa
        $stmt_simpan = mysqli_prepare(
            $koneksi,
            "INSERT INTO t_kelas_siswa (siswa_id, kelas_id, tahun_ajaran_id, tanggal_mulai, tanggal_selesai, status_aktif)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt_simpan,
            "iiissi",
            $siswa_id,
            $kelas_id,
            $tahun_ajaran_id,
            $tanggal_mulai,
            $tanggal_selesai,
            $status_aktif
        );

        if (mysqli_stmt_execute($stmt_simpan)) {
            mysqli_stmt_close($stmt_simpan);
            header("Location: penepatan_siswa.php?status=berhasil");
            exit;
        } else {
            $pesan = "Gagal menyimpan data penempatan: " . mysqli_error($koneksi);
            mysqli_stmt_close($stmt_simpan);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    
    <style>
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100 sidebar">
            <h4 class="text-white mb-4">
                Pelanggaran Siswa
            </h4>

            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link text-white">Data Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_guru.php" class="nav-link text-white">Data Guru</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link text-white">Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php" class="nav-link text-white">Tahun Ajaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="penepatan_siswa.php" class="nav-link active" aria-current="page">Penepatan Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link text-white">Wali Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">Kategori Pelanggaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">Jenis Pelanggaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">Laporan</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link text-white">About Me</a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Tambah Penempatan Siswa</h2>
            <p class="text-muted">
                Silakan pilih siswa, kelas, tahun ajaran, dan status penempatan.
            </p>

            <?php if ($pesan !== ""): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($pesan) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="">

                        <!-- PILIH SISWA -->
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Nama Siswa</label>
                            <select name="siswa_id" id="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>
                                    <option value="<?= (int) $siswa['id'] ?>">
                                        <?= htmlspecialchars($siswa['nis']) ?> - <?= htmlspecialchars($siswa['nama']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- PILIH TAHUN AJARAN -->
                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <?php while ($ta = mysqli_fetch_assoc($query_tahun)): ?>
                                    <option value="<?= (int) $ta['id'] ?>">
                                        <?= htmlspecialchars($ta['nama']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- PILIH KELAS -->
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>
                                    <option value="<?= (int) $kelas['id'] ?>">
                                        <?= htmlspecialchars($kelas['nama']) ?> (<?= htmlspecialchars($kelas['tingkat']) ?> - <?= htmlspecialchars($kelas['jurusan']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- TANGGAL MULAI -->
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        </div>

                        <!-- TANGGAL SELESAI -->
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="mb-4">
                            <label for="status_aktif" class="form-label">Status Penempatan</label>
                            <select name="status_aktif" id="status_aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="d-flex gap-2">
                            <a href="penepatan_siswa.php" class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Penempatan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
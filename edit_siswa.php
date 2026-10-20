<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Set variabel halaman aktif untuk siswa
$halaman = 'siswa';

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

// Ambil data siswa berdasarkan ID
$sql = "SELECT * FROM t_siswa WHERE id = '$id'";
$query = mysqli_query($koneksi, $sql);

// Cek apakah data ditemukan
if (!$query || mysqli_num_rows($query) == 0) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

$siswa = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR (Menggunakan struktur kode persis dari Anda) -->
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
                    <a href="laporan.php.php"
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


        <!-- KONTEN UTAMA DI SEBELAH KANAN -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-1">Edit Data Siswa</h2>
            <p class="text-muted small mb-4">Silakan ubah data siswa.</p>

            <!-- KARTU FORM -->
            <div class="card border-1 border-secondary-subtle shadow-sm p-4 rounded-3 bg-white">
                <form action="proses_edit_siswa.php" method="POST">

                    <!-- ID Hidden -->
                    <input type="hidden" name="id" value="<?= $siswa['id']; ?>">

                    <!-- NIS -->
                    <div class="mb-3">
                        <label class="form-label small text-secondary">NIS</label>
                        <input type="text" name="nis" class="form-control" maxlength="30" value="<?= htmlspecialchars($siswa['nis']); ?>" required>
                    </div>

                    <!-- NISN -->
                    <div class="mb-3">
                        <label class="form-label small text-secondary">NISN</label>
                        <input type="text" name="nisn" class="form-control" maxlength="20" value="<?= htmlspecialchars($siswa['nisn']); ?>" required>
                    </div>

                    <!-- Nama Siswa -->
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control" maxlength="150" value="<?= htmlspecialchars($siswa['nama']); ?>" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" <?= $siswa['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= $siswa['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= $siswa['tanggal_lahir']; ?>">
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="4"><?= htmlspecialchars($siswa['alamat']); ?></textarea>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label class="form-label small text-secondary">Status</label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="1" <?= $siswa['status_aktif'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                            <option value="0" <?= $siswa['status_aktif'] == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Tombol Batal & Simpan Perubahan -->
                    <div class="d-flex gap-2">
                        <a href="data_siswa.php" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" class="btn btn-primary px-3">Simpan Perubahan</button>
                    </div>

                </form>
            </div>
        </main>

    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
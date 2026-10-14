<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

// Set variabel halaman agar menu sidebar aktif sesuai
$halaman = 'kelas';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM t_kelas WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: kelas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100">
            <h4 class="text-white mb-4">My Website</h4>

            <!-- MENU UNTUK ADMIN -->
            <?php if ($_SESSION['role'] == 'admin') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link <?php echo ($halaman == 'siswa') ? 'active' : 'text-white'; ?>">Data Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_guru.php" class="nav-link <?php echo ($halaman == 'guru') ? 'active' : 'text-white'; ?>">Data Guru</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php" class="nav-link <?php echo ($halaman == 'tahun_ajaran') ? 'active' : 'text-white'; ?>">Tahun Ajaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">Laporan</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link <?php echo ($halaman == 'about') ? 'active' : 'text-white'; ?>">About Me</a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
            <?php } ?>

            <!-- MENU UNTUK PETUGAS -->
            <?php if ($_SESSION['role'] == 'petugas') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">Laporan</a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
            <?php } ?>

            <!-- MENU UNTUK GURU -->
            <?php if ($_SESSION['role'] == 'guru') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link <?php echo ($halaman == 'siswa') ? 'active' : 'text-white'; ?>">Data Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">Kelas</a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
            <?php } ?>

        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2>Edit Data Kelas</h2>
            <p>Ubah informasi kelas.</p>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="proses_edit_kelas.php" method="POST">
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">

                        <!-- NAMA KELAS -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
                        </div>

                        <!-- TINGKAT -->
                        <div class="mb-3">
                            <label class="form-label">Tingkat</label>
                            <select name="tingkat" class="form-select" required>
                                <option value="X" <?= $data['tingkat'] == 'X' ? 'selected' : ''; ?>>X</option>
                                <option value="XI" <?= $data['tingkat'] == 'XI' ? 'selected' : ''; ?>>XI</option>
                                <option value="XII" <?= $data['tingkat'] == 'XII' ? 'selected' : ''; ?>>XII</option>
                            </select>
                        </div>

                        <!-- JURUSAN -->
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="<?= htmlspecialchars($data['jurusan']); ?>" required>
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1" <?= $data['status_aktif'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?= $data['status_aktif'] == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- TOMBOL -->
                        <a href="kelas.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                    </form>
                </div>
            </div>
        </main>

    </div>
</div>
</body>
</html>
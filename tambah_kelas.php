<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

// Set variabel halaman agar menu sidebar aktif sesuai
$halaman = 'kelas';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
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
            <h2>Tambah Data Kelas</h2>
            <p>Silakan isi data kelas dengan lengkap.</p>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="proses_tambah_kelas.php" method="POST">

                        <!-- NAMA KELAS -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: XII RPL 1" required>
                        </div>

                        <!-- TINGKAT -->
                        <div class="mb-3">
                            <label class="form-label">Tingkat</label>
                            <select name="tingkat" class="form-select" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>

                        <!-- JURUSAN -->
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- TOMBOL -->
                        <a href="kelas.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Kelas</button>

                    </form>
                </div>
            </div>
        </main>

    </div>
</div>
</body>
</html>
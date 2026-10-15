<?php

session_start();

if (!isset($_SESSION['login'] ) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

// Set variabel halaman agar menu sidebar aktif sesuai
$halaman = 'kelas';

// ==============================
// AMBIL DATA KELAS SESUAI DATABASE
// ==============================
$sql = "SELECT * FROM t_kelas ORDER BY nama ASC";
$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas</title>
    
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        <!-- =================================
             SIDEBAR
        ================================== -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

            <!-- JUDUL -->
            <h4 class="text-white mb-4">
                My Website
            </h4>

            <!-- MENU UNTUK ADMIN -->
            <?php if ($_SESSION['role'] == 'admin') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link <?php echo ($halaman == 'siswa') ? 'active' : 'text-white'; ?>">
                        Data Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_guru.php" class="nav-link <?php echo ($halaman == 'guru') ? 'active' : 'text-white'; ?>">
                        Data Guru
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                        Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php" class="nav-link <?php echo ($halaman == 'tahun_ajaran') ? 'active' : 'text-white'; ?>">
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="penepatan_siswa.php" class="nav-link <?php echo ($halaman == 'penepatan_siswa') ? 'active' : 'text-white'; ?>">
                        Penepatan Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link <?php echo ($halaman == 'walikelas') ? 'active' : 'text-white'; ?>">
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link <?php echo ($halaman == 'kategori_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link <?php echo ($halaman == 'jenis_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="cetak.php" class="nav-link <?php echo ($halaman == 'cetak') ? 'active' : 'text-white'; ?>">
                        Cetak/Export
                    </a>
                </li>


                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                        Laporan
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link <?php echo ($halaman == 'about') ? 'active' : 'text-white'; ?>">
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
            <?php if ($_SESSION['role'] == 'petugas') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                        Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">
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
            <?php if ($_SESSION['role'] == 'guru') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link <?php echo ($halaman == 'siswa') ? 'active' : 'text-white'; ?>">
                        Data Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                        Kelas
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

        <!-- =================================
             KONTEN
        ================================== -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>
                Data Kelas
            </h2>

            <p>
                Daftar kelas pada sistem
            </p>

            <div class="mb-3">
                <a href="tambah_kelas.php" class="btn btn-primary">
                    Tambah Kelas
                </a>
            </div>

            <!-- TABEL -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no = 1;
                    while ($kelas = mysqli_fetch_assoc($query)):
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($kelas['nama']); ?></td>
                            <td><?= htmlspecialchars($kelas['tingkat']); ?></td>
                            <td><?= htmlspecialchars($kelas['jurusan']); ?></td>
                            <td>
                                <a href="edit_kelas.php?id=<?= $kelas['id']; ?>" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a href="hapus_kelas.php?id=<?= $kelas['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas ini?');">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </main>

    </div>
</div>

</body>
</html>
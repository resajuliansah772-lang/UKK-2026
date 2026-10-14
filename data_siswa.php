<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

// Set variabel halaman agar menu sidebar aktif sesuai
$halaman = 'siswa';

// ==============================
// AMBIL DATA SISWA AKTIF
// ==============================

$sql = "SELECT * FROM t_siswa
        WHERE status_aktif = 1
        ORDER BY nama ASC";

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
    <title>Data Siswa</title>
    
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
                Data Siswa
            </h2>

            <p>
                Data siswa pada sistem pelanggaran siswa
            </p>

            <!-- TOMBOL TAMBAH -->
            <div class="mb-3">
                <a href="tambah_siswa.php" class="btn btn-primary">
                    Tambah Siswa
                </a>
            </div>

            <!-- TABEL -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no = 1;
                    while ($siswa = mysqli_fetch_assoc($query)):
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($siswa['nis']); ?></td>
                            <td><?= htmlspecialchars($siswa['nisn']); ?></td>
                            <td><?= htmlspecialchars($siswa['nama']); ?></td>
                            <td>
                                <?php
                                if ($siswa['jenis_kelamin'] == 'L') {
                                    echo "Laki-laki";
                                } elseif ($siswa['jenis_kelamin'] == 'P') {
                                    echo "Perempuan";
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($siswa['tanggal_lahir']); ?></td>
                            <td><?= htmlspecialchars($siswa['alamat']); ?></td>
                            <td>
                                <span class="badge text-bg-success">
                                    Aktif
                                </span>
                            </td>
                            <td>
                                <a href="edit_siswa.php?id=<?= $siswa['id']; ?>" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a href="hapus_siswa.php?id=<?= $siswa['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menonaktifkan siswa ini?');">
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
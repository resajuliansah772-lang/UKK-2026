<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif di sidebar
$halaman = 'kategori_pelanggaran';

// Proses simpan data saat form di-submit
if (isset($_POST['simpan'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $status        = mysqli_real_escape_string($koneksi, $_POST['status']);

    $query = "INSERT INTO kategori_pelanggaran (nama_kategori, deskripsi, status) 
              VALUES ('$nama_kategori', '$deskripsi', '$status')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data Kategori Pelanggaran berhasil ditambahkan!');
                window.location.href='kategori_pelanggaran.php';
              </script>";
    } else {
        $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori Pelanggaran</title>

    <!-- BOOTSTRAP 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR (Murni Kelas Bootstrap 5) -->
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
                    <a href="laporan.php"
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

            <!-- HEADER -->
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Tambah Kategori Pelanggaran</h2>
                <p class="text-muted small mb-0">
                    Formulir penambahan data kategori pelanggaran siswa.
                </p>
            </div>

            <!-- FORM CARD CONTAINER -->
            <div class="card border-1 border-secondary-subtle shadow-sm p-4 rounded-3 bg-white">

                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label small text-secondary">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Kategori Sub-51" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label small text-secondary">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Contoh: Deskripsi Kategori Pelanggaran 51" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label small text-secondary">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="kategori_pelanggaran.php" class="btn btn-secondary px-3">
                            Batal
                        </a>
                        <button type="submit" name="simpan" class="btn btn-primary px-3">
                            Simpan Data
                        </button>
                    </div>

                </form>

            </div>

        </main>
    </div>
</div>

<!-- BOOTSTRAP 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
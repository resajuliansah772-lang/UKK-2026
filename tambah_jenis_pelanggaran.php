<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif di sidebar
$halaman = 'jenis_pelanggaran';

// Periksa struktur tabel jenis pelanggaran untuk mendeteksi nama kolom yang benar
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran");
if (!$hasil_kolom) {
    $hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran_jenis");
    if (!$hasil_kolom) {
        $hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM jenis_pelanggaran");
    }
}

if (!$hasil_kolom) {
    die("Tabel jenis pelanggaran tidak ditemukan: " . mysqli_error($koneksi));
}

$kolom_tersedia = [];
while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

function cariKolom($daftar, $pilihan) {
    foreach ($pilihan as $kolom) {
        if (in_array($kolom, $daftar, true)) {
            return $kolom;
        }
    }
    return null;
}

$kolom_nama = cariKolom($kolom_tersedia, ['nama', 'nama_pelanggaran', 'nama_jenis', 'nama_jenis_pelanggaran']);
$kolom_kategori = cariKolom($kolom_tersedia, ['kategori_id', 'pelanggaran_kategori_id', 'id_kategori']);
$kolom_poin = cariKolom($kolom_tersedia, ['poin', 'poin_pelanggaran', 'jumlah_poin']);
$kolom_deskripsi = cariKolom($kolom_tersedia, ['deskripsi', 'keterangan']);
$kolom_status = cariKolom($kolom_tersedia, ['status_aktif', 'status']);

// Ambil data kategori untuk pilihan dropdown
$query_kategori = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori");
if (!$query_kategori) {
    $query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori_pelanggaran");
}

// Proses simpan data saat form disubmit
if (isset($_POST['simpan'])) {
    $val_nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $val_kategori = mysqli_real_escape_string($koneksi, $_POST['kategori_id']);
    $val_poin = mysqli_real_escape_string($koneksi, $_POST['poin']);
    $val_deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $val_status = mysqli_real_escape_string($koneksi, $_POST['status_aktif']);

    // Query dinamis berdasarkan nama kolom yang ditemukan di database
    $sql_insert = "INSERT INTO t_pelanggaran ($kolom_nama, $kolom_kategori, $kolom_poin, $kolom_deskripsi, $kolom_status) 
                   VALUES ('$val_nama', '$val_kategori', '$val_poin', '$val_deskripsi', '$val_status')";
    
    $simpan = mysqli_query($koneksi, $sql_insert);
    if (!$simpan) {
        $sql_insert = "INSERT INTO t_pelanggaran_jenis (nama, kategori_id, poin, deskripsi, status_aktif) 
                       VALUES ('$val_nama', '$val_kategori', '$val_poin', '$val_deskripsi', '$val_status')";
        $simpan = mysqli_query($koneksi, $sql_insert);
    }

    if ($simpan) {
        echo "<script>
                alert('Data Jenis Pelanggaran berhasil ditambahkan!');
                window.location.href='jenis_pelanggaran.php';
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
    <title>Tambah Jenis Pelanggaran</title>

    <!-- BOOTSTRAP 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100">
            <h4 class="text-white mb-4">
                Pelanggaran Siswa
            </h4>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
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
                    <a href="penempatan_siswa.php" class="nav-link text-white">Penepatan Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link text-white">Wali Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">Kategori Pelanggaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link active">Jenis Pelanggaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">Laporan</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link text-white">About Me</a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger fw-bold">Logout</a>
                </li>
            </ul>
            <?php } ?>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Tambah Jenis Pelanggaran</h2>
                <p class="text-muted small mb-0">
                    Formulir penambahan data jenis pelanggaran siswa.
                </p>
            </div>

            <div class="card border-1 border-secondary-subtle shadow-sm p-4 rounded-3 bg-white">
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form action="" method="POST">

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Nama Jenis Pelanggaran</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Terlambat Masuk Sekolah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Kategori ID</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php 
                            if ($query_kategori && mysqli_num_rows($query_kategori) > 0) {
                                while ($kat = mysqli_fetch_assoc($query_kategori)) {
                                    $kat_nama = $kat['nama'] ?? $kat['nama_kategori'] ?? 'Kategori ' . $kat['id'];
                                    echo "<option value='{$kat['id']}'>{$kat['id']} - {$kat_nama}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Poin</label>
                        <input type="number" name="poin" class="form-control" placeholder="Contoh: 10" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Keterangan singkat jenis pelanggaran" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-secondary">Status</label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="jenis_pelanggaran.php" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" name="simpan" class="btn btn-primary px-3">Simpan Data</button>
                    </div>

                </form>
            </div>

        </main>

    </div>
</div>

<!-- BOOTSTRAP 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
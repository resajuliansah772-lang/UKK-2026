<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Ambil data siswa untuk dropdown
$sql_siswa = "SELECT id, nis, nama FROM t_siswa ORDER BY nama ASC";
$query_siswa = mysqli_query($koneksi, $sql_siswa);

// Ambil data kelas untuk dropdown
$sql_kelas = "SELECT id, nama FROM t_kelas ORDER BY nama ASC";
$query_kelas = mysqli_query($koneksi, $sql_kelas);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penempatan Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark text-white p-3 min-vh-100">

            <h4>My Website</h4>
            <hr>

            <a href="dashboard.php"
               class="d-block text-white text-decoration-none p-2">
                Dashboard
            </a>

            <a href="data_siswa.php"
               class="d-block text-white text-decoration-none p-2">
                Data Siswa
            </a>

            <a href="data_guru.php"
               class="d-block text-white text-decoration-none p-2">
                Data Guru
            </a>

            <a href="kelas.php"
               class="d-block text-white text-decoration-none p-2">
                Kelas
            </a>

            <a href="tahun_ajaran.php"
               class="d-block text-white text-decoration-none p-2">
                Tahun Ajaran
            </a>

            <a href="penempatan_siswa.php"
               class="d-block bg-primary text-white text-decoration-none rounded p-2">
                Penempatan Siswa
            </a>

            <a href="wali_kelas.php"
               class="d-block text-white text-decoration-none p-2">
                Wali Kelas
            </a>

            <a href="kategori_pelanggaran.php"
               class="d-block text-white text-decoration-none p-2">
                Kategori Pelanggaran
            </a>

            <a href="jenis_pelanggaran.php"
               class="d-block text-white text-decoration-none p-2">
                Jenis Pelanggaran
            </a>

            <a href="laporan.php"
               class="d-block text-white text-decoration-none p-2">
                Laporan
            </a>

            <a href="aboutme.php"
               class="d-block text-white text-decoration-none p-2">
                About Me
            </a>

            <hr>

            <a href="logout.php"
               class="d-block text-danger text-decoration-none p-2">
                Logout
            </a>

        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-9 col-lg-10 p-4">

            <div class="mb-4">
                <h2>Tambah Penempatan Siswa</h2>
                <p class="text-muted">Form untuk menempatkan siswa ke dalam kelas.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="proses_tambah_penempatan_siswa.php" method="POST">

                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Pilih Siswa</label>
                            <select name="siswa_id" id="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php while ($s = mysqli_fetch_assoc($query_siswa)) { ?>
                                    <option value="<?= $s['id']; ?>">
                                        <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Pilih Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php while ($k = mysqli_fetch_assoc($query_kelas)) { ?>
                                    <option value="<?= $k['id']; ?>">
                                        <?= htmlspecialchars($k['nama']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="penempatan_siswa.php" class="btn btn-secondary">
                                &larr; Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Simpan Penempatan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>
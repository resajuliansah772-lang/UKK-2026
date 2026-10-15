<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Ambil data catatan pelanggaran
$sql = "SELECT 
            ps.*, 
            s.nis, 
            s.nama AS nama_siswa, 
            p.nama AS nama_pelanggaran, 
            p.poin 
        FROM t_pelanggaran_siswa ps
        JOIN t_siswa s ON ps.siswa_id = s.id
        JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
        ORDER BY ps.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    $error_message = mysqli_error($koneksi);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Pelanggaran</title>

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

            <a href="catatan_pelanggaran.php"
               class="d-block bg-primary text-white text-decoration-none rounded p-2">
                Catatan Pelanggaran
            </a>

            <a href="tindakan.php"
               class="d-block text-white text-decoration-none p-2">
                Tindakan
            </a>

            <a href="laporan.php"
               class="d-block text-white text-decoration-none p-2">
                Laporan
            </a>

            <a href="riwayat.php"
               class="d-block text-white text-decoration-none p-2">
                Riwayat
            </a>

            <a href="rekap_poin.php"
               class="d-block text-white text-decoration-none p-2">
                Rekap Poin
            </a>

            <hr>

            <a href="logout.php"
               class="d-block text-danger text-decoration-none p-2">
                Logout
            </a>

        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-9 col-lg-10 p-4">

            <!-- HEADER DENGAN TOMBOL DI SEBELAH KANAN (FLEXBOX) -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2>Catatan Pelanggaran</h2>
                    <p class="text-muted mb-0">Daftar pelanggaran siswa yang tercatat dalam sistem.</p>
                </div>
                <div>
                    <a href="tambah_catatan_pelanggaran.php" class="btn btn-primary">
                        + Tambah Catatan
                    </a>
                </div>
            </div>

            <?php if (isset($error_message)) { ?>
                <div class="alert alert-warning" role="alert">
                    <strong>Informasi Database:</strong> Terdeteksi kendala query.<br>
                    Detail error: <?= htmlspecialchars($error_message); ?>
                </div>
            <?php } ?>

            <!-- TABEL -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Pelanggaran</th>
                            <th>Poin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    if (isset($query) && $query && mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nis']); ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa']); ?></td>
                            <td><?= htmlspecialchars($row['nama_pelanggaran']); ?></td>
                            <td>
                                <span class="badge bg-danger">
                                    <?= htmlspecialchars($row['poin']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_catatan_pelanggaran.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus_catatan_pelanggaran.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus catatan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data catatan pelanggaran.</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

</body>
</html>

<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Periksa struktur tabel jenis pelanggaran
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran");

if (!$hasil_kolom) {
    die("Tabel t_pelanggaran tidak ditemukan: " .
        mysqli_error($koneksi));
}

$kolom_tersedia = [];

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

// Cari kolom berdasarkan nama yang tersedia
function cariKolom($daftar, $pilihan) {
    foreach ($pilihan as $kolom) {
        if (in_array($kolom, $daftar, true)) {
            return $kolom;
        }
    }
    return null;
}

$kolom_nama = cariKolom($kolom_tersedia, [
    'nama', 'nama_pelanggaran', 'nama_jenis', 'jenis_pelanggaran'
]);

$kolom_kategori = cariKolom($kolom_tersedia, [
    'kategori_id', 'pelanggaran_kategori_id', 'id_kategori'
]);

$kolom_poin = cariKolom($kolom_tersedia, [
    'poin', 'poin_pelanggaran', 'jumlah_poin'
]);

$kolom_deskripsi = cariKolom($kolom_tersedia, [
    'deskripsi', 'keterangan'
]);

$kolom_status = cariKolom($kolom_tersedia, [
    'status_aktif'
]);

// Ambil data
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM t_pelanggaran ORDER BY id DESC"
);

if (!$query) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jenis Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
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
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100">

            <h4 class="text-white mb-4">
                My Website
            </h4>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_guru.php" class="nav-link text-white">
                        Data Guru
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link text-white">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php" class="nav-link text-white">
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="penepatan_siswa.php" class="nav-link text-white">
                       Penepatan Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link text-white">
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">
                        Kategori Pelanggaran
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">
                        Jenis Pelanggaran
                    </a>
                </li>

                 <li class="nav-item mb-2">
                    <a href="cetak.php" class="nav-link text-white">
                        Cetak/Export
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">
                        Laporan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link text-white">
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

        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-9 col-lg-10 p-4">

            <h2>Jenis Pelanggaran</h2>

            <p class="text-muted">
                Kelola data jenis pelanggaran siswa.
            </p>

            <div class="mb-3">
                <a href="tambah_jenis_pelanggaran.php"
                   class="btn btn-primary">
                    + Tambah Jenis Pelanggaran
                </a>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jenis Pelanggaran</th>

                                    <?php if ($kolom_kategori) { ?>
                                        <th>Kategori ID</th>
                                    <?php } ?>

                                    <?php if ($kolom_poin) { ?>
                                        <th>Poin</th>
                                    <?php } ?>

                                    <?php if ($kolom_deskripsi) { ?>
                                        <th>Deskripsi</th>
                                    <?php } ?>

                                    <?php if ($kolom_status) { ?>
                                        <th>Status</th>
                                    <?php } ?>

                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                            $no = 1;

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $kolom_nama
                                                ? (string) ($row[$kolom_nama] ?? '-')
                                                : 'Kolom nama belum diketahui'
                                        ); ?>
                                    </td>

                                    <?php if ($kolom_kategori) { ?>
                                        <td>
                                            <?= htmlspecialchars(
                                                (string) ($row[$kolom_kategori] ?? '-')
                                            ); ?>
                                        </td>
                                    <?php } ?>

                                    <?php if ($kolom_poin) { ?>
                                        <td>
                                            <?= htmlspecialchars(
                                                (string) ($row[$kolom_poin] ?? '0')
                                            ); ?>
                                        </td>
                                    <?php } ?>

                                    <?php if ($kolom_deskripsi) { ?>
                                        <td>
                                            <?= nl2br(htmlspecialchars(
                                                (string) ($row[$kolom_deskripsi] ?? '-')
                                            )); ?>
                                        </td>
                                    <?php } ?>

                                    <?php if ($kolom_status) { ?>
                                        <td>
                                            <?php if ((int) $row[$kolom_status] === 1) { ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>

                                    <td>
                                        <a href="edit_jenis_pelanggaran.php?id=<?= (int) $row['id']; ?>"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="hapus_jenis_pelanggaran.php?id=<?= (int) $row['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Belum ada data jenis pelanggaran.
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>

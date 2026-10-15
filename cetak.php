
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Ambil data pelanggaran siswa
$sql = "SELECT * FROM t_pelanggaran_siswa ORDER BY id DESC";
$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data pelanggaran: " .
        mysqli_error($koneksi));
}

// Nama kolom tabel secara otomatis
$kolom = [];

if ($hasil = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran_siswa")) {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $kolom[] = $baris['Field'];
    }
}

// Ekspor data ke CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="data_pelanggaran_siswa.csv"');

    $output = fopen('php://output', 'w');

    // BOM agar teks CSV terbaca dengan baik di Excel
    fwrite($output, "\xEF\xBB\xBF");

    fputcsv($output, $kolom);

    while ($row = mysqli_fetch_assoc($query)) {
        $data = [];

        foreach ($kolom as $field) {
            $data[] = $row[$field] ?? '';
        }

        fputcsv($output, $data);
    }

    fclose($output);
    exit;
}

// Ambil ulang data untuk tampilan tabel
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak / Ekspor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        @media print {
            .sidebar, .tombol-aksi {
                display: none !important;
            }

            .konten {
                width: 100% !important;
            }

            body {
                font-size: 12px;
            }
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
                    <a href="walikelas.php" class="nav-link text-white">
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
        <div class="col-md-9 col-lg-10 p-4 konten">

            <h2>Cetak / Ekspor</h2>

            <p class="text-muted">
                Cetak atau ekspor data pelanggaran siswa.
            </p>

            <div class="mb-3 tombol-aksi">
                <button type="button"
                        onclick="window.print()"
                        class="btn btn-primary">
                    Cetak Data
                </button>

                <a href="cetak_export.php?export=csv"
                   class="btn btn-success">
                    Ekspor ke CSV
                </a>
            </div>

            <div class="card">
                <div class="card-body">

                    <h5 class="mb-3">Data Pelanggaran Siswa</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>

                                    <?php foreach ($kolom as $field) { ?>
                                        <th>
                                            <?= htmlspecialchars($field); ?>
                                        </th>
                                    <?php } ?>
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

                                    <?php foreach ($kolom as $field) { ?>
                                        <td>
                                            <?= htmlspecialchars(
                                                (string) ($row[$field] ?? '-')
                                            ); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="<?= count($kolom) + 1; ?>"
                                        class="text-center">
                                        Belum ada data pelanggaran siswa.
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

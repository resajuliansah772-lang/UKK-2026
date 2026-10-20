<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'laporan';

// Cari tabel yang benar-benar ada di database secara aman
$query = false;
$result_tables = mysqli_query($koneksi, "SHOW TABLES");
$tables_db = [];
if ($result_tables) {
    while ($row_tabel = mysqli_fetch_row($result_tables)) {
        $tables_db[] = $row_tabel[0];
    }
}

// Daftar prioritas nama tabel laporan/catatan pelanggaran
$prioritas_tabel = ['t_pelanggaran_catatan', 'catatan_pelanggaran', 't_pelanggaran', 'pelanggaran', 'jenis_pelanggaran'];
$tabel_terpilih = '';

foreach ($prioritas_tabel as $t) {
    if (in_array($t, $tables_db)) {
        $tabel_terpilih = $t;
        break;
    }
}

// Jika ketemu, ambil datanya
if (!empty($tabel_terpilih)) {
    $query = mysqli_query($koneksi, "SELECT * FROM $tabel_terpilih ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran</title>

    <!-- BOOTSTRAP 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Mode Cetak -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            main {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            body {
                background-color: #ffffff !important;
            }
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100 no-print">
            <h4 class="text-white mb-4">Pelanggaran Siswa</h4>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item mb-2"><a href="data_siswa.php" class="nav-link text-white">Data Siswa</a></li>
                <li class="nav-item mb-2"><a href="data_guru.php" class="nav-link text-white">Data Guru</a></li>
                <li class="nav-item mb-2"><a href="kelas.php" class="nav-link text-white">Kelas</a></li>
                <li class="nav-item mb-2"><a href="tahun_ajaran.php" class="nav-link text-white">Tahun Ajaran</a></li>
                <li class="nav-item mb-2"><a href="penempatan_siswa.php" class="nav-link text-white">Penetapan Siswa</a></li>
                <li class="nav-item mb-2"><a href="wali_kelas.php" class="nav-link text-white">Wali Kelas</a></li>
                <li class="nav-item mb-2"><a href="kategori_pelanggaran.php" class="nav-link text-white">Kategori Pelanggaran</a></li>
                <li class="nav-item mb-2"><a href="jenis_pelanggaran.php" class="nav-link text-white">Jenis Pelanggaran</a></li>
                <li class="nav-item mb-2"><a href="cetak.php" class="nav-link text-white">Cetak/Export</a></li>
                <li class="nav-item mb-2"><a href="laporan.php" class="nav-link active">Laporan</a></li>
                <li class="nav-item mb-2"><a href="aboutme.php" class="nav-link text-white">About Me</a></li>
                <hr class="text-secondary">
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger fw-bold">Logout</a></li>
            </ul>
            <?php } ?>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                <div>
                    <h2 class="fw-bold mb-1">Laporan Pelanggaran</h2>
                    <p class="text-muted small mb-0">Rekapitulasi catatan pelanggaran siswa.</p>
                </div>
                <div>
                    <button onclick="window.print()" class="btn btn-success px-3 fw-medium">
                        🖨️ Cetak / Print Laporan
                    </button>
                </div>
            </div>

            <!-- KOP LAPORAN (Hanya muncul saat dicetak) -->
            <div class="text-center mb-4 d-none d-print-block">
                <h3 class="fw-bold text-uppercase">Laporan Rekapitulasi Pelanggaran Siswa</h3>
                <h5 class="text-secondary">Sistem Informasi Pelanggaran Siswa</h5>
                <hr class="border-dark opacity-75">
            </div>

            <div class="card border-1 border-secondary-subtle shadow-sm rounded-3 bg-white">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="py-3 px-3" style="width: 5%;">No</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3">Nama Siswa</th>
                                    <th class="py-3">Jenis Pelanggaran</th>
                                    <th class="py-3">Poin</th>
                                    <th class="py-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if ($query && mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $tgl = $row['tanggal'] ?? $row['tgl'] ?? '-';
                                        $siswa = $row['nama_siswa'] ?? $row['siswa'] ?? $row['nama'] ?? '-';
                                        $jenis = $row['jenis_pelanggaran'] ?? $row['nama_pelanggaran'] ?? $row['nama'] ?? '-';
                                        $poin = $row['poin'] ?? '0';
                                        $ket = $row['keterangan'] ?? $row['deskripsi'] ?? '-';
                                ?>
                                <tr>
                                    <td class="px-3"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($tgl); ?></td>
                                    <td class="fw-medium"><?= htmlspecialchars($siswa); ?></td>
                                    <td><?= htmlspecialchars($jenis); ?></td>
                                    <td><span class="badge bg-danger px-2 py-1"><?= htmlspecialchars($poin); ?></span></td>
                                    <td><?= htmlspecialchars($ket); ?></td>
                                </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data laporan atau tabel catatan pelanggaran belum dibuat di database.</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
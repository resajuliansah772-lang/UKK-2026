
<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

$halaman = 'dashboard';
$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

// =====================================
// STATISTIK UTAMA
// =====================================

$querySiswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM t_siswa WHERE status_aktif = 1");
$jumlahSiswa = mysqli_fetch_assoc($querySiswa)['total'] ?? 0;

$queryGuru = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM t_guru");
$jumlahGuru = mysqli_fetch_assoc($queryGuru)['total'] ?? 0;

$queryKelas = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM t_kelas");
$jumlahKelas = mysqli_fetch_assoc($queryKelas)['total'] ?? 0;

$queryPelanggaran = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM t_pelanggaran_siswa");
$jumlahPelanggaran = mysqli_fetch_assoc($queryPelanggaran)['total'] ?? 0;


// =====================================
// TOP 5 SISWA PELANGGARAN TERBANYAK
// =====================================

$dataTop5 = [];

$queryTop5 = mysqli_query($koneksi, "
    SELECT
        nama_siswa,
        COUNT(id) AS jumlah_pelanggaran
    FROM t_pelanggaran_siswa
    GROUP BY nama_siswa
    ORDER BY jumlah_pelanggaran DESC, nama_siswa ASC
    LIMIT 5
");

if (!$queryTop5) {
    die("Gagal mengambil Top 5: " . mysqli_error($koneksi));
}

while ($row = mysqli_fetch_assoc($queryTop5)) {
    $dataTop5[] = $row;
}


// =====================================
// PELANGGARAN TERBARU
// =====================================

$dataTerbaru = [];

$queryTerbaru = mysqli_query($koneksi, "
    SELECT
        id,
        tanggal,
        nama_siswa,
        nama_pelanggaran,
        poin,
        keterangan
    FROM t_pelanggaran_siswa
    ORDER BY tanggal DESC, id DESC
    LIMIT 5
");

if (!$queryTerbaru) {
    die("Gagal mengambil pelanggaran terbaru: " . mysqli_error($koneksi));
}

while ($row = mysqli_fetch_assoc($queryTerbaru)) {
    $dataTerbaru[] = $row;
}


// =====================================
// GRAFIK PELANGGARAN 6 BULAN TERAKHIR
// =====================================

$labelGrafik = [];
$dataGrafik = [];

$namaBulan = [
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'Mei',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Agu',
    9 => 'Sep',
    10 => 'Okt',
    11 => 'Nov',
    12 => 'Des'
];

$awalBulan = new DateTime('first day of this month');
$awalBulan->modify('-5 months');

$akhirBulan = new DateTime('first day of next month');

$tanggalAwal = $awalBulan->format('Y-m-d');
$tanggalAkhir = $akhirBulan->format('Y-m-d');

// Siapkan enam bulan dengan nilai awal 0
for ($i = 0; $i < 6; $i++) {

    $bulan = clone $awalBulan;
    $bulan->modify("+$i months");

    $key = $bulan->format('Y-m');

    $labelGrafik[] = $namaBulan[(int)$bulan->format('n')];
    $dataGrafik[$key] = 0;
}

// Ambil jumlah pelanggaran per bulan
$queryGrafik = mysqli_query($koneksi, "
    SELECT
        DATE_FORMAT(tanggal, '%Y-%m') AS bulan,
        COUNT(id) AS jumlah
    FROM t_pelanggaran_siswa
    WHERE tanggal >= '$tanggalAwal'
      AND tanggal < '$tanggalAkhir'
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY bulan ASC
");

if (!$queryGrafik) {
    die("Gagal mengambil grafik: " . mysqli_error($koneksi));
}

while ($row = mysqli_fetch_assoc($queryGrafik)) {
    if (isset($dataGrafik[$row['bulan']])) {
        $dataGrafik[$row['bulan']] = (int)$row['jumlah'];
    }
}

$dataGrafik = array_values($dataGrafik);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Sistem Pelanggaran Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            padding-left: 15px;
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important;
        }

        .icon-box {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.5rem;
        }

        .sidebar {
            background: linear-gradient(180deg, #212529 0%, #1a1e21 100%);
        }
    </style>

</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar min-vh-100 p-3">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i>
                Pelanggaran Siswa
            </h4>

            <?php if ($roleUser == 'admin') { ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_siswa.php" class="nav-link text-white">
                            <i class="bi bi-people me-2"></i> Data Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_guru.php" class="nav-link text-white">
                            <i class="bi bi-person-badge me-2"></i> Data Guru
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kelas.php" class="nav-link text-white">
                            <i class="bi bi-door-open me-2"></i> Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tahun_ajaran.php" class="nav-link text-white">
                            <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="penempatan_siswa.php" class="nav-link text-white">
                            <i class="bi bi-journal-check me-2"></i> Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="wali_kelas.php" class="nav-link text-white">
                            <i class="bi bi-person-workspace me-2"></i> Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kategori_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-tags me-2"></i> Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="jenis_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-list-task me-2"></i> Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="aboutme.php" class="nav-link text-white">
                            <i class="bi bi-info-circle me-2"></i> About Me
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            <?php } else { ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="catatan_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tindakan.php" class="nav-link text-white">
                            <i class="bi bi-hammer me-2"></i> Tindakan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="riwayat.php" class="nav-link text-white">
                            <i class="bi bi-clock-history me-2"></i> Riwayat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="rekap_poin.php" class="nav-link text-white">
                            <i class="bi bi-award me-2"></i> Rekap Poin
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            <?php } ?>

        </div>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4">

                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        Dashboard Utama
                    </h3>

                    <p class="text-muted mb-0">
                        Selamat datang kembali,
                        <span class="fw-semibold text-primary">
                            <?= $namaUser; ?>
                        </span>!
                    </p>
                </div>

                <div>
                    <span class="badge bg-primary-subtle text-primary border px-3 py-2 fs-6 text-uppercase">
                        <i class="bi bi-shield-check me-1"></i>
                        Role: <?= htmlspecialchars($roleUser); ?>
                    </span>
                </div>

            </div>


            <!-- STATISTIK -->
            <div class="row g-4 mb-4">

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm border-start border-primary border-4">
                        <div class="card-body d-flex align-items-center">

                            <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>

                            <div>
                                <span class="text-muted small fw-bold">Total Siswa</span>
                                <h3 class="fw-bold mb-0"><?= $jumlahSiswa; ?></h3>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm border-start border-success border-4">
                        <div class="card-body d-flex align-items-center">

                            <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>

                            <div>
                                <span class="text-muted small fw-bold">Total Guru</span>
                                <h3 class="fw-bold mb-0"><?= $jumlahGuru; ?></h3>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm border-start border-warning border-4">
                        <div class="card-body d-flex align-items-center">

                            <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                                <i class="bi bi-door-open-fill"></i>
                            </div>

                            <div>
                                <span class="text-muted small fw-bold">Total Kelas</span>
                                <h3 class="fw-bold mb-0"><?= $jumlahKelas; ?></h3>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm border-start border-danger border-4">
                        <div class="card-body d-flex align-items-center">

                            <div class="icon-box bg-danger bg-opacity-10 text-danger me-3">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>

                            <div>
                                <span class="text-muted small fw-bold">Pelanggaran</span>
                                <h3 class="fw-bold mb-0"><?= $jumlahPelanggaran; ?></h3>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <!-- GRAFIK DAN TOP 5 -->
            <div class="row g-4 mb-4">

                <!-- GRAFIK -->
                <div class="col-lg-7">

                    <div class="card shadow-sm p-4 bg-white h-100">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h5 class="fw-bold text-dark m-0">
                                <i class="bi bi-graph-up text-primary me-2"></i>
                                Grafik Pelanggaran Siswa
                            </h5>

                            <span class="badge bg-light text-dark border">
                                6 Bulan Terakhir
                            </span>

                        </div>

                        <hr class="text-muted opacity-25">

                        <div style="height:270px;">
                            <canvas id="chartPelanggaranLine"></canvas>
                        </div>

                    </div>

                </div>


                <!-- TOP 5 -->
                <div class="col-lg-5">

                    <div class="card shadow-sm p-4 bg-white h-100">

                        <div class="d-flex align-items-center mb-3">

                            <span class="text-warning fs-4 me-2">
                                <i class="bi bi-trophy-fill"></i>
                            </span>

                            <h5 class="fw-bold text-dark m-0">
                                Top 5 Siswa dengan Pelanggaran Terbanyak
                            </h5>

                        </div>

                        <hr class="text-muted opacity-25">

                        <div class="table-responsive">

                            <table class="table table-sm table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="15%">No</th>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">Jumlah Pelanggaran</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php if (count($dataTop5) > 0) { ?>

                                        <?php $no = 1; ?>

                                        <?php foreach ($dataTop5 as $top) { ?>

                                            <tr>

                                                <td class="text-center fw-bold">
                                                    <?= $no++; ?>
                                                </td>

                                                <td>
                                                    <?= htmlspecialchars($top['nama_siswa']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php
                                                    $jumlah = (int)$top['jumlah_pelanggaran'];

                                                    if ($jumlah >= 8) {
                                                        $warna = 'danger';
                                                    } elseif ($jumlah >= 5) {
                                                        $warna = 'warning';
                                                    } else {
                                                        $warna = 'success';
                                                    }
                                                    ?>

                                                    <span class="badge bg-<?= $warna; ?>-subtle text-<?= $warna; ?> px-2 py-1">
                                                        <?= $jumlah; ?>
                                                    </span>

                                                </td>

                                            </tr>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                Belum ada data pelanggaran.
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>


            <!-- PELANGGARAN TERBARU -->
            <div class="row g-4">

                <div class="col-12">

                    <div class="card shadow-sm p-4 bg-white">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h5 class="fw-bold text-dark m-0">
                                <i class="bi bi-clock-history text-primary me-2"></i>
                                Pelanggaran Terbaru
                            </h5>

                            <a href="laporan.php" class="btn btn-sm btn-primary">
                                Lihat Semua
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                        </div>

                        <hr class="text-muted opacity-25">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover align-middle mb-0">

                                <thead class="table-dark">

                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="20%">Nama Siswa</th>
                                        <th width="25%">Jenis Pelanggaran</th>
                                        <th class="text-center" width="10%">Poin</th>
                                        <th width="25%">Keterangan</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php if (count($dataTerbaru) > 0) { ?>

                                        <?php $no = 1; ?>

                                        <?php foreach ($dataTerbaru as $data) { ?>

                                            <tr>

                                                <td class="text-center">
                                                    <?= $no++; ?>
                                                </td>

                                                <td>
                                                    <?= !empty($data['tanggal'])
                                                        ? date('d-m-Y', strtotime($data['tanggal']))
                                                        : '-'; ?>
                                                </td>

                                                <td>
                                                    <?= htmlspecialchars($data['nama_siswa'] ?? '-'); ?>
                                                </td>

                                                <td>
                                                    <?= htmlspecialchars($data['nama_pelanggaran'] ?? '-'); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php
                                                    $poin = (int)$data['poin'];
                                                    $warnaPoin = ($poin >= 15) ? 'danger' : 'warning';
                                                    ?>

                                                    <span class="badge bg-<?= $warnaPoin; ?>">
                                                        <?= $poin; ?>
                                                    </span>

                                                </td>

                                                <td>
                                                    <?= htmlspecialchars($data['keterangan'] ?? '-'); ?>
                                                </td>

                                            </tr>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Belum ada pelanggaran terbaru.
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>
</div>


<!-- JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctxLine = document.getElementById('chartPelanggaranLine').getContext('2d');

let lineGradient = ctxLine.createLinearGradient(0, 0, 0, 270);

lineGradient.addColorStop(0, 'rgba(13, 110, 253, 0.4)');
lineGradient.addColorStop(1, 'rgba(13, 110, 253, 0.0)');

new Chart(ctxLine, {

    type: 'line',

    data: {

        labels: <?= json_encode($labelGrafik); ?>,

        datasets: [{

            label: 'Jumlah Pelanggaran',

            data: <?= json_encode($dataGrafik); ?>,

            backgroundColor: lineGradient,

            borderColor: 'rgb(13, 110, 253)',

            borderWidth: 3,

            fill: true,

            tension: 0.3,

            pointBackgroundColor: 'rgb(13, 110, 253)',

            pointRadius: 5,

            pointHoverRadius: 7

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                display: false
            }

        },

        scales: {

            y: {

                beginAtZero: true,

                ticks: {
                    precision: 0
                },

                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }

            },

            x: {

                grid: {
                    display: false
                }

            }

        }

    }

});

</script>

</body>
</html>

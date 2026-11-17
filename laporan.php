
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "includes/cek_session.php";
include "config/koneksi.php";

// =====================================
// IDENTITAS USER
// =====================================

$halaman = 'laporan';

$namaUser = htmlspecialchars(
    $_SESSION['name'] ?? 'Pengguna',
    ENT_QUOTES,
    'UTF-8'
);

$roleUser = strtolower(trim($_SESSION['role'] ?? 'guru'));

$user_id_login = (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
$guru_id_login = (int)($_SESSION['guru_id'] ?? $_SESSION['id_guru'] ?? 0);

// =====================================
// CEK HAK AKSES
// ADMIN DAN WALI KELAS
// =====================================

if ($roleUser !== 'admin' && $roleUser !== 'wali_kelas') {

    if ($user_id_login > 0 && $guru_id_login <= 0) {

        $stmtGuru = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_guru WHERE user_id = ? LIMIT 1"
        );

        if ($stmtGuru) {
            mysqli_stmt_bind_param($stmtGuru, "i", $user_id_login);
            mysqli_stmt_execute($stmtGuru);
            mysqli_stmt_bind_result($stmtGuru, $idGuru);

            if (mysqli_stmt_fetch($stmtGuru)) {
                $guru_id_login = (int)$idGuru;
            }

            mysqli_stmt_close($stmtGuru);
        }
    }

    $waliAktif = false;

    if ($guru_id_login > 0) {

        $stmtWali = mysqli_prepare(
            $koneksi,
            "SELECT id
             FROM t_wali_kelas
             WHERE guru_id = ?
             AND status_aktif = 1
             LIMIT 1"
        );

        if ($stmtWali) {
            mysqli_stmt_bind_param($stmtWali, "i", $guru_id_login);
            mysqli_stmt_execute($stmtWali);
            mysqli_stmt_store_result($stmtWali);

            $waliAktif = mysqli_stmt_num_rows($stmtWali) > 0;

            mysqli_stmt_close($stmtWali);
        }
    }

    if (!$waliAktif) {
        echo "<script>
            alert('Akses ditolak! Halaman laporan hanya dapat dibuka oleh Admin dan Wali Kelas.');
            window.location='dashboard.php';
        </script>";
        exit;
    }

    $roleUser = 'wali_kelas';
}

// =====================================
// AMBIL ID GURU WALI KELAS
// =====================================

if ($roleUser === 'wali_kelas' && $guru_id_login <= 0) {

    $stmtGuru = mysqli_prepare(
        $koneksi,
        "SELECT id FROM t_guru WHERE user_id = ? LIMIT 1"
    );

    if ($stmtGuru) {
        mysqli_stmt_bind_param($stmtGuru, "i", $user_id_login);
        mysqli_stmt_execute($stmtGuru);
        mysqli_stmt_bind_result($stmtGuru, $idGuru);

        if (mysqli_stmt_fetch($stmtGuru)) {
            $guru_id_login = (int)$idGuru;
        }

        mysqli_stmt_close($stmtGuru);
    }
}

// =====================================
// AMBIL KELAS WALI KELAS
// =====================================

$kelas_id_login = 0;

if ($roleUser === 'wali_kelas') {

    $stmtKelas = mysqli_prepare(
        $koneksi,
        "SELECT kelas_id
         FROM t_wali_kelas
         WHERE guru_id = ?
         AND status_aktif = 1
         LIMIT 1"
    );

    if ($stmtKelas) {
        mysqli_stmt_bind_param($stmtKelas, "i", $guru_id_login);
        mysqli_stmt_execute($stmtKelas);
        mysqli_stmt_bind_result($stmtKelas, $idKelas);

        if (mysqli_stmt_fetch($stmtKelas)) {
            $kelas_id_login = (int)$idKelas;
        }

        mysqli_stmt_close($stmtKelas);
    }

    if ($kelas_id_login <= 0) {
        echo "<script>
            alert('Data kelas wali kelas tidak ditemukan.');
            window.location='dashboard.php';
        </script>";
        exit;
    }
}

// =====================================
// FILTER WALI KELAS
// =====================================

$filter_guru = "";

if ($roleUser === 'wali_kelas') {

    $filter_guru = "
        WHERE EXISTS (
            SELECT 1
            FROM t_kelas_siswa ks_filter
            WHERE ks_filter.siswa_id = ps.siswa_id
            AND ks_filter.kelas_id = " . (int)$kelas_id_login . "
        )
    ";
}

// =====================================
// QUERY LAPORAN
// =====================================

$sql_query = "
    SELECT
        ps.id,
        ps.tanggal,
        s.nis,
        ps.nama_siswa,

        COALESCE(
            (
                SELECT k.nama
                FROM t_kelas_siswa ks
                LEFT JOIN t_kelas k
                    ON ks.kelas_id = k.id
                WHERE ks.siswa_id = ps.siswa_id
                LIMIT 1
            ),
            '-'
        ) AS nama_kelas,

        ps.nama_pelanggaran,
        ps.poin,
        ps.nama_guru,
        ps.keterangan

    FROM t_pelanggaran_siswa ps

    LEFT JOIN t_siswa s
        ON ps.siswa_id = s.id

    $filter_guru

    ORDER BY ps.tanggal DESC, ps.id DESC
";

$query = mysqli_query($koneksi, $sql_query);

if (!$query) {
    die("Query laporan gagal: " . mysqli_error($koneksi));
}

// =====================================
// HITUNG DATA LAPORAN
// =====================================

$data_laporan = [];
$total_data = 0;
$total_poin = 0;

while ($row = mysqli_fetch_assoc($query)) {

    $data_laporan[] = $row;

    $total_data++;

    $total_poin += (int)($row['poin'] ?? 0);
}

// =====================================
// EXPORT EXCEL
// =====================================

if (isset($_GET['export']) && $_GET['export'] === 'excel') {

    $nama_file = "Laporan_Pelanggaran_" . date('Y-m-d') . ".xls";

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$nama_file\"");

    echo "\xEF\xBB\xBF";
    ?>

    <table border="1">
        <thead>
            <tr>
                <th colspan="8">LAPORAN PELANGGARAN SISWA</th>
            </tr>

            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

            <?php $no = 1; ?>

            <?php foreach ($data_laporan as $row) { ?>

                <tr>
                    <td><?= $no++; ?></td>

                    <td>
                        <?= htmlspecialchars($row['tanggal'] ?? '-'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nis'] ?? '-'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nama_kelas'] ?? '-'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?>
                    </td>

                    <td>
                        <?= (int)($row['poin'] ?? 0); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['keterangan'] ?? '-'); ?>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

    <?php
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan - Sistem Informasi Pelanggaran Siswa</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- DATATABLES CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>

        /* =====================================
           PENGATURAN BODY
        ===================================== */

        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* =====================================
           SIDEBAR TETAP DI KIRI
        ===================================== */

        .sidebar {
            background: linear-gradient(
                180deg,
                #212529 0%,
                #1a1e21 100%
            );

            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;

            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;

            z-index: 1030;
            box-sizing: border-box;
        }

        /* SCROLLBAR SIDEBAR */

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #555;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background-color: #888;
        }

        /* =====================================
           MENU SIDEBAR
        ===================================== */

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

        /* =====================================
           KONTEN UTAMA DESKTOP
        ===================================== */

        @media (min-width: 992px) {

            .sidebar {
                width: 16.666667%;
            }

            main.col-md-9,
            main.col-lg-10 {
                margin-left: 16.666667%;
                width: 83.333333%;
                flex: 0 0 auto;
            }

        }

        /* =====================================
           KONTEN UTAMA TABLET
        ===================================== */

        @media (min-width: 768px) and (max-width: 991.98px) {

            .sidebar {
                width: 25%;
            }

            main.col-md-9,
            main.col-lg-10 {
                margin-left: 25%;
                width: 75%;
                flex: 0 0 auto;
            }

        }

        /* =====================================
           TAMPILAN HP
        ===================================== */

        @media (max-width: 767.98px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 100vh;
                overflow-y: visible;
            }

            main.col-md-9,
            main.col-lg-10 {
                margin-left: 0;
                width: 100%;
                flex: 0 0 auto;
            }

        }

        /* =====================================
           TABEL LAPORAN
        ===================================== */

        #tabelLaporan th,
        #tabelLaporan td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            margin-top: 15px;
        }

        .table-responsive {
            width: 100%;
        }

        /* =====================================
           CARD
        ===================================== */

        .card {
            border: none;
            border-radius: 12px;
        }

        /* =====================================
           UKURAN JUDUL
        ===================================== */

        .judul-halaman {
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 5px;
        }

        .deskripsi-halaman {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 12px;
        }

        .judul-statistik {
            font-size: 13px;
            font-weight: 400;
            color: #6c757d;
        }

        .angka-statistik {
            font-size: 22px;
            font-weight: 400;
        }

        /* =====================================
           CETAK LAPORAN
        ===================================== */

        @media print {

            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                background: white !important;
            }

            .sidebar,
            .tombol-aksi,
            .dt-search,
            .dt-length,
            .dt-paging,
            .dt-info {
                display: none !important;
            }

            main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }

            .container-fluid,
            .row {
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }

            #tabelLaporan {
                width: 100% !important;
            }

            #tabelLaporan th,
            #tabelLaporan td {
                font-size: 11px !important;
                padding: 6px !important;
            }

        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- =================================
             SIDEBAR
        ================================== -->

        <div class="col-md-3 col-lg-2 sidebar p-3">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">

                <i class="bi bi-shield-exclamation text-primary me-2"></i>

                Pelanggaran Siswa

            </h4>


            <!-- =================================
                 MENU ADMIN
            ================================== -->

            <?php if ($roleUser === 'admin') { ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
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
                        <a href="penepatan_siswa.php" class="nav-link text-white">
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
                        <a href="laporan.php" class="nav-link active">
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

            <?php } ?>


            <!-- =================================
                 MENU WALI KELAS
            ================================== -->

            <?php if ($roleUser === 'wali_kelas') { ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
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
                        <a href="laporan.php" class="nav-link active">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="Riwayat.php" class="nav-link text-white">
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


        <!-- =================================
             KONTEN UTAMA
        ================================== -->

        <main class="col-md-9 col-lg-10 p-4">

            <div class="card shadow-sm p-4 bg-white">

                <!-- JUDUL HALAMAN -->

                <h2 class="judul-halaman">
                    Laporan Pelanggaran Siswa
                </h2>

                <p class="deskripsi-halaman">
                    Laporan data pelanggaran siswa pada sistem pelanggaran siswa
                </p>


                <!-- =================================
                     RINGKASAN LAPORAN
                ================================== -->

                <div class="row mb-3">

                    <!-- TOTAL PELANGGARAN -->

                    <div class="col-md-6 mb-3">

                        <div class="card shadow-sm p-3 bg-light">

                            <div class="card-body">

                                <h6 class="judul-statistik">
                                    Total Pelanggaran
                                </h6>

                                <h3 class="angka-statistik text-primary">
                                    <?= $total_data; ?>
                                </h3>

                            </div>

                        </div>

                    </div>


                    <!-- TOTAL POIN -->

                    <div class="col-md-6 mb-3">

                        <div class="card shadow-sm p-3 bg-light">

                            <div class="card-body">

                                <h6 class="judul-statistik">
                                    Total Poin Pelanggaran
                                </h6>

                                <h3 class="angka-statistik text-danger">
                                    <?= $total_poin; ?>
                                </h3>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =================================
                     TOMBOL EXPORT DAN CETAK
                ================================== -->

                <div class="mb-3 tombol-aksi d-flex gap-2 flex-wrap">

                    <a href="laporan.php?export=excel"
                       class="btn btn-success btn-sm">

                        <i class="bi bi-file-earmark-excel me-1"></i>
                        Export Excel

                    </a>

                    <button type="button"
                            onclick="cetakLaporan()"
                            class="btn btn-primary btn-sm">

                        <i class="bi bi-printer me-1"></i>
                        Cetak Laporan

                    </button>

                </div>


                <!-- =================================
                     TABEL LAPORAN
                ================================== -->

                <div class="table-responsive">

                    <table id="tabelLaporan"
                           class="table table-bordered table-striped table-hover w-100 align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Poin</th>
                                <th>Keterangan</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $no = 1;

                            foreach ($data_laporan as $row) {
                            ?>

                                <tr>

                                    <td>
                                        <?= $no++; ?>
                                    </td>

                                    <td>
                                        <?= !empty($row['tanggal'])
                                            ? date('d-m-Y', strtotime($row['tanggal']))
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nis'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_kelas'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?>
                                    </td>

                                    <td class="text-center">

                                        <span class="badge text-bg-danger">
                                            +<?= (int)($row['poin'] ?? 0); ?>
                                        </span>

                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['keterangan'] ?? '-'); ?>
                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</div>


<!-- =====================================
     JAVASCRIPT
===================================== -->

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DATATABLES JS -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>


<script>

// =====================================
// INISIALISASI DATATABLES
// =====================================

$(document).ready(function () {

    $('#tabelLaporan').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        columnDefs: [
            {
                targets: [0],
                orderable: false,
                searchable: false
            }
        ],

        order: [[1, 'desc']],

        language: {

            search: "Cari laporan:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ laporan",

            infoEmpty: "Tidak ada data laporan",

            infoFiltered: "(difilter dari _MAX_ total laporan)",

            zeroRecords: "Data laporan tidak ditemukan",

            emptyTable: "Belum ada data laporan",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }

        }

    });

});


// =====================================
// CETAK LAPORAN
// =====================================

function cetakLaporan() {

    let tabel = $('#tabelLaporan').DataTable();

    let panjangAwal = tabel.page.len();

    tabel.page.len(-1).draw();

    setTimeout(function () {

        window.onafterprint = function () {

            tabel.page.len(panjangAwal).draw();

            window.onafterprint = null;

        };

        window.print();

    }, 500);

}

</script>

</body>
</html>

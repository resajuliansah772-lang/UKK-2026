
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/cek_session.php";
include "config/koneksi.php";

// ==========================================
// IDENTITAS USER
// ==========================================

$halaman = 'laporan';

$namaUser = htmlspecialchars(
    $_SESSION['name'] ?? 'Pengguna',
    ENT_QUOTES,
    'UTF-8'
);

$roleUser = strtolower(trim($_SESSION['role'] ?? 'guru'));
$roleUser = str_replace([' ', '-'], '_', $roleUser);

$id_user_login = (int) ($_SESSION['id'] ?? $_SESSION['user_id'] ?? 0);
$guru_id_login = (int) ($_SESSION['guru_id'] ?? $_SESSION['id_guru'] ?? 0);

// ==========================================
// FUNGSI PEMERIKSAAN KOLOM DATABASE
// ==========================================

function ambilKolom($koneksi, $namaTabel)
{
    $kolom = [];

    $namaTabel = mysqli_real_escape_string($koneksi, $namaTabel);

    $hasil = mysqli_query(
        $koneksi,
        "SHOW COLUMNS FROM `$namaTabel`"
    );

    if ($hasil) {
        while ($row = mysqli_fetch_assoc($hasil)) {
            $kolom[] = $row['Field'];
        }
    }

    return $kolom;
}

function pilihKolom($daftarKolom, $pilihan)
{
    foreach ($pilihan as $kolom) {
        if (in_array($kolom, $daftarKolom, true)) {
            return $kolom;
        }
    }

    return null;
}

function ekspresiKolom($alias, $kolom, $fallback)
{
    if ($kolom !== null) {
        return "`$alias`.`$kolom`";
    }

    return $fallback;
}

// ==========================================
// PROTEKSI HAK AKSES LAPORAN
// ==========================================

$isAdmin = ($roleUser === 'admin');
$is_wali_kelas = ($roleUser === 'wali_kelas');

if (!$isAdmin && !$is_wali_kelas) {

    // Cari ID guru melalui user_id jika tersedia
    if ($guru_id_login <= 0 && $id_user_login > 0) {

        $kolomGuru = ambilKolom($koneksi, 't_guru');

        if (in_array('user_id', $kolomGuru, true)) {

            $stmtGuru = mysqli_prepare(
                $koneksi,
                "SELECT id FROM t_guru WHERE user_id = ? LIMIT 1"
            );

            if ($stmtGuru) {
                mysqli_stmt_bind_param(
                    $stmtGuru,
                    "i",
                    $id_user_login
                );

                mysqli_stmt_execute($stmtGuru);

                $hasilGuru = mysqli_stmt_get_result($stmtGuru);

                if ($hasilGuru && mysqli_num_rows($hasilGuru) > 0) {
                    $dataGuru = mysqli_fetch_assoc($hasilGuru);
                    $guru_id_login = (int) $dataGuru['id'];
                }

                mysqli_stmt_close($stmtGuru);
            }
        }
    }

    // Periksa apakah guru merupakan wali kelas aktif
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

            mysqli_stmt_bind_param(
                $stmtWali,
                "i",
                $guru_id_login
            );

            mysqli_stmt_execute($stmtWali);

            $hasilWali = mysqli_stmt_get_result($stmtWali);

            if ($hasilWali && mysqli_num_rows($hasilWali) > 0) {
                $is_wali_kelas = true;
            }

            mysqli_stmt_close($stmtWali);
        }
    }
}

$tampilkan_menu_laporan = ($isAdmin || $is_wali_kelas);

if (!$tampilkan_menu_laporan) {
    echo "<script>
        alert('Maaf, halaman laporan hanya dapat diakses Admin dan Wali Kelas.');
        window.location.href = 'dashboard.php';
    </script>";
    exit;
}

// ==========================================
// AMBIL STRUKTUR TABEL
// ==========================================

$kolomPS = ambilKolom($koneksi, 't_pelanggaran_siswa');
$kolomSiswa = ambilKolom($koneksi, 't_siswa');
$kolomPelanggaran = ambilKolom($koneksi, 't_pelanggaran');
$kolomGuru = ambilKolom($koneksi, 't_guru');

// ==========================================
// QUERY DATA LAPORAN
// ==========================================

$queryLaporan = false;
$errorLaporan = '';

if (empty($kolomPS)) {

    $errorLaporan = "Tabel t_pelanggaran_siswa tidak ditemukan.";

} elseif (empty($kolomSiswa)) {

    $errorLaporan = "Tabel t_siswa tidak ditemukan.";

} else {

    // Kolom catatan pelanggaran
    $idPS = pilihKolom($kolomPS, ['id']);

    $tanggalPS = pilihKolom(
        $kolomPS,
        ['tanggal', 'tanggal_pelanggaran', 'tgl_pelanggaran', 'created_at']
    );

    $siswaID = pilihKolom($kolomPS, ['siswa_id']);

    $pelanggaranID = pilihKolom(
        $kolomPS,
        ['pelanggaran_id']
    );

    $guruID = pilihKolom($kolomPS, ['guru_id']);

    $keteranganPS = pilihKolom(
        $kolomPS,
        ['keterangan', 'deskripsi', 'catatan']
    );

    // Kolom siswa
    $nisSiswa = pilihKolom($kolomSiswa, ['nis']);

    $namaSiswa = pilihKolom(
        $kolomSiswa,
        ['nama', 'nama_siswa']
    );

    // Kolom jenis pelanggaran
    $namaPelanggaran = pilihKolom(
        $kolomPelanggaran,
        ['nama_pelanggaran', 'nama', 'jenis_pelanggaran']
    );

    $poinPelanggaran = pilihKolom(
        $kolomPelanggaran,
        ['poin', 'jumlah_poin', 'point']
    );

    // Kolom guru
    $namaGuru = pilihKolom(
        $kolomGuru,
        ['nama', 'nama_guru']
    );

    // ======================================
    // MENYIAPKAN SELECT
    // ======================================

    $select = [];

    $select[] = ekspresiKolom(
        'ps',
        $idPS,
        "0"
    ) . " AS id_catatan";

    $select[] = ekspresiKolom(
        'ps',
        $tanggalPS,
        "'-'"
    ) . " AS tanggal";

    $select[] = ekspresiKolom(
        's',
        $nisSiswa,
        "'-'"
    ) . " AS nis";

    $select[] = ekspresiKolom(
        's',
        $namaSiswa,
        "'Nama siswa tidak tersedia'"
    ) . " AS nama_siswa";

    $select[] = ekspresiKolom(
        'p',
        $namaPelanggaran,
        "'Jenis pelanggaran tidak tersedia'"
    ) . " AS nama_pelanggaran";

    $select[] = ekspresiKolom(
        'p',
        $poinPelanggaran,
        "0"
    ) . " AS poin";

    $select[] = ekspresiKolom(
        'g',
        $namaGuru,
        "'Tidak diketahui'"
    ) . " AS nama_guru";

    $select[] = ekspresiKolom(
        'ps',
        $keteranganPS,
        "'-'"
    ) . " AS keterangan";

    // ======================================
    // RELASI TABEL SISWA
    // ======================================

    $joinSiswa = '';

    if (
        $siswaID !== null &&
        in_array('id', $kolomSiswa, true)
    ) {
        $joinSiswa = "
            LEFT JOIN t_siswa s
            ON ps.`$siswaID` = s.id
        ";
    } else {
        $errorLaporan = "Relasi siswa_id atau kolom id pada t_siswa tidak ditemukan.";
    }

    // ======================================
    // RELASI TABEL PELANGGARAN
    // ======================================

    $joinPelanggaran = '';

    if (
        $pelanggaranID !== null &&
        in_array('id', $kolomPelanggaran, true)
    ) {
        $joinPelanggaran = "
            LEFT JOIN t_pelanggaran p
            ON ps.`$pelanggaranID` = p.id
        ";
    }

    // ======================================
    // RELASI TABEL GURU
    // ======================================

    $joinGuru = '';

    if (
        $guruID !== null &&
        in_array('id', $kolomGuru, true)
    ) {
        $joinGuru = "
            LEFT JOIN t_guru g
            ON ps.`$guruID` = g.id
        ";
    }

    // ======================================
    // EKSEKUSI QUERY
    // ======================================

    if ($errorLaporan === '') {

        $orderBy = $tanggalPS !== null
            ? "ORDER BY ps.`$tanggalPS` DESC"
            : "ORDER BY ps.id DESC";

        $sqlLaporan = "
            SELECT
                " . implode(",\n", $select) . "
            FROM t_pelanggaran_siswa ps
            $joinSiswa
            $joinPelanggaran
            $joinGuru
            $orderBy
        ";

        $queryLaporan = mysqli_query($koneksi, $sqlLaporan);

        if (!$queryLaporan) {
            $errorLaporan = "Gagal mengambil laporan: " . mysqli_error($koneksi);
        }
    }
}

// ==========================================
// TOTAL LAPORAN
// ==========================================

$totalLaporan = 0;

if ($queryLaporan) {
    $totalLaporan = mysqli_num_rows($queryLaporan);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan - Sistem Pelanggaran Siswa</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DATATABLES -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>

        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            background: linear-gradient(180deg, #212529 0%, #1a1e21 100%);
            min-height: 100vh;
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
        }

        /* =================================
           HEADER TABEL DATATABLES
        ================================= */

        #tabelLaporan thead th,
        #tabelLaporan_wrapper table thead th {
            background-color: #212529 !important;
            color: #ffffff !important;
            font-weight: bold !important;
            white-space: nowrap;
            text-align: left;
            vertical-align: middle;
            opacity: 1 !important;
        }

        #tabelLaporan thead th .dt-column-title {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        #tabelLaporan thead th .dt-column-order {
            color: #ffffff !important;
        }

        #tabelLaporan thead th span {
            color: #ffffff !important;
        }

        #tabelLaporan tbody td {
            vertical-align: middle;
        }

        .table-responsive {
            width: 100%;
        }

        @media print {

            .sidebar,
            .no-print,
            .dt-search,
            .dt-length,
            .dt-paging,
            .dt-info {
                display: none !important;
            }

            main {
                width: 100% !important;
                padding: 0 !important;
            }

            body {
                background: white !important;
            }

            .card {
                box-shadow: none !important;
            }

            #tabelLaporan thead th {
                background-color: #212529 !important;
                color: white !important;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
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

        <div class="col-md-3 col-lg-2 sidebar p-3 no-print">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">

                <i class="bi bi-shield-exclamation text-primary me-2"></i>

                Pelanggaran Siswa

            </h4>

            <?php if ($isAdmin) { ?>

                <!-- MENU ADMIN -->

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_siswa.php" class="nav-link text-white">
                            <i class="bi bi-people me-2"></i>
                            Data Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_guru.php" class="nav-link text-white">
                            <i class="bi bi-person-badge me-2"></i>
                            Data Guru
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kelas.php" class="nav-link text-white">
                            <i class="bi bi-door-open me-2"></i>
                            Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tahun_ajaran.php" class="nav-link text-white">
                            <i class="bi bi-calendar-range me-2"></i>
                            Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="penepatan_siswa.php" class="nav-link text-white">
                            <i class="bi bi-journal-check me-2"></i>
                            Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="wali_kelas.php" class="nav-link text-white">
                            <i class="bi bi-person-workspace me-2"></i>
                            Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kategori_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-tags me-2"></i>
                            Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="jenis_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-list-task me-2"></i>
                            Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link active">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="aboutme.php" class="nav-link text-white">
                            <i class="bi bi-info-circle me-2"></i>
                            About Me
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </a>
                    </li>

                </ul>

            <?php } else { ?>

                <!-- MENU WALI KELAS -->

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="catatan_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-journal-text me-2"></i>
                            Catatan Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tindakan.php" class="nav-link text-white">
                            <i class="bi bi-hammer me-2"></i>
                            Tindakan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link active">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="riwayat.php" class="nav-link text-white">
                            <i class="bi bi-clock-history me-2"></i>
                            Riwayat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="rekap_poin.php" class="nav-link text-white">
                            <i class="bi bi-award me-2"></i>
                            Rekap Poin
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </a>
                    </li>

                </ul>

            <?php } ?>

        </div>

        <!-- =================================
             KONTEN UTAMA
        ================================== -->

        <main class="col-md-9 col-lg-10 p-4">

            <!-- HEADER -->

            <div class="card shadow-sm p-4 mb-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h2 class="mb-1">
                            Laporan Pelanggaran Siswa
                        </h2>

                        <p class="text-muted mb-0">
                            Rekapitulasi dan laporan data pelanggaran siswa.
                        </p>

                    </div>

                    <span class="badge bg-primary p-2">

                        <i class="bi bi-shield-check me-1"></i>

                        <?= $isAdmin ? 'Administrator' : 'Wali Kelas'; ?>

                    </span>

                </div>

            </div>

            <!-- TOTAL LAPORAN -->

            <div class="row mb-4">

                <div class="col-md-4">

                    <div class="card shadow-sm p-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="bg-primary-subtle text-primary rounded p-3">

                                <i class="bi bi-file-earmark-text fs-3"></i>

                            </div>

                            <div>

                                <div class="text-muted">
                                    Total Catatan Pelanggaran
                                </div>

                                <h3 class="fw-bold mb-0">
                                    <?= $totalLaporan; ?>
                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- TABEL LAPORAN -->

            <div class="card shadow-sm p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-table me-2"></i>

                        Data Laporan Pelanggaran

                    </h5>

                    <button
                        type="button"
                        class="btn btn-success no-print"
                        onclick="window.print()"
                    >

                        <i class="bi bi-printer me-1"></i>

                        Cetak Laporan

                    </button>

                </div>

                <?php if ($errorLaporan !== '') { ?>

                    <div class="alert alert-danger">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        <?= htmlspecialchars(
                            $errorLaporan,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </div>

                <?php } else { ?>

                    <div class="table-responsive">

                        <table
                            id="tabelLaporan"
                            class="table table-bordered table-striped table-hover align-middle w-100"
                        >

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>Tanggal</th>

                                    <th>NIS</th>

                                    <th>Nama Siswa</th>

                                    <th>Pelanggaran</th>

                                    <th>Poin</th>

                                    <th>Pelapor</th>

                                    <th>Keterangan</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $no = 1;

                                if (
                                    $queryLaporan &&
                                    mysqli_num_rows($queryLaporan) > 0
                                ) {

                                    while ($data = mysqli_fetch_assoc($queryLaporan)) {

                                        $tanggal = $data['tanggal'] ?? '-';

                                        if (
                                            $tanggal !== '-' &&
                                            $tanggal !== '' &&
                                            strtotime($tanggal) !== false
                                        ) {
                                            $tanggal = date(
                                                'd-m-Y',
                                                strtotime($tanggal)
                                            );
                                        }

                                        $nis = htmlspecialchars(
                                            $data['nis'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );

                                        $namaSiswaTampil = htmlspecialchars(
                                            $data['nama_siswa'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );

                                        $pelanggaranTampil = htmlspecialchars(
                                            $data['nama_pelanggaran'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );

                                        $namaGuruTampil = htmlspecialchars(
                                            $data['nama_guru'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );

                                        $keteranganTampil = htmlspecialchars(
                                            $data['keterangan'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );

                                        $poin = (int) ($data['poin'] ?? 0);

                                        ?>

                                        <tr>

                                            <td>
                                                <?= $no++; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $tanggal,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </td>

                                            <td>
                                                <?= $nis; ?>
                                            </td>

                                            <td>
                                                <?= $namaSiswaTampil; ?>
                                            </td>

                                            <td>
                                                <?= $pelanggaranTampil; ?>
                                            </td>

                                            <td>
                                                <span class="badge bg-danger">
                                                    <?= $poin; ?>
                                                </span>
                                            </td>

                                            <td>
                                                <?= $namaGuruTampil; ?>
                                            </td>

                                            <td>
                                                <?= $keteranganTampil; ?>
                                            </td>

                                        </tr>

                                        <?php

                                    }

                                } else {

                                    ?>

                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            Belum ada data pelanggaran yang tersimpan.
                                        </td>
                                    </tr>

                                    <?php

                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                <?php } ?>

            </div>

            <!-- FOOTER -->

            <div class="text-center text-muted mt-4">

                <small>
                    Sistem Pelanggaran Siswa &copy; <?= date('Y'); ?>
                </small>

            </div>

        </main>

    </div>

</div>

<!-- =================================
     JAVASCRIPT
================================== -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function () {

    $('#tabelLaporan').DataTable({

        pageLength: 10,

        order: [],

        language: {

            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data",

            zeroRecords: "Data tidak ditemukan",

            emptyTable: "Belum ada data pelanggaran",

            paginate: {

                first: "Pertama",

                last: "Terakhir",

                next: "Selanjutnya",

                previous: "Sebelumnya"

            }

        }

    });

});

</script>

</body>
</html>

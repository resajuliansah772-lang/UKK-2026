
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// =====================================
// IDENTITAS USER
// =====================================

$halaman = 'catatan_pelanggaran';

$namaUser = htmlspecialchars(
    $_SESSION['name'] ?? 'Pengguna',
    ENT_QUOTES,
    'UTF-8'
);

$roleUser = strtolower(trim($_SESSION['role'] ?? 'guru'));

$id_user_login = (int) (
    $_SESSION['id'] ??
    $_SESSION['user_id'] ??
    0
);

// =====================================
// CEK HAK AKSES WALI KELAS
// =====================================

$isAdmin = ($roleUser === 'admin');

$is_wali_kelas_aktif = false;

if (!$isAdmin && $id_user_login > 0) {

    $stmtWali = mysqli_prepare($koneksi, "
        SELECT wk.id
        FROM t_guru g
        INNER JOIN t_wali_kelas wk
            ON wk.guru_id = g.id
        WHERE g.user_id = ?
          AND wk.status_aktif = 1
        LIMIT 1
    ");

    if (!$stmtWali) {
        die("Gagal mengecek hak akses wali kelas: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param(
        $stmtWali,
        "i",
        $id_user_login
    );

    mysqli_stmt_execute($stmtWali);

    $resultWali = mysqli_stmt_get_result($stmtWali);

    if ($resultWali && mysqli_num_rows($resultWali) > 0) {
        $is_wali_kelas_aktif = true;
    }

    mysqli_stmt_close($stmtWali);
}

// Hak akses menu laporan
$tampilkan_menu_laporan = (
    $isAdmin || $is_wali_kelas_aktif
);


// =====================================
// QUERY DATA CATATAN PELANGGARAN
// =====================================

$sql = "SELECT 
            ps.id,
            ps.tanggal,
            ps.keterangan,
            s.nis,
            s.nama AS nama_siswa,
            p.nama AS nama_pelanggaran,
            p.poin,
            pk.nama AS nama_kategori,
            g.nama AS nama_guru
        FROM t_pelanggaran_siswa ps
        LEFT JOIN t_siswa s
            ON ps.siswa_id = s.id
        LEFT JOIN t_pelanggaran p
            ON ps.pelanggaran_id = p.id
        LEFT JOIN t_pelanggaran_kategori pk
            ON p.pelanggaran_kategori_id = pk.id
        LEFT JOIN t_guru g
            ON ps.guru_id = g.id
        ORDER BY ps.tanggal DESC, ps.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die(
        "Gagal mengambil data catatan pelanggaran: "
        . mysqli_error($koneksi)
    );
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catatan Pelanggaran - Sistem Informasi Pelanggaran Siswa</title>

    <!-- BOOTSTRAP CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- BOOTSTRAP ICONS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <!-- DATATABLES CSS -->

    <link
        href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
        rel="stylesheet"
    >

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

        #tabelCatatan th,
        #tabelCatatan td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .dataTables_wrapper {
            margin-top: 10px;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .sidebar {
            background: linear-gradient(
                180deg,
                #212529 0%,
                #1a1e21 100%
            );

            min-height: 100vh;
        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- ================================= -->
        <!-- SIDEBAR -->
        <!-- ================================= -->

        <div class="col-md-3 col-lg-2 sidebar p-3">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">

                <i class="bi bi-shield-exclamation text-primary me-2"></i>

                Pelanggaran Siswa

            </h4>


            <ul class="nav nav-pills flex-column gap-1">

                <!-- DASHBOARD -->

                <li class="nav-item">

                    <a href="dashboard.php" class="nav-link text-white">

                        <i class="bi bi-speedometer2 me-2"></i>

                        Dashboard

                    </a>

                </li>


                <!-- CATATAN PELANGGARAN -->

                <li class="nav-item">

                    <a
                        href="catatan_pelanggaran.php"
                        class="nav-link active"
                        aria-current="page"
                    >

                        <i class="bi bi-journal-text me-2"></i>

                        Catatan Pelanggaran

                    </a>

                </li>


                <!-- TINDAKAN -->

                <li class="nav-item">

                    <a href="tindakan.php" class="nav-link text-white">

                        <i class="bi bi-hammer me-2"></i>

                        Tindakan

                    </a>

                </li>


                <!-- LAPORAN KHUSUS WALI KELAS -->

                <?php if ($tampilkan_menu_laporan) { ?>

                    <li class="nav-item">

                        <a href="laporan.php" class="nav-link text-white">

                            <i class="bi bi-file-earmark-text me-2"></i>

                            Laporan

                        </a>

                    </li>

                <?php } ?>


                <!-- RIWAYAT -->

                <li class="nav-item">

                    <a href="riwayat.php" class="nav-link text-white">

                        <i class="bi bi-clock-history me-2"></i>

                        Riwayat

                    </a>

                </li>


                <!-- REKAP POIN -->

                <li class="nav-item">

                    <a href="rekap_poin.php" class="nav-link text-white">

                        <i class="bi bi-award me-2"></i>

                        Rekap Poin

                    </a>

                </li>


                <hr class="text-secondary my-3">


                <!-- LOGOUT -->

                <li class="nav-item">

                    <a href="logout.php" class="nav-link text-danger">

                        <i class="bi bi-box-arrow-right me-2"></i>

                        Logout

                    </a>

                </li>

            </ul>

        </div>


        <!-- ================================= -->
        <!-- KONTEN UTAMA -->
        <!-- ================================= -->

        <main class="col-md-9 col-lg-10 p-4">


            <!-- HEADER -->

            <div class="card shadow-sm p-4 bg-white mb-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>

                        <h2 class="fw-bold mb-2">
                            Catatan Pelanggaran
                        </h2>

                        <p class="text-muted mb-0">
                            Daftar transaksi pencatatan pelanggaran siswa di sekolah.
                        </p>

                    </div>

                    <div>

                        <span class="badge bg-primary-subtle text-primary border px-3 py-2">

                            <i class="bi bi-shield-check me-1"></i>

                            <?= htmlspecialchars($roleUser); ?>

                            <?php if ($is_wali_kelas_aktif && !$isAdmin) { ?>
                                - Wali Kelas
                            <?php } ?>

                        </span>

                    </div>

                </div>

            </div>


            <!-- NOTIFIKASI BERHASIL -->

            <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil') { ?>

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    Catatan pelanggaran siswa berhasil disimpan!

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>

                </div>

            <?php } ?>


            <!-- TOMBOL TAMBAH -->

            <div class="mb-3">

                <a
                    href="tambah_catatan_pelanggaran.php"
                    class="btn btn-primary btn-sm"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    Tambah Catatan Pelanggaran

                </a>

            </div>


            <!-- ================================= -->
            <!-- TABEL CATATAN PELANGGARAN -->
            <!-- ================================= -->

            <div class="card shadow-sm bg-white">

                <div class="card-body p-4">

                    <div class="table-responsive">

                        <table
                            id="tabelCatatan"
                            class="table table-bordered table-striped table-hover w-100 align-middle"
                        >

                            <thead class="table-dark">

                                <tr>

                                    <th>No</th>

                                    <th>Tanggal</th>

                                    <th>NIS</th>

                                    <th>Nama Siswa</th>

                                    <th>Kategori</th>

                                    <th>Jenis Pelanggaran</th>

                                    <th>Poin</th>

                                    <th>Pelapor / Guru</th>

                                    <th>Keterangan</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $no = 1;

                                while ($row = mysqli_fetch_assoc($query)) {

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

                                            <?= htmlspecialchars(
                                                $row['nis'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $row['nama_siswa'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $row['nama_kategori'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $row['nama_pelanggaran'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </td>


                                        <td class="text-center">

                                            <span class="badge bg-danger">

                                                +<?= (int) ($row['poin'] ?? 0); ?>

                                            </span>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $row['nama_guru'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $row['keterangan'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </td>

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


<!-- ================================= -->
<!-- JAVASCRIPT -->
<!-- ================================= -->

<!-- JQUERY -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- BOOTSTRAP JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- DATATABLES JS -->

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>


<!-- AKTIFKAN DATATABLES -->

<script>

$(document).ready(function () {

    $('#tabelCatatan').DataTable({

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

        language: {

            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data catatan pelanggaran",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data catatan pelanggaran tidak ditemukan",

            emptyTable: "Belum ada catatan pelanggaran",

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

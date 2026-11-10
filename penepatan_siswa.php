
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'penempatan_siswa';

$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

// =====================================
// MENGAMBIL DATA PENEMPATAN SISWA
// =====================================

$sql = "
    SELECT
        ks.id,
        ks.tanggal_mulai,
        ks.tanggal_selesai,
        ks.status_aktif AS status_penempatan,
        s.nis,
        s.nama AS nama_siswa,
        k.nama AS nama_kelas,
        k.tingkat,
        k.jurusan,
        ta.nama AS tahun_ajaran

    FROM t_kelas_siswa ks

    LEFT JOIN t_siswa s
        ON ks.siswa_id = s.id

    LEFT JOIN t_kelas k
        ON ks.kelas_id = k.id

    LEFT JOIN t_tahun_ajaran ta
        ON ks.tahun_ajaran_id = ta.id

    ORDER BY s.id ASC
";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data penempatan siswa: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penempatan Siswa - Sistem Pelanggaran Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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

        #tabelPenempatan th,
        #tabelPenempatan td {
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
            background: linear-gradient(180deg, #212529 0%, #1a1e21 100%);
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

        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- ================================= -->
        <!-- SIDEBAR -->
        <!-- ================================= -->

        <div class="col-md-3 col-lg-2 sidebar p-3 min-vh-100">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">

                <i class="bi bi-shield-exclamation text-primary me-2"></i>
                Pelanggaran Siswa

            </h4>

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
                    <a href="penempatan_siswa.php" class="nav-link active">
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
                    <a href="laporan.php" class="nav-link text-white">
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

        </div>


        <!-- ================================= -->
        <!-- KONTEN UTAMA -->
        <!-- ================================= -->

        <main class="col-md-9 col-lg-10 p-4">

            <div class="card shadow-sm p-4 bg-white">

                <h2>Penempatan Siswa</h2>

                <p class="text-muted">
                    Kelola data penempatan siswa ke dalam kelas dan tahun ajaran.
                </p>


                <!-- PESAN BERHASIL -->

                <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil'): ?>

                    <div class="alert alert-success alert-dismissible fade show">

                        Data penempatan siswa berhasil disimpan!

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>

                    </div>

                <?php endif; ?>


                <!-- TOMBOL TAMBAH -->

                <div class="mb-3 no-print">

                    <a href="tambah_penempatan_siswa.php"
                       class="btn btn-primary btn-sm">

                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Penempatan Siswa

                    </a>

                </div>


                <!-- ================================= -->
                <!-- TABEL PENEMPATAN SISWA -->
                <!-- ================================= -->

                <div class="table-responsive">

                    <table id="tabelPenempatan"
                           class="table table-bordered table-striped table-hover w-100 align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Tahun Ajaran</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $no = 1;

                            $urutanTingkat = [
                                'X' => 10,
                                'XI' => 11,
                                'XII' => 12
                            ];

                            while ($row = mysqli_fetch_assoc($query)) {

                                $status = $row['status_penempatan'] ?? 1;
                                $aktif = (int)$status === 1;

                                $namaKelas = trim($row['nama_kelas'] ?? '');

                                $tingkat = strtoupper(trim($row['tingkat'] ?? ''));

                                // =================================
                                // NORMALISASI PENCARIAN KELAS
                                // =================================

                                $kelasSearch = strtoupper(
                                    preg_replace('/\s+/', '', $namaKelas)
                                );

                                // =================================
                                // PENGURUTAN TINGKAT KELAS
                                // =================================

                                $nomorTingkat = $urutanTingkat[$tingkat] ?? 99;

                                // =================================
                                // PENGURUTAN NOMOR KELAS
                                // =================================

                                $nomorKelas = 0;

                                if (preg_match('/(\d+)$/', $namaKelas, $match)) {
                                    $nomorKelas = (int)$match[1];
                                }

                                // Kunci pengurutan kelas
                                $kunciUrut = sprintf(
                                    '%02d-%s-%05d',
                                    $nomorTingkat,
                                    strtoupper($row['jurusan'] ?? ''),
                                    $nomorKelas
                                );

                            ?>

                                <tr>

                                    <td>
                                        <?= $no++; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nis'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tahun_ajaran'] ?? '-'); ?>
                                    </td>

                                    <!-- NAMA KELAS -->

                                    <td
                                        data-search="<?= htmlspecialchars($kelasSearch, ENT_QUOTES, 'UTF-8'); ?>"
                                        data-order="<?= htmlspecialchars($kunciUrut, ENT_QUOTES, 'UTF-8'); ?>"
                                    >
                                        <?= htmlspecialchars($namaKelas ?: '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tingkat'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['jurusan'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= !empty($row['tanggal_mulai'])
                                            ? date('d-m-Y', strtotime($row['tanggal_mulai']))
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <?= !empty($row['tanggal_selesai'])
                                            ? date('d-m-Y', strtotime($row['tanggal_selesai']))
                                            : '-'; ?>
                                    </td>

                                    <td>

                                        <?php if ($aktif): ?>

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">
                                                Tidak Aktif
                                            </span>

                                        <?php endif; ?>

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


<!-- ================================= -->
<!-- JAVASCRIPT -->
<!-- ================================= -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>


<script>

$(document).ready(function () {

    // Inisialisasi DataTables
    const tabel = $('#tabelPenempatan').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        // Urutkan berdasarkan tingkat, jurusan,
        // dan nomor kelas melalui data-order
        order: [
            [4, 'asc'],
            [2, 'asc']
        ],

        columnDefs: [

            {
                targets: 0,
                orderable: false,
                searchable: false
            }

        ],

        language: {

            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data penempatan siswa",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data penempatan siswa tidak ditemukan",

            emptyTable: "Belum ada data penempatan siswa",

            paginate: {

                first: "Pertama",

                last: "Terakhir",

                next: "Selanjutnya",

                previous: "Sebelumnya"

            }

        }

    });


    // =====================================
    // PENCARIAN KELAS TANPA MEMPERMASALAHKAN SPASI
    // =====================================

    $('.dt-search input').off('input.dt');

    let waktuPencarian;

    $('.dt-search input').on('input', function () {

        clearTimeout(waktuPencarian);

        const kataKunci = $(this).val();

        // Hilangkan spasi dan samakan huruf
        const pencarianNormal = kataKunci
            .toUpperCase()
            .replace(/\s+/g, '');

        waktuPencarian = setTimeout(function () {

            tabel.search(pencarianNormal).draw();

        }, 200);

    });

});

</script>

</body>
</html>

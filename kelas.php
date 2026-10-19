<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

// Halaman aktif
$halaman = 'kelas';

// Ambil data kelas
$sql = "SELECT * FROM t_kelas ORDER BY nama ASC";
$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Kelas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>
        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }

        #tabelKelas th,
        #tabelKelas td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

            <h4 class="text-white mb-4">
                My Website
            </h4>

            <!-- MENU ADMIN -->
            <?php if ($_SESSION['role'] == 'admin') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa.php"
                       class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_guru.php"
                       class="nav-link text-white">
                        Data Guru
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link active">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php"
                       class="nav-link text-white">
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="penepatan_siswa.php"
                       class="nav-link text-white">
                        Penepatan Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php"
                       class="nav-link text-white">
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php"
                       class="nav-link text-white">
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php"
                       class="nav-link text-white">
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="cetak.php"
                       class="nav-link text-white">
                        Cetak/Export
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link text-white">
                        Laporan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="aboutme.php"
                       class="nav-link text-white">
                        About Me
                    </a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php"
                       class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

            <?php } ?>


            <!-- MENU PETUGAS -->
            <?php if ($_SESSION['role'] == 'petugas') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link active">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link text-white">
                        Laporan
                    </a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php"
                       class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

            <?php } ?>


            <!-- MENU GURU -->
            <?php if ($_SESSION['role'] == 'guru') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa.php"
                       class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link active">
                        Kelas
                    </a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php"
                       class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

            <?php } ?>

        </div>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Data Kelas</h2>

            <p>
                Daftar kelas pada sistem
            </p>

            <!-- TOMBOL TAMBAH KELAS -->
            <?php if ($_SESSION['role'] == 'admin') { ?>
            <div class="mb-3">
                <a href="tambah_kelas.php"
                   class="btn btn-primary">
                    Tambah Kelas
                </a>
            </div>
            <?php } ?>


            <!-- TABEL DATATABLES -->
            <div class="table-responsive">

                <table id="tabelKelas"
                       class="table table-bordered table-striped table-hover w-100">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    while ($kelas = mysqli_fetch_assoc($query)) {
                    ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($kelas['nama'] ?? ''); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($kelas['tingkat'] ?? ''); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($kelas['jurusan'] ?? ''); ?>
                            </td>

                            <td>
                                <?php if ($_SESSION['role'] == 'admin') { ?>

                                <div class="d-flex gap-1">

                                    <a
                                        href="edit_kelas.php?id=<?= urlencode((string)$kelas['id']); ?>"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <a
                                        href="hapus_kelas.php?id=<?= urlencode((string)$kelas['id']); ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus kelas ini?');">
                                        Hapus
                                    </a>

                                </div>

                                <?php } else { ?>

                                    <span class="text-muted">-</span>

                                <?php } ?>
                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </main>

    </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- INISIALISASI DATATABLES -->
<script>
$(document).ready(function () {

    $('#tabelKelas').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        // Kolom No dan Aksi tidak dapat diurutkan atau dicari
        columnDefs: [
            {
                targets: [0, 4],
                orderable: false,
                searchable: false
            }
        ],

        // Urutkan berdasarkan nama kelas
        order: [[1, 'asc']],

        // Bahasa Indonesia
        language: {
            search: "Cari kelas:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ kelas",

            infoEmpty: "Tidak ada data kelas",

            infoFiltered: "(difilter dari _MAX_ total kelas)",

            zeroRecords: "Data kelas tidak ditemukan",

            emptyTable: "Belum ada data kelas",

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
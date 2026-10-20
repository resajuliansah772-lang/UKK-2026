<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'jenis_pelanggaran';

// Memeriksa struktur tabel
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran");

if (!$hasil_kolom) {
    die("Tabel t_pelanggaran tidak ditemukan: " . mysqli_error($koneksi));
}

$kolom_tersedia = [];

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

// Mencari nama kolom sesuai struktur database
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
    'pelanggaran_kategori_id', 'kategori_id', 'id_kategori'
]);

$kolom_poin = cariKolom($kolom_tersedia, [
    'poin', 'poin_pelanggaran', 'jumlah_poin'
]);

$kolom_deskripsi = cariKolom($kolom_tersedia, [
    'deskripsi', 'keterangan'
]);

$kolom_status = cariKolom($kolom_tersedia, [
    'status_aktif', 'status'
]);

// Mengambil data jenis pelanggaran
$sql = "SELECT * FROM t_pelanggaran ORDER BY id DESC";
$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data jenis pelanggaran: "
        . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jenis Pelanggaran</title>

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

        #tabelJenis th,
        #tabelJenis td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            margin-top: 10px;
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

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100 sidebar">

            <h4 class="text-white mb-4">
                Pelanggaran Siswa
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
                    <a href="penempatan_siswa.php" class="nav-link text-white">
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
                    <a href="jenis_pelanggaran.php"
                       class="nav-link active"
                       aria-current="page">
                        Jenis Pelanggaran
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
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Jenis Pelanggaran</h2>

            <p class="text-muted">
                Kelola data jenis pelanggaran siswa.
            </p>

            <!-- TOMBOL TAMBAH -->
            <div class="mb-3 no-print">
                <a href="tambah_jenis_pelanggaran.php"
                   class="btn btn-primary">
                    + Tambah Jenis Pelanggaran
                </a>
            </div>

            <!-- TABEL JENIS PELANGGARAN -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelJenis"
                               class="table table-bordered table-striped table-hover w-100">

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

                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) (
                                                    $kolom_nama
                                                        ? ($row[$kolom_nama] ?? '-')
                                                        : '-'
                                                )
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
                                                <span class="badge bg-danger">
                                                    <?= htmlspecialchars(
                                                        (string) ($row[$kolom_poin] ?? 0)
                                                    ) ?>
                                                </span>
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
                                                <?php
                                                $status = $row[$kolom_status] ?? 0;

                                                if (
                                                    $kolom_status === 'status'
                                                    && !is_numeric($status)
                                                ) {
                                                    $aktif = strtolower((string)$status) === 'aktif';
                                                } else {
                                                    $aktif = (int)$status === 1;
                                                }
                                                ?>

                                                <?php if ($aktif) { ?>
                                                    <span class="badge bg-success">
                                                        Aktif
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="badge bg-secondary">
                                                        Tidak Aktif
                                                    </span>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>

                                        <td>
                                            <div class="d-flex gap-1">

                                                <a href="edit_jenis_pelanggaran.php?id=<?= (int)$row['id']; ?>"
                                                   class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <a href="hapus_jenis_pelanggaran.php?id=<?= (int)$row['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?');">
                                                    Hapus
                                                </a>

                                            </div>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- AKTIFKAN DATATABLES -->
<script>
$(document).ready(function () {

    $('#tabelJenis').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        columnDefs: [
            {
                targets: [0, -1],
                orderable: false,
                searchable: false
            }
        ],

        language: {
            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data jenis pelanggaran",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data jenis pelanggaran tidak ditemukan",

            emptyTable: "Belum ada data jenis pelanggaran",

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
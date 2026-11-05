<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// --- PROSES AKTIFKAN TAHUN AJARAN LANGSUNG ---
if (isset($_GET['aktifkan'])) {
    $id = intval($_GET['aktifkan']);

    // 1. Ubah semua status_aktif menjadi 0 (Tidak Aktif)
    $reset = mysqli_query($koneksi, "UPDATE t_tahun_ajaran SET status_aktif = 0");

    if ($reset) {
        // 2. Ubah tahun ajaran yang dipilih menjadi status_aktif = 1 (Aktif)
        $aktifkan = mysqli_query($koneksi, "UPDATE t_tahun_ajaran SET status_aktif = 1 WHERE id = $id");

        if ($aktifkan) {
            echo "<script>alert('Tahun ajaran berhasil diaktifkan!'); window.location='tahun_ajaran.php';</script>";
            exit;
        }
    }

    echo "<script>alert('Gagal mengaktifkan tahun ajaran!'); window.location='tahun_ajaran.php';</script>";
    exit;
}

// Halaman aktif
$halaman = 'tahun_ajaran';
$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

// Ambil data tahun ajaran
$sql = "SELECT * FROM t_tahun_ajaran ORDER BY id DESC";
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

    <title>Tahun Ajaran - Sistem Informasi Pelanggaran Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            padding-left: 15px;
        }

        #tabelTahunAjaran th,
        #tabelTahunAjaran td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            margin-top: 15px;
        }

        .card { border: none; border-radius: 12px; }
        .sidebar { background: linear-gradient(180deg, #212529 0%, #1a1e21 100%); }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar min-vh-100 p-3">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i> Pelanggaran Siswa
            </h4>

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_siswa.php"
                       class="nav-link text-white">
                        <i class="bi bi-people me-2"></i> Data Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_guru.php"
                       class="nav-link text-white">
                        <i class="bi bi-person-badge me-2"></i> Data Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelas.php"
                       class="nav-link text-white">
                        <i class="bi bi-door-open me-2"></i> Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tahun_ajaran.php"
                       class="nav-link active">
                        <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penepatan_siswa.php"
                       class="nav-link text-white">
                        <i class="bi bi-journal-check me-2"></i> Penempatan Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="walikelas.php"
                       class="nav-link text-white">
                        <i class="bi bi-person-workspace me-2"></i> Wali Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kategori_pelanggaran.php"
                       class="nav-link text-white">
                        <i class="bi bi-tags me-2"></i> Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="jenis_pelanggaran.php"
                       class="nav-link text-white">
                        <i class="bi bi-list-task me-2"></i> Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php"
                       class="nav-link text-white">
                        <i class="bi bi-file-earmark-text me-2"></i> Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="aboutme.php"
                       class="nav-link text-white">
                        <i class="bi bi-info-circle me-2"></i> About Me
                    </a>
                </li>

                <hr class="text-secondary my-3">

                <li class="nav-item">
                    <a href="logout.php"
                       class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>

            </ul>
        </div>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="card shadow-sm p-4 bg-white">

                <h2>Tahun Ajaran</h2>

                <p class="text-muted">Kelola data tahun ajaran sekolah.</p>

                <!-- TOMBOL TAMBAH -->
                <div class="mb-3">
                    <a href="tambah_tahun_ajaran.php"
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Tahun Ajaran
                    </a>
                </div>

                <!-- TABEL -->
                <div class="table-responsive">

                    <table id="tabelTahunAjaran"
                           class="table table-bordered table-striped table-hover align-middle w-100">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Tahun Ajaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        $no = 1;

                        if (mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>

                            <tr>

                                <td>
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nama'] ?? ''); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['tanggal_mulai'] ?? ''); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['tanggal_selesai'] ?? ''); ?>
                                </td>

                                <td>
                                    <?php if (($data['status_aktif'] ?? 0) == 1) { ?>

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-secondary">
                                            Tidak Aktif
                                        </span>

                                    <?php } ?>
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <?php if (($data['status_aktif'] ?? 0) == 0) { ?>
                                            <a href="tahun_ajaran.php?aktifkan=<?= urlencode((string)$data['id']); ?>" 
                                               class="btn btn-success btn-sm"
                                               onclick="return confirm('Aktifkan tahun ajaran ini? Tahun ajaran lain akan otomatis dinonaktifkan.');">
                                                Aktifkan
                                            </a>
                                        <?php } ?>

                                        <a href="edit_tahun_ajaran.php?id=<?= urlencode((string)$data['id']); ?>" 
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="hapus_tahun_ajaran.php?id=<?= urlencode((string)$data['id']); ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus data tahun ajaran ini?');">
                                            Hapus
                                        </a>
                                    </div>
                                </td>

                            </tr>

                        <?php
                            }
                        }
                        ?>

                        </tbody>

                    </table>

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

<!-- INISIALISASI DATATABLES -->
<script>
$(document).ready(function () {

    $('#tabelTahunAjaran').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        columnDefs: [
            {
                targets: [0, 5],
                orderable: false,
                searchable: false
            }
        ],

        order: [[0, 'asc']],

        language: {
            search: "Cari tahun ajaran:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data tahun ajaran",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data tahun ajaran tidak ditemukan",

            emptyTable: "Data tahun ajaran belum ada",

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
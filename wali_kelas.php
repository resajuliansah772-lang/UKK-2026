<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'wali_kelas';
$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

// Ambil struktur kolom tabel tahun ajaran
$kolom_ta = [];
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_tahun_ajaran");

if (!$hasil_kolom) {
    die("Gagal membaca tabel tahun ajaran: " . mysqli_error($koneksi));
}

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_ta[] = $kolom['Field'];
}

// Cari kolom nama tahun ajaran yang tersedia
$pilihan_kolom = [
    'nama_tahun_ajaran',
    'nama',
    'tahun_ajaran',
    'tahun'
];

$kolom_nama_ta = null;

foreach ($pilihan_kolom as $nama_kolom) {
    if (in_array($nama_kolom, $kolom_ta, true)) {
        $kolom_nama_ta = $nama_kolom;
        break;
    }
}

// Jika kolom nama tidak ditemukan, gunakan ID tahun ajaran
$select_ta = $kolom_nama_ta
    ? "ta.`" . $kolom_nama_ta . "` AS nama_tahun_ajaran"
    : "ta.id AS nama_tahun_ajaran";

// Mengambil data wali kelas beserta relasinya
$sql = "SELECT
            wk.id,
            wk.tanggal_mulai,
            wk.tanggal_selesai,
            wk.status_aktif,
            $select_ta,
            k.nama AS nama_kelas,
            k.tingkat,
            k.jurusan,
            g.nama AS nama_guru
        FROM t_wali_kelas wk
        LEFT JOIN t_tahun_ajaran ta
            ON wk.tahun_ajaran_id = ta.id
        LEFT JOIN t_kelas k
            ON wk.kelas_id = k.id
        LEFT JOIN t_guru g
            ON wk.guru_id = g.id
        ORDER BY wk.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data wali kelas: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wali Kelas - Sistem Informasi Pelanggaran Siswa</title>

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

        #tabelWaliKelas th,
        #tabelWaliKelas td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            margin-top: 10px;
        }

        .card { border: none; border-radius: 12px; }
        .sidebar { background: linear-gradient(180deg, #212529 0%, #1a1e21 100%); }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3 min-vh-100">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i> Pelanggaran Siswa
            </h4>

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
                    <a href="wali_kelas.php" class="nav-link active">
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

        </div>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="card shadow-sm p-4 bg-white">

                <h2>Wali Kelas</h2>

                <p class="text-muted">
                    Kelola data penugasan guru sebagai wali kelas.
                </p>

                <div class="mb-3">
                    <a href="tambah_wali_kelas.php" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Wali Kelas
                    </a>
                </div>

                <!-- TABEL DATATABLES -->
                <div class="table-responsive">

                    <table id="tabelWaliKelas"
                           class="table table-bordered table-striped table-hover w-100 align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Kelas</th>
                                <th>Tahun Ajaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
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
                                    <?= htmlspecialchars($row['nama_guru'] ?? '-'); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        trim(
                                            ($row['nama_kelas'] ?? '-') . ' ' .
                                            ($row['tingkat'] ?? '') . ' ' .
                                            ($row['jurusan'] ?? '')
                                        )
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        (string) ($row['nama_tahun_ajaran'] ?? '-')
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['tanggal_mulai'] ?? '-'); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['tanggal_selesai'] ?? '-'); ?>
                                </td>

                                <td>
                                    <?php if ((int) $row['status_aktif'] === 1) { ?>
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
                                        <a href="edit_wali_kelas.php?id=<?= (int) $row['id']; ?>"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="hapus_wali_kelas.php?id=<?= (int) $row['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus data wali kelas ini?');">
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

    $('#tabelWaliKelas').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        columnDefs: [
            {
                targets: [0, 7],
                orderable: false,
                searchable: false
            }
        ],

        order: [[0, 'asc']],

        language: {
            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data wali kelas",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data wali kelas tidak ditemukan",

            emptyTable: "Belum ada data wali kelas",

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
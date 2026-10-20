<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'catatan_pelanggaran';

// Query mengambil data catatan pelanggaran siswa dengan relasi lengkap ke t_siswa, t_pelanggaran, t_pelanggaran_kategori, dan t_guru
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
        LEFT JOIN t_siswa s ON ps.siswa_id = s.id
        LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
        LEFT JOIN t_pelanggaran_kategori pk ON p.pelanggaran_kategori_id = pk.id
        LEFT JOIN t_guru g ON ps.guru_id = g.id
        ORDER BY ps.tanggal DESC, ps.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data catatan pelanggaran: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catatan Pelanggaran</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }

        #tabelCatatan th,
        #tabelCatatan td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .dataTables_wrapper {
            margin-top: 10px;
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

            <hr class="text-secondary">

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="catatan_pelanggaran.php" class="nav-link <?php echo ($halaman == 'catatan_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Catatan Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tindakan.php" class="nav-link text-white">
                        Tindakan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">
                        Laporan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="riwayat.php" class="nav-link text-white">
                        Riwayat
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="rekap_poin.php" class="nav-link text-white">
                        Rekap Poin
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

            <h2>Catatan Pelanggaran</h2>

            <p class="text-muted">
                Daftar transaksi pencatatan pelanggaran siswa di sekolah.
            </p>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Catatan pelanggaran siswa berhasil disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- TOMBOL TAMBAH -->
            <div class="mb-3">
                <a href="tambah_catatan_pelanggaran.php" class="btn btn-primary">
                    + Tambah Catatan Pelanggaran
                </a>
            </div>

            <!-- TABEL CATATAN PELANGGARAN -->
            <div class="card shadow-sm border">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelCatatan" class="table table-bordered table-striped table-hover w-100">

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
                                        <td><?= $no++; ?></td>
                                        <td><?= !empty($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : '-'; ?></td>
                                        <td><?= htmlspecialchars($row['nis'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger">
                                                +<?= (int) ($row['poin'] ?? 0); ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($row['nama_guru'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['keterangan'] ?? '-'); ?></td>
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
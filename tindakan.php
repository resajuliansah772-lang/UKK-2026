<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif agar sidebar menyorot menu Tindakan
$halaman = 'tindakan';

// Query mengambil data dari t_pelanggaran dan berelasi dengan t_pelanggaran_kategori
$sql = "SELECT 
            p.id,
            p.kode,
            p.nama AS nama_pelanggaran,
            p.poin,
            p.deskripsi,
            pk.nama AS nama_kategori
        FROM t_pelanggaran p
        LEFT JOIN t_pelanggaran_kategori pk ON p.pelanggaran_kategori_id = pk.id
        ORDER BY p.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data pelanggaran: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tindakan & Pelanggaran</title>

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

        #tabelTindakan th,
        #tabelTindakan td {
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

        <!-- SIDEBAR TERPISAH (Ukuran font dan menu otomatis seragam) -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Tindakan / Pelanggaran</h2>

            <p class="text-muted">
                Daftar referensi jenis pelanggaran beserta kategori dan bobot poin.
            </p>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data berhasil disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- TOMBOL TAMBAH -->
            <div class="mb-3">
                <a href="tambah_pelanggaran.php" class="btn btn-primary">
                    + Tambah Pelanggaran
                </a>
            </div>

            <!-- TABEL TINDAKAN / PELANGGARAN -->
            <div class="card shadow-sm border">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelTindakan" class="table table-bordered table-striped table-hover w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Kategori</th>
                                    <th>Nama Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['kode'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger">
                                                <?= (int) ($row['poin'] ?? 0); ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($row['deskripsi'] ?? '-'); ?></td>
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
    $('#tabelTindakan').DataTable({
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
            infoEmpty: "Tidak ada data pelanggaran",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data pelanggaran tidak ditemukan",
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
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'rekap_poin';

// Menghitung jumlah pelanggaran dan total poin setiap siswa
$sql = "SELECT
            nama_siswa,
            COUNT(id) AS jumlah_pelanggaran,
            SUM(poin) AS total_poin,
            MAX(tanggal) AS pelanggaran_terakhir
        FROM t_pelanggaran_siswa
        GROUP BY nama_siswa
        ORDER BY total_poin DESC, nama_siswa ASC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data rekap poin: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekap Poin Siswa</title>

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

        #tabelRekap th,
        #tabelRekap td {
            vertical-align: middle;
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
        <?php include "includes/sidebar.php"; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Rekap Poin Siswa</h2>

            <p class="text-muted">
                Rekapitulasi jumlah pelanggaran dan total poin setiap siswa.
            </p>

            <!-- TABEL REKAP POIN -->
            <div class="card shadow-sm border">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelRekap"
                               class="table table-bordered table-striped table-hover w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Jumlah Pelanggaran</th>
                                    <th>Total Poin</th>
                                    <th>Pelanggaran Terakhir</th>
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
                                            <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                        </td>

                                        <td class="text-center">
                                            <?= (int) $row['jumlah_pelanggaran']; ?>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-danger">
                                                <?= (int) $row['total_poin']; ?> Poin
                                            </span>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['pelanggaran_terakhir'] ?? '-'); ?>
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

<!-- Aktifkan DataTables -->
<script>
$(document).ready(function () {

    $('#tabelRekap').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false
            }
        ],

        order: [[3, 'desc']],

        language: {
            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data rekap poin",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data rekap poin tidak ditemukan",

            emptyTable: "Belum ada data rekap poin",

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
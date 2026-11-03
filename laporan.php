
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Role pengguna
$role = strtolower(trim($_SESSION['role'] ?? ''));

// Penanda halaman aktif
$halaman = 'laporan';

// Mengambil nama kolom tabel secara otomatis
function cariKolomLaporan($koneksi, $tabel, $pilihan) {
    $hasil = mysqli_query($koneksi, "SHOW COLUMNS FROM `$tabel`");

    if (!$hasil) {
        return null;
    }

    $kolomTersedia = [];

    while ($data = mysqli_fetch_assoc($hasil)) {
        $kolomTersedia[] = $data['Field'];
    }

    foreach ($pilihan as $kolom) {
        if (in_array($kolom, $kolomTersedia)) {
            return $kolom;
        }
    }

    return null;
}

// Periksa tabel yang digunakan
$tabel = 't_pelanggaran_siswa';

$cekTabel = mysqli_query($koneksi, "SHOW TABLES LIKE '$tabel'");

if (!$cekTabel || mysqli_num_rows($cekTabel) == 0) {
    die("Tabel t_pelanggaran_siswa tidak ditemukan. Periksa nama tabel database.");
}

// Cari nama kolom yang tersedia
$kolomSiswa = cariKolomLaporan(
    $koneksi,
    $tabel,
    ['siswa_id', 'id_siswa']
);

$kolomPelanggaran = cariKolomLaporan(
    $koneksi,
    $tabel,
    ['pelanggaran_id', 'id_pelanggaran', 'jenis_pelanggaran_id']
);

$kolomTanggal = cariKolomLaporan(
    $koneksi,
    $tabel,
    ['tanggal', 'tanggal_pelanggaran', 'created_at']
);

$kolomKeterangan = cariKolomLaporan(
    $koneksi,
    $tabel,
    ['keterangan', 'catatan', 'deskripsi']
);

// Pastikan kolom relasi tersedia
if (!$kolomSiswa || !$kolomPelanggaran || !$kolomTanggal) {
    die("Kolom relasi siswa, pelanggaran, atau tanggal tidak ditemukan. Periksa struktur tabel t_pelanggaran_siswa.");
}

// Keterangan boleh tidak tersedia
$kolomKeteranganSQL = $kolomKeterangan
    ? "ps.`$kolomKeterangan`"
    : "''";

// Query laporan
$sql = "
    SELECT
        ps.id,
        ps.`$kolomTanggal` AS tanggal,
        s.nama AS nama_siswa,
        p.nama AS nama_pelanggaran,
        p.poin AS poin,
        $kolomKeteranganSQL AS keterangan
    FROM t_pelanggaran_siswa ps
    LEFT JOIN t_siswa s
        ON ps.`$kolomSiswa` = s.id
    LEFT JOIN t_pelanggaran p
        ON ps.`$kolomPelanggaran` = p.id
    ORDER BY ps.`$kolomTanggal` DESC
";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil laporan: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables -->
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

        #tabelLaporan th,
        #tabelLaporan td {
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

        <!-- SIDEBAR SESUAI ROLE -->
        <?php include "includes/sidebar.php"; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="fw-bold">Laporan Pelanggaran</h2>

            <p class="text-muted">
                Rekapitulasi catatan pelanggaran siswa.
            </p>

            <?php if ($role == 'admin') { ?>

                <div class="alert alert-primary">
                    Anda login sebagai Admin. Berikut seluruh laporan pelanggaran siswa.
                </div>

            <?php } elseif ($role == 'guru') { ?>

                <div class="alert alert-info">
                    Anda login sebagai Guru. Berikut laporan pelanggaran siswa.
                </div>

            <?php } elseif ($role == 'petugas') { ?>

                <div class="alert alert-info">
                    Anda login sebagai Petugas. Berikut laporan pelanggaran siswa.
                </div>

            <?php } ?>

            <!-- TOMBOL CETAK -->
            <div class="mb-3">
                <button onclick="window.print()" class="btn btn-success">
                    Cetak / Print Laporan
                </button>
            </div>

            <!-- TABEL LAPORAN -->
            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelLaporan"
                               class="table table-bordered table-striped table-hover w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Poin</th>
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

                                    <td>
                                        <?= htmlspecialchars($row['tanggal'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            <?= (int)($row['poin'] ?? 0); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['keterangan'] ?? '-'); ?>
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

<!-- DataTables Bahasa Indonesia -->
<script>
$(document).ready(function () {

    $('#tabelLaporan').DataTable({

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
            infoEmpty: "Tidak ada data laporan",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data tidak ditemukan",
            emptyTable: "Belum ada laporan pelanggaran",

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

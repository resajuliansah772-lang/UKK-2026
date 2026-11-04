<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'laporan';
$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

// =====================================
// EXPORT LAPORAN KE EXCEL (CSV)
// =====================================
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    $sql_export = mysqli_query($koneksi, "
        SELECT id, tanggal, nama_siswa, nama_pelanggaran, poin, keterangan
        FROM t_pelanggaran_siswa
        ORDER BY tanggal DESC, id DESC
    ");

    if (!$sql_export) {
        die("Gagal export: " . mysqli_error($koneksi));
    }

    $nama_file = "Laporan_Pelanggaran_Siswa_" . date('Y-m-d') . ".csv";

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $nama_file . '"');

    $output = fopen('php://output', 'w');
    fwrite($output, "\xEF\xBB\xBF");

    fputcsv($output, ['No', 'Tanggal', 'Nama Siswa', 'Jenis Pelanggaran', 'Poin', 'Keterangan'], ';');

    $no = 1;
    while ($row = mysqli_fetch_assoc($sql_export)) {
        fputcsv($output, [
            $no++,
            $row['tanggal'],
            $row['nama_siswa'],
            $row['nama_pelanggaran'],
            $row['poin'],
            $row['keterangan']
        ], ';');
    }

    fclose($output);
    exit;
}

// =====================================
// MENGAMBIL DATA LAPORAN
// =====================================
$query = mysqli_query($koneksi, "
    SELECT id, tanggal, nama_siswa, nama_pelanggaran, poin, keterangan
    FROM t_pelanggaran_siswa
    ORDER BY tanggal DESC, id DESC
");

if (!$query) {
    die("Gagal mengambil data laporan: " . mysqli_error($koneksi));
}

$total_data = mysqli_num_rows($query);
$total_poin = 0;
$data_laporan = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data_laporan[] = $row;
    $total_poin += (int)$row['poin'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran Siswa - Sistem Informasi Pelanggaran Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css" rel="stylesheet">

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

        .table th { white-space: nowrap; vertical-align: middle; }
        .table td { vertical-align: middle; }
        .card { border: none; border-radius: 12px; }
        .sidebar { background: linear-gradient(180deg, #212529 0%, #1a1e21 100%); min-height: 100vh; }

        @media print {
            .sidebar, .tombol-aksi, .dt-search, .dt-length, .dt-paging, .dt-info {
                display: none !important;
            }
            main { width: 100% !important; padding: 0 !important; }
            body { background: white !important; }
            .card { border: none !important; box-shadow: none !important; }
            .table { font-size: 11px; }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR SESUAI ROLE -->
        <div class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i> Pelanggaran Siswa
            </h4>

            <?php if ($roleUser == 'admin'): ?>
                <!-- MENU KHUSUS ADMIN SAJA -->
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="data_siswa.php" class="nav-link text-white"><i class="bi bi-people me-2"></i> Data Siswa</a></li>
                    <li class="nav-item"><a href="data_guru.php" class="nav-link text-white"><i class="bi bi-person-badge me-2"></i> Data Guru</a></li>
                    <li class="nav-item"><a href="kelas.php" class="nav-link text-white"><i class="bi bi-door-open me-2"></i> Kelas</a></li>
                    <li class="nav-item"><a href="tahun_ajaran.php" class="nav-link text-white"><i class="bi bi-calendar-range me-2"></i> Tahun Ajaran</a></li>
                    <li class="nav-item"><a href="penempatan_siswa.php" class="nav-link text-white"><i class="bi bi-journal-check me-2"></i> Penempatan Siswa</a></li>
                    <li class="nav-item"><a href="wali_kelas.php" class="nav-link text-white"><i class="bi bi-person-workspace me-2"></i> Wali Kelas</a></li>
                    <li class="nav-item"><a href="kategori_pelanggaran.php" class="nav-link text-white"><i class="bi bi-tags me-2"></i> Kategori Pelanggaran</a></li>
                    <li class="nav-item"><a href="jenis_pelanggaran.php" class="nav-link text-white"><i class="bi bi-list-task me-2"></i> Jenis Pelanggaran</a></li>
                    <li class="nav-item"><a href="laporan.php" class="nav-link active"><i class="bi bi-file-earmark-text me-2"></i> Laporan</a></li>
                    <li class="nav-item"><a href="aboutme.php" class="nav-link text-white"><i class="bi bi-info-circle me-2"></i> About Me</a></li>
                    <hr class="text-secondary my-3">
                    <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>

            <?php else: ?>
                <!-- MENU KHUSUS GURU SAJA -->
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="catatan_pelanggaran.php" class="nav-link text-white"><i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran</a></li>
                    <li class="nav-item"><a href="tindakan.php" class="nav-link text-white"><i class="bi bi-hammer me-2"></i> Tindakan</a></li>
                    <li class="nav-item"><a href="laporan.php" class="nav-link active"><i class="bi bi-file-earmark-text me-2"></i> Laporan</a></li>
                    <li class="nav-item"><a href="riwayat.php" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i> Riwayat</a></li>
                    <li class="nav-item"><a href="rekap_poin.php" class="nav-link text-white"><i class="bi bi-award me-2"></i> Rekap Poin</a></li>
                    <hr class="text-secondary my-3">
                    <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            <?php endif; ?>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="card shadow-sm p-4 bg-white mb-4">
                <h2>Laporan Pelanggaran Siswa</h2>
                <p class="text-muted mb-0">Kelola dan lihat laporan data pelanggaran siswa.</p>
            </div>

            <!-- RINGKASAN -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm border-0 bg-white p-3">
                        <div class="card-body">
                            <h6 class="text-muted">Total Pelanggaran</h6>
                            <h3 class="fw-bold text-primary mb-0"><?= $total_data; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm border-0 bg-white p-3">
                        <div class="card-body">
                            <h6 class="text-muted">Total Poin Pelanggaran</h6>
                            <h3 class="fw-bold text-danger mb-0"><?= $total_poin; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL LAPORAN -->
            <div class="card shadow-sm bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="mb-0 fw-bold">Data Laporan Pelanggaran</h5>
                        <div class="d-flex gap-2 tombol-aksi">
                            <a href="laporan.php?export=excel" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                            </a>
                            <button onclick="cetakLaporan()" class="btn btn-primary btn-sm">
                                <i class="bi bi-printer me-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tabelLaporan" class="table table-bordered table-striped table-hover align-middle w-100">
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
                                <?php $no = 1; ?>
                                <?php foreach ($data_laporan as $data): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= !empty($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-'; ?></td>
                                    <td><?= htmlspecialchars($data['nama_siswa'] ?? '-'); ?></td>
                                    <td><?= htmlspecialchars($data['nama_pelanggaran'] ?? '-'); ?></td>
                                    <td class="text-center"><span class="badge bg-danger"><?= (int)$data['poin']; ?></span></td>
                                    <td><?= htmlspecialchars($data['keterangan'] ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_data == 0): ?>
                        <div class="alert alert-info mt-3 mb-0">Belum ada data pelanggaran siswa.</div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

<script>
$(document).ready(function () {
    $('#tabelLaporan').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });
});

function cetakLaporan() {
    let tabel = $('#tabelLaporan').DataTable();
    let panjangAwal = tabel.page.len();
    tabel.page.len(-1).draw();

    setTimeout(function () {
        window.print();
        window.onafterprint = function () {
            tabel.page.len(panjangAwal).draw();
            window.onafterprint = null;
        };
    }, 500);
}
</script>
</body>
</html>
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'tindakan';
$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

// Memeriksa struktur tabel t_pelanggaran_siswa untuk keamanan kolom
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran_siswa");
if (!$hasil_kolom) {
    die("Tabel t_pelanggaran_siswa tidak ditemukan: " . mysqli_error($koneksi));
}
$kolom_tersedia = [];
while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

// Proses jika tombol Tindak/Simpan Sanksi ditekan
if (isset($_POST['proses_tindakan'])) {
    $id_pelanggaran_siswa = (int)$_POST['id_pelanggaran_siswa'];
    $jenis_tindakan = mysqli_real_escape_string($koneksi, $_POST['jenis_tindakan']);

    // Update status menjadi Selesai dan simpan jenis tindakannya (jika kolom tersedia)
    $update_sql = "UPDATE t_pelanggaran_siswa SET status = 'Selesai'";
    if (in_array('jenis_tindakan', $kolom_tersedia, true)) {
        $update_sql .= ", jenis_tindakan = '$jenis_tindakan'";
    }
    $update_sql .= " WHERE id = '$id_pelanggaran_siswa'";
    
    $update = mysqli_query($koneksi, $update_sql);

    if ($update) {
        echo "<script>alert('Tindakan berhasil diproses dan masuk ke Riwayat!'); window.location='tindakan.php';</script>";
        exit;
    } else {
        $pesan_error = "Gagal memproses tindakan: " . mysqli_error($koneksi);
    }
}

// Ambil data pelanggaran siswa yang statusnya masih 'Pending', kosong, atau NULL
$sql = "SELECT 
            ps.id,
            ps.tanggal,
            ps.keterangan,
            s.nis,
            s.nama AS nama_siswa,
            p.nama AS nama_pelanggaran,
            p.poin,
            g.nama AS nama_guru
        FROM t_pelanggaran_siswa ps
        LEFT JOIN t_siswa s ON ps.siswa_id = s.id
        LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
        LEFT JOIN t_guru g ON ps.guru_id = g.id
        WHERE ps.status = 'Pending' OR ps.status = '' OR ps.status IS NULL
        ORDER BY ps.tanggal DESC, ps.id DESC";

$query = mysqli_query($koneksi, $sql);
if (!$query) {
    die("Gagal mengambil data tindakan: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tindakan Pelanggaran - Sistem Informasi Pelanggaran Siswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .nav-link { transition: all 0.3s ease; border-radius: 6px; }
        .nav-link:hover, .nav-link.active { background-color: #0d6efd !important; color: white !important; padding-left: 15px; }
        .card { border: none; border-radius: 12px; }
        .sidebar { background: linear-gradient(180deg, #212529 0%, #1a1e21 100%); min-height: 100vh; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i> Pelanggaran Siswa
            </h4>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item"><a href="dashboard.php" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a href="catatan_pelanggaran.php" class="nav-link text-white"><i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran</a></li>
                <li class="nav-item"><a href="tindakan.php" class="nav-link active"><i class="bi bi-hammer me-2"></i> Tindakan</a></li>
                <li class="nav-item"><a href="laporan.php" class="nav-link text-white"><i class="bi bi-file-earmark-text me-2"></i> Laporan</a></li>
                <li class="nav-item"><a href="riwayat.php" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i> Riwayat</a></li>
                <li class="nav-item"><a href="rekap_poin.php" class="nav-link text-white"><i class="bi bi-award me-2"></i> Rekap Poin</a></li>
                <hr class="text-secondary my-3">
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="card shadow-sm p-4 bg-white mb-4">
                <h2>Proses Tindakan Pelanggaran</h2>
                <p class="text-muted mb-0">Daftar siswa yang melanggar dan menunggu untuk diberi tindakan/sanksi.</p>
            </div>

            <?php if (isset($pesan_error)): ?>
                <div class="alert alert-danger"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <div class="card shadow-sm bg-white p-4">
                <div class="table-responsive">
                    <table id="tabelTindakan" class="table table-bordered table-striped table-hover w-100 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS & Nama Siswa</th>
                                <th>Pelanggaran</th>
                                <th>Poin</th>
                                <th>Pelapor</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['nis'] . ' - ' . $row['nama_siswa']); ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggaran']); ?></td>
                                <td class="text-center"><span class="badge bg-danger">+<?= (int)$row['poin']; ?></span></td>
                                <td><?= htmlspecialchars($row['nama_guru']); ?></td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTindakan<?= $row['id']; ?>">
                                        <i class="bi bi-hammer me-1"></i> Beri Tindakan
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Beri Tindakan -->
                            <div class="modal fade" id="modalTindakan<?= $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Proses Sanksi / Tindakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id_pelanggaran_siswa" value="<?= $row['id']; ?>">
                                                <p>Siswa: <strong><?= htmlspecialchars($row['nama_siswa']); ?></strong></p>
                                                <p>Pelanggaran: <strong><?= htmlspecialchars($row['nama_pelanggaran']); ?></strong></p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Pilih / Masukkan Jenis Tindakan / Sanksi</label>
                                                    <textarea name="jenis_tindakan" class="form-control" rows="3" placeholder="Contoh: Diberikan Surat Peringatan 1 (SP1) / Pembinaan oleh Wali Kelas" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="proses_tindakan" class="btn btn-success">Simpan & Masukkan ke Riwayat</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
<script>
$(document).ready(function () {
    $('#tabelTindakan').DataTable({
        language: {
            search: "Cari data:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tindakan",
            zeroRecords: "Data tindakan tidak ditemukan",
            emptyTable: "Belum ada siswa yang perlu ditindak",
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
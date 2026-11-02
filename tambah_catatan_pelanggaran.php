<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

$pesan = "";
$halaman = 'catatan_pelanggaran'; // Penanda agar menu Catatan Pelanggaran aktif di sidebar

// Ambil data siswa untuk dropdown
$siswa = mysqli_query($koneksi, "SELECT id, nis, nama FROM t_siswa WHERE status_aktif = 1 ORDER BY nama ASC");

// Ambil data jenis pelanggaran untuk dropdown
$pelanggaran = mysqli_query($koneksi, "SELECT id, nama, poin FROM t_pelanggaran ORDER BY nama ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siswa_id = mysqli_real_escape_string($koneksi, $_POST['siswa_id']);
    $pelanggaran_id = mysqli_real_escape_string($koneksi, $_POST['pelanggaran_id']);

    // Query memasukkan data ke tabel t_pelanggaran_siswa
    $sql = "INSERT INTO t_pelanggaran_siswa (siswa_id, pelanggaran_id) VALUES ('$siswa_id', '$pelanggaran_id')";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>alert('Catatan pelanggaran berhasil disimpan!'); window.location='catatan_pelanggaran.php';</script>";
        exit;
    } else {
        $pesan = "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan Pelanggaran</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="mb-4">
                <h2>Tambah Catatan Pelanggaran</h2>
                <p class="text-muted">Form pencatatan pelanggaran siswa baru.</p>
            </div>

            <?php if (!empty($pesan)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($pesan) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Pilih Siswa</label>
                            <select name="siswa_id" id="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php if ($siswa) { while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                    <option value="<?= (int)$s['id']; ?>"><?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?></option>
                                <?php }} ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="pelanggaran_id" class="form-label">Jenis Pelanggaran</label>
                            <select name="pelanggaran_id" id="pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                <?php if ($pelanggaran) { while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                    <option value="<?= (int)$p['id']; ?>"><?= htmlspecialchars($p['nama'] . ' (' . $p['poin'] . ' Poin)'); ?></option>
                                <?php }} ?>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="catatan_pelanggaran.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
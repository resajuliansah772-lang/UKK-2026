<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

$pesan = "";
$halaman = 'catatan_pelanggaran';

// 1. Ambil data siswa
$siswa = mysqli_query($koneksi, "
    SELECT id, nis, nama 
    FROM t_siswa 
    WHERE status_aktif = 1 
    ORDER BY nama ASC
");

// 2. Ambil data jenis pelanggaran (mengambil kolom yang pasti ada: id, nama, poin)
$pelanggaran = mysqli_query($koneksi, "
    SELECT id, nama, poin 
    FROM t_pelanggaran 
    ORDER BY nama ASC
");

// 3. Ambil data guru untuk pilihan pelapor
$guru = mysqli_query($koneksi, "SELECT id, nama FROM t_guru ORDER BY nama ASC");

// 4. Ambil tahun ajaran yang aktif
$sql_ta = mysqli_query($koneksi, "SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1 LIMIT 1");
$data_ta = mysqli_fetch_assoc($sql_ta);
$tahun_ajaran_id = $data_ta['id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $siswa_id = mysqli_real_escape_string($koneksi, $_POST['siswa_id']);
    $pelanggaran_id = mysqli_real_escape_string($koneksi, $_POST['pelanggaran_id']);
    $guru_id = mysqli_real_escape_string($koneksi, $_POST['guru_id']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // Ambil detail siswa
    $q_siswa = mysqli_query($koneksi, "SELECT nama FROM t_siswa WHERE id = '$siswa_id'");
    $d_siswa = mysqli_fetch_assoc($q_siswa);
    $nama_siswa = $d_siswa['nama'] ?? '';

    // Ambil detail pelanggaran (nama & poin)
    $q_pel = mysqli_query($koneksi, "SELECT nama, poin FROM t_pelanggaran WHERE id = '$pelanggaran_id'");
    $d_pel = mysqli_fetch_assoc($q_pel);
    $nama_pelanggaran = $d_pel['nama'] ?? '';
    $poin = $d_pel['poin'] ?? 0;

    // Ambil detail guru (nama)
    $q_guru = mysqli_query($koneksi, "SELECT nama FROM t_guru WHERE id = '$guru_id'");
    $d_guru = mysqli_fetch_assoc($q_guru);
    $nama_guru = $d_guru['nama'] ?? '';

    // Query memasukkan data ke t_pelanggaran_siswa
    $sql = "INSERT INTO t_pelanggaran_siswa (tahun_ajaran_id, siswa_id, nama_siswa, pelanggaran_id, nama_pelanggaran, poin, guru_id, nama_guru, tanggal, keterangan) 
            VALUES ('$tahun_ajaran_id', '$siswa_id', '$nama_siswa', '$pelanggaran_id', '$nama_pelanggaran', '$poin', '$guru_id', '$nama_guru', '$tanggal', '$keterangan')";
    
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
    <title>Tambah Catatan Pelanggaran - Sistem Informasi Pelanggaran Siswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .nav-link { transition: all 0.3s ease; border-radius: 6px; }
        .nav-link:hover { background-color: #0d6efd !important; color: white !important; }
        .card { border: none; border-radius: 12px; }
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
                <p class="text-muted">Form pencatatan pelanggaran siswa baru ke dalam sistem.</p>
            </div>

            <?php if (!empty($pesan)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($pesan) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm bg-white p-4">
                <form action="" method="POST">
                    
                    <!-- Tanggal Pelanggaran -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Pelanggaran</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <!-- Pilih Siswa -->
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label fw-semibold">Pilih Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php if ($siswa) { while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                <option value="<?= (int)$s['id']; ?>">
                                    <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>
                                </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!-- Jenis Pelanggaran -->
                    <div class="mb-3">
                        <label for="pelanggaran_id" class="form-label fw-semibold">Jenis Pelanggaran</label>
                        <select name="pelanggaran_id" id="pelanggaran_id" class="form-select" required>
                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                            <?php if ($pelanggaran) { while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                <option value="<?= (int)$p['id']; ?>">
                                    <?= htmlspecialchars($p['nama'] . ' (Poin: ' . $p['poin'] . ')'); ?>
                                </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!-- Pelapor / Guru -->
                    <div class="mb-3">
                        <label for="guru_id" class="form-label fw-semibold">Pelapor / Guru</label>
                        <select name="guru_id" id="guru_id" class="form-select" required>
                            <option value="">-- Pilih Guru Pelapor --</option>
                            <?php if ($guru) { while ($g = mysqli_fetch_assoc($guru)) { ?>
                                <option value="<?= (int)$g['id']; ?>">
                                    <?= htmlspecialchars($g['nama']); ?>
                                </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!-- Keterangan Tambahan -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan jika ada..."></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-2">
                        <a href="catatan_pelanggaran.php" class="btn btn-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Catatan</button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
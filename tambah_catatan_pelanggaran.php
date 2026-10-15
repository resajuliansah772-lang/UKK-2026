<?php
<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siswa_id = mysqli_real_escape_string($koneksi, $_POST['siswa_id']);
    $pelanggaran_id = mysqli_real_escape_string($koneksi, $_POST['pelanggaran_id']);

    // Query memasukkan data ke tabel t_pelanggaran_siswa
    $sql = "INSERT INTO t_pelanggaran_siswa (siswa_id, pelanggaran_id) VALUES ('$siswa_id', '$pelanggaran_id')";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>alert('Catatan pelanggaran berhasil disimpan!'); window.location='catatan_pelanggaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan: " . mysqli_error($koneksi) . "'); window.location='tambah_catatan_pelanggaran.php';</script>";
    }
} else {
    header("Location: catatan_pelanggaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan Pelanggaran</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark text-white p-3 min-vh-100">
            <h4>My Website</h4>
            <hr>
            <a href="dashboard.php" class="d-block text-white text-decoration-none p-2">Dashboard</a>
            <a href="catatan_pelanggaran.php" class="d-block bg-primary text-white text-decoration-none rounded p-2">Catatan Pelanggaran</a>
            <a href="tindakan.php" class="d-block text-white text-decoration-none p-2">Tindakan</a>
            <a href="laporan.php" class="d-block text-white text-decoration-none p-2">Laporan</a>
            <a href="riwayat.php" class="d-block text-white text-decoration-none p-2">Riwayat</a>
            <a href="rekap_poin.php" class="d-block text-white text-decoration-none p-2">Rekap Poin</a>
            <hr>
            <a href="logout.php" class="d-block text-danger text-decoration-none p-2">Logout</a>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="mb-4">
                <h2>Tambah Catatan Pelanggaran</h2>
                <p class="text-muted">Form pencatatan pelanggaran siswa baru.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="proses_tambah_catatan.php" method="POST">
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Pilih Siswa</label>
                            <select name="siswa_id" id="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php if ($siswa) { while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                    <option value="<?= $s['id']; ?>"><?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?></option>
                                <?php }} ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pelanggaran_id" class="form-label">Jenis Pelanggaran</label>
                            <select name="pelanggaran_id" id="pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                <?php if ($pelanggaran) { while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                    <option value="<?= $p['id']; ?>"><?= htmlspecialchars($p['nama'] . ' (' . $p['poin'] . ' Poin)'); ?></option>
                                <?php }} ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="catatan_pelanggaran.php" class="btn btn-secondary">&larr; Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
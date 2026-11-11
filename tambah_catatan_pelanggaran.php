
<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";

$pesan = "";
$halaman = 'catatan_pelanggaran';

// Ambil ID akun yang sedang login
// Mendukung session user_id maupun id
$user_id_login = (int) ($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);

// Ambil nama user/guru dari session
$nama_user_login = $_SESSION['name'] ?? $_SESSION['nama'] ?? 'Pengguna';

// 1. Ambil data siswa beserta nama kelasnya dengan JOIN ke tabel t_kelas_siswa dan t_kelas
$siswa = mysqli_query($koneksi, "
    SELECT s.id, s.nis, s.nama, 
           COALESCE(k.nama, 'Tanpa Kelas') AS nama_kelas 
    FROM t_siswa s
    LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
    LEFT JOIN t_kelas k ON ks.kelas_id = k.id
    WHERE s.status_aktif = 1 
    ORDER BY s.nama ASC
");

// 2. Ambil data jenis pelanggaran
$pelanggaran = mysqli_query($koneksi, "
    SELECT id, nama, poin 
    FROM t_pelanggaran 
    ORDER BY nama ASC
");

// 3. Ambil data guru berdasarkan akun yang sedang login
$guru_login_id = '';
$guru_login_nama = $nama_user_login;

if ($user_id_login > 0) {

    $stmt_guru = mysqli_prepare($koneksi, "
        SELECT id, nama
        FROM t_guru
        WHERE user_id = ?
        LIMIT 1
    ");

    mysqli_stmt_bind_param($stmt_guru, "i", $user_id_login);
    mysqli_stmt_execute($stmt_guru);

    mysqli_stmt_bind_result($stmt_guru, $id_guru, $nama_guru_db);

    if (mysqli_stmt_fetch($stmt_guru)) {
        $guru_login_id = $id_guru;
        $guru_login_nama = $nama_guru_db;
    }

    mysqli_stmt_close($stmt_guru);
}

// Pastikan akun login sudah terhubung dengan data guru
if (empty($guru_login_id)) {
    $pesan = "Akun login ini belum terhubung dengan data guru. Silakan hubungi admin.";
}

// 4. Ambil tahun ajaran yang aktif
$sql_ta = mysqli_query($koneksi, "
    SELECT id
    FROM t_tahun_ajaran
    WHERE status_aktif = 1
    LIMIT 1
");

$data_ta = mysqli_fetch_assoc($sql_ta);
$tahun_ajaran_id = $data_ta['id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($guru_login_id)) {

    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $siswa_id = mysqli_real_escape_string($koneksi, $_POST['siswa_id']);
    $pelanggaran_id = mysqli_real_escape_string($koneksi, $_POST['pelanggaran_id']);

    // Guru ID otomatis berdasarkan akun yang sedang login
    // Tidak mengambil guru_id dari input form
    $guru_id = $guru_login_id;

    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // Ambil detail siswa
    $q_siswa = mysqli_query($koneksi, "
        SELECT nama
        FROM t_siswa
        WHERE id = '$siswa_id'
    ");

    $d_siswa = mysqli_fetch_assoc($q_siswa);
    $nama_siswa = $d_siswa['nama'] ?? '';

    // Ambil detail pelanggaran (nama & poin)
    $q_pel = mysqli_query($koneksi, "
        SELECT nama, poin
        FROM t_pelanggaran
        WHERE id = '$pelanggaran_id'
    ");

    $d_pel = mysqli_fetch_assoc($q_pel);
    $nama_pelanggaran = $d_pel['nama'] ?? '';
    $poin = $d_pel['poin'] ?? 0;

    // Nama guru pelapor otomatis sesuai akun login
    $nama_guru = $guru_login_nama;

    // Query memasukkan data ke t_pelanggaran_siswa
    $sql = "INSERT INTO t_pelanggaran_siswa
            (
                tahun_ajaran_id,
                siswa_id,
                nama_siswa,
                pelanggaran_id,
                nama_pelanggaran,
                poin,
                guru_id,
                nama_guru,
                tanggal,
                keterangan
            )
            VALUES
            (
                '$tahun_ajaran_id',
                '$siswa_id',
                '$nama_siswa',
                '$pelanggaran_id',
                '$nama_pelanggaran',
                '$poin',
                '$guru_id',
                '$nama_guru',
                '$tanggal',
                '$keterangan'
            )";

    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>
            alert('Catatan pelanggaran berhasil disimpan!');
            window.location='catatan_pelanggaran.php';
        </script>";
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
    
    <!-- Select2 CSS & Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        body { background-color: #f4f6f9; }
        .nav-link { transition: all 0.3s ease; border-radius: 6px; }
        .nav-link:hover { background-color: #0d6efd !important; color: white !important; }
        .card { border: none; border-radius: 12px; }

        /* Perbaikan Posisi Kotak Pencarian Select2 agar di atas */
        .select2-container--bootstrap-5 .select2-dropdown .select2-search {
            padding: 0.5rem;
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field {
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
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

                    <!-- Pilih Siswa (Otomatis Menampilkan NIS - Nama - Kelas) -->
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label fw-semibold">Pilih Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="form-select select2" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php if ($siswa) { while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                <option value="<?= (int)$s['id']; ?>">
                                    <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama'] . ' (' . $s['nama_kelas'] . ')'); ?>
                                </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!-- Jenis Pelanggaran -->
                    <div class="mb-3">
                        <label for="pelanggaran_id" class="form-label fw-semibold">Jenis Pelanggaran</label>
                        <select name="pelanggaran_id" id="pelanggaran_id" class="form-select select2" required>
                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                            <?php if ($pelanggaran) { while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                <option value="<?= (int)$p['id']; ?>">
                                    <?= htmlspecialchars($p['nama'] . ' (Poin: ' . $p['poin'] . ')'); ?>
                                </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!-- Pelapor / Guru (Otomatis sesuai akun login) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pelapor / Guru</label>
                        <input type="text" class="form-control bg-light"
                               value="<?= htmlspecialchars($guru_login_nama); ?>" readonly>
                        <input type="hidden" name="guru_id"
                               value="<?= (int)$guru_login_id; ?>">
                    </div>

                    <!-- Keterangan Tambahan -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan jika ada..."></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-2">
                        <a href="catatan_pelanggaran.php" class="btn btn-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4"
                                <?= empty($guru_login_id) ? 'disabled' : ''; ?>>
                            Simpan Catatan
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>

<!-- jQuery (Wajib untuk Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Inisialisasi Select2 -->
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
});
</script>

</body>
</html>

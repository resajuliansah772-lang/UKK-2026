
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'jenis_pelanggaran';

$error = '';
$nama = '';
$kategori_id = '';
$poin = '';
$deskripsi = '';
$status = '1';

function aman($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

// Cari tabel jenis pelanggaran yang tersedia
$tabel_jenis = '';
$daftar_tabel = ['t_pelanggaran', 't_pelanggaran_jenis', 'jenis_pelanggaran'];

foreach ($daftar_tabel as $nama_tabel) {
    $cek_tabel = mysqli_query($koneksi, "SHOW TABLES LIKE '$nama_tabel'");

    if ($cek_tabel && mysqli_num_rows($cek_tabel) > 0) {
        $tabel_jenis = $nama_tabel;
        break;
    }
}

if ($tabel_jenis === '') {
    die("Tabel jenis pelanggaran tidak ditemukan di database.");
}

// Ambil struktur kolom
$kolom_tersedia = [];
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM `$tabel_jenis`");

if (!$hasil_kolom) {
    die("Gagal membaca struktur tabel: " . mysqli_error($koneksi));
}

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

// Fungsi mencari kolom
function cariKolom($daftar, $pilihan) {
    foreach ($pilihan as $kolom) {
        if (in_array($kolom, $daftar, true)) {
            return $kolom;
        }
    }
    return null;
}

$kolom_nama = cariKolom($kolom_tersedia, [
    'nama', 'nama_pelanggaran', 'nama_jenis',
    'nama_jenis_pelanggaran'
]);

$kolom_kategori = cariKolom($kolom_tersedia, [
    'pelanggaran_kategori_id', 'kategori_id', 'id_kategori'
]);

$kolom_poin = cariKolom($kolom_tersedia, [
    'poin', 'poin_pelanggaran', 'jumlah_poin'
]);

$kolom_deskripsi = cariKolom($kolom_tersedia, [
    'deskripsi', 'keterangan'
]);

$kolom_status = cariKolom($kolom_tersedia, [
    'status_aktif', 'status'
]);

// Ambil data kategori
$query_kategori = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_pelanggaran_kategori ORDER BY nama ASC"
);

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $kategori_id = (int) ($_POST['kategori_id'] ?? 0);
    $poin = trim($_POST['poin'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $status = $_POST['status_aktif'] ?? '1';

    if (
        !$kolom_nama ||
        !$kolom_kategori ||
        !$kolom_poin ||
        !$kolom_deskripsi ||
        !$kolom_status
    ) {
        $error = "Kolom tabel tidak sesuai. Periksa struktur tabel jenis pelanggaran.";

    } elseif (
        $nama === '' ||
        $kategori_id <= 0 ||
        $poin === '' ||
        !ctype_digit($poin) ||
        $deskripsi === '' ||
        !in_array($status, ['0', '1'], true)
    ) {
        $error = "Semua data wajib diisi dengan benar.";

    } else {

        // Pastikan kategori tersedia
        $stmt_cek = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_pelanggaran_kategori WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt_cek, "i", $kategori_id);
        mysqli_stmt_execute($stmt_cek);
        $hasil_cek = mysqli_stmt_get_result($stmt_cek);
        $kategori_ada = mysqli_num_rows($hasil_cek) > 0;
        mysqli_stmt_close($stmt_cek);

        if (!$kategori_ada) {
            $error = "Kategori pelanggaran yang dipilih tidak ditemukan.";

        } else {

            $poin_int = (int) $poin;
            $status_int = (int) $status;

            $sql = "INSERT INTO `$tabel_jenis`
                    (`$kolom_nama`, `$kolom_kategori`, `$kolom_poin`,
                     `$kolom_deskripsi`, `$kolom_status`)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($koneksi, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param(
                    $stmt,
                    "siisi",
                    $nama,
                    $kategori_id,
                    $poin_int,
                    $deskripsi,
                    $status_int
                );

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location: jenis_pelanggaran.php?status=berhasil");
                    exit;
                } else {
                    $error = "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
                    mysqli_stmt_close($stmt);
                }

            } else {
                $error = "Gagal menyiapkan query: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Jenis Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            background: linear-gradient(180deg, #212529 0%, #1a1e21 100%);
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            padding-left: 15px;
        }

        .card {
            border: none;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3 min-vh-100">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i>
                Pelanggaran Siswa
            </h4>

            <!-- MENU ADMIN -->
            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_siswa.php" class="nav-link text-white">
                            <i class="bi bi-people me-2"></i> Data Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="data_guru.php" class="nav-link text-white">
                            <i class="bi bi-person-badge me-2"></i> Data Guru
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kelas.php" class="nav-link text-white">
                            <i class="bi bi-door-open me-2"></i> Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tahun_ajaran.php" class="nav-link text-white">
                            <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="penepatan_siswa.php" class="nav-link text-white">
                            <i class="bi bi-journal-check me-2"></i> Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="wali_kelas.php" class="nav-link text-white">
                            <i class="bi bi-person-workspace me-2"></i> Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kategori_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-tags me-2"></i> Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="jenis_pelanggaran.php" class="nav-link active">
                            <i class="bi bi-list-task me-2"></i> Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="aboutme.php" class="nav-link text-white">
                            <i class="bi bi-info-circle me-2"></i> About Me
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            <?php endif; ?>

            <!-- MENU PETUGAS -->
            <?php if (($_SESSION['role'] ?? '') === 'petugas'): ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="kelas.php" class="nav-link text-white">
                            <i class="bi bi-door-open me-2"></i> Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            <?php endif; ?>

            <!-- MENU GURU -->
            <?php if (($_SESSION['role'] ?? '') === 'guru'): ?>

                <ul class="nav nav-pills flex-column gap-1">

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="catatan_pelanggaran.php" class="nav-link text-white">
                            <i class="bi bi-journal-text me-2"></i> Catatan Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tindakan.php" class="nav-link text-white">
                            <i class="bi bi-clipboard-check me-2"></i> Tindakan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="riwayat.php" class="nav-link text-white">
                            <i class="bi bi-clock-history me-2"></i> Riwayat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="rekap_poin.php" class="nav-link text-white">
                            <i class="bi bi-bar-chart me-2"></i> Rekap Poin
                        </a>
                    </li>

                    <hr class="text-secondary my-3">

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            <?php endif; ?>

        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="fw-bold mb-1">
                Tambah Jenis Pelanggaran
            </h2>

            <p class="text-muted mb-4">
                Silakan isi data jenis pelanggaran dengan lengkap.
            </p>

            <!-- FORM CARD -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= aman($error); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">
                                Nama Jenis Pelanggaran
                            </label>

                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                class="form-control"
                                placeholder="Masukkan nama jenis pelanggaran"
                                value="<?= aman($nama); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label fw-semibold">
                                Kategori Pelanggaran
                            </label>

                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>

                                <?php if ($query_kategori): ?>
                                    <?php while ($kat = mysqli_fetch_assoc($query_kategori)): ?>
                                        <option
                                            value="<?= (int) $kat['id']; ?>"
                                            <?= (string) $kategori_id === (string) $kat['id'] ? 'selected' : ''; ?>>
                                            <?= aman($kat['nama']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="poin" class="form-label fw-semibold">
                                Poin Pelanggaran
                            </label>

                            <input
                                type="number"
                                name="poin"
                                id="poin"
                                class="form-control"
                                min="0"
                                placeholder="Masukkan jumlah poin"
                                value="<?= aman($poin); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                name="deskripsi"
                                id="deskripsi"
                                class="form-control"
                                rows="4"
                                placeholder="Masukkan deskripsi jenis pelanggaran"
                                required><?= aman($deskripsi); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status_aktif" class="form-label fw-semibold">
                                Status
                            </label>

                            <select
                                name="status_aktif"
                                id="status_aktif"
                                class="form-select"
                                required>

                                <option value="1" <?= $status === '1' ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0" <?= $status === '0' ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>
                        </div>

                        <!-- TOMBOL TANPA IKON -->
                        <div class="d-flex gap-2">

                            <a href="jenis_pelanggaran.php" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" name="simpan" class="btn btn-primary">
                                Simpan Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

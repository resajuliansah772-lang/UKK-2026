
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'jenis_pelanggaran';

$error = '';
$kolom_tersedia = [];

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

if ($tabel_jenis == '') {
    die("Tabel jenis pelanggaran tidak ditemukan di database.");
}

// Ambil struktur kolom tabel
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM `$tabel_jenis`");

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

// Fungsi mencari kolom yang sesuai
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

// Ambil kategori pelanggaran
$query_kategori = mysqli_query(
    $koneksi,
    "SELECT * FROM t_pelanggaran_kategori ORDER BY id ASC"
);

// Proses simpan
if (isset($_POST['simpan'])) {

    if (
        !$kolom_nama ||
        !$kolom_kategori ||
        !$kolom_poin ||
        !$kolom_deskripsi ||
        !$kolom_status
    ) {
        $error = "Kolom tabel tidak sesuai. Periksa struktur tabel jenis pelanggaran.";
    } else {

        $nama = trim($_POST['nama'] ?? '');
        $kategori_id = (int) ($_POST['kategori_id'] ?? 0);
        $poin = (int) ($_POST['poin'] ?? 0);
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $status = (int) ($_POST['status_aktif'] ?? 1);

        if ($nama === '' || $kategori_id <= 0 || $poin < 0 || $deskripsi === '') {
            $error = "Mohon isi semua data dengan benar.";
        } else {

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
                    $poin,
                    $deskripsi,
                    $status
                );

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);

                    echo "<script>
                        alert('Data jenis pelanggaran berhasil ditambahkan!');
                        window.location.href='jenis_pelanggaran.php';
                    </script>";
                    exit;
                } else {
                    $error = "Gagal menyimpan data: " .
                        mysqli_stmt_error($stmt);
                }

                mysqli_stmt_close($stmt);
            } else {
                $error = "Gagal menyiapkan query: " .
                    mysqli_error($koneksi);
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

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

            <h4 class="text-white mb-4">
                Pelanggaran Siswa
            </h4>

            <!-- MENU ADMIN -->
            <?php if (($_SESSION['role'] ?? '') == 'admin') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">Dashboard</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa.php"
                       class="nav-link text-white">Data Siswa</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_guru.php"
                       class="nav-link text-white">Data Guru</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link text-white">Kelas</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php"
                       class="nav-link text-white">Tahun Ajaran</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="penempatan_siswa.php"
                       class="nav-link text-white">Penepatan Siswa</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php"
                       class="nav-link text-white">Wali Kelas</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php"
                       class="nav-link text-white">Kategori Pelanggaran</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php"
                       class="nav-link active">Jenis Pelanggaran</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link text-white">Laporan</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="aboutme.php"
                       class="nav-link text-white">About Me</a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

            <?php } ?>

            <!-- MENU PETUGAS -->
            <?php if (($_SESSION['role'] ?? '') == 'petugas') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">Dashboard</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link text-white">Kelas</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link text-white">Laporan</a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

            <?php } ?>

            <!-- MENU GURU -->
            <?php if (($_SESSION['role'] ?? '') == 'guru') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">Dashboard</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="catatan_pelanggaran.php"
                       class="nav-link text-white">Catatan Pelanggaran</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tindakan.php"
                       class="nav-link text-white">Tindakan</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link text-white">Laporan</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="Riwayat.php"
                       class="nav-link text-white">Riwayat</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="rekap_poin.php"
                       class="nav-link text-white">Rekap Poin</a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

            <?php } ?>

        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="mb-4">
                <h2 class="fw-bold mb-1">
                    Tambah Jenis Pelanggaran
                </h2>

                <p class="text-muted small mb-0">
                    Formulir penambahan data jenis pelanggaran siswa.
                </p>
            </div>

            <div class="card border shadow-sm rounded-3 bg-white">
                <div class="card-body p-4">

                    <?php if ($error !== '') { ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error); ?>
                        </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label small text-secondary">
                                Nama Jenis Pelanggaran
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                placeholder="Contoh: Terlambat Masuk Sekolah"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">
                                Kategori ID
                            </label>

                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>

                                <?php
                                if ($query_kategori) {
                                    while ($kat = mysqli_fetch_assoc($query_kategori)) {
                                        $id_kategori = (int) $kat['id'];
                                        $nama_kategori = $kat['nama_kategori']
                                            ?? $kat['nama']
                                            ?? ('Kategori ' . $id_kategori);
                                ?>
                                    <option value="<?= $id_kategori; ?>">
                                        <?= $id_kategori; ?> -
                                        <?= htmlspecialchars($nama_kategori); ?>
                                    </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">
                                Poin
                            </label>

                            <input
                                type="number"
                                name="poin"
                                class="form-control"
                                min="0"
                                placeholder="Contoh: 10"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">
                                Deskripsi
                            </label>

                            <textarea
                                name="deskripsi"
                                class="form-control"
                                rows="4"
                                placeholder="Keterangan singkat jenis pelanggaran"
                                required
                            ></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-secondary">
                                Status
                            </label>

                            <select name="status_aktif" class="form-select" required>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="jenis_pelanggaran.php"
                               class="btn btn-secondary px-3">
                                Batal
                            </a>

                            <button type="submit"
                                    name="simpan"
                                    class="btn btn-primary px-3">
                                Simpan Data
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

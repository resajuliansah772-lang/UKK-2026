<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif di sidebar
$halaman = 'jenis_pelanggaran';

// Ambil ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: jenis_pelanggaran.php");
    exit();
}

$id = (int) $_GET['id'];

// Ambil data jenis pelanggaran
$query_data = mysqli_query(
    $koneksi,
    "SELECT * FROM t_pelanggaran WHERE id = $id"
);

if (!$query_data) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    echo "<script>
        alert('Data jenis pelanggaran tidak ditemukan!');
        window.location.href='jenis_pelanggaran.php';
    </script>";
    exit();
}

// Proses update data
if (isset($_POST['update'])) {

    $kategori_id = (int) $_POST['pelanggaran_kategori_id'];
    $nama = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['nama'])
    );
    $poin = (int) $_POST['poin'];
    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['deskripsi'])
    );
    $status = (int) $_POST['status_aktif'];

    $sql_update = "UPDATE t_pelanggaran SET
                    pelanggaran_kategori_id = $kategori_id,
                    nama = '$nama',
                    poin = $poin,
                    deskripsi = '$deskripsi',
                    status_aktif = $status
                   WHERE id = $id";

    if (mysqli_query($koneksi, $sql_update)) {
        echo "<script>
            alert('Data jenis pelanggaran berhasil diperbarui!');
            window.location.href='jenis_pelanggaran.php';
        </script>";
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}

// Ambil data kategori untuk pilihan dropdown
$query_kategori = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_pelanggaran_kategori
     ORDER BY nama ASC"
);

if (!$query_kategori) {
    die("Gagal mengambil kategori: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Jenis Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

            <h4 class="text-white mb-4">
                Pelanggaran Siswa
            </h4>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa.php"
                       class="nav-link <?php echo ($halaman == 'siswa') ? 'active' : 'text-white'; ?>">
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_guru.php"
                       class="nav-link <?php echo ($halaman == 'guru') ? 'active' : 'text-white'; ?>">
                        Data Guru
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php"
                       class="nav-link <?php echo ($halaman == 'tahun_ajaran') ? 'active' : 'text-white'; ?>">
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="penempatan_siswa.php"
                       class="nav-link <?php echo ($halaman == 'penempatan_siswa') ? 'active' : 'text-white'; ?>">
                        Penepatan Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php"
                       class="nav-link <?php echo ($halaman == 'wali_kelas') ? 'active' : 'text-white'; ?>">
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php"
                       class="nav-link <?php echo ($halaman == 'kategori_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php"
                       class="nav-link <?php echo ($halaman == 'jenis_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                        Laporan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="aboutme.php"
                       class="nav-link <?php echo ($halaman == 'about') ? 'active' : 'text-white'; ?>">
                        About Me
                    </a>
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
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'petugas') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link <?php echo ($halaman == 'kelas') ? 'active' : 'text-white'; ?>">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                        Laporan
                    </a>
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
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'guru') { ?>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link <?php echo ($halaman == 'dashboard') ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="catatan_pelanggaran.php"
                       class="nav-link <?php echo ($halaman == 'catatan_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Catatan Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tindakan.php"
                       class="nav-link <?php echo ($halaman == 'tindakan') ? 'active' : 'text-white'; ?>">
                        Tindakan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link <?php echo ($halaman == 'laporan') ? 'active' : 'text-white'; ?>">
                        Laporan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="Riwayat.php"
                       class="nav-link <?php echo ($halaman == 'riwayat') ? 'active' : 'text-white'; ?>">
                        Riwayat
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="rekap_poin.php"
                       class="nav-link <?php echo ($halaman == 'rekap_poin') ? 'active' : 'text-white'; ?>">
                        Rekap Poin
                    </a>
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

            <h2 class="fw-bold mb-1">Edit Jenis Pelanggaran</h2>
            <p class="text-muted small mb-4">
                Ubah informasi jenis pelanggaran.
            </p>

            <div class="card border-1 border-secondary-subtle shadow-sm p-4 rounded-3 bg-white">

                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4"
                         role="alert">
                        <?= htmlspecialchars($error); ?>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form action="" method="POST">

                    <!-- NAMA JENIS PELANGGARAN -->
                    <div class="mb-3">
                        <label for="nama" class="form-label small text-secondary">
                            Nama Jenis Pelanggaran
                        </label>

                        <input type="text"
                               class="form-control"
                               id="nama"
                               name="nama"
                               value="<?= htmlspecialchars($data['nama'] ?? ''); ?>"
                               required>
                    </div>

                    <!-- KATEGORI -->
                    <div class="mb-3">
                        <label for="pelanggaran_kategori_id"
                               class="form-label small text-secondary">
                            Kategori Pelanggaran
                        </label>

                        <select class="form-select"
                                id="pelanggaran_kategori_id"
                                name="pelanggaran_kategori_id"
                                required>

                            <option value="">-- Pilih Kategori --</option>

                            <?php while ($kategori = mysqli_fetch_assoc($query_kategori)) { ?>
                                <option value="<?= (int) $kategori['id']; ?>"
                                    <?= ((int) ($data['pelanggaran_kategori_id'] ?? 0) === (int) $kategori['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($kategori['nama']); ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>

                    <!-- POIN -->
                    <div class="mb-3">
                        <label for="poin" class="form-label small text-secondary">
                            Poin Pelanggaran
                        </label>

                        <input type="number"
                               class="form-control"
                               id="poin"
                               name="poin"
                               min="0"
                               value="<?= (int) ($data['poin'] ?? 0); ?>"
                               required>
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="mb-3">
                        <label for="deskripsi"
                               class="form-label small text-secondary">
                            Deskripsi
                        </label>

                        <textarea class="form-control"
                                  id="deskripsi"
                                  name="deskripsi"
                                  rows="3"
                                  required><?= htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-4">
                        <label for="status_aktif"
                               class="form-label small text-secondary">
                            Status
                        </label>

                        <select class="form-select"
                                id="status_aktif"
                                name="status_aktif"
                                required>
                            <option value="1"
                                <?= ((int) $data['status_aktif'] === 1) ? 'selected' : ''; ?>>
                                Aktif
                            </option>

                            <option value="0"
                                <?= ((int) $data['status_aktif'] === 0) ? 'selected' : ''; ?>>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <!-- TOMBOL -->
                    <div class="d-flex gap-2">
                        <a href="jenis_pelanggaran.php"
                           class="btn btn-secondary px-3">
                            Batal
                        </a>

                        <button type="submit"
                                name="update"
                                class="btn btn-primary px-3">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

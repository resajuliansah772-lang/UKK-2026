
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Fungsi keamanan output
function aman($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

// Ambil ID dari URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: wali_kelas.php");
    exit;
}

// Deteksi kolom nama tahun ajaran
$kolomTahun = "id";

$cekKolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_tahun_ajaran");

if (!$cekKolom) {
    die("Gagal membaca kolom tahun ajaran: " . mysqli_error($koneksi));
}

$daftarKolom = [];

while ($kolom = mysqli_fetch_assoc($cekKolom)) {
    $daftarKolom[] = $kolom['Field'];
}

foreach (['nama_tahun_ajaran', 'nama', 'tahun_ajaran', 'tahun'] as $calon) {
    if (in_array($calon, $daftarKolom, true)) {
        $kolomTahun = $calon;
        break;
    }
}

// Ambil data wali kelas
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_wali_kelas WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

mysqli_stmt_close($stmt);

if (!$data) {
    echo "<script>
        alert('Data wali kelas tidak ditemukan!');
        window.location='wali_kelas.php';
    </script>";
    exit;
}

$pesan = "";

// Nilai awal form
$guru_id = $data['guru_id'];
$kelas_id = $data['kelas_id'];
$tahun_ajaran_id = $data['tahun_ajaran_id'];
$tanggal_mulai = $data['tanggal_mulai'] ?? "";
$tanggal_selesai = $data['tanggal_selesai'] ?? "";
$status_aktif = (string) $data['status_aktif'];

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $guru_id = filter_input(INPUT_POST, 'guru_id', FILTER_VALIDATE_INT);
    $kelas_id = filter_input(INPUT_POST, 'kelas_id', FILTER_VALIDATE_INT);
    $tahun_ajaran_id = filter_input(INPUT_POST, 'tahun_ajaran_id', FILTER_VALIDATE_INT);

    $tanggal_mulai = trim($_POST['tanggal_mulai'] ?? '');
    $tanggal_selesai = trim($_POST['tanggal_selesai'] ?? '');
    $status_aktif = $_POST['status_aktif'] ?? '';

    // Validasi pilihan
    if (
        !$guru_id ||
        !$kelas_id ||
        !$tahun_ajaran_id ||
        !in_array($status_aktif, ['0', '1'], true) ||
        $tanggal_mulai === ''
    ) {

        $pesan = "Guru, kelas, tahun ajaran, tanggal mulai, dan status wajib diisi dengan benar.";

    } elseif (
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_mulai) ||
        !checkdate(
            (int) substr($tanggal_mulai, 5, 2),
            (int) substr($tanggal_mulai, 8, 2),
            (int) substr($tanggal_mulai, 0, 4)
        ) ||
        ($tanggal_selesai !== '' && (
            !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_selesai) ||
            !checkdate(
                (int) substr($tanggal_selesai, 5, 2),
                (int) substr($tanggal_selesai, 8, 2),
                (int) substr($tanggal_selesai, 0, 4)
            )
        ))
    ) {

        $pesan = "Format tanggal tidak valid.";

    } elseif (
        $tanggal_selesai !== '' &&
        $tanggal_selesai < $tanggal_mulai
    ) {

        $pesan = "Tanggal selesai tidak boleh sebelum tanggal mulai.";

    } else {

        // Validasi guru, kelas, dan tahun ajaran
        $stmt_validasi = mysqli_prepare(
            $koneksi,
            "SELECT
                (SELECT COUNT(*) FROM t_guru WHERE id = ?) AS jumlah_guru,
                (SELECT COUNT(*) FROM t_kelas WHERE id = ?) AS jumlah_kelas,
                (SELECT COUNT(*) FROM t_tahun_ajaran WHERE id = ?) AS jumlah_ta"
        );

        mysqli_stmt_bind_param(
            $stmt_validasi,
            "iii",
            $guru_id,
            $kelas_id,
            $tahun_ajaran_id
        );

        mysqli_stmt_execute($stmt_validasi);

        $hasil_validasi = mysqli_stmt_get_result($stmt_validasi);
        $validasi = mysqli_fetch_assoc($hasil_validasi);

        mysqli_stmt_close($stmt_validasi);

        if (
            (int) $validasi['jumlah_guru'] === 0 ||
            (int) $validasi['jumlah_kelas'] === 0 ||
            (int) $validasi['jumlah_ta'] === 0
        ) {

            $pesan = "Guru, kelas, atau tahun ajaran yang dipilih tidak ditemukan.";

        } else {

            // Cek wali kelas aktif lainnya
            $sudah_ada = false;

            if ($status_aktif === '1') {

                $stmt_cek = mysqli_prepare(
                    $koneksi,
                    "SELECT id
                     FROM t_wali_kelas
                     WHERE kelas_id = ?
                       AND tahun_ajaran_id = ?
                       AND status_aktif = 1
                       AND id != ?
                     LIMIT 1"
                );

                mysqli_stmt_bind_param(
                    $stmt_cek,
                    "iii",
                    $kelas_id,
                    $tahun_ajaran_id,
                    $id
                );

                mysqli_stmt_execute($stmt_cek);

                $hasil_cek = mysqli_stmt_get_result($stmt_cek);
                $sudah_ada = mysqli_num_rows($hasil_cek) > 0;

                mysqli_stmt_close($stmt_cek);
            }

            if ($sudah_ada) {

                $pesan = "Kelas tersebut sudah memiliki wali kelas aktif pada tahun ajaran yang dipilih.";

            } else {

                // Update data wali kelas
                $sqlUpdate = "
                    UPDATE t_wali_kelas
                    SET
                        guru_id = ?,
                        kelas_id = ?,
                        tahun_ajaran_id = ?,
                        tanggal_mulai = ?,
                        tanggal_selesai = ?,
                        status_aktif = ?
                    WHERE id = ?
                ";

                $stmtUpdate = mysqli_prepare($koneksi, $sqlUpdate);

                if (!$stmtUpdate) {
                    die("Gagal menyiapkan update: " . mysqli_error($koneksi));
                }

                $mulai = $tanggal_mulai;
                $selesai = ($tanggal_selesai !== '')
                    ? $tanggal_selesai
                    : null;

                $status_int = (int) $status_aktif;

                mysqli_stmt_bind_param(
                    $stmtUpdate,
                    "iiissii",
                    $guru_id,
                    $kelas_id,
                    $tahun_ajaran_id,
                    $mulai,
                    $selesai,
                    $status_int,
                    $id
                );

                if (mysqli_stmt_execute($stmtUpdate)) {

                    mysqli_stmt_close($stmtUpdate);

                    header("Location: wali_kelas.php?status=berhasil");
                    exit;

                } else {

                    $pesan = "Gagal memperbarui data: " . mysqli_stmt_error($stmtUpdate);

                    mysqli_stmt_close($stmtUpdate);
                }
            }
        }
    }
}

// Ambil pilihan guru, kelas, dan tahun ajaran
$guru = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_guru ORDER BY nama ASC"
);

$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama, tingkat, jurusan
     FROM t_kelas
     ORDER BY tingkat ASC, nama ASC"
);

$tahun = mysqli_query(
    $koneksi,
    "SELECT id, `$kolomTahun` AS nama_tahun
     FROM t_tahun_ajaran
     ORDER BY id DESC"
);

if (!$guru || !$kelas || !$tahun) {
    die("Gagal mengambil data pilihan: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Wali Kelas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
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

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_siswa.php" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i>
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_guru.php" class="nav-link text-white">
                        <i class="bi bi-person-badge me-2"></i>
                        Data Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelas.php" class="nav-link text-white">
                        <i class="bi bi-door-open me-2"></i>
                        Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tahun_ajaran.php" class="nav-link text-white">
                        <i class="bi bi-calendar-range me-2"></i>
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penepatan_siswa.php" class="nav-link text-white">
                        <i class="bi bi-journal-check me-2"></i>
                        Penempatan Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="wali_kelas.php" class="nav-link active">
                        <i class="bi bi-person-workspace me-2"></i>
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-tags me-2"></i>
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-list-task me-2"></i>
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php" class="nav-link text-white">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="aboutme.php" class="nav-link text-white">
                        <i class="bi bi-info-circle me-2"></i>
                        About Me
                    </a>
                </li>

                <hr class="text-secondary my-3">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="fw-bold mb-1">
                Edit Wali Kelas
            </h2>

            <p class="text-muted mb-4">
                Silakan perbarui data penugasan guru sebagai wali kelas.
            </p>

            <!-- PESAN ERROR -->
            <?php if ($pesan !== ''): ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <?= aman($pesan); ?>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <form method="POST" action="">

                        <!-- NAMA GURU -->
                        <div class="mb-3">

                            <label for="guru_id" class="form-label fw-semibold">
                                Nama Guru
                            </label>

                            <select name="guru_id" id="guru_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Guru --
                                </option>

                                <?php while ($g = mysqli_fetch_assoc($guru)): ?>

                                    <option
                                        value="<?= (int) $g['id']; ?>"
                                        <?= (int) $guru_id === (int) $g['id'] ? 'selected' : ''; ?>>

                                        <?= aman($g['nama']); ?>

                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- KELAS -->
                        <div class="mb-3">

                            <label for="kelas_id" class="form-label fw-semibold">
                                Nama Kelas
                            </label>

                            <select name="kelas_id" id="kelas_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Kelas --
                                </option>

                                <?php while ($k = mysqli_fetch_assoc($kelas)): ?>

                                    <option
                                        value="<?= (int) $k['id']; ?>"
                                        <?= (int) $kelas_id === (int) $k['id'] ? 'selected' : ''; ?>>

                                        <?= aman($k['nama']); ?>
                                        <?= !empty($k['tingkat']) ? ' - ' . aman($k['tingkat']) : ''; ?>
                                        <?= !empty($k['jurusan']) ? ' ' . aman($k['jurusan']) : ''; ?>

                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- TAHUN AJARAN -->
                        <div class="mb-3">

                            <label for="tahun_ajaran_id" class="form-label fw-semibold">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Tahun Ajaran --
                                </option>

                                <?php while ($t = mysqli_fetch_assoc($tahun)): ?>

                                    <option
                                        value="<?= (int) $t['id']; ?>"
                                        <?= (int) $tahun_ajaran_id === (int) $t['id'] ? 'selected' : ''; ?>>

                                        <?= aman($t['nama_tahun']); ?>

                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- TANGGAL MULAI -->
                        <div class="mb-3">

                            <label for="tanggal_mulai" class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                id="tanggal_mulai"
                                class="form-control"
                                value="<?= aman($tanggal_mulai); ?>"
                                required>

                        </div>

                        <!-- TANGGAL SELESAI -->
                        <div class="mb-3">

                            <label for="tanggal_selesai" class="form-label fw-semibold">
                                Tanggal Selesai
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                id="tanggal_selesai"
                                class="form-control"
                                value="<?= aman($tanggal_selesai); ?>">

                        </div>

                        <!-- STATUS -->
                        <div class="mb-3">

                            <label for="status_aktif" class="form-label fw-semibold">
                                Status Penugasan
                            </label>

                            <select name="status_aktif" id="status_aktif" class="form-select" required>

                                <option value="1" <?= $status_aktif === '1' ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0" <?= $status_aktif === '0' ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                        <!-- TOMBOL -->
                        <div class="d-flex gap-2">

                            <a href="wali_kelas.php" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                Simpan Perubahan
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

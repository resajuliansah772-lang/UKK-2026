<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

function aman($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: wali_kelas.php");
    exit;
}

// Deteksi kolom nama tahun ajaran yang tersedia
$kolomTahun = "id";
$cekKolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_tahun_ajaran");

if ($cekKolom) {
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
}

// Ambil data wali kelas
$stmt = mysqli_prepare($koneksi, "
    SELECT *
    FROM t_wali_kelas
    WHERE id = ?
");
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

// Simpan perubahan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guru_id = filter_input(INPUT_POST, 'guru_id', FILTER_VALIDATE_INT);
    $kelas_id = filter_input(INPUT_POST, 'kelas_id', FILTER_VALIDATE_INT);
    $tahun_ajaran_id = filter_input(INPUT_POST, 'tahun_ajaran_id', FILTER_VALIDATE_INT);
    $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
    $status_aktif = isset($_POST['status_aktif']) ? (int) $_POST['status_aktif'] : -1;

    if (
        !$guru_id || !$kelas_id || !$tahun_ajaran_id ||
        !in_array($status_aktif, [0, 1], true) ||
        ($tanggal_mulai !== '' && $tanggal_selesai !== '' &&
        $tanggal_selesai < $tanggal_mulai)
    ) {
        $pesan = "Periksa kembali data yang diisi. Tanggal selesai tidak boleh sebelum tanggal mulai.";
    } else {
        // Pastikan guru, kelas, dan tahun ajaran tersedia
        $valid = true;

        foreach ([
            ['t_guru', $guru_id],
            ['t_kelas', $kelas_id],
            ['t_tahun_ajaran', $tahun_ajaran_id]
        ] as $item) {
            $sqlCek = "SELECT id FROM " . $item[0] . " WHERE id = ?";
            $stmtCek = mysqli_prepare($koneksi, $sqlCek);
            mysqli_stmt_bind_param($stmtCek, "i", $item[1]);
            mysqli_stmt_execute($stmtCek);
            $hasilCek = mysqli_stmt_get_result($stmtCek);

            if (mysqli_num_rows($hasilCek) === 0) {
                $valid = false;
            }

            mysqli_stmt_close($stmtCek);
        }

        if (!$valid) {
            $pesan = "Guru, kelas, atau tahun ajaran yang dipilih tidak ditemukan.";
        } else {
            $mulai = $tanggal_mulai !== '' ? $tanggal_mulai : null;
            $selesai = $tanggal_selesai !== '' ? $tanggal_selesai : null;

            $sqlUpdate = "
                UPDATE t_wali_kelas
                SET guru_id = ?,
                    kelas_id = ?,
                    tahun_ajaran_id = ?,
                    tanggal_mulai = ?,
                    tanggal_selesai = ?,
                    status_aktif = ?
                WHERE id = ?
            ";

            $stmtUpdate = mysqli_prepare($koneksi, $sqlUpdate);
            mysqli_stmt_bind_param(
                $stmtUpdate,
                "iiissii",
                $guru_id,
                $kelas_id,
                $tahun_ajaran_id,
                $mulai,
                $selesai,
                $status_aktif,
                $id
            );

            if (mysqli_stmt_execute($stmtUpdate)) {
                mysqli_stmt_close($stmtUpdate);
                header("Location: wali_kelas.php?status=berhasil");
                exit;
            } else {
                $pesan = "Gagal memperbarui data wali kelas.";
            }

            mysqli_stmt_close($stmtUpdate);
        }
    }

    // Pertahankan nilai yang baru diisi jika validasi gagal
    $data['guru_id'] = $guru_id ?: $data['guru_id'];
    $data['kelas_id'] = $kelas_id ?: $data['kelas_id'];
    $data['tahun_ajaran_id'] = $tahun_ajaran_id ?: $data['tahun_ajaran_id'];
    $data['tanggal_mulai'] = $tanggal_mulai;
    $data['tanggal_selesai'] = $tanggal_selesai;
    $data['status_aktif'] = $status_aktif;
}

// Ambil pilihan guru, kelas, dan tahun ajaran
$guru = mysqli_query($koneksi, "SELECT id, nama FROM t_guru ORDER BY nama ASC");
$kelas = mysqli_query($koneksi, "SELECT id, nama, tingkat, jurusan FROM t_kelas ORDER BY nama ASC");
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, `$kolomTahun` AS nama_tahun FROM t_tahun_ajaran ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Wali Kelas</title>
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
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100 sidebar">
            <h4 class="text-white mb-4">
                Pelanggaran Siswa
            </h4>

            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link text-white">Data Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="data_guru.php" class="nav-link text-white">Data Guru</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link text-white">Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php" class="nav-link text-white">Tahun Ajaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="penepatan_siswa.php" class="nav-link text-white">Penepatan Siswa</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link active" aria-current="page">Wali Kelas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">Kategori Pelanggaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">Jenis Pelanggaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">Laporan</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link text-white">About Me</a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Edit Data Wali Kelas</h2>
            <p class="text-muted">
                Form perbarui penugasan guru sebagai wali kelas.
            </p>

            <?php if ($pesan !== ''): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= aman($pesan) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nama Guru</label>
                            <select name="guru_id" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php while ($g = mysqli_fetch_assoc($guru)): ?>
                                    <option value="<?= (int) $g['id'] ?>"
                                        <?= (int) $data['guru_id'] === (int) $g['id'] ? 'selected' : '' ?>>
                                        <?= aman($g['nama']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php while ($k = mysqli_fetch_assoc($kelas)): ?>
                                    <option value="<?= (int) $k['id'] ?>"
                                        <?= (int) $data['kelas_id'] === (int) $k['id'] ? 'selected' : '' ?>>
                                        <?= aman($k['nama']) ?>
                                        <?= isset($k['tingkat']) ? ' - ' . aman($k['tingkat']) : '' ?>
                                        <?= !empty($k['jurusan']) ? ' ' . aman($k['jurusan']) : '' ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <?php while ($t = mysqli_fetch_assoc($tahun)): ?>
                                    <option value="<?= (int) $t['id'] ?>"
                                        <?= (int) $data['tahun_ajaran_id'] === (int) $t['id'] ? 'selected' : '' ?>>
                                        <?= aman($t['nama_tahun']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai"
                                    class="form-control"
                                    value="<?= aman($data['tanggal_mulai'] ?? '') ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai"
                                    class="form-control"
                                    value="<?= aman($data['tanggal_selesai'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1" <?= (int) $data['status_aktif'] === 1 ? 'selected' : '' ?>>
                                    Aktif
                                </option>
                                <option value="0" <?= (int) $data['status_aktif'] === 0 ? 'selected' : '' ?>>
                                    Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="wali_kelas.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
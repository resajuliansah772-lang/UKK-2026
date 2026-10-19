
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$pesan = "";
$jenis_pesan = "danger";

// Mengambil data siswa
$sql_siswa = "SELECT id, nis, nama
              FROM t_siswa
              WHERE status_aktif = 1
              ORDER BY nama ASC";

$query_siswa = mysqli_query($koneksi, $sql_siswa);

if (!$query_siswa) {
    die("Gagal mengambil data siswa: " . mysqli_error($koneksi));
}

// Mengambil data kelas
$sql_kelas = "SELECT id, nama
              FROM t_kelas
              ORDER BY nama ASC";

$query_kelas = mysqli_query($koneksi, $sql_kelas);

if (!$query_kelas) {
    die("Gagal mengambil data kelas: " . mysqli_error($koneksi));
}

// Proses simpan penempatan siswa
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $siswa_id = filter_input(INPUT_POST, "siswa_id", FILTER_VALIDATE_INT);
    $kelas_id = filter_input(INPUT_POST, "kelas_id", FILTER_VALIDATE_INT);

    if (!$siswa_id || !$kelas_id) {

        $pesan = "Siswa dan kelas wajib dipilih.";

    } else {

        // Pastikan siswa aktif
        $stmt_siswa = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_siswa
             WHERE id = ? AND status_aktif = 1"
        );

        mysqli_stmt_bind_param($stmt_siswa, "i", $siswa_id);
        mysqli_stmt_execute($stmt_siswa);
        $hasil_siswa = mysqli_stmt_get_result($stmt_siswa);
        $siswa_valid = mysqli_num_rows($hasil_siswa) > 0;
        mysqli_stmt_close($stmt_siswa);

        // Pastikan kelas tersedia
        $stmt_kelas = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_kelas WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt_kelas, "i", $kelas_id);
        mysqli_stmt_execute($stmt_kelas);
        $hasil_kelas = mysqli_stmt_get_result($stmt_kelas);
        $kelas_valid = mysqli_num_rows($hasil_kelas) > 0;
        mysqli_stmt_close($stmt_kelas);

        if (!$siswa_valid) {

            $pesan = "Siswa tidak ditemukan atau sudah tidak aktif.";

        } elseif (!$kelas_valid) {

            $pesan = "Kelas yang dipilih tidak ditemukan.";

        } else {

            // Cek apakah siswa sudah memiliki penempatan
            $stmt_cek = mysqli_prepare(
                $koneksi,
                "SELECT siswa_id
                 FROM t_kelas_siswa
                 WHERE siswa_id = ?
                 LIMIT 1"
            );

            mysqli_stmt_bind_param($stmt_cek, "i", $siswa_id);
            mysqli_stmt_execute($stmt_cek);
            $hasil_cek = mysqli_stmt_get_result($stmt_cek);
            $sudah_ada = mysqli_num_rows($hasil_cek) > 0;
            mysqli_stmt_close($stmt_cek);

            if ($sudah_ada) {

                $pesan = "Siswa tersebut sudah memiliki penempatan kelas.";

            } else {

                // Simpan penempatan
                $stmt_simpan = mysqli_prepare(
                    $koneksi,
                    "INSERT INTO t_kelas_siswa (siswa_id, kelas_id)
                     VALUES (?, ?)"
                );

                mysqli_stmt_bind_param(
                    $stmt_simpan,
                    "ii",
                    $siswa_id,
                    $kelas_id
                );

                if (mysqli_stmt_execute($stmt_simpan)) {

                    mysqli_stmt_close($stmt_simpan);

                    header("Location: penepatan_siswa.php?status=berhasil");
                    exit;

                } else {

                    $pesan = "Gagal menyimpan data penempatan.";
                    mysqli_stmt_close($stmt_simpan);
                }
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

    <title>Tambah Penempatan Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Tambah Penempatan Siswa</h4>
                </div>

                <div class="card-body p-4">

                    <p class="text-muted">
                        Pilih siswa dan kelas yang akan ditempati.
                    </p>

                    <?php if ($pesan !== ""): ?>
                        <div class="alert alert-<?= htmlspecialchars($jenis_pesan) ?>">
                            <?= htmlspecialchars($pesan) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">

                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">
                                Nama Siswa
                            </label>

                            <select name="siswa_id" id="siswa_id"
                                    class="form-select" required>

                                <option value="">-- Pilih Siswa --</option>

                                <?php while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>
                                    <option
                                        value="<?= (int) $siswa['id'] ?>"
                                        <?= (isset($siswa_id) &&
                                            (int) $siswa_id === (int) $siswa['id'])
                                            ? 'selected' : '' ?>>

                                        <?= htmlspecialchars($siswa['nis']) ?>
                                        - 
                                        <?= htmlspecialchars($siswa['nama']) ?>

                                    </option>
                                <?php endwhile; ?>

                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="kelas_id" class="form-label">
                                Nama Kelas
                            </label>

                            <select name="kelas_id" id="kelas_id"
                                    class="form-select" required>

                                <option value="">-- Pilih Kelas --</option>

                                <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>
                                    <option
                                        value="<?= (int) $kelas['id'] ?>"
                                        <?= (isset($kelas_id) &&
                                            (int) $kelas_id === (int) $kelas['id'])
                                            ? 'selected' : '' ?>>

                                        <?= htmlspecialchars($kelas['nama']) ?>

                                    </option>
                                <?php endwhile; ?>

                            </select>
                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="penepatan_siswa.php"
                               class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Simpan Penempatan
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

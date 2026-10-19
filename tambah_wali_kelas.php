
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$pesan = "";
$jenis_pesan = "danger";

// Deteksi kolom nama tahun ajaran yang tersedia
$kolom_ta = [];
$hasil_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM t_tahun_ajaran");

if (!$hasil_kolom) {
    die("Gagal membaca tabel tahun ajaran: " . mysqli_error($koneksi));
}

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_ta[] = $kolom['Field'];
}

$pilihan_kolom = [
    'nama_tahun_ajaran',
    'nama',
    'tahun_ajaran',
    'tahun'
];

$kolom_nama_ta = null;

foreach ($pilihan_kolom as $nama_kolom) {
    if (in_array($nama_kolom, $kolom_ta, true)) {
        $kolom_nama_ta = $nama_kolom;
        break;
    }
}

$select_ta = $kolom_nama_ta
    ? "`" . $kolom_nama_ta . "` AS nama_tahun_ajaran"
    : "id AS nama_tahun_ajaran";

// Ambil data guru
$query_guru = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_guru ORDER BY nama ASC"
);

if (!$query_guru) {
    die("Gagal mengambil data guru: " . mysqli_error($koneksi));
}

// Ambil data kelas
$query_kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama, tingkat, jurusan
     FROM t_kelas
     ORDER BY nama ASC"
);

if (!$query_kelas) {
    die("Gagal mengambil data kelas: " . mysqli_error($koneksi));
}

// Ambil data tahun ajaran
$query_ta = mysqli_query(
    $koneksi,
    "SELECT id, $select_ta
     FROM t_tahun_ajaran
     ORDER BY id DESC"
);

if (!$query_ta) {
    die("Gagal mengambil tahun ajaran: " . mysqli_error($koneksi));
}

// Nilai awal form
$guru_id = "";
$kelas_id = "";
$tahun_ajaran_id = "";
$tanggal_mulai = "";
$tanggal_selesai = "";
$status_aktif = "1";

// Proses penyimpanan
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $guru_id = filter_input(INPUT_POST, "guru_id", FILTER_VALIDATE_INT);
    $kelas_id = filter_input(INPUT_POST, "kelas_id", FILTER_VALIDATE_INT);
    $tahun_ajaran_id = filter_input(
        INPUT_POST,
        "tahun_ajaran_id",
        FILTER_VALIDATE_INT
    );

    $tanggal_mulai = trim($_POST["tanggal_mulai"] ?? "");
    $tanggal_selesai = trim($_POST["tanggal_selesai"] ?? "");
    $status_aktif = $_POST["status_aktif"] ?? "1";

    if (
        !$guru_id ||
        !$kelas_id ||
        !$tahun_ajaran_id ||
        $tanggal_mulai === "" ||
        $tanggal_selesai === "" ||
        !in_array($status_aktif, ["0", "1"], true)
    ) {
        $pesan = "Semua kolom wajib diisi dengan benar.";

    } elseif (
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_mulai) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_selesai) ||
        !checkdate(
            (int) substr($tanggal_mulai, 5, 2),
            (int) substr($tanggal_mulai, 8, 2),
            (int) substr($tanggal_mulai, 0, 4)
        ) ||
        !checkdate(
            (int) substr($tanggal_selesai, 5, 2),
            (int) substr($tanggal_selesai, 8, 2),
            (int) substr($tanggal_selesai, 0, 4)
        )
    ) {
        $pesan = "Format tanggal tidak valid.";

    } elseif ($tanggal_selesai < $tanggal_mulai) {
        $pesan = "Tanggal selesai tidak boleh sebelum tanggal mulai.";

    } else {

        // Pastikan guru, kelas, dan tahun ajaran benar-benar tersedia
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
            (int) $validasi["jumlah_guru"] === 0 ||
            (int) $validasi["jumlah_kelas"] === 0 ||
            (int) $validasi["jumlah_ta"] === 0
        ) {
            $pesan = "Guru, kelas, atau tahun ajaran tidak ditemukan.";

        } else {

            // Cegah dua wali kelas aktif untuk kelas dan tahun ajaran sama
            if ($status_aktif === "1") {

                $stmt_cek = mysqli_prepare(
                    $koneksi,
                    "SELECT id
                     FROM t_wali_kelas
                     WHERE kelas_id = ?
                       AND tahun_ajaran_id = ?
                       AND status_aktif = 1
                     LIMIT 1"
                );

                mysqli_stmt_bind_param(
                    $stmt_cek,
                    "ii",
                    $kelas_id,
                    $tahun_ajaran_id
                );

                mysqli_stmt_execute($stmt_cek);
                $hasil_cek = mysqli_stmt_get_result($stmt_cek);
                $sudah_ada = mysqli_num_rows($hasil_cek) > 0;
                mysqli_stmt_close($stmt_cek);

            } else {
                $sudah_ada = false;
            }

            if ($sudah_ada) {

                $pesan = "Kelas tersebut sudah memiliki wali kelas aktif pada tahun ajaran yang dipilih.";

            } else {

                $stmt_simpan = mysqli_prepare(
                    $koneksi,
                    "INSERT INTO t_wali_kelas
                        (
                            guru_id,
                            kelas_id,
                            tahun_ajaran_id,
                            tanggal_mulai,
                            tanggal_selesai,
                            status_aktif
                        )
                     VALUES (?, ?, ?, ?, ?, ?)"
                );

                if (!$stmt_simpan) {
                    die("Gagal menyiapkan penyimpanan: " .
                        mysqli_error($koneksi));
                }

                $status_int = (int) $status_aktif;

                mysqli_stmt_bind_param(
                    $stmt_simpan,
                    "iiissi",
                    $guru_id,
                    $kelas_id,
                    $tahun_ajaran_id,
                    $tanggal_mulai,
                    $tanggal_selesai,
                    $status_int
                );

                if (mysqli_stmt_execute($stmt_simpan)) {

                    mysqli_stmt_close($stmt_simpan);

                    header("Location: wali_kelas.php?status=berhasil");
                    exit;

                } else {

                    $pesan = "Gagal menyimpan data: " .
                        mysqli_stmt_error($stmt_simpan);

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

    <title>Tambah Wali Kelas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Tambah Wali Kelas</h4>
                </div>

                <div class="card-body p-4">

                    <p class="text-muted">
                        Form penugasan guru sebagai wali kelas.
                    </p>

                    <?php if ($pesan !== ""): ?>
                        <div class="alert alert-<?= htmlspecialchars($jenis_pesan) ?>">
                            <?= htmlspecialchars($pesan) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="tambah_wali_kelas.php">

                        <div class="mb-3">
                            <label for="guru_id" class="form-label">
                                Nama Guru
                            </label>

                            <select name="guru_id" id="guru_id"
                                    class="form-select" required>
                                <option value="">-- Pilih Guru --</option>

                                <?php while ($guru = mysqli_fetch_assoc($query_guru)): ?>
                                    <option
                                        value="<?= (int) $guru['id'] ?>"
                                        <?= (string) $guru_id === (string) $guru['id']
                                            ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($guru['nama']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">
                                Kelas
                            </label>

                            <select name="kelas_id" id="kelas_id"
                                    class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>

                                <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>
                                    <option
                                        value="<?= (int) $kelas['id'] ?>"
                                        <?= (string) $kelas_id === (string) $kelas['id']
                                            ? 'selected' : '' ?>>

                                        <?= htmlspecialchars(
                                            trim(
                                                $kelas['nama'] . ' ' .
                                                ($kelas['tingkat'] ?? '') . ' ' .
                                                ($kelas['jurusan'] ?? '')
                                            )
                                        ) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran_id"
                                    id="tahun_ajaran_id"
                                    class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>

                                <?php while ($ta = mysqli_fetch_assoc($query_ta)): ?>
                                    <option
                                        value="<?= (int) $ta['id'] ?>"
                                        <?= (string) $tahun_ajaran_id === (string) $ta['id']
                                            ? 'selected' : '' ?>>
                                        <?= htmlspecialchars(
                                            (string) $ta['nama_tahun_ajaran']
                                        ) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">
                                    Tanggal Mulai
                                </label>

                                <input type="date"
                                       name="tanggal_mulai"
                                       id="tanggal_mulai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($tanggal_mulai) ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_selesai" class="form-label">
                                    Tanggal Selesai
                                </label>

                                <input type="date"
                                       name="tanggal_selesai"
                                       id="tanggal_selesai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($tanggal_selesai) ?>"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status_aktif" class="form-label">
                                Status Penugasan
                            </label>

                            <select name="status_aktif"
                                    id="status_aktif"
                                    class="form-select" required>
                                <option value="1"
                                    <?= $status_aktif === "1" ? "selected" : "" ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= $status_aktif === "0" ? "selected" : "" ?>>
                                    Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between gap-2">
                            <a href="wali_kelas.php"
                               class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Simpan Wali Kelas
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

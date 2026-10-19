
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

$pesan = "";

// Proses penghapusan setelah konfirmasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPost = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$idPost || $idPost !== $id) {
        header("Location: wali_kelas.php");
        exit;
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "DELETE FROM t_wali_kelas WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $idPost);

    if (mysqli_stmt_execute($stmt)) {
        $terhapus = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($terhapus > 0) {
            header("Location: wali_kelas.php?status=hapus");
            exit;
        }

        header("Location: wali_kelas.php?status=tidak_ditemukan");
        exit;
    } else {
        $pesan = "Data gagal dihapus. Periksa apakah data ini digunakan oleh tabel lain.";
        mysqli_stmt_close($stmt);
    }
}

// Ambil data untuk konfirmasi
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT
        wk.id,
        wk.tanggal_mulai,
        wk.tanggal_selesai,
        wk.status_aktif,
        g.nama AS nama_guru,
        k.nama AS nama_kelas
    FROM t_wali_kelas wk
    LEFT JOIN t_guru g ON wk.guru_id = g.id
    LEFT JOIN t_kelas k ON wk.kelas_id = k.id
    WHERE wk.id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);
mysqli_stmt_close($stmt);

if (!$data) {
    header("Location: wali_kelas.php?status=tidak_ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hapus Wali Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Konfirmasi Hapus Wali Kelas</h5>
                </div>

                <div class="card-body">
                    <?php if ($pesan !== ''): ?>
                        <div class="alert alert-danger">
                            <?= aman($pesan) ?>
                        </div>
                    <?php endif; ?>

                    <p>
                        Apakah bang yakin ingin menghapus data wali kelas berikut?
                    </p>

                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama Guru</th>
                            <td><?= aman($data['nama_guru'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td><?= aman($data['nama_kelas'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td><?= aman($data['tanggal_mulai'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td><?= aman($data['tanggal_selesai'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?= (int) $data['status_aktif'] === 1
                                    ? 'Aktif'
                                    : 'Tidak Aktif' ?>
                            </td>
                        </tr>
                    </table>

                    <div class="alert alert-warning">
                        Data yang dihapus tidak dapat dikembalikan secara langsung.
                    </div>

                    <form method="POST" action="hapus_wali_kelas.php?id=<?= (int) $id ?>">
                        <input type="hidden" name="id" value="<?= (int) $id ?>">

                        <button type="submit" class="btn btn-danger">
                            Ya, Hapus
                        </button>

                        <a href="wali_kelas.php" class="btn btn-secondary">
                            Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

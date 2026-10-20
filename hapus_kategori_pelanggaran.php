
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Pastikan ID tersedia
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
        alert('ID kategori pelanggaran tidak valid!');
        window.location.href = 'kategori_pelanggaran.php';
    </script>";
    exit;
}

$id = (int) $_GET['id'];

// Periksa apakah data kategori tersedia
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_pelanggaran_kategori WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($hasil) === 0) {
    echo "<script>
        alert('Data kategori pelanggaran tidak ditemukan!');
        window.location.href = 'kategori_pelanggaran.php';
    </script>";
    exit;
}

mysqli_stmt_close($stmt);

// Hapus kategori
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_pelanggaran_kategori WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);

    echo "<script>
        alert('Kategori pelanggaran berhasil dihapus!');
        window.location.href = 'kategori_pelanggaran.php';
    </script>";
    exit;
} else {
    $error = mysqli_error($koneksi);
    mysqli_stmt_close($stmt);

    echo "<script>
        alert('Gagal menghapus kategori. Pastikan kategori tidak digunakan oleh data pelanggaran lain.');
        window.location.href = 'kategori_pelanggaran.php';
    </script>";
    exit;
}
?>

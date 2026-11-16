
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Pastikan ID tersedia
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: data_siswa.php?pesan=id_tidak_valid");
    exit;
}

$id = (int) $_GET['id'];

// Hapus data siswa berdasarkan ID
$sql = "DELETE FROM t_siswa WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    die("Gagal menyiapkan query: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: data_siswa.php?pesan=hapus_berhasil");
        exit;
    } else {
        header("Location: data_siswa.php?pesan=data_tidak_ditemukan");
        exit;
    }
} else {
    // Kemungkinan data masih digunakan oleh tabel lain (foreign key)
    if (mysqli_errno($koneksi) == 1451) {
        die("Data siswa tidak bisa dihapus karena masih digunakan pada data lain, seperti catatan pelanggaran atau penempatan kelas.");
    }

    die("Gagal menghapus data siswa: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
?>

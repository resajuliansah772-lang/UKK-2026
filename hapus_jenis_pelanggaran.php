<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Periksa ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: jenis_pelanggaran.php");
    exit();
}

$id = (int) $_GET['id'];

// Pastikan hanya admin yang dapat menghapus
if (!isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin') {

    echo "<script>
        alert('Anda tidak memiliki akses untuk menghapus data!');
        window.location.href='jenis_pelanggaran.php';
    </script>";
    exit();
}

// Periksa apakah data tersedia
$cek = mysqli_query(
    $koneksi,
    "SELECT id FROM t_pelanggaran WHERE id = $id"
);

if (!$cek) {
    die("Gagal memeriksa data: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($cek) == 0) {
    echo "<script>
        alert('Data jenis pelanggaran tidak ditemukan!');
        window.location.href='jenis_pelanggaran.php';
    </script>";
    exit();
}

// Hapus data
$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM t_pelanggaran WHERE id = $id"
);

if ($hapus) {
    echo "<script>
        alert('Data jenis pelanggaran berhasil dihapus!');
        window.location.href='jenis_pelanggaran.php';
    </script>";
    exit();
} else {
    echo "<script>
        alert('Data gagal dihapus. Data mungkin masih digunakan oleh tabel lain.');
        window.location.href='jenis_pelanggaran.php';
    </script>";
    exit();
}
?>
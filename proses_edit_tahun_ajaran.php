<?php
include "config/koneksi.php";

$id              = $_POST['id'];
$nama            = $_POST['nama'];
$tanggal_mulai   = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status_aktif    = $_POST['status_aktif'];

$sql = "UPDATE t_tahun_ajaran SET 
        nama = '$nama', 
        tanggal_mulai = '$tanggal_mulai', 
        tanggal_selesai = '$tanggal_selesai', 
        status_aktif = '$status_aktif' 
        WHERE id = '$id'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: tahun_ajaran.php");
    exit;
} else {
    die("Gagal memperbarui data tahun ajaran: " . mysqli_error($koneksi));
}
?>
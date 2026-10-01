<?php
include "config/koneksi.php";

$id           = $_POST['id'];
$nama         = $_POST['nama'];
$tingkat      = $_POST['tingkat'];
$jurusan      = $_POST['jurusan'];
$status_aktif = $_POST['status_aktif'];

$sql = "UPDATE t_kelas SET 
        nama = '$nama', 
        tingkat = '$tingkat', 
        jurusan = '$jurusan', 
        status_aktif = '$status_aktif' 
        WHERE id = '$id'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: kelas.php");
    exit;
} else {
    die("Gagal memperbarui data kelas: " . mysqli_error($koneksi));
}
?>
<?php
include "config/koneksi.php";

$nama         = $_POST['nama'];
$tingkat      = $_POST['tingkat'];
$jurusan      = $_POST['jurusan'];
$status_aktif = $_POST['status_aktif'];

$sql = "INSERT INTO t_kelas (nama, tingkat, jurusan, status_aktif) 
        VALUES ('$nama', '$tingkat', '$jurusan', '$status_aktif')";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: kelas.php");
    exit;
} else {
    die("Gagal menambahkan data kelas: " . mysqli_error($koneksi));
}
?>
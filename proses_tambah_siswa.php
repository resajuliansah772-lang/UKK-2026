<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";


// Ambil data dari form
$nis = $_POST['nis'];
$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$status_aktif = $_POST['status_aktif'];


// Query insert
$sql = "INSERT INTO t_siswa
        (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
        VALUES
        ('$nis', '$nisn', '$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$status_aktif')";


$query = mysqli_query($koneksi, $sql);


if ($query) {

    header("Location: data_siswa.php");

    exit;

} else {

    echo "Data siswa gagal ditambahkan.";

    echo "<br>";

    echo "Error: " . mysqli_error($koneksi);

    echo "<br><br>";

    echo "<a href='tambah_siswa.php'>Kembali</a>";

}

?>
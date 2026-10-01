<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";


// Ambil data dari form
$id = $_POST['id'];
$nis = $_POST['nis'];
$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$status_aktif = $_POST['status_aktif'];


// Query update
$sql = "UPDATE t_siswa SET

        nis = '$nis',
        nisn = '$nisn',
        nama = '$nama',
        jenis_kelamin = '$jenis_kelamin',
        tanggal_lahir = '$tanggal_lahir',
        alamat = '$alamat',
        status_aktif = '$status_aktif',
        updated_at = CURRENT_TIMESTAMP

        WHERE id = '$id'";


$query = mysqli_query($koneksi, $sql);


if ($query) {

    header("Location: data_siswa.php");

    exit;

} else {

    echo "Data siswa gagal diubah.";

    echo "<br>";

    echo "Error: " . mysqli_error($koneksi);

    echo "<br><br>";

    echo "<a href='data_siswa.php'>Kembali</a>";

}

?>
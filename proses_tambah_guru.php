<?php

include "config/koneksi.php";

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$status_aktif = $_POST['status_aktif'];
$user_id = $_POST['user_id'];

$sql = "INSERT INTO t_guru
        (nip, nama, email, status_aktif, user_id)
        VALUES
        ('$nip', '$nama', '$email', '$status_aktif', '$user_id')";

$query = mysqli_query($koneksi, $sql);

if ($query) {

    header("Location: data_guru.php");
    exit;

} else {

    die("Gagal menambahkan guru: " . mysqli_error($koneksi));

}

?>
<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";


// Ambil ID guru
$id = $_GET['id'];


// Hapus data guru
$sql = "DELETE FROM t_guru WHERE id = '$id'";

$query = mysqli_query($koneksi, $sql);


if ($query) {

    header("Location: data_guru.php");

    exit;

} else {

    echo "Data guru gagal dihapus.";

    echo "<br>";

    echo "Error: " . mysqli_error($koneksi);

    echo "<br><br>";

    echo "<a href='data_guru.php'>Kembali ke Data Guru</a>";

}

?>
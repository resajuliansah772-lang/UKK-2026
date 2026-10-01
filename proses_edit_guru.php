<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";


// Ambil data dari form
$id = $_POST['id'];
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$status_aktif = $_POST['status_aktif'];


// Cek user ID
if ($_POST['user_id'] == '') {

    $user_id = "NULL";

} else {

    $user_id = "'" . $_POST['user_id'] . "'";

}


// Query update
$sql = "UPDATE t_guru SET

        nip = '$nip',
        nama = '$nama',
        email = '$email',
        status_aktif = '$status_aktif',
        user_id = $user_id,
        updated_at = CURRENT_TIMESTAMP

        WHERE id = '$id'";


$query = mysqli_query($koneksi, $sql);


if ($query) {

    header("Location: data_guru.php");

    exit;

} else {

    echo "Data guru gagal diubah.";

    echo "<br>";

    echo "Error: " . mysqli_error($koneksi);

    echo "<br><br>";

    echo "<a href='data_guru.php'>Kembali</a>";

}

?>
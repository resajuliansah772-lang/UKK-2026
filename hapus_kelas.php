<?php
include "config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM t_kelas WHERE id = '$id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        header("Location: kelas.php");
        exit;
    } else {
        die("Gagal menghapus data kelas: " . mysqli_error($koneksi));
    }
} else {
    header("Location: kelas.php");
    exit;
}
?>
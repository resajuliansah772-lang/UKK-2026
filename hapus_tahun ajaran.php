<?php
include "config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM t_tahun_ajaran WHERE id = '$id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        header("Location: tahun_ajaran.php");
        exit;
    } else {
        die("Gagal menghapus data tahun ajaran: " . mysqli_error($koneksi));
    }
} else {
    header("Location: tahun_ajaran.php");
    exit;
}
?>
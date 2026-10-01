<?php

include "config/koneksi.php";

if (!isset($_GET['id'])) {
    die("ID siswa tidak ditemukan.");
}

$id = (int) $_GET['id'];

// Ubah status siswa menjadi tidak aktif
$sql = "UPDATE t_siswa 
        SET status_aktif = 0,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = $id";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: data_siswa.php");
    exit;
} else {
    die("Gagal menonaktifkan siswa: " . mysqli_error($koneksi));
}

?>
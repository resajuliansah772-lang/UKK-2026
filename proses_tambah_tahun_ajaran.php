<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama           = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal_mulai  = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai= mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);
    $status_aktif   = mysqli_real_escape_string($koneksi, $_POST['status_aktif']);

    $query = "INSERT INTO t_tahun_ajaran (nama, tanggal_mulai, tanggal_selesai, status_aktif) 
              VALUES ('$nama', '$tanggal_mulai', '$tanggal_selesai', '$status_aktif')";
              
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: tahun_ajaran.php?pesan=sukses");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: tambah_tahun_ajaran.php");
    exit;
}
?>
<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id             = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama           = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal_mulai  = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai= mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);
    $status_aktif   = mysqli_real_escape_string($koneksi, $_POST['status_aktif']);

    $query = "UPDATE t_tahun_ajaran SET 
                nama = '$nama', 
                tanggal_mulai = '$tanggal_mulai', 
                tanggal_selesai = '$tanggal_selesai', 
                status_aktif = '$status_aktif' 
              WHERE id = '$id'";
              
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: tahun_ajaran.php?pesan=edit_sukses");
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: tahun_ajaran.php");
    exit;
}
?>
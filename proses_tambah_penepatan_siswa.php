<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siswa_id = mysqli_real_escape_string($koneksi, $_POST['siswa_id']);
    $kelas_id = mysqli_real_escape_string($koneksi, $_POST['kelas_id']);

    // Cek apakah siswa sudah ditempatkan sebelumnya (opsional, mencegah duplikasi)
    $cek = mysqli_query($koneksi, "SELECT * FROM t_kelas_siswa WHERE siswa_id = '$siswa_id'");
    
    if (mysqli_num_rows($cek) > 0) {
        // Jika sudah ada, bisa di-update atau dialihkan kembali dengan pesan error
        echo "<script>alert('Siswa ini sudah memiliki penempatan kelas!'); window.location='tambah_penempatan_siswa.php';</script>";
    } else {
        $sql = "INSERT INTO t_kelas_siswa (siswa_id, kelas_id) VALUES ('$siswa_id', '$kelas_id')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            echo "<script>alert('Penempatan siswa berhasil ditambahkan!'); window.location='penempatan_siswa.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan penempatan: " . mysqli_error($koneksi) . "'); window.location='tambah_penempatan_siswa.php';</script>";
        }
    }
} else {
    header("Location: penempatan_siswa.php");
    exit;
}
?>
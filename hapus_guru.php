<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

// Periksa ID guru (jika kosong, kembalikan ke data_guru.php)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: data_guru.php");
    exit;
}

$id = (int)$_GET['id'];

// Langkah 1: Hapus dulu kaitan guru di t_pelanggaran_siswa
$hapus_pelanggaran = mysqli_prepare($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE guru_id = ?");
mysqli_stmt_bind_param($hapus_pelanggaran, "i", $id);
mysqli_stmt_execute($hapus_pelanggaran);
mysqli_stmt_close($hapus_pelanggaran);

// Langkah 2: Hapus kaitan guru di t_wali_kelas (kalau jadi wali kelas)
$hapus_wali = mysqli_prepare($koneksi, "DELETE FROM t_wali_kelas WHERE guru_id = ?");
mysqli_stmt_bind_param($hapus_wali, "i", $id);
mysqli_stmt_execute($hapus_wali);
mysqli_stmt_close($hapus_wali);

// Langkah 3: Baru hapus data gurunya di t_guru
$hapus_guru = mysqli_prepare($koneksi, "DELETE FROM t_guru WHERE id = ?");
mysqli_stmt_bind_param($hapus_guru, "i", $id);

if (mysqli_stmt_execute($hapus_guru)) {
    echo "<script>
        alert('Data Guru berhasil dihapus! Semua kaitan data sudah dibersihkan.');
        window.location='data_guru.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal dihapus: " . addslashes(mysqli_error($koneksi)) . "');
        window.location='data_guru.php';
    </script>";
}

mysqli_stmt_close($hapus_guru);
exit;
?>
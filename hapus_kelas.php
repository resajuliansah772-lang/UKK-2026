<?php
session_start();
include "includes/cek_session.php";
include "config/koneksi.php";

// Periksa ID kelas
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: kelas.php");
    exit;
}

$id = (int)$_GET['id'];

// Langkah 1: Hapus data di t_pelanggaran_siswa (tabel yang menyebabkan error)
$hapus_pelanggaran = mysqli_prepare($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE kelas_id = ?");
mysqli_stmt_bind_param($hapus_pelanggaran, "i", $id);
mysqli_stmt_execute($hapus_pelanggaran);
mysqli_stmt_close($hapus_pelanggaran);

// Langkah 2: Hapus data di t_wali_kelas
$hapus_wali = mysqli_prepare($koneksi, "DELETE FROM t_wali_kelas WHERE kelas_id = ?");
mysqli_stmt_bind_param($hapus_wali, "i", $id);
mysqli_stmt_execute($hapus_wali);
mysqli_stmt_close($hapus_wali);

// Langkah 3: Hapus data di t_kelas_siswa
$hapus_siswa = mysqli_prepare($koneksi, "DELETE FROM t_kelas_siswa WHERE kelas_id = ?");
mysqli_stmt_bind_param($hapus_siswa, "i", $id);
mysqli_stmt_execute($hapus_siswa);
mysqli_stmt_close($hapus_siswa);

// Langkah 4: Baru hapus kelasnya
$hapus_kelas = mysqli_prepare($koneksi, "DELETE FROM t_kelas WHERE id = ?");
mysqli_stmt_bind_param($hapus_kelas, "i", $id);

if (mysqli_stmt_execute($hapus_kelas)) {
    echo "<script>
        alert('Kelas berhasil dihapus! Semua data terkait sudah dibersihkan.');
        window.location='kelas.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal dihapus: " . addslashes(mysqli_error($koneksi)) . "');
        window.location='kelas.php';
    </script>";
}

mysqli_stmt_close($hapus_kelas);
exit;
?>

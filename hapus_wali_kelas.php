<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: wali_kelas.php");
    exit;
}

// Proses hapus langsung
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_wali_kelas WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    $terhapus = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($terhapus > 0) {
        header("Location: wali_kelas.php?status=hapus");
    } else {
        header("Location: wali_kelas.php?status=tidak_ditemukan");
    }
} else {
    header("Location: wali_kelas.php?status=gagal");
}
exit;

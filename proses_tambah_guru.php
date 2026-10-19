<?php

include "config/koneksi.php";

// Pastikan form dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_guru.php");
    exit;
}

// Ambil data dari form
$nip          = trim($_POST['nip'] ?? '');
$nama         = trim($_POST['nama'] ?? '');
$email        = trim($_POST['email'] ?? '');
$status_aktif = $_POST['status_aktif'] ?? '';
$user_id      = $_POST['user_id'] ?? '';

// Validasi input
if (
    $nip === '' ||
    $nama === '' ||
    $email === '' ||
    $status_aktif === '' ||
    $user_id === '' ||
    !ctype_digit((string) $user_id) ||
    (int) $user_id < 1
) {
    die("Data belum lengkap atau user_id tidak valid.");
}

$user_id = (int) $user_id;

// Pastikan user_id benar-benar ada di tabel t_users
$cek = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_users WHERE id = ?"
);

mysqli_stmt_bind_param($cek, "i", $user_id);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) === 0) {
    mysqli_stmt_close($cek);
    die("Gagal: user_id tidak ditemukan di tabel t_users.");
}

mysqli_stmt_close($cek);

// Simpan data guru
$sql = "INSERT INTO t_guru
        (nip, nama, email, status_aktif, user_id)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssi",
    $nip,
    $nama,
    $email,
    $status_aktif,
    $user_id
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: data_guru.php");
    exit;
} else {
    die("Gagal menambahkan guru: " . mysqli_stmt_error($stmt));
}
?>
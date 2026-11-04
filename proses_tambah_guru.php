<?php

session_start();

include "includes/cek_session.php";
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
$password     = $_POST['password'] ?? '';
$konfirmasi   = $_POST['konfirmasi_password'] ?? '';
$status_aktif = $_POST['status_aktif'] ?? '';

// Validasi data
if (
    $nip === '' ||
    $nama === '' ||
    $email === '' ||
    $password === '' ||
    $konfirmasi === ''
) {
    die("Semua data wajib diisi!");
}

// Validasi NIP 18 digit
if (!preg_match('/^[0-9]{18}$/', $nip)) {
    die("NIP harus terdiri dari 18 digit angka!");
}

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid!");
}

// Validasi password
if (strlen($password) < 6) {
    die("Password minimal 6 karakter!");
}

// Validasi konfirmasi password
if ($password !== $konfirmasi) {
    die("Password dan konfirmasi password tidak sama!");
}

// Validasi status
if (!in_array($status_aktif, ['0', '1'], true)) {
    die("Status tidak valid!");
}

// Periksa NIP sudah digunakan
$cek_nip = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_guru WHERE nip = ?"
);

mysqli_stmt_bind_param($cek_nip, "s", $nip);
mysqli_stmt_execute($cek_nip);
mysqli_stmt_store_result($cek_nip);

if (mysqli_stmt_num_rows($cek_nip) > 0) {
    mysqli_stmt_close($cek_nip);
    die("NIP sudah terdaftar!");
}

mysqli_stmt_close($cek_nip);

// Periksa email sudah digunakan
$cek_email = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_users WHERE email = ?"
);

mysqli_stmt_bind_param($cek_email, "s", $email);
mysqli_stmt_execute($cek_email);
mysqli_stmt_store_result($cek_email);

if (mysqli_stmt_num_rows($cek_email) > 0) {
    mysqli_stmt_close($cek_email);
    die("Email sudah digunakan!");
}

mysqli_stmt_close($cek_email);

// Enkripsi password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Mulai transaksi database
mysqli_begin_transaction($koneksi);

try {

    // 1. Simpan akun ke tabel t_users
    $sql_user = "INSERT INTO t_users
                 (name, email, password, role)
                 VALUES (?, ?, ?, ?)";

    $stmt_user = mysqli_prepare($koneksi, $sql_user);

    $role = "guru";

    mysqli_stmt_bind_param(
        $stmt_user,
        "ssss",
        $nama,
        $email,
        $password_hash,
        $role
    );

    if (!mysqli_stmt_execute($stmt_user)) {
        throw new Exception(mysqli_stmt_error($stmt_user));
    }

    // Ambil ID user yang baru dibuat
    $user_id = mysqli_insert_id($koneksi);

    mysqli_stmt_close($stmt_user);


    // 2. Simpan data ke tabel t_guru
    $sql_guru = "INSERT INTO t_guru
                 (nip, nama, email, status_aktif, user_id)
                 VALUES (?, ?, ?, ?, ?)";

    $stmt_guru = mysqli_prepare($koneksi, $sql_guru);

    mysqli_stmt_bind_param(
        $stmt_guru,
        "ssssi",
        $nip,
        $nama,
        $email,
        $status_aktif,
        $user_id
    );

    if (!mysqli_stmt_execute($stmt_guru)) {
        throw new Exception(mysqli_stmt_error($stmt_guru));
    }

    mysqli_stmt_close($stmt_guru);

    // Jika semuanya berhasil
    mysqli_commit($koneksi);

    header("Location: data_guru.php?pesan=berhasil");
    exit;

} catch (Exception $e) {

    // Batalkan semua penyimpanan jika terjadi kesalahan
    mysqli_rollback($koneksi);

    die("Gagal menambahkan guru: " . $e->getMessage());

}

?>
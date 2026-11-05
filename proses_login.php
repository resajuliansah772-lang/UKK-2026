<?php

session_start();

include "config/koneksi.php";

// Pastikan form dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

// Ambil data login
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input
if ($email === '' || $password === '') {
    header("Location: login.php?pesan=gagal");
    exit;
}

// Cari akun berdasarkan email di t_users, 
// sekaligus pastikan guru/user tersebut berstatus aktif (status_aktif = 1) di t_guru 
// (Sesuaikan nama kolom status jika di tabel t_users langsung atau t_guru)
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT u.*, g.status_aktif AS status_guru 
     FROM t_users u 
     LEFT JOIN t_guru g ON u.id = g.user_id 
     WHERE u.email = ? LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

// Periksa apakah akun ditemukan
if ($data) {

    // Cek apakah status guru/user tidak aktif (misal nilai status_aktif = 0)
    // Catatan: Jika kolom status_aktif bernilai 0 (tidak aktif), maka langsung Tolak Login.
    if (isset($data['status_guru']) && $data['status_guru'] == 0) {
        header("Location: login.php?pesan=gagal");
        exit;
    }

    $password_db = $data['password'];

    // Verifikasi password yang sudah di-hash
    $password_cocok = password_verify($password, $password_db);

    // Mendukung password lama yang masih berupa teks biasa
    if (!$password_cocok && $password_db !== null) {
        $password_cocok = hash_equals($password_db, $password);
    }

    if ($password_cocok) {

        // Jika password masih teks biasa, ubah menjadi hash
        if (!password_verify($password, $password_db)) {

            $password_baru = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $update = mysqli_prepare(
                $koneksi,
                "UPDATE t_users SET password = ? WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $update,
                "si",
                $password_baru,
                $data['id']
            );

            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);
        }

        // Simpan session
        session_regenerate_id(true);

        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        // Arahkan ke dashboard
        header("Location: dashboard.php");
        exit;

    } else {

        header("Location: login.php?pesan=gagal");
        exit;

    }

} else {

    header("Location: login.php?pesan=gagal");
    exit;

}

?>
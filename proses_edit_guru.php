<?php

session_start();

include "config/koneksi.php";

// Pastikan menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: data_guru.php");
    exit;
}

// Ambil data dari form
$id             = $_POST['id'] ?? '';
$nip            = trim($_POST['nip'] ?? '');
$nama           = trim($_POST['nama'] ?? '');
$email          = trim($_POST['email'] ?? '');
$password       = $_POST['password'] ?? '';
$konfirmasi     = $_POST['konfirmasi_password'] ?? '';
$status_aktif   = $_POST['status_aktif'] ?? '';

// Validasi ID
if ($id === '' || !ctype_digit((string)$id)) {
    die("ID guru tidak valid.");
}

$id = (int)$id;

// Validasi data
if (
    $nip === '' ||
    !preg_match('/^[0-9]{18}$/', $nip) ||
    $nama === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !in_array($status_aktif, ['0', '1'], true)
) {
    die("Data tidak valid. Pastikan NIP terdiri dari 18 digit.");
}

// Validasi password
if ($password !== '' || $konfirmasi !== '') {

    if ($password !== $konfirmasi) {
        die("Konfirmasi password tidak sama.");
    }

    if (strlen($password) < 6) {
        die("Password minimal 6 karakter.");
    }

}

// Ambil user_id asli dari database
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT user_id FROM t_guru WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data_guru = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$data_guru) {
    die("Data guru tidak ditemukan.");
}

// Gunakan user_id yang sudah tersimpan
$user_id = (int)$data_guru['user_id'];

if ($user_id < 1) {
    die("User ID guru tidak valid. Periksa relasi tabel t_guru dan t_users.");
}

// Pastikan akun masih ada di t_users
$cek_user = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_users WHERE id = ?"
);

mysqli_stmt_bind_param($cek_user, "i", $user_id);
mysqli_stmt_execute($cek_user);

$result_user = mysqli_stmt_get_result($cek_user);
$user = mysqli_fetch_assoc($result_user);

mysqli_stmt_close($cek_user);

if (!$user) {
    die("Akun pengguna guru tidak ditemukan di t_users.");
}

// Cek NIP duplikat
$cek_nip = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_guru WHERE nip = ? AND id != ?"
);

mysqli_stmt_bind_param($cek_nip, "si", $nip, $id);
mysqli_stmt_execute($cek_nip);

mysqli_stmt_store_result($cek_nip);

if (mysqli_stmt_num_rows($cek_nip) > 0) {
    mysqli_stmt_close($cek_nip);
    die("NIP sudah digunakan oleh guru lain.");
}

mysqli_stmt_close($cek_nip);

// Cek email duplikat di t_users
$cek_email = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_users WHERE email = ? AND id != ?"
);

mysqli_stmt_bind_param($cek_email, "si", $email, $user_id);
mysqli_stmt_execute($cek_email);

mysqli_stmt_store_result($cek_email);

if (mysqli_stmt_num_rows($cek_email) > 0) {
    mysqli_stmt_close($cek_email);
    die("Email sudah digunakan oleh pengguna lain.");
}

mysqli_stmt_close($cek_email);

// Mulai transaksi
mysqli_begin_transaction($koneksi);

try {

    // Update data akun pengguna
    if ($password !== '') {

        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $update_user = mysqli_prepare(
            $koneksi,
            "UPDATE t_users
             SET name = ?, email = ?, password = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $update_user,
            "sssi",
            $nama,
            $email,
            $password_hash,
            $user_id
        );

    } else {

        $update_user = mysqli_prepare(
            $koneksi,
            "UPDATE t_users
             SET name = ?, email = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $update_user,
            "ssi",
            $nama,
            $email,
            $user_id
        );

    }

    if (!mysqli_stmt_execute($update_user)) {
        throw new Exception(mysqli_stmt_error($update_user));
    }

    mysqli_stmt_close($update_user);


    // Update data guru
    // user_id tidak diubah karena sudah terhubung
    $update_guru = mysqli_prepare(
        $koneksi,
        "UPDATE t_guru
         SET nip = ?,
             nama = ?,
             email = ?,
             status_aktif = ?
         WHERE id = ?"
    );

    $status_aktif = (int)$status_aktif;

    mysqli_stmt_bind_param(
        $update_guru,
        "sssii",
        $nip,
        $nama,
        $email,
        $status_aktif,
        $id
    );

    if (!mysqli_stmt_execute($update_guru)) {
        throw new Exception(mysqli_stmt_error($update_guru));
    }

    mysqli_stmt_close($update_guru);

    // Simpan semua perubahan
    mysqli_commit($koneksi);

    header("Location: data_guru.php?pesan=berhasil");
    exit;

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    die("Gagal mengedit data guru: " . $e->getMessage());

}

?>

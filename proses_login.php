<?php

session_start();

include "config/koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM t_users WHERE email = '$email'");

$data = mysqli_fetch_assoc($query);

if ($data) {

    // Pengecekan password: bisa mendeteksi password yang di-hash ATAU teks biasa
    if (password_verify($password, $data['password']) || $password == $data['password']) {

        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

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
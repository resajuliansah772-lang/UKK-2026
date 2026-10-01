<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";


// Ambil ID
$id = $_GET['id'];


// Ambil data guru
$sql = "SELECT * FROM t_guru WHERE id = '$id'";

$query = mysqli_query($koneksi, $sql);


if (!$query) {

    die("Query gagal: " . mysqli_error($koneksi));

}


if (mysqli_num_rows($query) == 0) {

    echo "Data guru tidak ditemukan.";

    exit;

}


$guru = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data Guru</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

    <h2>Edit Data Guru</h2>

    <p>Silakan ubah data guru.</p>


    <form action="proses_edit_guru.php" method="POST">


        <input type="hidden"
               name="id"
               value="<?= $guru['id']; ?>">


        <div class="mb-3">

            <label class="form-label">
                NIP
            </label>

            <input type="text"
                   name="nip"
                   class="form-control"
                   maxlength="30"
                   value="<?= htmlspecialchars($guru['nip']); ?>"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Nama Guru
            </label>

            <input type="text"
                   name="nama"
                   class="form-control"
                   maxlength="150"
                   value="<?= htmlspecialchars($guru['nama']); ?>"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <input type="email"
                   name="email"
                   class="form-control"
                   maxlength="150"
                   value="<?= htmlspecialchars($guru['email']); ?>"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Status
            </label>

            <select name="status_aktif"
                    class="form-select"
                    required>

                <option value="1"
                    <?= $guru['status_aktif'] == 1 ? 'selected' : ''; ?>>
                    Aktif
                </option>

                <option value="0"
                    <?= $guru['status_aktif'] == 0 ? 'selected' : ''; ?>>
                    Tidak Aktif
                </option>

            </select>

        </div>


        <div class="mb-3">

            <label class="form-label">
                User ID
            </label>

            <input type="number"
                   name="user_id"
                   class="form-control"
                   value="<?= htmlspecialchars($guru['user_id'] ?? ''); ?>">

        </div>


        <button type="submit"
                class="btn btn-warning">
            Update
        </button>

        <a href="data_guru.php"
           class="btn btn-secondary">
            Kembali
        </a>


    </form>

</div>

</body>

</html>
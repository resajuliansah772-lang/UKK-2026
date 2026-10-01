<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";


// Ambil ID dari URL
$id = $_GET['id'];


// Ambil data siswa berdasarkan ID
$sql = "SELECT * FROM t_siswa WHERE id = '$id'";

$query = mysqli_query($koneksi, $sql);


// Cek apakah data ditemukan
if (mysqli_num_rows($query) == 0) {

    echo "Data siswa tidak ditemukan.";

    exit;

}


$siswa = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

    <h2>Edit Data Siswa</h2>

    <p>Silakan ubah data siswa.</p>


    <form action="proses_edit_siswa.php" method="POST">


        <!-- ID disembunyikan -->

        <input type="hidden"
               name="id"
               value="<?= $siswa['id']; ?>">


        <div class="mb-3">

            <label class="form-label">NIS</label>

            <input type="text"
                   name="nis"
                   class="form-control"
                   maxlength="30"
                   value="<?= htmlspecialchars($siswa['nis']); ?>"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">NISN</label>

            <input type="text"
                   name="nisn"
                   class="form-control"
                   maxlength="20"
                   value="<?= htmlspecialchars($siswa['nisn']); ?>"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">Nama Siswa</label>

            <input type="text"
                   name="nama"
                   class="form-control"
                   maxlength="150"
                   value="<?= htmlspecialchars($siswa['nama']); ?>"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">Jenis Kelamin</label>

            <select name="jenis_kelamin" class="form-select" required>

                <option value="">-- Pilih Jenis Kelamin --</option>

                <option value="L"
                    <?= $siswa['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>
                    Laki-laki
                </option>

                <option value="P"
                    <?= $siswa['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>
                    Perempuan
                </option>

            </select>

        </div>


        <div class="mb-3">

            <label class="form-label">Tanggal Lahir</label>

            <input type="date"
                   name="tanggal_lahir"
                   class="form-control"
                   value="<?= $siswa['tanggal_lahir']; ?>">

        </div>


        <div class="mb-3">

            <label class="form-label">Alamat</label>

            <textarea name="alamat"
                      class="form-control"
                      rows="4"><?= htmlspecialchars($siswa['alamat']); ?></textarea>

        </div>


        <div class="mb-3">

            <label class="form-label">Status</label>

            <select name="status_aktif" class="form-select" required>

                <option value="1"
                    <?= $siswa['status_aktif'] == 1 ? 'selected' : ''; ?>>
                    Aktif
                </option>

                <option value="0"
                    <?= $siswa['status_aktif'] == 0 ? 'selected' : ''; ?>>
                    Tidak Aktif
                </option>

            </select>

        </div>


        <button type="submit" class="btn btn-warning">
            Update
        </button>

        <a href="data_siswa.php" class="btn btn-secondary">
            Kembali
        </a>


    </form>

</div>

</body>

</html>
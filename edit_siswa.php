
<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

$halaman = 'data_siswa';

// Ambil ID siswa dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: data_siswa.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data siswa
$query = mysqli_prepare($koneksi, "SELECT * FROM t_siswa WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data siswa tidak ditemukan!";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100">

            <h4 class="text-white mb-4">
                Pelanggaran Siswa
            </h4>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa.php" class="nav-link active">
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_guru.php" class="nav-link text-white">
                        Data Guru
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link text-white">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tahun_ajaran.php" class="nav-link text-white">
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="penepatan_siswa.php" class="nav-link text-white">
                        Penepatan Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link text-white">
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">
                        Laporan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="aboutme.php" class="nav-link text-white">
                        About Me
                    </a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

        </div>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>
                Edit Data Siswa
            </h2>

            <p>
                Silakan ubah data siswa.
            </p>


            <!-- FORM EDIT -->
            <div class="card shadow-sm">

                <div class="card-body">

                    <form action="proses_edit_siswa.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= htmlspecialchars($data['id']) ?>"
                        >


                        <!-- NIS -->
                        <div class="mb-3">

                            <label class="form-label">
                                NIS
                            </label>

                            <input
                                type="text"
                                name="nis"
                                class="form-control"
                                value="<?= htmlspecialchars($data['nis']) ?>"
                                placeholder="Masukkan NIS (15 digit)"
                                maxlength="15"
                                minlength="15"
                                pattern="[0-9]{15}"
                                inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)"
                                title="NIS harus terdiri dari 15 digit angka"
                                required
                            >

                        </div>


                        <!-- NISN -->
                        <div class="mb-3">

                            <label class="form-label">
                                NISN
                            </label>

                            <input
                                type="text"
                                name="nisn"
                                class="form-control"
                                value="<?= htmlspecialchars($data['nisn']) ?>"
                                placeholder="Masukkan NISN (10 digit)"
                                maxlength="10"
                                minlength="10"
                                pattern="[0-9]{10}"
                                inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                title="NISN harus terdiri dari 10 digit angka"
                                required
                            >

                        </div>


                        <!-- NAMA SISWA -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama Siswa
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="<?= htmlspecialchars($data['nama']) ?>"
                                required
                            >

                        </div>


                        <!-- JENIS KELAMIN -->
                        <div class="mb-3">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="L"
                                    <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>
                                    Perempuan
                                </option>

                            </select>

                        </div>


                        <!-- TANGGAL LAHIR -->
                        <div class="mb-3">

                            <label class="form-label">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="<?= htmlspecialchars($data['tanggal_lahir']) ?>"
                                required
                            >

                        </div>


                        <!-- ALAMAT -->
                        <div class="mb-3">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"
                            ><?= htmlspecialchars($data['alamat']) ?></textarea>

                        </div>


                        <!-- STATUS -->
                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status_aktif"
                                class="form-select"
                                required
                            >

                                <option value="1"
                                    <?= ($data['status_aktif'] == 1) ? 'selected' : '' ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= ($data['status_aktif'] == 0) ? 'selected' : '' ?>>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>


                        <!-- TOMBOL -->
                        <a
                            href="data_siswa.php"
                            class="btn btn-secondary"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Simpan Perubahan
                        </button>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>

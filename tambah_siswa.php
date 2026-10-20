<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

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
                    <a href="data_siswa.php" class="nav-link text-white">
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
                    <a href="penepatan_siswa.php" class="nav-link <?php echo ($halaman == 'penepatan_siswa') ? 'active' : 'text-white'; ?>">
                        Penepatan Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="wali_kelas.php" class="nav-link <?php echo ($halaman == 'walikelas') ? 'active' : 'text-white'; ?>">
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link <?php echo ($halaman == 'kategori_pelanggaran') ? 'active' : 'text-white'; ?>">
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="jenis_pelanggaran.php" class="nav-link <?php echo ($halaman == 'jenis_pelanggaran') ? 'active' : 'text-white'; ?>">
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
                Tambah Data Siswa
            </h2>

            <p>
                Silakan isi data siswa dengan lengkap.
            </p>


            <!-- FORM -->
            <div class="card">

                <div class="card-body">

                    <form action="proses_tambah_siswa.php" method="POST">


                        <!-- NIS -->
                        <div class="mb-3">

                            <label class="form-label">
                                NIS
                            </label>

                            <input
                                type="text"
                                name="nis"
                                class="form-control"
                                placeholder="Masukkan NIS"
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
                                placeholder="Masukkan NISN"
                                required
                            >

                        </div>


                        <!-- NAMA -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama Siswa
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                placeholder="Masukkan nama siswa"
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

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="L">
                                    Laki-laki
                                </option>

                                <option value="P">
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
                                placeholder="Masukkan alamat siswa"
                            ></textarea>

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

                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>


                        <!-- TOMBOL -->

                        <a
                            href="data_siswa.php"
                            class="btn btn-secondary"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Simpan Siswa
                        </button>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>
<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "config/koneksi.php";


// ==============================
// AMBIL DATA SISWA AKTIF
// ==============================

$sql = "SELECT * FROM t_siswa
        WHERE status_aktif = 1
        ORDER BY nama ASC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<div class="container-fluid">

    <div class="row">


        <!-- =================================
             SIDEBAR
        ================================== -->

        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">


            <!-- JUDUL -->

            <h4 class="text-white mb-4">

                My Website

            </h4>


            <!-- MENU -->

            <ul class="nav nav-pills flex-column">


                <!-- DASHBOARD -->

                <li class="nav-item mb-2">

                    <a href="dashboard.php"
                       class="nav-link text-white">

                        Dashboard

                    </a>

                </li>


                <!-- DATA SISWA -->

                <li class="nav-item mb-2">

                    <a href="data_siswa.php"
                       class="nav-link text-white">

                        Data Siswa

                    </a>

                </li>


                <!-- DATA GURU -->

                <li class="nav-item mb-2">

                    <a href="data_guru.php"
                       class="nav-link text-white">

                        Data Guru

                    </a>

                </li>


                <!-- KELAS -->

                <li class="nav-item mb-2">

                    <a href="kelas.php"
                       class="nav-link text-white">

                        Kelas

                    </a>

                </li>


                <!-- TAHUN AJARAN -->

                <li class="nav-item mb-2">

                    <a href="tahun_ajaran.php"
                       class="nav-link text-white">

                        Tahun Ajaran

                    </a>

                </li>


                <!-- LAPORAN -->

                <li class="nav-item mb-2">

                    <a href="laporan.php"
                       class="nav-link text-white">

                        Laporan

                    </a>

                </li>


                <!-- ABOUT ME -->

                <li class="nav-item mb-2">

                    <a href="aboutme.php"
                       class="nav-link text-white">

                        About Me

                    </a>

                </li>


                <!-- GARIS -->

                <hr class="text-secondary">


                <!-- LOGOUT -->

                <li class="nav-item">

                    <a href="logout.php"
                       class="nav-link text-danger">

                        Logout

                    </a>

                </li>


            </ul>

        </div>



        <!-- =================================
             KONTEN
        ================================== -->

        <main class="col-md-9 col-lg-10 p-4">


            <!-- JUDUL -->

            <h2>

                Data Siswa

            </h2>


            <p>

                Data siswa pada sistem pelanggaran siswa

            </p>


            <!-- =================================
                 TOMBOL TAMBAH
            ================================== -->

            <div class="mb-3">

                <a href="tambah_siswa.php"
                   class="btn btn-primary">

                    Tambah Siswa

                </a>

            </div>


            <!-- =================================
                 TABEL
            ================================== -->

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">


                    <!-- HEADER -->

                    <thead class="table-dark">

                        <tr>

                            <th>No</th>

                            <th>NIS</th>

                            <th>NISN</th>

                            <th>Nama</th>

                            <th>Jenis Kelamin</th>

                            <th>Tanggal Lahir</th>

                            <th>Alamat</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <!-- ISI DATA -->

                    <tbody>

                    <?php

                    $no = 1;

                    while ($siswa = mysqli_fetch_assoc($query)):

                    ?>

                        <tr>


                            <!-- NO -->

                            <td>

                                <?= $no++; ?>

                            </td>


                            <!-- NIS -->

                            <td>

                                <?= htmlspecialchars($siswa['nis']); ?>

                            </td>


                            <!-- NISN -->

                            <td>

                                <?= htmlspecialchars($siswa['nisn']); ?>

                            </td>


                            <!-- NAMA -->

                            <td>

                                <?= htmlspecialchars($siswa['nama']); ?>

                            </td>


                            <!-- JENIS KELAMIN -->

                            <td>

                                <?php

                                if ($siswa['jenis_kelamin'] == 'L') {

                                    echo "Laki-laki";

                                } elseif ($siswa['jenis_kelamin'] == 'P') {

                                    echo "Perempuan";

                                } else {

                                    echo "-";

                                }

                                ?>

                            </td>


                            <!-- TANGGAL LAHIR -->

                            <td>

                                <?= htmlspecialchars($siswa['tanggal_lahir']); ?>

                            </td>


                            <!-- ALAMAT -->

                            <td>

                                <?= htmlspecialchars($siswa['alamat']); ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <span class="badge text-bg-success">

                                    Aktif

                                </span>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <a href="edit_siswa.php?id=<?= $siswa['id']; ?>"
                                   class="btn btn-warning btn-sm">

                                    Edit

                                </a>


                                <a href="hapus_siswa.php?id=<?= $siswa['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menonaktifkan siswa ini?');">

                                    Hapus

                                </a>

                            </td>


                        </tr>

                    <?php endwhile; ?>


                    </tbody>

                </table>

            </div>


        </main>


    </div>

</div>


</body>

</html>
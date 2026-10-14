<?php

session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// Ambil data guru
$sql = "SELECT * FROM t_guru ORDER BY nama ASC";

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

    <title>Data Guru</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark p-3 min-vh-100">

            <h4 class="text-white mb-4">
                My Website
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

            <!-- JUDUL -->
            <h2>
                Data Guru
            </h2>

            <p>
                Data guru pada sistem pelanggaran siswa
            </p>


            <!-- TOMBOL TAMBAH GURU -->
            <a href="tambah_guru.php" class="btn btn-primary mb-3">
                Tambah Guru
            </a>


            <!-- TABEL DATA GURU -->
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>No</th>

                            <th>NIP</th>

                            <th>Nama</th>

                            <th>Email</th>

                            <th>Status</th>

                            <th>User ID</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    $no = 1;

                    while ($guru = mysqli_fetch_assoc($query)) {

                    ?>

                        <tr>

                            <!-- NO -->
                            <td>
                                <?= $no++; ?>
                            </td>


                            <!-- NIP -->
                            <td>
                                <?= htmlspecialchars($guru['nip']); ?>
                            </td>


                            <!-- NAMA -->
                            <td>
                                <?= htmlspecialchars($guru['nama']); ?>
                            </td>


                            <!-- EMAIL -->
                            <td>
                                <?= htmlspecialchars($guru['email']); ?>
                            </td>


                            <!-- STATUS -->
                            <td>

                                <?php if ($guru['status_aktif'] == 1) { ?>

                                    <span class="badge text-bg-success">
                                        Aktif
                                    </span>

                                <?php } else { ?>

                                    <span class="badge text-bg-secondary">
                                        Tidak Aktif
                                    </span>

                                <?php } ?>

                            </td>


                            <!-- USER ID -->
                            <td>
                                <?= htmlspecialchars($guru['user_id']); ?>
                            </td>


                            <!-- AKSI -->
                            <td>

                                <a
                                    href="edit_guru.php?id=<?= $guru['id']; ?>"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <a
                                    href="hapus_guru.php?id=<?= $guru['id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus data guru ini?');"
                                >
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</div>

</body>

</html>
<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            min-height: 100vh;
        }


        /* Semua menu sidebar */

        .sidebar .nav-link {

            color: white;

            border-radius: 6px;

            padding: 10px 14px;

            transition: 0.2s;

        }


        /* Efek saat kursor diarahkan */

        .sidebar .nav-link:hover {

            background-color: #0d6efd;

            color: white;

        }


        /* Menu Logout */

        .sidebar .logout {

            color: #dc3545 !important;

        }


        /* Hover Logout */

        .sidebar .logout:hover {

            background-color: #dc3545;

            color: white !important;

        }

    </style>

</head>


<body>

<div class="container-fluid">

    <div class="row">


        <!-- =====================================
             SIDEBAR
        ====================================== -->

        <div class="col-md-3 col-lg-2 bg-dark p-3 sidebar">


            <!-- Judul Website -->

            <h4 class="text-white mb-4">

                My Website

            </h4>


            <!-- Menu Sidebar -->

            <ul class="nav nav-pills flex-column">


                <!-- ==============================
                     DASHBOARD
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="dashboard.php" class="nav-link">

                        Dashboard

                    </a>

                </li>


                <!-- ==============================
                     DATA SISWA
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="data_siswa.php" class="nav-link">

                        Data Siswa

                    </a>

                </li>


                <!-- ==============================
                     DATA GURU
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="data_guru.php" class="nav-link">

                        Data Guru

                    </a>

                </li>


                <!-- ==============================
                     KELAS
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="kelas.php" class="nav-link">

                        Kelas

                    </a>

                </li>


                <!-- ==============================
                     TAHUN AJARAN
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="tahun_ajaran.php" class="nav-link">

                        Tahun Ajaran

                    </a>

                </li>


                <!-- ==============================
                     LAPORAN
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="laporan.php" class="nav-link">

                        Laporan

                    </a>

                </li>


                <!-- ==============================
                     ABOUT ME
                =============================== -->

                <li class="nav-item mb-2">

                    <a href="aboutme.php" class="nav-link">

                        About Me

                    </a>

                </li>


                <!-- GARIS PEMISAH -->

                <hr class="text-secondary">


                <!-- ==============================
                     LOGOUT
                =============================== -->

                <li class="nav-item">

                    <a href="logout.php" class="nav-link logout">

                        Logout

                    </a>

                </li>


            </ul>

        </div>



        <!-- =====================================
             KONTEN DASHBOARD
        ====================================== -->

        <main class="col-md-9 col-lg-10 p-4">


            <!-- Judul -->

            <h2>

                Dashboard

            </h2>


            <p>

                Selamat datang di halaman dashboard.

            </p>



            <!-- =================================
                 CARD DASHBOARD
            ================================== -->

            <div class="row">


                <!-- ==============================
                     CARD DATA SISWA
                =============================== -->

                <div class="col-md-4 mb-3">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                                Data Siswa

                            </h5>


                            <h2>

                                120

                            </h2>

                        </div>

                    </div>

                </div>



                <!-- ==============================
                     CARD DATA GURU
                =============================== -->

                <div class="col-md-4 mb-3">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                                Data Guru

                            </h5>


                            <h2>

                                25

                            </h2>

                        </div>

                    </div>

                </div>



                <!-- ==============================
                     CARD KELAS
                =============================== -->

                <div class="col-md-4 mb-3">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                                Kelas

                            </h5>


                            <h2>

                                12

                            </h2>

                        </div>

                    </div>

                </div>


            </div>


        </main>


    </div>

</div>


</body>

</html>
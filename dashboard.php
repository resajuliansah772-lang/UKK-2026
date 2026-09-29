<?php

session_start();

include "includes/cek_session.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

            <h4 class="text-white mb-4">
                My Website
            </h4>
            <?php if ($_SESSION['role'] == 'admin') { ?>
            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link active">
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

    <?php } elseif ($_SESSION['role'] == 'guru') { ?> 
        <ul class="nav nav-pills flex-column"> 

            <li class="nav-item mb-2"> 
                <a href="#" class="nav-link active"> 
                    Dashboard 
                </a> 
            </li> 

            <li class="nav-item mb-2"> 
                <a href="menu3" class="nav-link text-white"> 
                    Kelas 
                </a> 
            </li> 

            <li class="nav-item mb-2"> 
                <a href="menu4" class="nav-link text-white"> 
                    laporan 
                </a> 
            </li> 

            <li class="nav-item"> 
                <a href="logout.php" class="nav-link text-danger"> 
                    Logout 
                </a> 
            </li> 

        </ul>

    </div>

<?php } ?> 

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2>Sistem Pelanggaran Siswa</h2>
            <p>Selamat datang, <?=  htmlspecialchars($_SESSION['name']); ?></p>
            <p>Anda login sebagai, <?=  htmlspecialchars($_SESSION['role']); ?></p>

            <div class="row">

                <!-- CARD DATA SISWA -->
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


                <!-- CARD DATA GURU -->

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


                <!-- CARD KELAS -->
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
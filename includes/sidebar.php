<?php
?>

<style>
    .sidebar-menu .nav-link {
        color: white;
        transition: 0.2s;
        border-radius: 6px;
    }

    .sidebar-menu .nav-link:hover {
        background-color: #0d6efd;
        color: white;
    }

    .sidebar-menu .logout:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

<div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">

    <h4 class="text-white mb-4">
        My Website
    </h4>

    <ul class="nav nav-pills flex-column sidebar-menu">

        <!-- Dashboard -->
        <li class="nav-item mb-2">
            <a href="dashboard.php" class="nav-link">
                Dashboard
            </a>
        </li>

        <!-- Data Siswa -->
        <li class="nav-item mb-2">
            <a href="data_siswa.php" class="nav-link">
                Data Siswa
            </a>
        </li>

        <!-- Data Guru -->
        <li class="nav-item mb-2">
            <a href="data_guru.php" class="nav-link">
                Data Guru
            </a>
        </li>

        <!-- Kelas -->
        <li class="nav-item mb-2">
            <a href="kelas.php" class="nav-link">
                Kelas
            </a>
        </li>

        <!-- Laporan -->
        <li class="nav-item mb-2">
            <a href="laporan.php" class="nav-link">
                Laporan
            </a>
        </li>

        <!-- About Me -->
        <li class="nav-item mb-2">
            <a href="aboutme.php" class="nav-link">
                About Me
            </a>
        </li>

        <hr class="text-secondary">

        <!-- Logout -->
        <li class="nav-item">
            <a href="logout.php" class="nav-link logout text-danger">
                Logout
            </a>
        </li>

    </ul>

</div>
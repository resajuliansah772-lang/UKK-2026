<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Sistem Pelanggaran Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="p-3 mb-2 bg-success-subtle text-success-emphasis d-flex justify-content-center align-items-center min-vh-100">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

    <div class="container">

        <div class="row justify-content-md-center">

            <div class="col-md-auto">

                <div class="card" style="width: 18rem;">

                    <div class="card-body">
                        
                        <h2 class="text-center mb-4">Login</h2></h2>

                        <?php if (isset($_GET['pesan'])): ?>

                            <?php if ($_GET['pesan'] == 'gagal'): ?>
                                <p>Email atau password salah!</p>
                            <?php endif; ?>

                        <?php endif; ?>

                        <form action="proses_login.php" method="POST">

                            <label>Email</label><br>
                            <input type="email" name="email" required>

                            <br><br>

                            <label>Password</label><br>
                            <input type="password" name="password" required>

                            <br><br>

                            <button type="submit" class="btn btn-outline-success">
                                Login
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
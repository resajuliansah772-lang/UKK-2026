<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pelanggaran Siswa</title>
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #1a1e21 0%, #212529 100%);
        }
        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 12px;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-exclamation text-primary fs-1"></i>
                            <h3 class="fw-bold text-dark mt-2 fs-4">Login Pelanggaran Siswa</h3>
                            <p class="text-muted small">Silakan masuk menggunakan akun Anda</p>
                        </div>

                        <!-- PESAN ERROR LOGIN -->
                        <?php if (isset($_GET['pesan'])): ?>
                            <?php if ($_GET['pesan'] == 'gagal'): ?>
                                <div class="alert alert-danger alert-dismissible fade show py-2 text-center" role="alert">
                                    <small>Email atau password salah!</small>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <form action="proses_login.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary py-2 fw-semibold">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
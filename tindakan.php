
<?php
session_start();

include "includes/cek_session.php";
include "config/koneksi.php";

// =====================================
// IDENTITAS USER
// =====================================

$halaman = 'tindakan';

$namaUser = htmlspecialchars(
    $_SESSION['name'] ?? 'Pengguna',
    ENT_QUOTES,
    'UTF-8'
);

$roleUser = strtolower(trim($_SESSION['role'] ?? 'guru'));

$id_user_login = (int) (
    $_SESSION['id'] ??
    $_SESSION['user_id'] ??
    0
);

// =====================================
// CEK HAK AKSES WALI KELAS
// =====================================

$isAdmin = ($roleUser === 'admin');
$is_wali_kelas_aktif = ($roleUser === 'wali_kelas');

if (!$isAdmin && !$is_wali_kelas_aktif && $id_user_login > 0) {

    $stmtWali = mysqli_prepare($koneksi, "
        SELECT wk.id
        FROM t_guru g
        INNER JOIN t_wali_kelas wk ON wk.guru_id = g.id
        WHERE g.user_id = ?
          AND wk.status_aktif = 1
        LIMIT 1
    ");

    if (!$stmtWali) {
        die("Gagal mengecek hak akses wali kelas: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmtWali, "i", $id_user_login);
    mysqli_stmt_execute($stmtWali);

    $resultWali = mysqli_stmt_get_result($stmtWali);

    if ($resultWali && mysqli_num_rows($resultWali) > 0) {
        $is_wali_kelas_aktif = true;
    }

    mysqli_stmt_close($stmtWali);
}

$tampilkan_menu_laporan = (
    $isAdmin || $is_wali_kelas_aktif
);

// =====================================
// CEK STRUKTUR TABEL
// =====================================

$hasil_kolom = mysqli_query(
    $koneksi,
    "SHOW COLUMNS FROM t_pelanggaran_siswa"
);

if (!$hasil_kolom) {
    die("Tabel t_pelanggaran_siswa tidak ditemukan: " . mysqli_error($koneksi));
}

$kolom_tersedia = [];

while ($kolom = mysqli_fetch_assoc($hasil_kolom)) {
    $kolom_tersedia[] = $kolom['Field'];
}

if (!in_array('keterangan', $kolom_tersedia, true)) {
    die("Kolom keterangan tidak tersedia pada tabel t_pelanggaran_siswa.");
}

// =====================================
// PROSES TINDAKAN
// =====================================

$pesan_error = "";

if (isset($_POST['proses_tindakan'])) {

    $id_pelanggaran_siswa = (int)($_POST['id_pelanggaran_siswa'] ?? 0);
    $jenis_tindakan = trim($_POST['jenis_tindakan'] ?? '');

    if ($id_pelanggaran_siswa <= 0 || $jenis_tindakan === '') {

        $pesan_error = "Data tindakan tidak boleh kosong.";

    } else {

        // Ambil keterangan pelanggaran sebelumnya
        $stmtCek = mysqli_prepare($koneksi, "
            SELECT keterangan
            FROM t_pelanggaran_siswa
            WHERE id = ?
              AND (
                  status = 'Pending'
                  OR status = ''
                  OR status IS NULL
              )
            LIMIT 1
        ");

        if (!$stmtCek) {

            $pesan_error = "Gagal memeriksa data: " . mysqli_error($koneksi);

        } else {

            mysqli_stmt_bind_param($stmtCek, "i", $id_pelanggaran_siswa);
            mysqli_stmt_execute($stmtCek);

            $resultCek = mysqli_stmt_get_result($stmtCek);
            $dataCek = mysqli_fetch_assoc($resultCek);

            mysqli_stmt_close($stmtCek);

            if (!$dataCek) {

                $pesan_error = "Data tidak ditemukan atau tindakan sudah diproses.";

            } else {

                // Gabungkan keterangan lama dan tindakan
                $keterangan_lama = trim($dataCek['keterangan'] ?? '');

                $keterangan_baru = $keterangan_lama;

                if ($keterangan_baru !== '') {
                    $keterangan_baru .= "\n\n";
                }

                $keterangan_baru .= "Tindakan/Sanksi: " . $jenis_tindakan;

                // Update status dan keterangan
                $stmtUpdate = mysqli_prepare($koneksi, "
                    UPDATE t_pelanggaran_siswa
                    SET status = 'Selesai',
                        keterangan = ?
                    WHERE id = ?
                      AND (
                          status = 'Pending'
                          OR status = ''
                          OR status IS NULL
                      )
                ");

                if (!$stmtUpdate) {

                    $pesan_error = "Gagal menyiapkan proses tindakan: " . mysqli_error($koneksi);

                } else {

                    mysqli_stmt_bind_param(
                        $stmtUpdate,
                        "si",
                        $keterangan_baru,
                        $id_pelanggaran_siswa
                    );

                    if (mysqli_stmt_execute($stmtUpdate)) {

                        if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {

                            mysqli_stmt_close($stmtUpdate);

                            echo "
                                <script>
                                    alert('Tindakan berhasil diproses dan masuk ke Riwayat!');
                                    window.location='tindakan.php';
                                </script>
                            ";

                            exit;

                        } else {

                            $pesan_error = "Data tidak berhasil diperbarui.";
                        }

                    } else {

                        $pesan_error = "Gagal memproses tindakan: " . mysqli_stmt_error($stmtUpdate);
                    }

                    mysqli_stmt_close($stmtUpdate);
                }
            }
        }
    }
}

// =====================================
// AMBIL DATA PELANGGARAN PENDING
// =====================================

$sql = "
    SELECT
        ps.id,
        ps.tanggal,
        ps.keterangan,
        s.nis,
        s.nama AS nama_siswa,
        p.nama AS nama_pelanggaran,
        p.poin,
        g.nama AS nama_guru

    FROM t_pelanggaran_siswa ps

    LEFT JOIN t_siswa s
        ON ps.siswa_id = s.id

    LEFT JOIN t_pelanggaran p
        ON ps.pelanggaran_id = p.id

    LEFT JOIN t_guru g
        ON ps.guru_id = g.id

    WHERE
        ps.status = 'Pending'
        OR ps.status = ''
        OR ps.status IS NULL

    ORDER BY ps.tanggal DESC, ps.id DESC
";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data tindakan: " . mysqli_error($koneksi));
}

$dataTindakan = [];

while ($row = mysqli_fetch_assoc($query)) {
    $dataTindakan[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tindakan Pelanggaran - Sistem Pelanggaran Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>

        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            background-color: #f4f6f9;
        }

        /* SIDEBAR TETAP */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;

            width: 16.666667%;
            height: 100vh;

            overflow-y: auto;
            overflow-x: hidden;

            background: linear-gradient(
                180deg,
                #212529 0%,
                #1a1e21 100%
            );

            z-index: 1000;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #6c757d;
            border-radius: 10px;
        }

        /* MENU */

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            padding-left: 15px;
        }

        /* KONTEN UTAMA */

        .main-content {
            margin-left: 16.666667%;
            width: 83.333333%;

            height: 100vh;

            overflow-y: auto;
            overflow-x: hidden;

            padding: 24px !important;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        #tabelTindakan th,
        #tabelTindakan td {
            vertical-align: middle;
            white-space: nowrap;
        }

        /* UKURAN TABLET */

        @media (min-width: 768px) and (max-width: 991.98px) {

            .sidebar {
                width: 25%;
            }

            .main-content {
                margin-left: 25%;
                width: 75%;
            }

        }

        /* UKURAN HP */

        @media (max-width: 767.98px) {

            html,
            body {
                height: auto;
                overflow: auto;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: auto;
                overflow: visible;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                height: auto;
                overflow: visible;
                padding: 16px !important;
            }

        }

        /* CETAK */

        @media print {

            html,
            body {
                height: auto;
                overflow: visible;
            }

            .sidebar,
            .no-print,
            .dt-search,
            .dt-length,
            .dt-paging,
            .dt-info {
                display: none !important;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                height: auto;
                overflow: visible;
                padding: 0 !important;
            }

        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->

        <div class="sidebar p-3">

            <h4 class="text-white mb-4 fw-bold fs-5 px-2">
                <i class="bi bi-shield-exclamation text-primary me-2"></i>
                Pelanggaran Siswa
            </h4>

            <ul class="nav nav-pills flex-column gap-1">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="catatan_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-journal-text me-2"></i>
                        Catatan Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tindakan.php" class="nav-link active">
                        <i class="bi bi-hammer me-2"></i>
                        Tindakan
                    </a>
                </li>

                <?php if ($tampilkan_menu_laporan) { ?>
                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Laporan
                        </a>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a href="riwayat.php" class="nav-link text-white">
                        <i class="bi bi-clock-history me-2"></i>
                        Riwayat
                    </a>
                </li>

                <li class="nav-item">
                    <a href="rekap_poin.php" class="nav-link text-white">
                        <i class="bi bi-award me-2"></i>
                        Rekap Poin
                    </a>
                </li>

                <hr class="text-secondary my-3">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>

        <!-- KONTEN UTAMA -->

        <main class="main-content">

            <div class="card shadow-sm p-4 bg-white mb-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>

                        <h2 class="fw-bold mb-2">
                            Proses Tindakan Pelanggaran
                        </h2>

                        <p class="text-muted mb-0">
                            Daftar siswa yang melanggar dan menunggu untuk diberi tindakan atau sanksi.
                        </p>

                    </div>

                    <div>

                        <span class="badge bg-primary-subtle text-primary border px-3 py-2">

                            <i class="bi bi-shield-check me-1"></i>

                            <?= htmlspecialchars($roleUser); ?>

                            <?php if ($is_wali_kelas_aktif && !$isAdmin) { ?>
                                - Wali Kelas
                            <?php } ?>

                        </span>

                    </div>

                </div>

            </div>

            <!-- PESAN ERROR -->

            <?php if ($pesan_error !== '') { ?>

                <div class="alert alert-danger alert-dismissible fade show">

                    <?= htmlspecialchars($pesan_error, ENT_QUOTES, 'UTF-8'); ?>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            <?php } ?>

            <!-- TABEL TINDAKAN -->

            <div class="card shadow-sm bg-white p-4">

                <div class="table-responsive">

                    <table
                        id="tabelTindakan"
                        class="table table-bordered table-striped table-hover w-100 align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS & Nama Siswa</th>
                                <th>Pelanggaran</th>
                                <th>Poin</th>
                                <th>Pelapor</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach ($dataTindakan as $row) { ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= !empty($row['tanggal'])
                                            ? date('d-m-Y', strtotime($row['tanggal']))
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            ($row['nis'] ?? '-') . ' - ' . ($row['nama_siswa'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $row['nama_pelanggaran'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            +<?= (int)($row['poin'] ?? 0); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $row['nama_guru'] ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td class="text-center">

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalTindakan<?= (int)$row['id']; ?>">

                                            <i class="bi bi-hammer me-1"></i>
                                            Beri Tindakan

                                        </button>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</div>

<!-- MODAL TINDAKAN -->

<?php foreach ($dataTindakan as $row) { ?>

    <div
        class="modal fade"
        id="modalTindakan<?= (int)$row['id']; ?>"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="" method="POST">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Proses Sanksi / Tindakan
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="id_pelanggaran_siswa"
                            value="<?= (int)$row['id']; ?>">

                        <p>
                            Siswa:
                            <strong>
                                <?= htmlspecialchars(
                                    $row['nama_siswa'] ?? '-',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </strong>
                        </p>

                        <p>
                            Pelanggaran:
                            <strong>
                                <?= htmlspecialchars(
                                    $row['nama_pelanggaran'] ?? '-',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </strong>
                        </p>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Jenis Tindakan / Sanksi
                            </label>

                            <textarea
                                name="jenis_tindakan"
                                class="form-control"
                                rows="3"
                                placeholder="Contoh: Diberikan Surat Peringatan 1 (SP1) / Pembinaan oleh Wali Kelas"
                                required></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button
                            type="submit"
                            name="proses_tindakan"
                            class="btn btn-success">

                            <i class="bi bi-check-circle me-1"></i>
                            Simpan & Masukkan ke Riwayat

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

<?php } ?>

<!-- JAVASCRIPT -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function () {

    $('#tabelTindakan').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        columnDefs: [
            {
                targets: [0, 6],
                orderable: false,
                searchable: false
            }
        ],

        language: {

            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data tindakan",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data tindakan tidak ditemukan",

            emptyTable: "Belum ada siswa yang perlu diberi tindakan",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }

        }

    });

});

</script>

</body>
</html>

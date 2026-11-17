
<?php
// Pastikan tidak ada spasi atau baris kosong sebelum tag PHP

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/cek_session.php";
include "config/koneksi.php";

// Penanda halaman aktif
$halaman = 'penempatan_siswa';

$namaUser = htmlspecialchars($_SESSION['name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$roleUser = $_SESSION['role'] ?? 'guru';

$pesan_error = "";

// =====================================
// PROSES PINDAH KELAS
// =====================================
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['aksi']) &&
    $_POST['aksi'] === 'pindah_kelas'
) {
    $id_penempatan = (int)($_POST['id_penempatan'] ?? 0);
    $kelas_baru_id = (int)($_POST['kelas_baru_id'] ?? 0);
    $tanggal_pindah = $_POST['tanggal_pindah'] ?? date('Y-m-d');

    if ($id_penempatan > 0 && $kelas_baru_id > 0) {

        $update_sql = "
            UPDATE t_kelas_siswa
            SET kelas_id = ?,
                tanggal_mulai = ?,
                status_aktif = 1
            WHERE id = ?
        ";

        $stmt = mysqli_prepare($koneksi, $update_sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "isi",
                $kelas_baru_id,
                $tanggal_pindah,
                $id_penempatan
            );

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: penepatan_siswa.php");
                exit;
            } else {
                $pesan_error = "Gagal eksekusi query: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            $pesan_error = "Gagal prepare query: " . mysqli_error($koneksi);
        }

    } else {
        $pesan_error = "Data ID penempatan atau kelas baru tidak boleh kosong!";
    }
}

// =====================================
// MENGAMBIL DATA PENEMPATAN SISWA
// =====================================
$sql = "
    SELECT
        ks.id,
        ks.tanggal_mulai,
        ks.tanggal_selesai,

        CASE
            WHEN s.status_aktif = 0 THEN 0
            ELSE ks.status_aktif
        END AS status_penempatan,

        s.nis,
        s.nama AS nama_siswa,
        s.status_aktif AS status_siswa,

        k.id AS kelas_id_asal,
        k.nama AS nama_kelas,
        k.tingkat,
        k.jurusan,

        ta.nama AS tahun_ajaran

    FROM t_kelas_siswa ks

    JOIN (
        SELECT siswa_id, MAX(id) AS max_id
        FROM t_kelas_siswa
        GROUP BY siswa_id
    ) latest ON ks.id = latest.max_id

    LEFT JOIN t_siswa s
        ON ks.siswa_id = s.id

    LEFT JOIN t_kelas k
        ON ks.kelas_id = k.id

    LEFT JOIN t_tahun_ajaran ta
        ON ks.tahun_ajaran_id = ta.id

    ORDER BY s.id ASC
";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data penempatan siswa: " . mysqli_error($koneksi));
}

// =====================================
// DAFTAR KELAS UNTUK MODAL
// =====================================
$sql_kelas_list = "
    SELECT *
    FROM t_kelas
    ORDER BY tingkat, nama ASC
";

$query_kelas_list = mysqli_query($koneksi, $sql_kelas_list);

$data_kelas = [];

if ($query_kelas_list) {
    while ($kls = mysqli_fetch_assoc($query_kelas_list)) {
        $data_kelas[] = $kls;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penempatan Siswa - Sistem Pelanggaran Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>

        /* =====================================
           PENGATURAN DASAR HALAMAN
        ===================================== */

        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            background-color: #f4f6f9;
        }

        /* =====================================
           SIDEBAR TETAP / FIXED
        ===================================== */

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

        /* Scrollbar sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #6c757d;
            border-radius: 10px;
        }

        /* =====================================
           MENU SIDEBAR
        ===================================== */

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

        /* =====================================
           KONTEN UTAMA BISA DI-SCROLL
        ===================================== */

        .main-content {
            margin-left: 16.666667%;
            width: 83.333333%;

            height: 100vh;

            overflow-y: auto;
            overflow-x: hidden;

            padding: 24px !important;
        }

        /* =====================================
           TABEL DAN CARD
        ===================================== */

        #tabelPenempatan th,
        #tabelPenempatan td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .dataTables_wrapper {
            margin-top: 10px;
        }

        .table-responsive {
            width: 100%;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        /* =====================================
           RESPONSIVE HP
        ===================================== */

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

        /* =====================================
           CETAK
        ===================================== */

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

            .card {
                box-shadow: none !important;
            }

        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- =====================================
             SIDEBAR
        ====================================== -->

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
                    <a href="data_siswa.php" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i>
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_guru.php" class="nav-link text-white">
                        <i class="bi bi-person-badge me-2"></i>
                        Data Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelas.php" class="nav-link text-white">
                        <i class="bi bi-door-open me-2"></i>
                        Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tahun_ajaran.php" class="nav-link text-white">
                        <i class="bi bi-calendar-range me-2"></i>
                        Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="penepatan_siswa.php" class="nav-link active">
                        <i class="bi bi-journal-check me-2"></i>
                        Penempatan Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="wali_kelas.php" class="nav-link text-white">
                        <i class="bi bi-person-workspace me-2"></i>
                        Wali Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-tags me-2"></i>
                        Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="jenis_pelanggaran.php" class="nav-link text-white">
                        <i class="bi bi-list-task me-2"></i>
                        Jenis Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="laporan.php" class="nav-link text-white">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="aboutme.php" class="nav-link text-white">
                        <i class="bi bi-info-circle me-2"></i>
                        About Me
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

        <!-- =====================================
             KONTEN UTAMA
        ====================================== -->

        <main class="main-content">

            <div class="card shadow-sm p-4 bg-white">

                <h2>Penempatan Siswa</h2>

                <p class="text-muted">
                    Kelola data penempatan siswa ke dalam kelas dan tahun ajaran.
                </p>

                <!-- NOTIFIKASI ERROR -->

                <?php if (!empty($pesan_error)): ?>

                    <div class="alert alert-danger alert-dismissible fade show">

                        <?= htmlspecialchars($pesan_error, ENT_QUOTES, 'UTF-8'); ?>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>

                    </div>

                <?php endif; ?>

                <!-- TOMBOL TAMBAH -->

                <div class="mb-3 no-print">

                    <a href="tambah_penempatan_siswa.php" class="btn btn-primary btn-sm">

                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Penempatan Siswa

                    </a>

                </div>

                <!-- TABEL PENEMPATAN SISWA -->

                <div class="table-responsive">

                    <table
                        id="tabelPenempatan"
                        class="table table-bordered table-striped table-hover w-100 align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Tahun Ajaran</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th class="no-print">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $no = 1;

                            $urutanTingkat = [
                                'X' => 10,
                                'XI' => 11,
                                'XII' => 12
                            ];

                            while ($row = mysqli_fetch_assoc($query)) {

                                $status = (int)($row['status_penempatan'] ?? 0);
                                $aktif = ($status === 1);

                                $namaKelas = trim($row['nama_kelas'] ?? '');
                                $tingkat = strtoupper(trim($row['tingkat'] ?? ''));

                                $kelasSearch = strtoupper(
                                    preg_replace('/\s+/', '', $namaKelas)
                                );

                                $nomorTingkat = $urutanTingkat[$tingkat] ?? 99;
                                $nomorKelas = 0;

                                if (preg_match('/(\d+)$/', $namaKelas, $match)) {
                                    $nomorKelas = (int)$match[1];
                                }

                                $kunciUrut = sprintf(
                                    '%02d-%s-%05d',
                                    $nomorTingkat,
                                    strtoupper($row['jurusan'] ?? ''),
                                    $nomorKelas
                                );

                            ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= htmlspecialchars($row['nis'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tahun_ajaran'] ?? '-'); ?>
                                    </td>

                                    <td
                                        data-search="<?= htmlspecialchars($kelasSearch, ENT_QUOTES, 'UTF-8'); ?>"
                                        data-order="<?= htmlspecialchars($kunciUrut, ENT_QUOTES, 'UTF-8'); ?>">

                                        <?= htmlspecialchars($namaKelas ?: '-'); ?>

                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tingkat'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['jurusan'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= !empty($row['tanggal_mulai'])
                                            ? date('d-m-Y', strtotime($row['tanggal_mulai']))
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <?= !empty($row['tanggal_selesai'])
                                            ? date('d-m-Y', strtotime($row['tanggal_selesai']))
                                            : '-'; ?>
                                    </td>

                                    <td>

                                        <?php if ($aktif): ?>

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">
                                                Tidak Aktif
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td class="no-print">

                                        <?php if ($aktif): ?>

                                            <button
                                                type="button"
                                                class="btn btn-warning btn-sm btn-pindah"
                                                data-id="<?= (int)$row['id']; ?>"
                                                data-nama="<?= htmlspecialchars($row['nama_siswa'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                data-kelas="<?= htmlspecialchars($namaKelas, ENT_QUOTES, 'UTF-8'); ?>"
                                                data-kelas-id="<?= (int)$row['kelas_id_asal']; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalPindahKelas"
                                                title="Pindah Kelas">

                                                <i class="bi bi-arrow-left-right"></i>
                                                Pindah

                                            </button>

                                        <?php else: ?>

                                            <span class="text-muted fs-6">-</span>

                                        <?php endif; ?>

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

<!-- =====================================
     MODAL PINDAH KELAS
====================================== -->

<div
    class="modal fade"
    id="modalPindahKelas"
    tabindex="-1"
    aria-labelledby="modalPindahKelasLabel"
    aria-hidden="true">

    <div class="modal-dialog">

        <form
            method="POST"
            action=""
            class="modal-content"
            id="formPindahKelas">

            <input type="hidden" name="aksi" value="pindah_kelas">

            <input
                type="hidden"
                name="id_penempatan"
                id="modal_id_penempatan">

            <div class="modal-header">

                <h5 class="modal-title" id="modalPindahKelasLabel">
                    Pindah Kelas Siswa
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <p class="mb-2">
                    Siswa:
                    <strong id="modal_nama_siswa">-</strong>
                </p>

                <p class="mb-3">
                    Kelas Saat Ini:
                    <strong id="modal_kelas_sekarang">-</strong>
                </p>

                <div class="mb-3">

                    <label for="kelas_baru_id" class="form-label">
                        Pilih Kelas Tujuan Baru
                    </label>

                    <select
                        name="kelas_baru_id"
                        id="kelas_baru_id"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Kelas --</option>

                        <?php foreach ($data_kelas as $kls): ?>

                            <option value="<?= (int)$kls['id']; ?>">

                                <?= htmlspecialchars(
                                    ($kls['tingkat'] ?? '') .
                                    ' - ' .
                                    ($kls['nama'] ?? '') .
                                    ' (' .
                                    ($kls['jurusan'] ?? '') .
                                    ')'
                                ); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label for="tanggal_pindah" class="form-label">
                        Tanggal Pindah / Berlaku
                    </label>

                    <input
                        type="date"
                        name="tanggal_pindah"
                        id="tanggal_pindah"
                        class="form-control"
                        value="<?= date('Y-m-d'); ?>"
                        required>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary btn-sm"
                    data-bs-dismiss="modal">

                    Batal

                </button>

                <button
                    type="submit"
                    class="btn btn-primary btn-sm"
                    id="btnSimpanPindah">

                    Simpan Pindah Kelas

                </button>

            </div>

        </form>

    </div>

</div>

<!-- =====================================
     JAVASCRIPT
====================================== -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function () {

    // =====================================
    // INISIALISASI DATATABLES
    // =====================================

    const tabel = $('#tabelPenempatan').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        info: true,

        order: [
            [4, 'asc'],
            [2, 'asc']
        ],

        columnDefs: [
            {
                targets: [0, 10],
                orderable: false,
                searchable: false
            }
        ],

        language: {

            search: "Cari data:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data penempatan siswa",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data penempatan siswa tidak ditemukan",

            emptyTable: "Belum ada data penempatan siswa",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }

        }

    });

    // =====================================
    // PENCARIAN KELAS TANPA SPASI
    // =====================================

    $('.dt-search input').off('input.dt');

    let waktuPencarian;

    $('.dt-search input').on('input', function () {

        clearTimeout(waktuPencarian);

        const kataKunci = $(this).val();

        const pencarianNormal = kataKunci
            .toUpperCase()
            .replace(/\s+/g, '');

        waktuPencarian = setTimeout(function () {

            tabel.search(pencarianNormal).draw();

        }, 200);

    });

    // =====================================
    // ISI MODAL PINDAH KELAS
    // =====================================

    $(document).on('click', '.btn-pindah', function () {

        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const kelas = $(this).data('kelas');
        const kelasId = $(this).data('kelas-id');

        $('#modal_id_penempatan').val(id);

        $('#modal_nama_siswa').text(nama);

        $('#modal_kelas_sekarang').text(kelas);

        // Tampilkan seluruh pilihan kelas
        $('#kelas_baru_id option').show();

        // Reset pilihan
        $('#kelas_baru_id').val('');

        // Sembunyikan kelas asal siswa
        if (kelasId) {

            $('#kelas_baru_id option[value="' + kelasId + '"]').hide();

        }

    });

});

</script>

</body>

</html>

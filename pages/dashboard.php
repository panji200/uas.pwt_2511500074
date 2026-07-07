<?php
// pengaman halaman
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

// menghitung jumlah data  total buku
$jml_buku = $mysqli->query("SELECT COUNT(*) as total FROM buku")->fetch_assoc()['total'];

// menghitung jumlah data total anggota
$jml_anggota = $mysqli->query("SELECT COUNT(*) as total FROM anggota")->fetch_assoc()['total'];

// menghitung jumlah data total peminjaman
$jml_pinjam = $mysqli->query("SELECT COUNT(*) as total FROM peminjaman WHERE status='Dipinjam'")->fetch_assoc()['total'];

// menghitung jumlah data total pengembalian
$jml_kembali = $mysqli->query("SELECT COUNT(*) as total FROM peminjaman WHERE status='Dikembalikan'")->fetch_assoc()['total'];
?>

<div class="container-fluid px-4">

    <h1 class="mt-4">Dashboard</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard Perpustakaan</li>
    </ol>

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body text-center">
                    <h5>Total Buku</h5>
                    <h2><?= $jml_buku ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"
                       href="index.php?hal=buku">
                        Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body text-center">
                    <h5>Total Anggota</h5>
                    <h2><?= $jml_anggota ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"
                       href="index.php?hal=daftar-anggota">
                        Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body text-center">
                    <h5>Sedang Dipinjam</h5>
                    <h2><?= $jml_pinjam ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"
                       href="index.php?hal=daftar-peminjaman">
                        Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body text-center">
                    <h5>Sudah Dikembalikan</h5>
                    <h2><?= $jml_kembali ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"
                       href="index.php?hal=konfirmasi_pengembalian">
                        Lihat Data
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow mt-3">

        <div class="card-header">
            <h5>Selamat Datang</h5>
        </div>

        <div class="card-body">

            <h4>Selamat Datang di Sistem Informasi Perpustakaan</h4>

            <p>
                Sistem ini digunakan untuk mengelola data:
            </p>

            <ul>
                <li>📚 Data Buku</li>
                <li>📁 Kategori Buku</li>
                <li>👨‍🎓 Data Anggota</li>
                <li>📖 Peminjaman Buku</li>
                <li>✅ Pengembalian Buku</li>
            </ul>

            <hr>

            <h5>Ringkasan Sistem</h5>

            <table class="table table-bordered">

                <tr>
                    <th>Total Buku</th>
                    <td><?= $jml_buku ?></td>
                </tr>

                <tr>
                    <th>Total Anggota</th>
                    <td><?= $jml_anggota ?></td>
                </tr>

                <tr>
                    <th>Buku Dipinjam</th>
                    <td><?= $jml_pinjam ?></td>
                </tr>

                <tr>
                    <th>Buku Dikembalikan</th>
                    <td><?= $jml_kembali ?></td>
                </tr>

            </table>

        </div>

    </div>

</div>
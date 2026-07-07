<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Peminjaman</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Peminjaman Buku</li>
    </ol>

    <a href="index.php?hal=tambah_peminjaman" class="btn btn-primary mb-3">
        Tambah Peminjaman
    </a>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        $sql = "SELECT
                                    p.*,
                                    a.nama_lengkap,
                                    b.judul
                                FROM peminjaman p
                                JOIN anggota a
                                    ON p.id_anggota = a.id_anggota
                                JOIN buku b
                                    ON p.id_buku = b.id_buku
                                ORDER BY p.id_peminjaman DESC";

                        $query = $mysqli->query($sql);

                        if ($query->num_rows > 0) {

                            $no = 1;

                            while ($row = $query->fetch_assoc()) {

                        ?>

                        <tr>

                            <td><?= $no++ ?></td>

                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>

                            <td><?= htmlspecialchars($row['judul']) ?></td>

                            <td><?= $row['tanggal_pinjam'] ?></td>

                            <td><?= $row['tanggal_kembali'] ?></td>

                            <td>

                                <?php
                                if ($row['status'] == "Dipinjam") {
                                    echo "<span class='badge bg-warning'>Dipinjam</span>";
                                } else {
                                    echo "<span class='badge bg-success'>Dikembalikan</span>";
                                }
                                ?>

                            </td>

                            <td>

                                <a href="index.php?hal=ubah_peminjaman&id=<?= $row['id_peminjaman'] ?>"
                                   class="btn btn-warning btn-sm">
                                    Ubah
                                </a>

                                <a href="index.php?hal=hapus_peminjaman&id=<?= $row['id_peminjaman'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    Hapus
                                </a>

                            </td>

                        </tr>

                        <?php

                            }

                        } else {

                            echo "<tr>
                                    <td colspan='7' class='text-center'>
                                        Belum ada data peminjaman
                                    </td>
                                  </tr>";

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>
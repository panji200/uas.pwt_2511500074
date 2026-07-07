<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}
?>

<div class="container-fluid px-4">

<h1 class="mt-4">Konfirmasi Pengembalian</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Daftar Buku Yang Dipinjam</li>
</ol>

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
    <th>No</th>
    <th>Anggota</th>
    <th>Buku</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

</thead>

<tbody>

<?php

$sql = "SELECT
        p.*,
        a.nama_lengkap,
        b.judul
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota=a.id_anggota
        JOIN buku b ON p.id_buku=b.id_buku
        WHERE p.status='Dipinjam'
        ORDER BY p.id_peminjaman DESC";

$query = $mysqli->query($sql);

$no=1;

while($row=$query->fetch_assoc()){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_lengkap']; ?></td>

<td><?= $row['judul']; ?></td>

<td><?= $row['tanggal_pinjam']; ?></td>

<td><?= $row['tanggal_kembali']; ?></td>

<td>
<span class="badge bg-warning">
<?= $row['status']; ?>
</span>
</td>

<td>

<a href="index.php?hal=proses_pengembalian&id=<?= $row['id_peminjaman']; ?>"
class="btn btn-success btn-sm"
onclick="return confirm('Konfirmasi pengembalian buku?')">

Kembalikan

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>
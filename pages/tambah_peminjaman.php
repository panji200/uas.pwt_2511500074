<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

if (isset($_POST['simpan'])) {

    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    // Cek stok buku
    $cek = $mysqli->query("SELECT stok FROM buku WHERE id_buku='$id_buku'");
    $buku = $cek->fetch_assoc();

    if ($buku['stok'] <= 0) {

        echo "<script>
                alert('Stok buku habis!');
                window.location='index.php?hal=tambah_peminjaman';
              </script>";

    } else {

        $stmt = $mysqli->prepare("INSERT INTO peminjaman(id_anggota,id_buku,tanggal_pinjam,tanggal_kembali,status)
                                  VALUES(?,?,?,?,?)");

        $stmt->bind_param(
            "iisss",
            $id_anggota,
            $id_buku,
            $tanggal_pinjam,
            $tanggal_kembali,
            $status
        );

        if ($stmt->execute()) {

            // Kurangi stok buku
            $mysqli->query("UPDATE buku SET stok = stok - 1 WHERE id_buku='$id_buku'");

            echo "<script>
                    alert('Peminjaman berhasil ditambahkan');
                    window.location='index.php?hal=daftar_peminjaman';
                  </script>";

        } else {

            echo "<script>
                    alert('Gagal menambahkan data');
                  </script>";

        }
    }
}
?>

<div class="container-fluid px-4">

<h1 class="mt-4">Tambah Peminjaman</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Form Tambah Peminjaman</li>
</ol>

<div class="card">

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Nama Anggota</label>

<select name="id_anggota" class="form-control" required>

<option value="">-- Pilih Anggota --</option>

<?php

$anggota = $mysqli->query("SELECT * FROM anggota ORDER BY nama_lengkap");

while($a = $anggota->fetch_assoc()){

?>

<option value="<?= $a['id_anggota'] ?>">
    <?= $a['nama_lengkap'] ?>
</option>

<?php } ?>

</select>

</div>


<div class="mb-3">

<label>Buku</label>

<select name="id_buku" class="form-control" required>

<option value="">-- Pilih Buku --</option>

<?php

$buku = $mysqli->query("SELECT * FROM buku WHERE stok > 0 ORDER BY judul");

while($b = $buku->fetch_assoc()){

?>

<option value="<?= $b['id_buku'] ?>">
    <?= $b['judul'] ?> (Stok : <?= $b['stok'] ?>)
</option>

<?php } ?>

</select>

</div>


<div class="mb-3">

<label>Tanggal Pinjam</label>

<input
type="date"
name="tanggal_pinjam"
class="form-control"
value="<?= date('Y-m-d') ?>"
required>

</div>


<div class="mb-3">

<label>Tanggal Kembali</label>

<input
type="date"
name="tanggal_kembali"
class="form-control"
required>

</div>


<div class="mb-3">

<label>Status</label>

<select name="status" class="form-control">

<option value="Dipinjam">Dipinjam</option>
<option value="Dikembalikan">Dikembalikan</option>

</select>

</div>


<button type="submit" name="simpan" class="btn btn-primary">
Simpan
</button>

<a href="index.php?hal=daftar_peminjaman" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

</div>
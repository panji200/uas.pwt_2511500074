<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$id = $_GET['id'] ?? 0;

// Ambil data peminjaman
$stmt = $mysqli->prepare("SELECT * FROM peminjaman WHERE id_peminjaman=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "<script>
            alert('Data tidak ditemukan!');
            window.location='index.php?hal=daftar_peminjaman';
          </script>";
    exit;
}

if (isset($_POST['simpan'])) {

    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    // Tambah stok jika sebelumnya Dipinjam lalu diubah menjadi Dikembalikan
    if ($data['status'] == 'Dipinjam' && $status == 'Dikembalikan') {
        $mysqli->query("UPDATE buku SET stok = stok + 1 WHERE id_buku='$id_buku'");
    }

    $stmt = $mysqli->prepare("
        UPDATE peminjaman
        SET id_anggota=?,
            id_buku=?,
            tanggal_pinjam=?,
            tanggal_kembali=?,
            status=?
        WHERE id_peminjaman=?
    ");

    $stmt->bind_param(
        "iisssi",
        $id_anggota,
        $id_buku,
        $tanggal_pinjam,
        $tanggal_kembali,
        $status,
        $id
    );

    if ($stmt->execute()) {

        echo "<script>
                alert('Data berhasil diubah!');
                window.location='index.php?hal=daftar_peminjaman';
              </script>";

    } else {

        echo "<script>alert('Gagal mengubah data');</script>";

    }
}
?>

<div class="container-fluid px-4">

<h1 class="mt-4">Ubah Peminjaman</h1>

<div class="card">
<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Anggota</label>

<select name="id_anggota" class="form-control">

<?php
$q = $mysqli->query("SELECT * FROM anggota ORDER BY nama_lengkap");

while($a = $q->fetch_assoc()){
?>

<option value="<?= $a['id_anggota']; ?>"
<?= ($a['id_anggota']==$data['id_anggota'])?'selected':''; ?>>

<?= $a['nama_lengkap']; ?>

</option>

<?php } ?>

</select>

</div>


<div class="mb-3">

<label>Buku</label>

<select name="id_buku" class="form-control">

<?php
$q = $mysqli->query("SELECT * FROM buku ORDER BY judul");

while($b = $q->fetch_assoc()){
?>

<option value="<?= $b['id_buku']; ?>"
<?= ($b['id_buku']==$data['id_buku'])?'selected':''; ?>>

<?= $b['judul']; ?>

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
value="<?= $data['tanggal_pinjam']; ?>">

</div>


<div class="mb-3">

<label>Tanggal Kembali</label>

<input
type="date"
name="tanggal_kembali"
class="form-control"
value="<?= $data['tanggal_kembali']; ?>">

</div>


<div class="mb-3">

<label>Status</label>

<select name="status" class="form-control">

<option value="Dipinjam"
<?= ($data['status']=="Dipinjam")?"selected":"";?>>
Dipinjam
</option>

<option value="Dikembalikan"
<?= ($data['status']=="Dikembalikan")?"selected":"";?>>
Dikembalikan
</option>

</select>

</div>

<button type="submit" name="simpan" class="btn btn-primary">
Simpan
</button>

<a href="index.php?hal=daftar_peminjaman"
class="btn btn-secondary">
Kembali
</a>

</form>

</div>
</div>

</div>
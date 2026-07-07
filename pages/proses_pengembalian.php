<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$id = $_GET['id'] ?? 0;

// Ambil data peminjaman
$stmt = $mysqli->prepare("SELECT * FROM peminjaman WHERE id_peminjaman=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

if(!$data){

    echo "<script>
    alert('Data tidak ditemukan');
    window.location='index.php?hal=konfirmasi_pengembalian';
    </script>";

    exit;
}

// Update status
$stmt = $mysqli->prepare("UPDATE peminjaman SET status='Dikembalikan' WHERE id_peminjaman=?");
$stmt->bind_param("i",$id);
$stmt->execute();

// Tambah stok
$stmt = $mysqli->prepare("UPDATE buku SET stok=stok+1 WHERE id_buku=?");
$stmt->bind_param("i",$data['id_buku']);
$stmt->execute();

echo "<script>

alert('Buku berhasil dikembalikan');

window.location='index.php?hal=konfirmasi_pengembalian';

</script>";
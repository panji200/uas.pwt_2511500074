<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$id = $_GET['id'] ?? 0;

// Ambil data peminjaman
$stmt = $mysqli->prepare("SELECT id_buku, status FROM peminjaman WHERE id_peminjaman = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>
            alert('Data tidak ditemukan!');
            window.location='index.php?hal=daftar_peminjaman';
          </script>";
    exit;
}

// Jika status masih Dipinjam, kembalikan stok buku
if ($data['status'] == 'Dipinjam') {

    $stmt = $mysqli->prepare("UPDATE buku SET stok = stok + 1 WHERE id_buku = ?");
    $stmt->bind_param("i", $data['id_buku']);
    $stmt->execute();
}

// Hapus data peminjaman
$stmt = $mysqli->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo "<script>
            alert('Data peminjaman berhasil dihapus!');
            window.location='index.php?hal=daftar_peminjaman';
          </script>";

} else {

    echo "<script>
            alert('Data gagal dihapus!');
            window.location='index.php?hal=daftar_peminjaman';
          </script>";

}
?>
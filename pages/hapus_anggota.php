<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$id = $_GET['id'] ?? 0;

// Ambil data foto anggota
$stmt = $mysqli->prepare("SELECT foto FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {

    // Hapus foto jika ada
    if (!empty($data['foto'])) {
        $file = __DIR__ . "/../uploads/anggota/" . $data['foto'];

        if (file_exists($file)) {
            unlink($file);
        }
    }

    // Hapus data anggota
    $stmt = $mysqli->prepare("DELETE FROM anggota WHERE id_anggota = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data anggota berhasil dihapus!');
                window.location='index.php?hal=daftar-anggota';
              </script>";
    } else {
        echo "<script>
                alert('Data anggota gagal dihapus!');
                window.location='index.php?hal=daftar-anggota';
              </script>";
    }
} else {
    echo "<script>
            alert('Data anggota tidak ditemukan!');
            window.location='index.php?hal=daftar-anggota';
          </script>";
}
exit;
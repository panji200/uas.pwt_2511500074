<?php
if (!defined('MY_APP')) die('Akses langsung tidak diperbolehkan!');

// ==== Koneksi langsung ke database ====
$mysqli = new mysqli("localhost", "root", "", "perpustakaan");
if ($mysqli->connect_errno) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

$id = $_GET['id'] ?? 0;

// Ambil data anggota berdasarkan ID
$stmt = $mysqli->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php?hal=daftar-anggota';</script>";
    exit;
}
    
// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['no_telepon'];
    $password = $_POST['password'];

    $update_password = '';
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update_password = ", password='$password_hash'";
    }

    // Upload foto baru jika ada
    $foto_baru = $data['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = __DIR__ . '/../uploads/anggota/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $nama_foto = time() . '_' . basename($_FILES['foto']['name']);
        $target_file = $target_dir . $nama_foto;

        // Hapus foto lama jika ada
        if (!empty($data['foto']) && file_exists($target_dir . $data['foto'])) {
            unlink($target_dir . $data['foto']);
        }
         
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $foto_baru = $nama_foto;
        }
    }

    // Update ke database
    $sql = "UPDATE anggota 
            SET nama_lengkap=?, email=?, alamat=?, no_telepon=?, foto=? $update_password
            WHERE id_anggota=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssi", $nama, $email, $alamat, $nohp, $foto_baru, $id);
    $stmt->execute();

    echo "<script>
        alert('Data anggota berhasil diperbarui!');
        window.location='index.php?hal=daftar-anggota';
    </script>";
    exit;
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Ubah Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Form Ubah Anggota</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="text-center mb-3">
                    <label for="foto" class="form-label d-block">Foto Profil</label>
                    <img id="preview" 
                         src="<?= !empty($data['foto']) ? 'uploads/anggota/' . $data['foto'] : 'https://via.placeholder.com/100' ?>" 
                         class="rounded-circle mb-2" width="100" height="100" alt="Foto Profil">
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Password (kosongkan jika tidak ingin diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="<?= htmlspecialchars($data['no_telepon']) ?>">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php?hal=daftar-anggota" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

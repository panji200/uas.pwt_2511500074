<?php
if (!defined('MY_APP')) die('Akses langsung tidak diperbolehkan!');

// ==== Koneksi langsung ke database ====
$mysqli = new mysqli("localhost", "root", "", "perpustakaan");
if ($mysqli->connect_errno) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $no_telepon = $_POST['no_telepon'] ?? '';

    // Proses upload foto
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = __DIR__ . '/../uploads/anggota/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $foto_name = time() . '_' . basename($_FILES['foto']['name']);
        $target_file = $target_dir . $foto_name;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $foto = $foto_name;
        } else {
            $pesan_error = "Gagal mengunggah foto.";
        }
    }

    // Simpan ke database
    if (empty($pesan_error)) {
        $sql = "INSERT INTO anggota (nama_lengkap, email, password, alamat, no_telepon, foto) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssss", $nama_lengkap, $email, $password, $alamat, $no_telepon, $foto);

        if ($stmt->execute()) {
            echo "<script>
    alert('Data anggota berhasil disimpan!');
    window.location.href='index.php?hal=daftar-anggota';
</script>";
exit;

        } else {
            $pesan_error = "Gagal menyimpan data anggota.";
        }

        $stmt->close();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Form Tambah Anggota</li>
    </ol>

    <?php if (!empty($pesan_error)): ?>
        <div class="alert alert-danger"><?= $pesan_error ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3 text-center">
                    <label for="foto" class="form-label d-block">Foto Profil</label>
                    <img id="preview" src="https://via.placeholder.com/100" 
                         class="rounded-circle mb-2" width="100" height="100" alt="Preview Foto">
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" 
                           onchange="previewImage(event)">
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php?hal=daftar-anggota" class="btn btn-danger">Kembali</a>
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

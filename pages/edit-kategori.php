<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$pesan = "";
$pesan_error = "";

// Ambil data kategori berdasarkan ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_kategori = $_GET['id'];

    $sql = "SELECT * FROM kategori WHERE id_kategori = ?";
    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $id_kategori);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $kategori = $result->fetch_assoc();
        } else {
            echo "Data kategori tidak ditemukan!";
            exit();
        }

        $stmt->close();
    }
} else {
    header("Location: index.php?hal=daftar-kategori");
    exit();
}

// UPDATE DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("si", $nama_kategori, $id_kategori);

        if ($stmt->execute()) {
            $pesan = "Data kategori berhasil diperbarui";
            $result_kategori =  $mysqli->query("SELECT * FROM kategori WHERE id_kategori = $id_kategori");
        } else {
            $pesan_error = "Terjadi kesalahan saat mengupdate data";
        }

        $stmt->close();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ubah Kategori</li>
    </ol>

    <?php if (!empty($pesan)) : ?>
        <div class="alert alert-success" role="alert">
            <?= $pesan ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($pesan_error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $pesan_error ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">

            <form action="" method="post">

                <input type="hidden" name="id_kategori" value="<?= $kategori['id_kategori'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" name="nama_kategori"
                           value="<?= $kategori['nama_kategori'] ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php?hal=daftar-kategori" class="btn btn-danger">Kembali</a>

            </form>

        </div>
    </div>
</div>

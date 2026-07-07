<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan');
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

     // proses upload cover
    $cover_name = null;
    if(!empty($_FILES['cover']['name'])) {
      $target_dir = "uploads/buku/";
      $file_name = time() . "_" . basename($_FILES['cover']['name']);
      $target_file = $target_dir . $file_name;

      // proses upload
      if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)) {
        $cover_name = $file_name;
      }
    }

    //  proses masuk ke database
    $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok, cover_buku) VALUES(?, ?, ?, ?, ?, ?)";
    if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssiis", $judul, $penulis, $penerbit, $tahun_terbit, $stok, $cover_name); 
        if($stmt->execute()) {
            $id_buku = $stmt->insert_id;
            if(!empty($_POST['kategori'])) {
                foreach($_POST['kategori'] as $id_kategori) {
                    $mysqli->query("INSERT INTO buku_kategori (id_buku, id_kategori) VALUES ($id_buku, $id_kategori)");
                }
                $pesan = "Buku berhasil di tmabahkan";
            } else {
                $pesan_error = "Gagal Menambahkan Buku";
            }
            $stmt->close();

        }
    }
}
?>

<div class="container mt-4">
    <h2>Tambah Buku</h2>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

        <div class="card mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input type="text" class="form-control" name="judul" required>
        </div>
        <div class="mb-3">
    <label class="form-label">Pilih Kategori</label>
    <div class="d-flex flex-wrap gap-3">
        <?php
        $sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
        $result_kategori = $mysqli->query($sql_kategori)
        ?>
        <?php while($kat = $result_kategori->fetch_assoc()) : ?>
            <input type="checkbox" name="kategori[]" value="<?php echo $kat['id_kategori'] ?>"><?php echo $kat['nama_kategori'] ?></input>
        <?php endwhile; 
        $mysqli->close(); ?> 
    </div>
</div>

        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input type="text" class="form-control" name="penulis" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penerbit</label>
            <input type="text" class="form-control" name="penerbit" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" name="tahun_terbit" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" required>
        </div>
         <div class="mb-4">
            <label for="cover" class="form-label">Upload Cover</label>
            <input type="file" name="cover" class="form-control" id="cover" type="file">
        </div>

        <button type="submit" class="btn btn-primary">Tambah Buku</button>
        <a href="index.php?hal=buku" class="btn btn-danger">Batal</a>
    </form>
 </div>

    

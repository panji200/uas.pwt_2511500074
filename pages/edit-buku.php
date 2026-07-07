<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan');
}

// Ambil data buku yang akan diedit
$buku = null;
$kategori_buku = [];

if(isset($_GET['id']) && !empty($_GET['id'])) {
   $id = $_GET['id'];
   $sql = "SELECT * FROM buku WHERE id_buku = ?";
   if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("i", $id);
      if($stmt->execute()) {
        $result = $stmt->get_result();
         if($result->num_rows == 1) {
            $buku = $result->fetch_assoc();
            
          
            $sql_kategori_buku = "SELECT id_kategori FROM buku_kategori WHERE id_buku = ?";
            if($stmt2 = $mysqli->prepare($sql_kategori_buku)) {
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                while($row = $result2->fetch_assoc()) {
                    $kategori_buku[] = $row['id_kategori'];
                }
                $stmt2->close();
            }
            
         } else {
            echo "Data buku tidak ditemukan";
            exit();
         }
      } else {
        echo "Error.";
        exit();
      }
      $stmt->close();
   }
} else {
    echo "ID buku tidak boleh kosong";
    exit();
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

     // proses upload cover
    $cover_name = $buku['cover_buku'];
    if(!empty($_FILES['cover']['name'])) {
      $target_dir = "uploads/buku/";
      $file_name = time() . "_" . basename($_FILES['cover']['name']);
      $target_file = $target_dir . $file_name;

      // proses upload
      if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)) {
        $cover_name = $file_name;
      }
    }

   
    $sql = "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ?, stok = ?, cover_buku = ? WHERE id_buku = ?";
    if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssiisi", $judul, $penulis, $penerbit, $tahun_terbit, $stok, $cover_name, $id); 
        if($stmt->execute()) {
            
           
            $mysqli->query("DELETE FROM buku_kategori WHERE id_buku = $id");
            
          
            if(!empty($_POST['kategori'])) {
                foreach($_POST['kategori'] as $id_kategori) {
                    $mysqli->query("INSERT INTO buku_kategori (id_buku, id_kategori) VALUES ($id, $id_kategori)");
                }
            }
            
            $pesan = "Buku berhasil diubah";
        } else {
            $pesan_error = "Gagal ubah buku";
        }
        $stmt->close();
    }
}
?>

<div class="container mt-4">
    <h2>Edit Buku</h2>
    
    <?php if(isset($pesan)): ?>
        <div class="alert alert-success"><?php echo $pesan; ?></div>
    <?php endif; ?>
    
    <?php if(isset($pesan_error)): ?>
        <div class="alert alert-danger"><?php echo $pesan_error; ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" name="judul" value="<?php echo $buku['judul']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Pilih Kategori</label>
                    <div class="d-flex flex-wrap gap-3">
                        <?php
                        $sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
                        $result_kategori = $mysqli->query($sql_kategori);
                        ?>
                        <?php while($kat = $result_kategori->fetch_assoc()) : ?>
                            <input type="checkbox" name="kategori[]" value="<?php echo $kat['id_kategori'] ?>" 
                                <?php echo in_array($kat['id_kategori'], $kategori_buku) ? 'checked' : ''; ?>> <!-- TAMBAH INI -->
                            <?php echo $kat['nama_kategori'] ?>
                        <?php endwhile; ?> 
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" class="form-control" name="penulis" value="<?php echo $buku['penulis']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" class="form-control" name="penerbit" value="<?php echo $buku['penerbit']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" name="tahun_terbit" value="<?php echo $buku['tahun_terbit']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stok" value="<?php echo $buku['stok']; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="cover" class="form-label">Upload Cover</label>
                    <input type="file" name="cover" class="form-control" id="cover">
                    <?php if(!empty($buku['cover_buku'])): ?>
                        <div class="mt-2">
                            <p>Cover saat ini:</p>
                            <img src="uploads/buku/<?php echo $buku['cover_buku']; ?>" width="100">
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="index.php?hal=buku" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>
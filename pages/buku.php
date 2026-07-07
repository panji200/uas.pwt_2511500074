<?php
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Data Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Buku</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            <a href="index.php?hal=tambah-buku" class="btn btn-primary mb-3">Tambah Buku</a>
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Kategori</th> 
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      // mengambil data buku dan kategori dari database
                        $sql = "SELECT b.*, GROUP_CONCAT(k.nama_kategori SEPARATOR ', ') as kategori // menghubungkan buku dan kategori
                                FROM buku b 
                                LEFT JOIN buku_kategori bk ON b.id_buku = bk.id_buku  
                                LEFT JOIN kategori k ON bk.id_kategori = k.id_kategori 
                                GROUP BY b.id_buku 
                                ORDER BY b.id_buku DESC";
                        $result = $mysqli->query($sql); //menjalankan perintah sql dan menyimpan hasilnya 
                        
                        if ($result->num_rows > 0) { // untuk mengecek apkah ada data buku yang ditemukan
                            $no = 1;
                            while ($row = $result->fetch_assoc()) { // menampilkan data buku satu per satu 
                                echo "
                                <tr>
                                    <td>{$no}</td>
                                    <td>";
                                
                                
                                if (!empty($row['cover_buku']) && $row['cover_buku'] != '0') { // menampilkan cover buku jika ada
                                    echo "<img src='uploads/buku/{$row['cover_buku']}' width='50' height='70' style='object-fit: cover; border: 1px solid #ddd;'>";
                                } else {
                                    echo "<div style='width:50px; height:70px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; font-size:10px; color:#666;'>No Cover</div>";
                                }
                                
                                echo "</td>
                                    <td>{$row['judul']}</td>
                                    <td>";
                                
                                // menampilkan kategori buku jika ada, jika tidak ada menampilkan teks "Tidak ada kategori"
                                if (!empty($row['kategori'])) {
                                    echo $row['kategori'];
                                } else {
                                    echo "<span class='text-muted'>Tidak ada kategori</span>";
                                }
                                // menampilkan penulis, penerbit, tahun terbit, dan stok buku
                                echo "</td>
                                    <td>{$row['penulis']}</td>
                                    <td>{$row['penerbit']}</td>
                                    <td>{$row['tahun_terbit']}</td>
                                    <td>{$row['stok']}</td>
                                   <td>
    <a href='index.php?hal=edit-buku&id={$row['id_buku']}' class='btn btn-warning btn-sm'>Edit</a>

    <a href='pages/hapus_buku.php?id={$row['id_buku']}'
       class='btn btn-danger btn-sm'
       onclick=\"return confirm('Yakin ingin menghapus data ini?')\">
       Hapus
    </a>
</td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>Tidak ada data buku</td></tr>"; // UBAH COLSPAN JADI 9
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
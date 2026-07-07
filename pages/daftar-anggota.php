<?php
if (!defined('MY_APP')) die('Akses langsung tidak diperbolehkan!');
$query = $mysqli->query("SELECT * FROM anggota ORDER BY id_anggota DESC");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Anggota</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users me-1"></i> Data Anggota</span>
            <a href="index.php?hal=tambah-anggota" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Anggota
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Lengkap</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 15%;">No Telepon</th>
                        <th>Alamat</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if ($query->num_rows > 0):
                        while($row = $query->fetch_assoc()):
                            $foto = (!empty($row['foto']) && file_exists("uploads/anggota/".$row['foto']))
                                ? "uploads/anggota/".htmlspecialchars($row['foto'])
                                : "assets/img/no-image.png";
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                <img src="<?= $foto ?>" 
                                     width="50" height="50" 
                                     class="rounded-circle border border-2 shadow-sm me-3" 
                                     alt="<?= htmlspecialchars($row['nama_lengkap']) ?>">
                                <div>
                                    <strong><?= htmlspecialchars($row['nama_lengkap']) ?></strong><br>
                                    <small class="text-muted">ID: <?= $row['id_anggota'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                        <td class="text-start"><?= nl2br(htmlspecialchars($row['alamat'])) ?></td>
                        <td>
                            <a href="index.php?hal=ubah-anggota&id=<?= $row['id_anggota'] ?>" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Ubah
                            </a>
                            <a href="index.php?hal=hapus_anggota&id=<?= $row['id_anggota']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin ingin menghapus anggota ini?')">
    Hapus
</a>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data anggota.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">DASHBOARD</div>
                <a class="nav-link <?php echo ($page == 'dashboard') ? 'active' : ''; ?>" href="index.php?hal=dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Manajemen</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Data Buku
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="index.php?hal=buku">Daftar Buku</a>
                        <a class="nav-link" href="index.php?hal=tambah-buku">Tambah Buku</a>
                    </nav>
                </div>
<?php 
    $kategori_active = (
        $page == "daftar-kategori" ||
        $page == "tambah-kategori" || 
        $page == "edit-kategori"
    );
?>
                <a class="nav-link <?php echo $kategori_active ? 'active' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="<?php echo $kategori_active ? 'true' : 'false'; ?>" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                    Kategori
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php echo $kategori_active ? 'show' : ''; ?>" id="collapsePages" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?php echo ($page == "daftar-kategori") ? "active" : ""; ?>" href="index.php?hal=daftar-kategori">Daftar Kategori</a>
                        <a class="nav-link <?php echo ($page == "tambah-kategori") ? "active" : ""; ?>" href="index.php?hal=tambah-kategori">Tambah Kategori</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#colapsAnggota" aria-expanded="false" aria-controls="colapsAnggota">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Anggota
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="colapsAnggota" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="index.php?hal=daftar-anggota">Daftar Anggota</a>
                        <a class="nav-link" href="index.php?hal=tambah-anggota">Tambah Anggota</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Transaksi</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#colapsPeminjaman" aria-expanded="false" aria-controls="colapsPeminjaman">
                    <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                    Peminjaman
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="colapsPeminjaman" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="index.php?hal=daftar_peminjaman">Daftar Peminjaman</a>
                        <a class="nav-link" href="index.php?hal=tambah_peminjaman">Tambah Peminjaman</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#colapsPengembalian" aria-expanded="false" aria-controls="colapsPengembalian">
                    <div class="sb-nav-link-icon"><i class="fas fa-undo"></i></div>
                    Pengembalian
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="colapsPengembalian" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="index.php?hal=konfirmasi_pengembalian">Konfirmasi</a> 
                    </nav>
                </div>
                <a class="nav-link" href="login.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
           PANJI    
        </div>
    </nav>
</div>
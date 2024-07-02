<style>
    .hovering .buku-box {
        transition: 0.3s all ease-in-out;
    }

    .hovering .buku-box:hover {
        transform: scale(1.05);
        transition: 0.3s all ease-in-out;
    }
</style>
<div class="container pt-3">
    <div class="bg-primary text-white py-2 my-3 rounded-3 shadow-xl">
        <marquee behavior="" direction=""><i class="fas fa-door-open"></i>&nbsp; Selamat Datang di Sistem Informasi Manajemen Perpustakaan</marquee>
    </div>
    <div class="row my-3">
        <div class="col-md-4 my-2">
            <div class="card shadow-sm border-none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>
                        <h5 class="text-primary fw-bold">Jumlah Kategori Buku</h5>
                        <h6><?= $kategori_buku ?></h6>
                    </span>
                    <i class="fas fa-list fa-3x"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('kategori') ?>" class="text-decoration-none"><i class="fas fa-info-circle"></i>&nbsp; Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-2">
            <div class="card shadow-sm border-none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>
                        <h5 class="text-primary fw-bold">Jumlah Jenjang</h5>
                        <h6><?= $jenjang ?></h6>
                    </span>
                    <i class="fas fa-box fa-3x"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('jenjang') ?>" class="text-decoration-none"><i class="fas fa-info-circle"></i>&nbsp; Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-2">
            <div class="card shadow-sm border-none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>
                        <h5 class="text-primary fw-bold">Jumlah Klasifikasi</h5>
                        <h6><?= $klasifikasi ?></h6>
                    </span>
                    <i class="fas fa-boxes fa-3x"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('klasifikasi') ?>" class="text-decoration-none"><i class="fas fa-info-circle"></i>&nbsp; Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-2">
            <div class="card shadow-sm border-none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>
                        <h5 class="text-primary fw-bold">Jumlah Buku</h5>
                        <h6><?= $buku ?></h6>
                    </span>
                    <i class="fas fa-book fa-3x"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('buku') ?>" class="text-decoration-none"><i class="fas fa-info-circle"></i>&nbsp; Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-2">
            <div class="card shadow-sm border-none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>
                        <h5 class="text-primary fw-bold">Jumlah Siswa</h5>
                        <h6><?= $siswa ?></h6>
                    </span>
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('siswa') ?>" class="text-decoration-none"><i class="fas fa-info-circle"></i>&nbsp; Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-2">
            <div class="card shadow-sm border-none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>
                        <h5 class="text-primary fw-bold">Jumlah Admin</h5>
                        <h6><?= $admin ?></h6>
                    </span>
                    <i class="fas fa-users-cog fa-3x"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin') ?>" class="text-decoration-none"><i class="fas fa-info-circle"></i>&nbsp; Lihat</a>
                </div>
            </div>
        </div>
    </div>
</div>
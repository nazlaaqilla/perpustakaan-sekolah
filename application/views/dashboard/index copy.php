<style>
    .hovering .buku-box {
        transition: 0.3s all ease-in-out;
    }

    .hovering .buku-box:hover {
        transform: scale(1.05);
        transition: 0.3s all ease-in-out;
    }
</style>
<div class="bg-primary text-white py-2 my-3 rounded-3 shadow-xl">
    <marquee behavior="" direction=""><i class="fas fa-door-open"></i>&nbsp; Selamat Datang di Sistem Informasi Manajemen Perpustakaan</marquee>
</div>
<?php if ($this->session->userdata('login') == true) : ?>
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
<?php endif ?>
<div class="card shadow-lg border-none mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Informasi Penggunaan</h5>
    </div>
    <div class="card-body">
        <p class="mb-1">Bacalah tahapan penggunaan Sistem Informasi Manajemen Perpustakaan berikut.</p>
        <ol class="ps-3">
            <li>Buka halaman "Beranda"</li>
            <li>Klik kolom "Cari Buku"</li>
            <li>Ketikkan salah satu kata kunci, baik itu dari judul buku, penerbit, pengarang, ataupun kategori buku</li>
            <li>Setelah diketikkan, akan secara otomatis muncul daftar buku sesuai apa yang diketikkan</li>
            <li>Bacalah kolom "Lokasi Buku" dan ingatlah</li>
            <li>Kemudian Anda cari rak yang bernamakan sesuai dengan kolom "Lokasi Buku" tersebut</li>
        </ol>
    </div>
</div>
<div class="bg-dark text-white p-5 rounded-3 shadow-lg text-center my-3">
    <h4 style="letter-spacing: 2px;" class="fw-bold text-primary">PENCARIAN BUKU</h4>
    <p>Lakukan pencarian dengan memasukkan judul buku, penerbit, pengarang, ataupun kategori buku</p>
    <input type="text" class="form-control rounded-pill shadow-sm border border-primary fas" name="search" id="search" placeholder="&#xf002; Cari Buku" autocomplete="off">
    <div id="search_box">
    </div>
</div>
<?php if ($listBukuTerfavorit != null) : ?>
    <div class="card shadow-lg border-none mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-book"></i>&nbsp; Buku Terfavorit</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($listBukuTerfavorit as $buku) : ?>
                    <div style="flex: 0 0 auto; width: 20%;">
                        <a href="<?= base_url('info_buku/' . $buku['isbn']) ?>" class="text-decoration-none hovering">
                            <div class="position-relative buku-box">
                                <img src="<?= base_url('assets/cover_buku/' . $buku['cover']) ?>" class="mb-2 w-100" style="aspect-ratio: 3/4; object-fit: cover; border-radius: 0.8rem;" alt="">
                                <small class="position-absolute bg-danger text-white px-3 py-1" style="top: 10px; right: -5px; font-size: 11px; border-radius: 0.3rem;"><i class="far fa-bookmark"></i>&nbsp; <?= $buku['nama_kategori'] ?></small>
                            </div>
                            <h6 class="text-muted"><?= $buku['judul_buku'] ?></h6>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php endif ?>
<script>
    $('#search').on('keyup', function() {
        const value = $(this).val()
        $.ajax({
            type: 'POST',
            url: "<?= base_url('dashboard/pencarian') ?>",
            data: {
                search: value
            },
            dataType: 'html',
            success: function(response) {
                $('#search_box').html(response)
            }
        })
    })
</script>
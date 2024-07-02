<div class="container pt-3">
    <a href="<?= base_url('') ?>" class="btn btn-sm btn-warning"><i class="fas fa-angle-left"></i>&nbsp; Kembali</a>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="position-relative buku-box w-75 mx-auto">
                <img src="<?= base_url('assets/cover_buku/' . $buku['cover']) ?>" class="mb-2 w-100" style="aspect-ratio: 3/4; object-fit: cover; border-radius: 0.8rem;" alt="">
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-2">
                <small class="bg-danger text-white px-3 py-1" style="font-size: 13px; border-radius: 0.3rem;"><i class="far fa-bookmark"></i>&nbsp; <?= $buku['nama_kategori'] ?></small>
            </div>
            <h4><?= $buku['judul_buku'] ?></h4>
            <p><i class="fas fa-minus"></i>&nbsp; <?= $buku['pengarang'] ?></p>
            <h6 class="mt-4"><i class="fas fa-info-circle"></i>&nbsp; Informasi Buku</h6>
            <hr>
            <table class="table-borderless">
                <tr>
                    <th class="pe-5">ISBN</th>
                    <td><?= $buku['isbn'] ?></td>
                </tr>
                <tr>
                    <th class="pe-5">Judul Buku</th>
                    <td><?= $buku['judul_buku'] ?></td>
                </tr>
                <tr>
                    <th class="pe-5">Kategori Buku</th>
                    <td><?= $buku['nama_kategori'] ?></td>
                </tr>
                <tr>
                    <th class="pe-5">Penerbit</th>
                    <td><?= $buku['penerbit'] ?></td>
                </tr>
                <tr>
                    <th class="pe-5">Pengarang</th>
                    <td><?= $buku['pengarang'] ?></td>
                </tr>
                <tr>
                    <th class="pe-5">Halaman</th>
                    <td><?= $buku['halaman'] ?></td>
                </tr>
                <tr>
                    <th class="pe-5">Jumlah</th>
                    <td><?= $buku['jumlah'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
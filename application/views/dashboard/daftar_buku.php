<div class="container pt-3">
    <?php foreach ($listBuku as $buku) : ?>
        <a href="<?= base_url('info_buku/' . $buku['isbn']) ?>" target="_blank" class="d-flex align-items-center px-3 py-3 border mb-2 bg-white shadow-sm justify-content-between d-block text-decoration-none text-dark rounded-3">
            <div class="d-flex" style="gap: 12px;">
                <img src="<?= base_url('assets/cover_buku/' . $buku['cover']) ?>" style="aspect-ratio: 3/4; width: 100px; object-fit: cover; border-radius: 0.8rem;" alt="">
                <div>
                    <h4 class="fw-bold"><?= $buku['judul_buku'] ?></h4>
                    <table class="table-borderless">
                        <tr>
                            <th class="pe-5">ISBN</th>
                            <td><?= $buku['isbn'] ?></td>
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
                    </table>
                </div>
            </div>
            <div class="border border-primary p-3 rounded-3 text-center">
                <h6 style="font-size: 13px;">Ketersediaan</h6>
                <h4 class="fw-bolder mb-0"><?= $this->buku_model->stokBuku($buku['isbn']) ?></h4>
            </div>
        </a>
    <?php endforeach; ?>
</div>
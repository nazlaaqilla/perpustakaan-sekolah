<div class="modal fade ubah" data-kode_rak="<?= $data['kode_rak'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-kode_rak="<?= $data['kode_rak'] ?>" action="" method="POST">
        <input type="hidden" name="kode_rak_lama" value="<?= $data['kode_rak'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Rak Penyimpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-kode_rak="<?= $data['kode_rak'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="kode_rak<?= $data['kode_rak'] ?>">Kode Rak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control kode_rak" data-kode_rak="<?= $data['kode_rak'] ?>" id="kode_rak<?= $data['kode_rak'] ?>" name="kode_rak" value="<?= $data['kode_rak'] ?>" required>
                        <div class="invalid-feedback feedback_kode_rak" data-kode_rak="<?= $data['kode_rak'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_rak<?= $data['kode_rak'] ?>">Nama Rak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama_rak" data-kode_rak="<?= $data['kode_rak'] ?>" id="nama_rak<?= $data['kode_rak'] ?>" name="nama_rak" value="<?= $data['nama_rak'] ?>" required>
                        <div class="invalid-feedback feedback_nama_rak" data-kode_rak="<?= $data['kode_rak'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori_buku<?= $data['kode_rak'] ?>">Kategori Buku <span class="text-danger">*</span></label>
                        <select class="form-control id_kategori_buku" data-kode_rak="<?= $data['kode_rak'] ?>" id="id_kategori_buku<?= $data['kode_rak'] ?>" name="id_kategori_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Kategori Buku --</option>
                            <?php foreach ($listKategori as $kategori) : ?>
                                <option value="<?= $kategori['id_kategori_buku'] ?>" <?= $data['id_kategori_buku'] == $kategori['id_kategori_buku'] ? 'selected' : '' ?>><?= $kategori['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback feedback_id_kategori_buku" data-kode_rak="<?= $data['kode_rak'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-kode_rak="<?= $data['kode_rak'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
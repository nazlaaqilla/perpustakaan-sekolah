<div class="modal fade ubah" data-isbn="<?= $data['isbn'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-isbn="<?= $data['isbn'] ?>" action="" method="POST">
        <input type="hidden" name="isbn_lama" value="<?= $data['isbn'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-isbn="<?= $data['isbn'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="isbn<?= $data['isbn'] ?>">ISBN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control isbn" data-isbn="<?= $data['isbn'] ?>" id="isbn<?= $data['isbn'] ?>" name="isbn" value="<?= $data['isbn'] ?>" required>
                        <div class="invalid-feedback feedback_isbn" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="judul_buku<?= $data['isbn'] ?>">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control judul_buku" data-isbn="<?= $data['isbn'] ?>" id="judul_buku<?= $data['isbn'] ?>" name="judul_buku" value="<?= $data['judul_buku'] ?>" required>
                        <div class="invalid-feedback feedback_judul_buku" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori_buku<?= $data['isbn'] ?>">Kategori Buku <span class="text-danger">*</span></label>
                        <select class="form-control id_kategori_buku" data-isbn="<?= $data['isbn'] ?>" id="id_kategori_buku<?= $data['isbn'] ?>" name="id_kategori_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Kategori Buku --</option>
                            <?php foreach ($listKategori as $kategori) : ?>
                                <option value="<?= $kategori['id_kategori_buku'] ?>" <?= $data['id_kategori_buku'] == $kategori['id_kategori_buku'] ? 'selected' : '' ?>><?= $kategori['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback feedback_id_kategori_buku" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="penerbit<?= $data['isbn'] ?>">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control penerbit" data-isbn="<?= $data['isbn'] ?>" id="penerbit<?= $data['isbn'] ?>" name="penerbit" value="<?= $data['penerbit'] ?>" required>
                        <div class="invalid-feedback feedback_penerbit" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang<?= $data['isbn'] ?>">Pengarang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control pengarang" data-isbn="<?= $data['isbn'] ?>" id="pengarang<?= $data['isbn'] ?>" name="pengarang" value="<?= $data['pengarang'] ?>" required>
                        <div class="invalid-feedback feedback_pengarang" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="halaman<?= $data['isbn'] ?>">Halaman <span class="text-danger">*</span></label>
                        <input type="number" class="form-control halaman" data-isbn="<?= $data['isbn'] ?>" id="halaman<?= $data['isbn'] ?>" name="halaman" value="<?= $data['halaman'] ?>" required>
                        <div class="invalid-feedback feedback_halaman" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah<?= $data['isbn'] ?>">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control jumlah" data-isbn="<?= $data['isbn'] ?>" id="jumlah<?= $data['isbn'] ?>" name="jumlah" value="<?= $data['jumlah'] ?>" required>
                        <div class="invalid-feedback feedback_jumlah" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="cover<?= $data['isbn'] ?>">Cover</label>
                        <input type="file" class="form-control cover" data-isbn="<?= $data['isbn'] ?>" id="cover<?= $data['isbn'] ?>" name="cover">
                        <div class="invalid-feedback feedback_cover" data-isbn="<?= $data['isbn'] ?>"></div>
                    </div>
                    <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_penyimpanan_buku'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                        <div class="mb-3">
                            <label for="id_klasifikasi<?= $data['isbn'] ?>">Klasifikasi <span class="text-danger">*</span></label>
                            <select class="form-control id_klasifikasi" data-isbn="<?= $data['isbn'] ?>" id="id_klasifikasi<?= $data['isbn'] ?>" name="id_klasifikasi" required>
                                <option value="" selected hidden disabled>-- Pilih Klasifikasi --</option>
                                <?php foreach ($listKlasifikasi as $klasifikasi) : ?>
                                    <option value="<?= $klasifikasi['id_klasifikasi'] ?>" <?= $data['id_klasifikasi'] == $klasifikasi['id_klasifikasi'] ? 'selected' : '' ?>><?= $klasifikasi['nama_klasifikasi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback feedback_id_klasifikasi" data-isbn="<?= $data['isbn'] ?>"></div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-isbn="<?= $data['isbn'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <form id="tambahForm" action="" method="POST">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel"><i class="fa fa-plus"></i>&nbsp; Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="pesan_error" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="isbn">ISBN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                        <div class="invalid-feedback" id="feedback_isbn"></div>
                    </div>
                    <div class="mb-3">
                        <label for="judul_buku">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
                        <div class="invalid-feedback" id="feedback_judul_buku"></div>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori_buku">Kategori Buku <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_kategori_buku" name="id_kategori_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Kategori Buku --</option>
                            <?php foreach ($listKategori as $kategori) : ?>
                                <option value="<?= $kategori['id_kategori_buku'] ?>"><?= $kategori['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="feedback_id_kategori_buku"></div>
                    </div>
                    <div class="mb-3">
                        <label for="penerbit">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                        <div class="invalid-feedback" id="feedback_penerbit"></div>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang">Pengarang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                        <div class="invalid-feedback" id="feedback_pengarang"></div>
                    </div>
                    <div class="mb-3">
                        <label for="halaman">Halaman <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="halaman" name="halaman" required>
                        <div class="invalid-feedback" id="feedback_halaman"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        <div class="invalid-feedback" id="feedback_jumlah"></div>
                    </div>
                    <div class="mb-3">
                        <label for="cover">Cover <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="cover" name="cover" required>
                        <div class="invalid-feedback" id="feedback_cover"></div>
                    </div>
                    <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_penyimpanan_buku'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                        <div class="mb-3">
                            <label for="id_klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
                            <select class="form-control" id="id_klasifikasi" name="id_klasifikasi" required>
                                <option value="" selected hidden disabled>-- Pilih Klasifikasi --</option>
                                <?php foreach ($listKlasifikasi as $klasifikasi) : ?>
                                    <option value="<?= $klasifikasi['id_klasifikasi'] ?>"><?= $klasifikasi['nama_klasifikasi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback" id="feedback_id_klasifikasi"></div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="tambahSubmit"><i class="fa fa-save"></i>&nbsp; Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>
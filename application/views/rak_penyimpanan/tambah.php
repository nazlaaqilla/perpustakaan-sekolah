<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <form id="tambahForm" action="" method="POST">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel"><i class="fa fa-plus"></i>&nbsp; Tambah Rak Penyimpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_rak">Kode Rak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_rak" name="kode_rak" required>
                        <div class="invalid-feedback" id="feedback_kode_rak"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_rak">Nama Rak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_rak" name="nama_rak" required>
                        <div class="invalid-feedback" id="feedback_nama_rak"></div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="tambahSubmit"><i class="fa fa-save"></i>&nbsp; Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>
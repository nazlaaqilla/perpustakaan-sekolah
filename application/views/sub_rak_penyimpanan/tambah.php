<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <form id="tambahForm" action="" method="POST">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel"><i class="fa fa-plus"></i>&nbsp; Tambah Sub Rak Penyimpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_sub_rak">Nama Sub Rak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_sub_rak" name="nama_sub_rak" required>
                        <div class="invalid-feedback" id="feedback_nama_sub_rak"></div>
                    </div>
                    <div class="mb-3">
                        <label for="kode_rak">Rak Penyimpanan <span class="text-danger">*</span></label>
                        <select class="form-control" id="kode_rak" name="kode_rak" required>
                            <option value="" selected hidden disabled>-- Pilih Rak Penyimpanan --</option>
                            <?php foreach ($listRak as $rak) : ?>
                                <option value="<?= $rak['kode_rak'] ?>"><?= $rak['nama_rak'] . ' - ' . $rak['kode_rak'] . ' (' . $rak['nama_kategori'] . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="feedback_kode_rak"></div>
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
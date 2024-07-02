<div class="modal fade ubah" data-id_sub_rak="<?= $data['id_sub_rak'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-id_sub_rak="<?= $data['id_sub_rak'] ?>" action="" method="POST">
        <input type="hidden" name="id_sub_rak" value="<?= $data['id_sub_rak'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Sub Rak Penyimpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-id_sub_rak="<?= $data['id_sub_rak'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nama_sub_rak<?= $data['id_sub_rak'] ?>">Nama Sub Rak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama_sub_rak" data-id_sub_rak="<?= $data['id_sub_rak'] ?>" id="nama_sub_rak<?= $data['id_sub_rak'] ?>" name="nama_sub_rak" value="<?= $data['nama_sub_rak'] ?>" required>
                        <div class="invalid-feedback feedback_nama_sub_rak" data-id_sub_rak="<?= $data['id_sub_rak'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="kode_rak<?= $data['id_sub_rak'] ?>">Rak Penyimpanan <span class="text-danger">*</span></label>
                        <select class="form-control kode_rak" data-id_sub_rak="<?= $data['id_sub_rak'] ?>" id="kode_rak<?= $data['id_sub_rak'] ?>" name="kode_rak" required>
                            <option value="" selected hidden disabled>-- Pilih Rak Penyimpanan --</option>
                            <?php foreach ($listRak as $rak) : ?>
                                <option value="<?= $rak['kode_rak'] ?>" <?= $data['kode_rak'] == $rak['kode_rak'] ? 'selected' : '' ?>><?= $rak['nama_rak'] . ' - ' . $rak['kode_rak'] . ' (' . $rak['nama_kategori'] . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback feedback_kode_rak" data-id_sub_rak="<?= $data['id_sub_rak'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-id_sub_rak="<?= $data['id_sub_rak'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade ubah" data-id_jenjang="<?= $data['id_jenjang'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-id_jenjang="<?= $data['id_jenjang'] ?>" action="" method="POST">
        <input type="hidden" name="id_jenjang" value=" <?= $data['id_jenjang'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Jenjang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-id_jenjang="<?= $data['id_jenjang'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nama_jenjang<?= $data['id_jenjang'] ?>">Nama Jenjang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama_jenjang" data-id_jenjang="<?= $data['id_jenjang'] ?>" id="nama_jenjang<?= $data['id_jenjang'] ?>" name="nama_jenjang" value="<?= $data['nama_jenjang'] ?>" required>
                        <div class="invalid-feedback feedback_nama_jenjang" data-id_jenjang="<?= $data['id_jenjang'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-id_jenjang="<?= $data['id_jenjang'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
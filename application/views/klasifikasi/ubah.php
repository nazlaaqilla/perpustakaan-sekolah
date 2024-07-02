<div class="modal fade ubah" data-id_klasifikasi="<?= $data['id_klasifikasi'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-id_klasifikasi="<?= $data['id_klasifikasi'] ?>" action="" method="POST">
        <input type="hidden" name="id_klasifikasi" value="<?= $data['id_klasifikasi'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Klasifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-id_klasifikasi="<?= $data['id_klasifikasi'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nama_klasifikasi<?= $data['id_klasifikasi'] ?>">Nama Klasifikasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama_klasifikasi" data-id_klasifikasi="<?= $data['id_klasifikasi'] ?>" id="nama_klasifikasi<?= $data['id_klasifikasi'] ?>" name="nama_klasifikasi" value="<?= $data['nama_klasifikasi'] ?>" required>
                        <div class="invalid-feedback feedback_nama_klasifikasi" data-id_klasifikasi="<?= $data['id_klasifikasi'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-id_klasifikasi="<?= $data['id_klasifikasi'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
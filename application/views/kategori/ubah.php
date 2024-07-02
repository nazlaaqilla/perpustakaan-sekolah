<div class="modal fade ubah" data-id_kategori_buku="<?= $data['id_kategori_buku'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-id_kategori_buku="<?= $data['id_kategori_buku'] ?>" action="" method="POST">
        <input type="hidden" name="id_kategori_buku" value=" <?= $data['id_kategori_buku'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-id_kategori_buku="<?= $data['id_kategori_buku'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nama_kategori<?= $data['id_kategori_buku'] ?>">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama_kategori" data-id_kategori_buku="<?= $data['id_kategori_buku'] ?>" id="nama_kategori<?= $data['id_kategori_buku'] ?>" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required>
                        <div class="invalid-feedback feedback_nama_kategori" data-id_kategori_buku="<?= $data['id_kategori_buku'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-id_kategori_buku="<?= $data['id_kategori_buku'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
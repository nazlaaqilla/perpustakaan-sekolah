<div class="modal fade ubah" data-nisn="<?= $data['nisn'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-nisn="<?= $data['nisn'] ?>" action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="nisn_lama" value=" <?= $data['nisn'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-nisn="<?= $data['nisn'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nisn<?= $data['nisn'] ?>">Nomor Induk Siswa Nasional <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nisn" data-nisn="<?= $data['nisn'] ?>" id="nisn<?= $data['nisn'] ?>" name="nisn" value="<?= $data['nisn'] ?>" required>
                        <div class="invalid-feedback feedback_nisn" data-nisn="<?= $data['nisn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nama<?= $data['nisn'] ?>">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama" data-nisn="<?= $data['nisn'] ?>" id="nama<?= $data['nisn'] ?>" name="nama" value="<?= $data['nama'] ?>" required>
                        <div class="invalid-feedback feedback_nama" data-nisn="<?= $data['nisn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="id_jenjang<?= $data['nisn'] ?>">Jenjang <span class="text-danger">*</span></label>
                        <select class="form-control id_jenjang" data-nisn="<?= $data['nisn'] ?>" id="id_jenjang<?= $data['nisn'] ?>" name="id_jenjang" required>
                            <option value="" selected hidden disabled>-- Pilih Jenjang --</option>
                            <?php foreach ($listJenjang as $jenjang) : ?>
                                <option value="<?= $jenjang['id_jenjang'] ?>" <?= $data['id_jenjang'] == $jenjang['id_jenjang'] ? 'selected' : '' ?>><?= $jenjang['nama_jenjang'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback feedback_id_jenjang" data-nisn="<?= $data['nisn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar<?= $data['nisn'] ?>">Gambar</label>
                        <input type="file" class="form-control gambar" data-nisn="<?= $data['nisn'] ?>" id="gambar<?= $data['nisn'] ?>" name="gambar">
                        <div class="invalid-feedback feedback_gambar" data-nisn="<?= $data['nisn'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_ponsel<?= $data['nisn'] ?>">Nomor Ponsel <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input type="number" class="form-control nomor_ponsel" data-nisn="<?= $data['nisn'] ?>" id="nomor_ponsel<?= $data['nisn'] ?>" name="nomor_ponsel" value="<?= $data['nomor_ponsel'] ?>" required>
                            <div class="invalid-feedback feedback_nomor_ponsel" data-nisn="<?= $data['nisn'] ?>"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat<?= $data['nisn'] ?>">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control alamat" data-nisn="<?= $data['nisn'] ?>" id="alamat<?= $data['nisn'] ?>" name="alamat" required><?= $data['alamat'] ?></textarea>
                        <div class="invalid-feedback feedback_alamat" data-nisn="<?= $data['nisn'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-nisn="<?= $data['nisn'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
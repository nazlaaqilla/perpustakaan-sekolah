<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <form id="tambahForm" action="" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel"><i class="fa fa-plus"></i>&nbsp; Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nisn">Nomor Induk Siswa Nasional <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nisn" name="nisn" required>
                        <div class="invalid-feedback" id="feedback_nisn"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                        <div class="invalid-feedback" id="feedback_nama"></div>
                    </div>
                    <div class="mb-3">
                        <label for="id_jenjang">Jenjang <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_jenjang" name="id_jenjang" required>
                            <option value="" selected hidden disabled>-- Pilih Jenjang --</option>
                            <?php foreach ($listJenjang as $jenjang) : ?>
                                <option value="<?= $jenjang['id_jenjang'] ?>"><?= $jenjang['nama_jenjang'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="feedback_id_jenjang"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <div class="invalid-feedback" id="feedback_gambar"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_ponsel">Nomor Ponsel <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input type="number" class="form-control" id="nomor_ponsel" name="nomor_ponsel" required>
                            <div class="invalid-feedback" id="feedback_nomor_ponsel"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        <div class="invalid-feedback" id="feedback_alamat"></div>
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
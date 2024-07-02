<div class="modal fade ubah" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_peminjaman" value=" <?= $data['id_peminjaman'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nisn<?= $data['id_peminjaman'] ?>">Siswa <span class="text-danger">*</span></label>
                        <select class="form-control nisn" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="nisn<?= $data['id_peminjaman'] ?>" name="nisn" required>
                            <option value="" selected hidden disabled>-- Pilih Siswa --</option>
                            <?php foreach ($listSiswa as $siswa) : ?>
                                <option value="<?= $siswa['nisn'] ?>" <?= $data['nisn'] == $siswa['nisn'] ? 'selected' : '' ?>><?= $siswa['nama'] . ' (' . $siswa['nisn'] . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback feedback_nisn" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="isbn<?= $data['id_peminjaman'] ?>">Buku <span class="text-danger">*</span></label>
                        <select class="form-control isbn" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="isbn<?= $data['id_peminjaman'] ?>" name="isbn" required>
                            <option value="" selected hidden disabled>-- Pilih Buku --</option>
                            <?php foreach ($listBuku as $buku) : ?>
                                <?php
                                $stok = $this->buku_model->stokBuku($buku['isbn']);
                                $stok = $data['isbn'] == $buku['isbn'] ? $stok + $data['jumlah'] : $stok;
                                ?>
                                <?php if ($stok > 0) : ?>
                                    <option value="<?= $buku['isbn'] ?>" <?= $data['isbn'] == $buku['isbn'] ? 'selected' : '' ?>><?= $buku['judul_buku'] . ' (' . $buku['isbn'] . ') - Stok ' . $stok  ?></option>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback feedback_isbn" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_peminjaman<?= $data['id_peminjaman'] ?>">Tanggal Peminjaman <span class="text-danger">*</span></label>
                        <input type="date" class="form-control tanggal_peminjaman" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="tanggal_peminjaman<?= $data['id_peminjaman'] ?>" name="tanggal_peminjaman" value="<?= $data['tanggal_peminjaman'] ?>" required>
                        <div class="invalid-feedback feedback_tanggal_peminjaman" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pengembalian<?= $data['id_peminjaman'] ?>">Tanggal Pengembalian</label>
                        <input type="date" class="form-control tanggal_pengembalian" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="tanggal_pengembalian<?= $data['id_peminjaman'] ?>" name="tanggal_pengembalian" value="<?= $data['tanggal_pengembalian'] ?>">
                        <div class="invalid-feedback feedback_tanggal_pengembalian" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah<?= $data['id_peminjaman'] ?>">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control jumlah" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="jumlah<?= $data['id_peminjaman'] ?>" name="jumlah" value="<?= $data['jumlah'] ?>" required>
                        <div class="invalid-feedback feedback_jumlah" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="lama_peminjaman<?= $data['id_peminjaman'] ?>">Lama Peminjaman <span class="text-danger">*</span></label>
                        <input type="number" class="form-control lama_peminjaman" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="lama_peminjaman<?= $data['id_peminjaman'] ?>" name="lama_peminjaman" value="<?= $data['lama_peminjaman'] ?>" required>
                        <div class="invalid-feedback feedback_lama_peminjaman" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="is_dikembalikan<?= $data['id_peminjaman'] ?>">Status <span class="text-danger">*</span></label>
                        <select class="form-control is_dikembalikan" data-id_peminjaman="<?= $data['id_peminjaman'] ?>" id="is_dikembalikan<?= $data['id_peminjaman'] ?>" name="is_dikembalikan" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="0" <?= $data['is_dikembalikan'] == '0' ? 'selected' : '' ?>>Dipinjam</option>
                            <option value="1" <?= $data['is_dikembalikan'] == '1' ? 'selected' : '' ?>>Sudah Dikembalikan</option>
                        </select>
                        <div class="invalid-feedback feedback_is_dikembalikan" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-id_peminjaman="<?= $data['id_peminjaman'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
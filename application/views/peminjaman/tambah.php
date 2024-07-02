<?php $this->load->model('BukuModel', 'buku_model'); ?>
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <form id="tambahForm" action="" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel"><i class="fa fa-plus"></i>&nbsp; Tambah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nisn">Siswa <span class="text-danger">*</span></label>
                        <select class="form-control" id="nisn" name="nisn" required>
                            <option value="" selected hidden disabled>-- Pilih Siswa --</option>
                            <?php foreach ($listSiswa as $siswa) : ?>
                                <option value="<?= $siswa['nisn'] ?>"><?= $siswa['nama'] . ' (' . $siswa['nisn'] . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="feedback_nisn"></div>
                    </div>
                    <div class="mb-3">
                        <label for="isbn">Buku <span class="text-danger">*</span></label>
                        <select class="form-control" id="isbn" name="isbn" required>
                            <option value="" selected hidden disabled>-- Pilih Buku --</option>
                            <?php foreach ($listBuku as $buku) : ?>
                                <?php $stok = $this->buku_model->stokBuku($buku['isbn']); ?>
                                <?php if ($stok > 0) : ?>
                                    <option value="<?= $buku['isbn'] ?>"><?= $buku['judul_buku'] . ' (' . $buku['isbn'] . ') - Stok ' . $stok ?></option>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="feedback_isbn"></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_peminjaman">Tanggal Peminjaman <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" required>
                        <div class="invalid-feedback" id="feedback_tanggal_peminjaman"></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian">
                        <div class="invalid-feedback" id="feedback_tanggal_pengembalian"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        <div class="invalid-feedback" id="feedback_jumlah"></div>
                    </div>
                    <div class="mb-3">
                        <label for="lama_peminjaman">Lama Peminjaman <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="lama_peminjaman" name="lama_peminjaman" required>
                        <div class="invalid-feedback" id="feedback_lama_peminjaman"></div>
                    </div>
                    <div class="mb-3">
                        <label for="is_dikembalikan">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="is_dikembalikan" name="is_dikembalikan" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="0">Dipinjam</option>
                            <option value="1">Sudah Dikembalikan</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_is_dikembalikan"></div>
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
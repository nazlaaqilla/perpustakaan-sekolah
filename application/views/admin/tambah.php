<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <form id="tambahForm" action="" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel"><i class="fa fa-plus"></i>&nbsp; Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                        <div class="invalid-feedback" id="feedback_nama"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback" id="feedback_email"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback" id="feedback_password"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <div class="invalid-feedback" id="feedback_gambar"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_buku">Permission Buku</label>
                        <select class="form-control" id="permission_buku" name="permission_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_buku"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_kategori_buku">Permission Kategori</label>
                        <select class="form-control" id="permission_kategori_buku" name="permission_kategori_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_kategori_buku"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_peminjaman_buku">Permission Peminjaman</label>
                        <select class="form-control" id="permission_peminjaman_buku" name="permission_peminjaman_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_peminjaman_buku"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_penyimpanan_buku">Permission Penyimpanan</label>
                        <select class="form-control" id="permission_penyimpanan_buku" name="permission_penyimpanan_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_penyimpanan_buku"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_klasifikasi">Permission Klasifikasi</label>
                        <select class="form-control" id="permission_klasifikasi" name="permission_klasifikasi" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_klasifikasi"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_jenjang">Permission Jenjang</label>
                        <select class="form-control" id="permission_jenjang" name="permission_jenjang" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_jenjang"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_siswa">Permission Siswa</label>
                        <select class="form-control" id="permission_siswa" name="permission_siswa" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        <div class="invalid-feedback" id="feedback_permission_siswa"></div>
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
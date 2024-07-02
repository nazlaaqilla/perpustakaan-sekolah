<div class="modal fade ubah" data-id_admin="<?= $data['id_admin'] ?>" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
    <form class="ubahForm" data-id_admin="<?= $data['id_admin'] ?>" action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_admin" value=" <?= $data['id_admin'] ?>" required>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahLabel"><i class="fa fa-edit"></i>&nbsp; Ubah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger pesan_error" data-id_admin="<?= $data['id_admin'] ?>" style="display: none;" role="alert"></div>
                    <div class="mb-3">
                        <label for="nama<?= $data['id_admin'] ?>">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nama" data-id_admin="<?= $data['id_admin'] ?>" id="nama<?= $data['id_admin'] ?>" name="nama" value="<?= $data['nama'] ?>" required>
                        <div class="invalid-feedback feedback_nama" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email<?= $data['id_admin'] ?>">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control email" data-id_admin="<?= $data['id_admin'] ?>" id="email<?= $data['id_admin'] ?>" name="email" value="<?= $data['email'] ?>" required>
                        <div class="invalid-feedback feedback_email" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password<?= $data['id_admin'] ?>">Password</label>
                        <input type="password" class="form-control password" data-id_admin="<?= $data['id_admin'] ?>" id="password<?= $data['id_admin'] ?>" name="password">
                        <div class="invalid-feedback feedback_password" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar<?= $data['id_admin'] ?>">Gambar</label>
                        <input type="file" class="form-control gambar" data-id_admin="<?= $data['id_admin'] ?>" id="gambar<?= $data['id_admin'] ?>" name="gambar">
                        <div class="invalid-feedback feedback_gambar" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_buku<?= $data['id_admin'] ?>">Permission Buku</label>
                        <select class="form-control permission_buku" data-id_admin="<?= $data['id_admin'] ?>" id="permission_buku<?= $data['id_admin'] ?>" name="permission_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_buku'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_buku'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_buku" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_kategori_buku<?= $data['id_admin'] ?>">Permission Kategori</label>
                        <select class="form-control permission_kategori_buku" data-id_admin="<?= $data['id_admin'] ?>" id="permission_kategori_buku<?= $data['id_admin'] ?>" name="permission_kategori_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_kategori_buku'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_kategori_buku'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_kategori_buku" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_peminjaman_buku<?= $data['id_admin'] ?>">Permission Peminjaman</label>
                        <select class="form-control permission_peminjaman_buku" data-id_admin="<?= $data['id_admin'] ?>" id="permission_peminjaman_buku<?= $data['id_admin'] ?>" name="permission_peminjaman_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_peminjaman_buku'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_peminjaman_buku'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_peminjaman_buku" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_penyimpanan_buku<?= $data['id_admin'] ?>">Permission Penyimpanan</label>
                        <select class="form-control permission_penyimpanan_buku" data-id_admin="<?= $data['id_admin'] ?>" id="permission_penyimpanan_buku<?= $data['id_admin'] ?>" name="permission_penyimpanan_buku" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_penyimpanan_buku'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_penyimpanan_buku'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_penyimpanan_buku" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_klasifikasi<?= $data['id_admin'] ?>">Permission Klasifikasi</label>
                        <select class="form-control permission_klasifikasi" data-id_admin="<?= $data['id_admin'] ?>" id="permission_klasifikasi<?= $data['id_admin'] ?>" name="permission_klasifikasi" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_klasifikasi'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_klasifikasi'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_klasifikasi" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_jenjang<?= $data['id_admin'] ?>">Permission Jenjang</label>
                        <select class="form-control permission_jenjang" data-id_admin="<?= $data['id_admin'] ?>" id="permission_jenjang<?= $data['id_admin'] ?>" name="permission_jenjang" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_jenjang'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_jenjang'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_jenjang" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_siswa<?= $data['id_admin'] ?>">Permission Siswa</label>
                        <select class="form-control permission_siswa" data-id_admin="<?= $data['id_admin'] ?>" id="permission_siswa<?= $data['id_admin'] ?>" name="permission_siswa" required>
                            <option value="" selected hidden disabled>-- Pilih Opsi --</option>
                            <option value="1" <?= $data['permission_siswa'] == '1' ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= $data['permission_siswa'] == '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <div class="invalid-feedback feedback_permission_siswa" data-id_admin="<?= $data['id_admin'] ?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm ubahSubmit" data-id_admin="<?= $data['id_admin'] ?>"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
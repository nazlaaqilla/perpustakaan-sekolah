<div class="container pt-3">
    <div class="row mt-5">
        <div class="col-md-7 mx-auto">
            <div class="card shadow-lg border-none">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Ubah Password</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="password_lama">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?= form_error('password_lama') ? 'is-invalid' : '' ?>" id="password_lama" name="password_lama" required>
                            <div class="invalid-feedback"><?= form_error('password_lama') ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="password_baru">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?= form_error('password_baru') ? 'is-invalid' : '' ?>" id="password_baru" name="password_baru" required>
                            <div class="invalid-feedback"><?= form_error('password_baru') ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="konfirmasi_password_baru">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?= form_error('konfirmasi_password_baru') ? 'is-invalid' : '' ?>" id="konfirmasi_password_baru" name="konfirmasi_password_baru" required>
                            <div class="invalid-feedback"><?= form_error('konfirmasi_password_baru') ?></div>
                        </div>
                        <div class="clearfix">
                            <button type="submit" class="float-end btn btn-primary btn-sm px-3 rounded-pill"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->session->flashdata('message') ?>
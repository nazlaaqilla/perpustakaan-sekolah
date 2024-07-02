<div class="container pt-3">
    <div class="row mt-5">
        <div class="col-md-7 mx-auto">
            <div class="card shadow-lg border-none mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <img src="<?= base_url('assets/image/' . $logo_aplikasi) ?>" class="rounded-circle shadow-sm bg-primary w-25 d-block mx-auto" style="aspect-ratio: 1 / 1;" alt="">
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border-none">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Website</h5>
                    <a href="<?= base_url('auth/backup_database') ?>" target="_blank" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Export Database (.sql)"><i class="fas fa-database"></i></a>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_aplikasi">Nama Aplikasi <span class="text-danger">*</span></label>
                            <input type="nama_aplikasi" class="form-control <?= form_error('nama_aplikasi') ? 'is-invalid' : '' ?>" id="nama_aplikasi" name="nama_aplikasi" value="<?= $nama_aplikasi ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_aplikasi') ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="logo_aplikasi">Logo Aplikasi</label>
                            <input type="file" class="form-control" id="logo_aplikasi" name="logo_aplikasi">
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
<script>
    $(document).ready(function() {
        tooltip()
    })
</script>
<div class="container pt-3">
    <div class="row mt-5">
        <div class="col-md-7 mx-auto">
            <div class="card shadow-lg border-none mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <img src="<?= base_url('assets/image/' . $data['gambar']) ?>" class="rounded-circle shadow-sm bg-primary" style="aspect-ratio: 1 / 1; width: 15%;" alt="">
                        <div>
                            <h5 class="mb-1 fw-bold"><?= ucwords(strtolower($data['nama'])) ?></h5>
                            <h6 class="mb-0 text-muted">Admin</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border-none">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Profil</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $data['email'] ?>" required>
                            <div class="invalid-feedback"><?= form_error('email') ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama') ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
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
<div class="container pt-3">
    <div class="row mt-5">
        <div class="col-md-7 mx-auto">
            <div class="card shadow-lg border-none">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa fa-sign-in-alt"></i>&nbsp; Sign In</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" required>
                            <div class="invalid-feedback"><?= form_error('email') ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" required>
                            <div class="invalid-feedback"><?= form_error('password') ?></div>
                        </div>
                        <div class="clearfix">
                            <button type="submit" class="float-end btn btn-primary btn-sm px-3 rounded-pill"><i class="fa fa-check"></i>&nbsp; Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->session->flashdata('message') ?>
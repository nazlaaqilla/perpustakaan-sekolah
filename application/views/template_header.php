<?php
$logo_aplikasi = $this->db->get_where('konfigurasi', ['nama' => 'logo_aplikasi'])->row_array()['nilai'];
$nama_aplikasi = $this->db->get_where('konfigurasi', ['nama' => 'nama_aplikasi'])->row_array()['nilai'];
$uri = $this->uri->segment(1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama_aplikasi ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/image/' . $logo_aplikasi) ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/DataTables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free-6.1.2-web/css/all.min.css') ?>">
    <script src="<?= base_url('assets/plugins/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/DataTables/datatables.min.js') ?>"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Quicksand', sans-serif;
        }

        select[readonly] option,
        select[readonly] optgroup {
            display: none;
        }

        @media(max-width: 768px) {
            .navbar-brand {
                font-size: 12px;
            }
        }
    </style>
</head>

<body style="background-color: #f2f3f8;">
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark <?= $this->uri->segment(1) == '' || $this->uri->segment(1) == 'index' ? 'bg-transparent' : 'bg-success' ?>">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/image/' . $logo_aplikasi) ?>" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                <?= $nama_aplikasi ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $uri == '' || $uri === 'index' ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <?php if ($this->session->userdata('login') == true) : ?>
                        <?php $admin = $this->db->get_where('admin', [
                            'id_admin' => $this->session->userdata('id_admin')
                        ])->row_array(); ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $uri === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard/admin') ?>">Dashboard</a>
                        </li>
                        <?php if ($this->session->userdata('is_superadmin') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'admin' ? 'active' : '' ?>" href="<?= base_url('admin') ?>">Admin</a>
                            </li>
                        <?php endif ?>
                        <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_jenjang'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'jenjang' ? 'active' : '' ?>" href="<?= base_url('jenjang') ?>">Jenjang</a>
                            </li>
                        <?php endif ?>
                        <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_siswa'] == 1)  || $this->session->userdata('is_superadmin') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'siswa' ? 'active' : '' ?>" href="<?= base_url('siswa') ?>">Siswa</a>
                            </li>
                        <?php endif ?>
                        <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_klasifikasi'] == 1)  || $this->session->userdata('is_superadmin') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'klasifikasi' ? 'active' : '' ?>" href="<?= base_url('klasifikasi') ?>">Klasifikasi</a>
                            </li>
                        <?php endif ?>
                        <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_kategori_buku'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'kategori' ? 'active' : '' ?>" href="<?= base_url('kategori') ?>">Kategori</a>
                            </li>
                        <?php endif ?>
                        <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_buku'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'buku' ? 'active' : '' ?>" href="<?= base_url('buku') ?>">Buku</a>
                            </li>
                        <?php endif ?>
                        <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_peminjaman_buku'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $uri === 'peminjaman' ? 'active' : '' ?>" href="<?= base_url('peminjaman') ?>">Peminjaman</a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= $uri === 'profil'  || $uri === 'website' || $uri === 'ubah_password' ? 'active' : '' ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pengaturan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item <?= $uri === 'profil' ? 'active' : '' ?>" href="<?= base_url('profil') ?>">Profil</a></li>
                                <?php if ($this->session->userdata('login') == true && $this->session->userdata('is_superadmin') == 1) : ?>
                                    <li><a class="dropdown-item <?= $uri === 'website' ? 'active' : '' ?>" href="<?= base_url('website') ?>">Website</a></li>
                                <?php endif ?>
                                <li><a class="dropdown-item <?= $uri === 'ubah_password' ? 'active' : '' ?>" href="<?= base_url('ubah_password') ?>">Ubah Password</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $uri === 'auth' ? 'active' : '' ?>" href="<?= base_url('auth') ?>">Masuk</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
<?php $this->load->helper('tanggal') ?>
<div class="modal fade info" data-isbn="<?= $data['isbn'] ?>" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoLabel"><i class="fa fa-edit"></i>&nbsp; Informasi Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ISBN</th>
                        <td><?= $data['isbn'] ?></td>
                    </tr>
                    <tr>
                        <th>Judul Buku</th>
                        <td><?= $data['judul_buku'] ?></td>
                    </tr>
                    <tr>
                        <th>Kategori Buku</th>
                        <td><?= $data['nama_kategori'] ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td><?= $data['penerbit'] ?></td>
                    </tr>
                    <tr>
                        <th>Pengarang</th>
                        <td><?= $data['pengarang'] ?></td>
                    </tr>
                    <tr>
                        <th>Halaman</th>
                        <td><?= $data['halaman'] ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td><?= $data['jumlah'] ?></td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th rowspan="3" class="align-middle text-center">No</th>
                                <th rowspan="3" class="align-middle text-center">Kategori</th>
                                <th colspan="4" class="align-middle text-center">Penyimpanan</th>
                            </tr>
                            <tr>
                                <th colspan="2" class="align-middle text-center">Rak</th>
                                <th rowspan="2" class="align-middle text-center">Sub Rak</th>
                                <th rowspan="2" class="align-middle text-center">Tanggal</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center">Kode</th>
                                <th class="align-middle text-center">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php foreach ($listPenyimpanan as $penyimpanan) : ?>
                                <tr>
                                    <td class="text-center"><?= $nomor++ ?></td>
                                    <td><?= $penyimpanan['nama_kategori'] ?></td>
                                    <td><?= $penyimpanan['kode_rak'] ?></td>
                                    <td><?= $penyimpanan['nama_rak'] ?></td>
                                    <td><?= $penyimpanan['nama_sub_rak'] ?></td>
                                    <td><?= tanggal_indo($penyimpanan['tanggal_disimpan']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
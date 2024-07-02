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
                    <tr>
                        <th>Barcode</th>
                        <td><img class="img-fluid" src="data:image/png;base64,<?= base64_encode($generator->getBarcode($data['isbn'], $generator::TYPE_CODE_128)) ?>" alt=""></td>
                    </tr>
                </table>
                <?php if (($this->session->userdata('is_superadmin') == 0 && $admin['permission_penyimpanan_buku'] == 1) || $this->session->userdata('is_superadmin') == 1) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th class="align-middle text-center">No</th>
                                    <th class="align-middle text-center">Klasifikasi</th>
                                    <th class="align-middle text-center">Tanggal</th>
                                    <th class="align-middle text-center">Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($listPenyimpanan != null) : ?>
                                    <?php $nomor = 1; ?>
                                    <?php foreach ($listPenyimpanan as $penyimpanan) : ?>
                                        <tr>
                                            <td class="text-center"><?= $nomor++ ?></td>
                                            <td><?= $penyimpanan['nama_klasifikasi'] ?></td>
                                            <td><?= tanggal_indo($penyimpanan['tanggal_disimpan']) ?></td>
                                            <td><?= $penyimpanan['dibuat_oleh'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No data available in table</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
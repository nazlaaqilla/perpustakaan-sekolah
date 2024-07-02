<table class="table table-bordered">
    <thead class="bg-primary text-center text-white">
        <tr>
            <th class="align-middle text-center">Aksi</th>
            <th class="align-middle text-center">ISBN</th>
            <th class="align-middle text-center">Judul Buku</th>
            <th class="align-middle text-center">Kategori Buku</th>
            <th class="align-middle text-center">Penerbit</th>
            <th class="align-middle text-center">Pengarang</th>
            <th class="align-middle text-center">Halaman</th>
            <th class="align-middle text-center">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($listBuku != null) : ?>
            <?php foreach ($listBuku as $key => $buku) : ?>
                <tr>
                    <input type="hidden" name="isbn[<?= $key ?>]" value="<?= $buku['isbn'] ?>">
                    <input type="hidden" name="id_kategori_buku[<?= $key ?>]" value="<?= $buku['id_kategori_buku'] ?>">
                    <input type="hidden" name="judul_buku[<?= $key ?>]" value="<?= $buku['judul_buku'] ?>">
                    <input type="hidden" name="penerbit[<?= $key ?>]" value="<?= $buku['penerbit'] ?>">
                    <input type="hidden" name="pengarang[<?= $key ?>]" value="<?= $buku['pengarang'] ?>">
                    <input type="hidden" name="halaman[<?= $key ?>]" value="<?= $buku['halaman'] ?>">
                    <input type="hidden" name="jumlah[<?= $key ?>]" value="<?= $buku['jumlah'] ?>">
                    <td>
                        <center>
                            <div class="custom-control custom-checkbox" style="margin-left : 0.65rem;">
                                <input type="checkbox" class="custom-control-input" name="terpilih[<?= $key ?>]" id="terpilih<?= $key ?>" value="1" checked>
                                <label class="custom-control-label" for="terpilih<?= $key ?>"></label>
                            </div>
                        </center>
                    </td>
                    <td><?= $buku['isbn'] ?></td>
                    <td><?= $buku['judul_buku'] ?></td>
                    <td><?= $buku['nama_kategori'] ?></td>
                    <td><?= $buku['penerbit'] ?></td>
                    <td><?= $buku['pengarang'] ?></td>
                    <td class="text-center"><?= $buku['halaman'] ?></td>
                    <td class="text-center"><?= $buku['jumlah'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="8" class="text-center">No data available in table</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
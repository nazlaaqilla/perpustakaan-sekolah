<table class="table table-bordered table-striped mt-4">
    <thead class="table-primary">
        <tr>
            <th class="align-middle text-center">No</th>
            <th class="align-middle text-center">ISBN</th>
            <th class="align-middle text-center">Judul Buku</th>
            <th class="align-middle text-center">Kategori Buku</th>
            <th class="align-middle text-center">Penerbit</th>
            <th class="align-middle text-center">Pengarang</th>
            <th class="align-middle text-center">Halaman</th>
            <th class="align-middle text-center">Lokasi Buku</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($listBuku != null) : ?>
            <?php $nomor = 1; ?>
            <?php foreach ($listBuku as $buku) : ?>
                <tr class="text-white">
                    <td class="text-center"><?= $nomor++ ?></td>
                    <td><a class="fw-bold" target="_blank" href="<?= base_url('info_buku/' . $buku['isbn']) ?>"><?= $buku['isbn'] ?></a></td>
                    <td><?= $buku['judul_buku'] ?></td>
                    <td><?= $buku['nama_kategori'] ?></td>
                    <td><?= $buku['penerbit'] ?></td>
                    <td><?= $buku['pengarang'] ?></td>
                    <td><?= $buku['halaman'] ?></td>
                    <td><?= $buku['nama_klasifikasi'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="8" class="text-center text-white"><i class="fas fa-times-circle text-danger"></i>&nbsp; Tidak ada data di tabel ini</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
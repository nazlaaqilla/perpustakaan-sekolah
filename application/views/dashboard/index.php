<style>
    .hovering .buku-box {
        transition: 0.3s all ease-in-out;
    }

    .hovering .buku-box:hover {
        transform: scale(1.05);
        transition: 0.3s all ease-in-out;
    }

    .mobile-view {
        padding-left: 300px;
        padding-right: 300px;
    }

    .mobile-width {
        flex: 0 0 auto;
        width: 20%;
    }

    .mobile-header {
        aspect-ratio: 28/9;
    }

    @media(max-width: 768px) {
        .mobile-header {
            aspect-ratio: 16/9;
        }

        .mobile-view {
            padding-left: 10px;
            padding-right: 10px;
        }

        .mobile-width {
            width: 50%;
        }
    }
</style>
<div class="mb-5" style="margin-top: -76px;">
    <div class="position-relative">
        <img src="<?= base_url('assets/image/slide1.jpg') ?>" class="w-100 mobile-header" style="object-fit: cover;" alt="">
        <div class="position-absolute w-100 mobile-view" style="bottom: -30px;">
            <input type="text" class="form-control shadow-sm" style="height: 70px;" name="search" id="search" placeholder="Masukkan kata kunci untuk mencari artikel" autocomplete="off">
        </div>
    </div>
    <div class="container" id="section-two">
        <div id="search_box" class="pt-3 pt-5">
        </div>
    </div>
</div>
<div class="container">
    <div class="text-center mb-4">
        <h5 class="mb-3">Carilah buku berdasarkan kategori</h5>
        <div class="d-flex justify-content-center" style="flex-wrap: wrap; gap: 5px; overflow: hidden;">
            <?php foreach ($listKategori as $kategori) : ?>
                <a href="<?= base_url('info_kategori/' . $kategori['id_kategori_buku']) ?>" class="btn btn-outline-secondary rounded-pill"><?= $kategori['nama_kategori'] ?></a>
            <?php endforeach ?>
        </div>
    </div>
    <?php if ($listBukuTerfavorit != null) : ?>
        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-book"></i>&nbsp; Buku Terfavorit</h5>
        <p>Terdapat beberapa buku atau artikel yang sering dipinjam oleh pengguna</p>
        <div class="row">
            <?php foreach ($listBukuTerfavorit as $buku) : ?>
                <div class="mobile-width">
                    <a href="<?= base_url('info_buku/' . $buku['isbn']) ?>" class="text-decoration-none hovering">
                        <div class="position-relative buku-box">
                            <img src="<?= base_url('assets/cover_buku/' . $buku['cover']) ?>" class="mb-2 w-100" style="aspect-ratio: 3/4; object-fit: cover; border-radius: 0.8rem;" alt="">
                            <small class="position-absolute bg-danger text-white px-3 py-1" style="top: 10px; right: -5px; font-size: 11px; border-radius: 0.3rem;"><i class="far fa-bookmark"></i>&nbsp; <?= $buku['nama_kategori'] ?></small>
                        </div>
                        <h6 class="text-dark"><?= $buku['judul_buku'] ?></h6>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
<script>
    $('#search').on('keyup', function() {
        const value = $(this).val()
        $.ajax({
            type: 'POST',
            url: "<?= base_url('dashboard/pencarian') ?>",
            data: {
                search: value
            },
            dataType: 'html',
            success: function(response) {
                $('#search_box').html(response)
            }
        })
    })
</script>
<script>
    var scroll_start = 0;
    var startchange = $('#section-two');

    function navbarColor() {
        if (startchange.length) {
            scroll_start = $(window).scrollTop();

            if (scroll_start > (startchange.offset().top - 25)) {
                $(".navbar").addClass('bg-success');
                $(".navbar").removeClass('bg-transparent');
                $(".navbar").addClass('shadow');
            } else {
                $(".navbar").removeClass('bg-success');
                $(".navbar").addClass('bg-transparent');
                $(".navbar").removeClass('shadow');
            }
        }
    }

    $(document).scroll(function() {
        navbarColor()
    })

    document.getElementById('navbarSupportedContent').addEventListener('show.bs.collapse', function() {
        $(".navbar").addClass('bg-success')
        $(".navbar").removeClass('bg-transparent');
        $(".navbar").addClass('shadow');
    })

    document.getElementById('navbarSupportedContent').addEventListener('hide.bs.collapse', function() {
        navbarColor()
    })
</script>
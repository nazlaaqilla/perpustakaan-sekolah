<div class="card shadow-lg border-none">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Rak Penyimpanan</h5>
        <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-data" class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th rowspan="2" class="align-middle text-center">No</th>
                        <th rowspan="2" class="align-middle text-center">Kategori</th>
                        <th colspan="2" class="align-middle text-center">Rak</th>
                        <th rowspan="2" class="align-middle text-center">Dibuat</th>
                        <th rowspan="2" class="align-middle text-center">Diubah</th>
                        <th rowspan="2" class="align-middle text-center" style="display: table-cell !important;">Aksi</th>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">Kode</th>
                        <th class="align-middle text-center">Nama</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modals"></div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(async function() {
        $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                async: true,
                url: "<?= base_url('rak_penyimpanan/ambil_data') ?>",
                type: 'GET'
            },
            columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center'
            }, {
                data: 'nama_kategori',
                name: 'nama_kategori'
            }, {
                data: 'kode_rak',
                name: 'kode_rak'
            }, {
                data: 'nama_rak',
                name: 'nama_rak'
            }, {
                data: 'dibuat_oleh',
                name: 'dibuat_oleh'
            }, {
                data: 'diubah_oleh',
                name: 'diubah_oleh'
            }, {
                data: 'aksi',
                name: 'aksi',
                className: 'text-center'
            }],
            initComplete: function() {
                tooltip()
            }
        })
    })

    function tambah() {
        if ($('#tambah').length > 0) {
            $('#tambah').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('rak_penyimpanan/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(kode_rak) {
        if ($('.ubah[data-kode_rak="' + kode_rak + '"]').length > 0) {
            $('.ubah[data-kode_rak="' + kode_rak + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('rak_penyimpanan/modal_ubah') ?>",
                data: {
                    kode_rak: kode_rak
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-kode_rak="' + kode_rak + '"]').modal('show')
                }
            })
        }
    }

    function hapus(kode_rak) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('rak_penyimpanan/hapus') ?>",
                    data: {
                        kode_rak: kode_rak
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Rak Penyimpanan telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Rak Penyimpanan gagal untuk dihapuskan', 'error')
                        }
                    }
                })
            }
        })
    }

    $(document).on('submit', '#tambahForm', function(e) {
        e.preventDefault()
        const form = $(this).serialize()
        $('#tambahSubmit').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('#tambahSubmit').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('rak_penyimpanan/tambah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Rak Penyimpanan telah berhasil ditambahkan', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('#tambah').remove()
                    }, 1000)
                } else {
                    if (response.status == false) {
                        if (response.message != null && response.message != '') {
                            $('#pesan_error').html(response.message)
                            $('#pesan_error').show()
                        } else {
                            $('#pesan_error').html('')
                            $('#pesan_error').hide()
                        }

                        if (response.kode_rak_error != null && response.kode_rak_error != '') {
                            $('#kode_rak').addClass('is-invalid')
                            $('#kode_rak').removeClass('is-valid')
                            $('#feedback_kode_rak').html(response.kode_rak_error)
                        } else {
                            $('#kode_rak').removeClass('is-invalid')
                            $('#kode_rak').addClass('is-valid')
                            $('#feedback_kode_rak').html('')
                        }

                        if (response.nama_rak_error != null && response.nama_rak_error != '') {
                            $('#nama_rak').addClass('is-invalid')
                            $('#nama_rak').removeClass('is-valid')
                            $('#feedback_nama_rak').html(response.nama_rak_error)
                        } else {
                            $('#nama_rak').removeClass('is-invalid')
                            $('#nama_rak').addClass('is-valid')
                            $('#feedback_nama_rak').html('')
                        }

                        if (response.id_kategori_buku_error != null && response.id_kategori_buku_error != '') {
                            $('#id_kategori_buku').addClass('is-invalid')
                            $('#id_kategori_buku').removeClass('is-valid')
                            $('#feedback_id_kategori_buku').html(response.id_kategori_buku_error)
                        } else {
                            $('#id_kategori_buku').removeClass('is-invalid')
                            $('#id_kategori_buku').addClass('is-valid')
                            $('#feedback_id_kategori_buku').html('')
                        }
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')
                $('#pesan_error').html(xhr.status + ' - ' + thrownError)
                $('#pesan_error').show()
            }
        })
    })

    $(document).on('submit', '.ubahForm', function(e) {
        e.preventDefault()
        const kode_rak = $(this).attr('data-kode_rak')
        const form = $(this).serialize()
        $('.ubahSubmit[data-kode_rak="' + kode_rak + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-kode_rak="' + kode_rak + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('rak_penyimpanan/ubah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-kode_rak="' + kode_rak + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-kode_rak="' + kode_rak + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-kode_rak="' + kode_rak + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Rak Penyimpanan telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-kode_rak="' + kode_rak + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-kode_rak="' + kode_rak + '"]').html(response.message)
                        $('.pesan_error[data-kode_rak="' + kode_rak + '"]').show()
                    } else {
                        $('.pesan_error[data-kode_rak="' + kode_rak + '"]').html('')
                        $('.pesan_error[data-kode_rak="' + kode_rak + '"]').hide()
                    }

                    if (response.kode_rak_error != null && response.kode_rak_error != '') {
                        $('.kode_rak[data-kode_rak="' + kode_rak + '"]').addClass('is-invalid')
                        $('.kode_rak[data-kode_rak="' + kode_rak + '"]').removeClass('is-valid')
                        $('.feedback_kode_rak[data-kode_rak="' + kode_rak + '"]').html(response.kode_rak_error)
                    } else {
                        $('.kode_rak[data-kode_rak="' + kode_rak + '"]').removeClass('is-invalid')
                        $('.kode_rak[data-kode_rak="' + kode_rak + '"]').addClass('is-valid')
                        $('.feedback_kode_rak[data-kode_rak="' + kode_rak + '"]').html('')
                    }

                    if (response.nama_rak_error != null && response.nama_rak_error != '') {
                        $('.nama_rak[data-kode_rak="' + kode_rak + '"]').addClass('is-invalid')
                        $('.nama_rak[data-kode_rak="' + kode_rak + '"]').removeClass('is-valid')
                        $('.feedback_nama_rak[data-kode_rak="' + kode_rak + '"]').html(response.nama_rak_error)
                    } else {
                        $('.nama_rak[data-kode_rak="' + kode_rak + '"]').removeClass('is-invalid')
                        $('.nama_rak[data-kode_rak="' + kode_rak + '"]').addClass('is-valid')
                        $('.feedback_nama_rak[data-kode_rak="' + kode_rak + '"]').html('')
                    }

                    if (response.id_kategori_buku_error != null && response.id_kategori_buku_error != '') {
                        $('.id_kategori_buku[data-kode_rak="' + kode_rak + '"]').addClass('is-invalid')
                        $('.id_kategori_buku[data-kode_rak="' + kode_rak + '"]').removeClass('is-valid')
                        $('.feedback_id_kategori_buku[data-kode_rak="' + kode_rak + '"]').html(response.id_kategori_buku_error)
                    } else {
                        $('.id_kategori_buku[data-kode_rak="' + kode_rak + '"]').removeClass('is-invalid')
                        $('.id_kategori_buku[data-kode_rak="' + kode_rak + '"]').addClass('is-valid')
                        $('.feedback_id_kategori_buku[data-kode_rak="' + kode_rak + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-kode_rak="' + kode_rak + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-kode_rak="' + kode_rak + '"]').removeClass('disabled')
                $('.pesan_error[data-id_sub_rak="' + id_sub_rak + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-id_sub_rak="' + id_sub_rak + '"]').show()
            }
        })
    })
</script>
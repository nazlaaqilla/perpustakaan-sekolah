<div class="container pt-3">
    <div class="card shadow-lg border-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Kategori</h5>
            <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">Nama Kategori</th>
                            <th class="align-middle text-center">Dibuat</th>
                            <th class="align-middle text-center">Diubah</th>
                            <th class="align-middle text-center" style="display: table-cell !important;">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
                url: "<?= base_url('kategori/ambil_data') ?>",
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
                url: "<?= base_url('kategori/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(id_kategori_buku) {
        if ($('.ubah[data-id_kategori_buku="' + id_kategori_buku + '"]').length > 0) {
            $('.ubah[data-id_kategori_buku="' + id_kategori_buku + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('kategori/modal_ubah') ?>",
                data: {
                    id_kategori_buku: id_kategori_buku
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-id_kategori_buku="' + id_kategori_buku + '"]').modal('show')
                }
            })
        }
    }

    function hapus(id_kategori_buku) {
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
                    url: "<?= base_url('kategori/hapus') ?>",
                    data: {
                        id_kategori_buku: id_kategori_buku
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Kategori telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Kategori gagal untuk dihapuskan', 'error')
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
            url: "<?= base_url('kategori/tambah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Kategori telah berhasil ditambahkan', 'success')

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

                        if (response.nama_kategori_error != null && response.nama_kategori_error != '') {
                            $('#nama_kategori').addClass('is-invalid')
                            $('#nama_kategori').removeClass('is-valid')
                            $('#feedback_nama_kategori').html(response.nama_kategori_error)
                        } else {
                            $('#nama_kategori').removeClass('is-invalid')
                            $('#nama_kategori').addClass('is-valid')
                            $('#feedback_nama_kategori').html('')
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
        const id_kategori_buku = $(this).attr('data-id_kategori_buku')
        const form = $(this).serialize()
        $('.ubahSubmit[data-id_kategori_buku="' + id_kategori_buku + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-id_kategori_buku="' + id_kategori_buku + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('kategori/ubah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-id_kategori_buku="' + id_kategori_buku + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_kategori_buku="' + id_kategori_buku + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-id_kategori_buku="' + id_kategori_buku + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Kategori telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-id_kategori_buku="' + id_kategori_buku + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-id_kategori_buku="' + id_kategori_buku + '"]').html(response.message)
                        $('.pesan_error[data-id_kategori_buku="' + id_kategori_buku + '"]').show()
                    } else {
                        $('.pesan_error[data-id_kategori_buku="' + id_kategori_buku + '"]').html('')
                        $('.pesan_error[data-id_kategori_buku="' + id_kategori_buku + '"]').hide()
                    }

                    if (response.nama_kategori_error != null && response.nama_kategori_error != '') {
                        $('.nama_kategori[data-id_kategori_buku="' + id_kategori_buku + '"]').addClass('is-invalid')
                        $('.nama_kategori[data-id_kategori_buku="' + id_kategori_buku + '"]').removeClass('is-valid')
                        $('.feedback_nama_kategori[data-id_kategori_buku="' + id_kategori_buku + '"]').html(response.nama_kategori_error)
                    } else {
                        $('.nama_kategori[data-id_kategori_buku="' + id_kategori_buku + '"]').removeClass('is-invalid')
                        $('.nama_kategori[data-id_kategori_buku="' + id_kategori_buku + '"]').addClass('is-valid')
                        $('.feedback_nama_kategori[data-id_kategori_buku="' + id_kategori_buku + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-id_kategori_buku="' + id_kategori_buku + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_kategori_buku="' + id_kategori_buku + '"]').removeClass('disabled')
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').show()
            }
        })
    })
</script>
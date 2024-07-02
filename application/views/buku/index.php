<div class="container pt-3">
    <div class="card shadow-lg border-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Buku</h5>
            <div>
                <a href="<?= base_url('buku/export') ?>" target="_blank" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Export"><i class="fas fa-download"></i></a>
                <button onclick="importExcel()" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Import"><i class="fas fa-file-excel"></i></button>
                <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">No</th>
                            <th rowspan="2" class="align-middle text-center">ISBN</th>
                            <th rowspan="2" class="align-middle text-center">Judul Buku</th>
                            <th rowspan="2" class="align-middle text-center">Kategori Buku</th>
                            <th rowspan="2" class="align-middle text-center">Penerbit</th>
                            <th rowspan="2" class="align-middle text-center">Pengarang</th>
                            <th rowspan="2" class="align-middle text-center">Halaman</th>
                            <th colspan="2" class="align-middle text-center">Jumlah</th>
                            <th rowspan="2" class="align-middle text-center">Dibuat</th>
                            <th rowspan="2" class="align-middle text-center">Diubah</th>
                            <th rowspan="2" class="align-middle text-center" style="display: table-cell !important;">Aksi</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">Total</th>
                            <th class="align-middle text-center">Ketersediaan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modals">
    <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
        <form id="importExcelForm" action="" method="POST" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importExcelLabel"><i class="fa fa-file-excel"></i>&nbsp; Import Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" id="pesan_error" style="display: none;" role="alert"></div>
                        <div class="mb-3">
                            <label for="file_excel">File Excel <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="file_excel" name="file_excel" required>
                            <div class="invalid-feedback" id="feedback_file_excel"></div>
                        </div>
                        <div class="table-responsive" id="table_import"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm disabled" id="importSubmit"><i class="fa fa-check"></i>&nbsp; Import</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(async function() {
        $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                async: true,
                url: "<?= base_url('buku/ambil_data') ?>",
                type: 'GET'
            },
            columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center'
            }, {
                data: 'isbn',
                name: 'isbn'
            }, {
                data: 'judul_buku',
                name: 'judul_buku'
            }, {
                data: 'nama_kategori',
                name: 'nama_kategori'
            }, {
                data: 'penerbit',
                name: 'penerbit'
            }, {
                data: 'pengarang',
                name: 'pengarang'
            }, {
                data: 'halaman',
                name: 'halaman',
                className: 'text-center'
            }, {
                data: 'jumlah',
                name: 'jumlah',
                className: 'text-center'
            }, {
                data: 'ketersediaan',
                name: 'ketersediaan',
                className: 'text-center',
                searchable: false,
                sortable: false
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

    function importExcel() {
        $('#importExcel').modal('show')
    }

    function tambah() {
        if ($('#tambah').length > 0) {
            $('#tambah').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('buku/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(isbn) {
        if ($('.ubah[data-isbn="' + isbn + '"]').length > 0) {
            $('.ubah[data-isbn="' + isbn + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('buku/modal_ubah') ?>",
                data: {
                    isbn: isbn
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-isbn="' + isbn + '"]').modal('show')
                }
            })
        }
    }

    function info(isbn) {
        if ($('.info[data-isbn="' + isbn + '"]').length > 0) {
            $('.info[data-isbn="' + isbn + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('buku/modal_info') ?>",
                data: {
                    isbn: isbn
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.info[data-isbn="' + isbn + '"]').modal('show')
                }
            })
        }
    }

    function hapus(isbn) {
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
                    url: "<?= base_url('buku/hapus') ?>",
                    data: {
                        isbn: isbn
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Buku telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Buku gagal untuk dihapuskan', 'error')
                        }
                    }
                })
            }
        })
    }

    $(document).on('change', '#file_excel', function() {
        const form = new FormData(document.querySelector('#importExcelForm'))
        $.ajax({
            type: 'POST',
            url: "<?= base_url('buku/import_excel') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'html',
            success: function(response) {
                $('#importSubmit').removeClass('disabled')
                $('#table_import').html(response)
            }
        })
    })

    $(document).on('submit', '#importExcelForm', function(e) {
        e.preventDefault()
        const form = $(this).serialize()
        $('#importSubmit').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('#importSubmit').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('buku/import_process') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('#importSubmit').html('<i class="fas fa-check"></i>&nbsp; Import')
                $('#importSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#importExcel').modal('hide')
                    Swal.fire('Berhasil', 'Buku telah berhasil diimport', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('#table_import').html('')
                        $('#importSubmit').addClass('disabled')
                    }, 1000)
                }
            }
        })
    })

    $(document).on('submit', '#tambahForm', function(e) {
        e.preventDefault()
        const form = new FormData(this)
        $('#tambahSubmit').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('#tambahSubmit').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('buku/tambah') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Buku telah berhasil ditambahkan', 'success')

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

                        if (response.isbn_error != null && response.isbn_error != '') {
                            $('#isbn').addClass('is-invalid')
                            $('#isbn').removeClass('is-valid')
                            $('#feedback_isbn').html(response.isbn_error)
                        } else {
                            $('#isbn').removeClass('is-invalid')
                            $('#isbn').addClass('is-valid')
                            $('#feedback_isbn').html('')
                        }

                        if (response.judul_buku_error != null && response.judul_buku_error != '') {
                            $('#judul_buku').addClass('is-invalid')
                            $('#judul_buku').removeClass('is-valid')
                            $('#feedback_judul_buku').html(response.judul_buku_error)
                        } else {
                            $('#judul_buku').removeClass('is-invalid')
                            $('#judul_buku').addClass('is-valid')
                            $('#feedback_judul_buku').html('')
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

                        if (response.penerbit_error != null && response.penerbit_error != '') {
                            $('#penerbit').addClass('is-invalid')
                            $('#penerbit').removeClass('is-valid')
                            $('#feedback_penerbit').html(response.penerbit_error)
                        } else {
                            $('#penerbit').removeClass('is-invalid')
                            $('#penerbit').addClass('is-valid')
                            $('#feedback_penerbit').html('')
                        }

                        if (response.pengarang_error != null && response.pengarang_error != '') {
                            $('#pengarang').addClass('is-invalid')
                            $('#pengarang').removeClass('is-valid')
                            $('#feedback_pengarang').html(response.pengarang_error)
                        } else {
                            $('#pengarang').removeClass('is-invalid')
                            $('#pengarang').addClass('is-valid')
                            $('#feedback_pengarang').html('')
                        }

                        if (response.halaman_error != null && response.halaman_error != '') {
                            $('#halaman').addClass('is-invalid')
                            $('#halaman').removeClass('is-valid')
                            $('#feedback_halaman').html(response.halaman_error)
                        } else {
                            $('#halaman').removeClass('is-invalid')
                            $('#halaman').addClass('is-valid')
                            $('#feedback_halaman').html('')
                        }

                        if (response.jumlah_error != null && response.jumlah_error != '') {
                            $('#jumlah').addClass('is-invalid')
                            $('#jumlah').removeClass('is-valid')
                            $('#feedback_jumlah').html(response.jumlah_error)
                        } else {
                            $('#jumlah').removeClass('is-invalid')
                            $('#jumlah').addClass('is-valid')
                            $('#feedback_jumlah').html('')
                        }

                        if (response.cover_error != null && response.cover_error != '') {
                            $('#cover').addClass('is-invalid')
                            $('#cover').removeClass('is-valid')
                            $('#feedback_cover').html(response.cover_error)
                        } else {
                            $('#cover').removeClass('is-invalid')
                            $('#cover').addClass('is-valid')
                            $('#feedback_cover').html('')
                        }

                        if (response.id_klasifikasi_error != null && response.id_klasifikasi_error != '') {
                            $('#id_klasifikasi').addClass('is-invalid')
                            $('#id_klasifikasi').removeClass('is-valid')
                            $('#feedback_id_klasifikasi').html(response.id_klasifikasi_error)
                        } else {
                            $('#id_klasifikasi').removeClass('is-invalid')
                            $('#id_klasifikasi').addClass('is-valid')
                            $('#feedback_id_klasifikasi').html('')
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
        const isbn = $(this).attr('data-isbn')
        const form = new FormData(this)
        $('.ubahSubmit[data-isbn="' + isbn + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-isbn="' + isbn + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('buku/ubah') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-isbn="' + isbn + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-isbn="' + isbn + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-isbn="' + isbn + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Buku telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-isbn="' + isbn + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-isbn="' + isbn + '"]').html(response.message)
                        $('.pesan_error[data-isbn="' + isbn + '"]').show()
                    } else {
                        $('.pesan_error[data-isbn="' + isbn + '"]').html('')
                        $('.pesan_error[data-isbn="' + isbn + '"]').hide()
                    }

                    if (response.isbn_error != null && response.isbn_error != '') {
                        $('.isbn[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.isbn[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_isbn[data-isbn="' + isbn + '"]').html(response.isbn_error)
                    } else {
                        $('.isbn[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.isbn[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_isbn[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.judul_buku_error != null && response.judul_buku_error != '') {
                        $('.judul_buku[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.judul_buku[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_judul_buku[data-isbn="' + isbn + '"]').html(response.judul_buku_error)
                    } else {
                        $('.judul_buku[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.judul_buku[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_judul_buku[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.id_kategori_buku_error != null && response.id_kategori_buku_error != '') {
                        $('.id_kategori_buku[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.id_kategori_buku[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_id_kategori_buku[data-isbn="' + isbn + '"]').html(response.id_kategori_buku_error)
                    } else {
                        $('.id_kategori_buku[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.id_kategori_buku[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_id_kategori_buku[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.penerbit_error != null && response.penerbit_error != '') {
                        $('.penerbit[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.penerbit[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_penerbit[data-isbn="' + isbn + '"]').html(response.penerbit_error)
                    } else {
                        $('.penerbit[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.penerbit[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_penerbit[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.pengarang_error != null && response.pengarang_error != '') {
                        $('.pengarang[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.pengarang[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_pengarang[data-isbn="' + isbn + '"]').html(response.pengarang_error)
                    } else {
                        $('.pengarang[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.pengarang[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_pengarang[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.halaman_error != null && response.halaman_error != '') {
                        $('.halaman[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.halaman[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_halaman[data-isbn="' + isbn + '"]').html(response.halaman_error)
                    } else {
                        $('.halaman[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.halaman[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_halaman[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.jumlah_error != null && response.jumlah_error != '') {
                        $('.jumlah[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.jumlah[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_jumlah[data-isbn="' + isbn + '"]').html(response.jumlah_error)
                    } else {
                        $('.jumlah[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.jumlah[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_jumlah[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.cover_error != null && response.cover_error != '') {
                        $('.cover[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.cover[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_cover[data-isbn="' + isbn + '"]').html(response.cover_error)
                    } else {
                        $('.cover[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.cover[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_cover[data-isbn="' + isbn + '"]').html('')
                    }

                    if (response.id_klasifikasi_error != null && response.id_klasifikasi_error != '') {
                        $('.id_klasifikasi[data-isbn="' + isbn + '"]').addClass('is-invalid')
                        $('.id_klasifikasi[data-isbn="' + isbn + '"]').removeClass('is-valid')
                        $('.feedback_id_klasifikasi[data-isbn="' + isbn + '"]').html(response.id_klasifikasi_error)
                    } else {
                        $('.id_klasifikasi[data-isbn="' + isbn + '"]').removeClass('is-invalid')
                        $('.id_klasifikasi[data-isbn="' + isbn + '"]').addClass('is-valid')
                        $('.feedback_id_klasifikasi[data-isbn="' + isbn + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-isbn="' + isbn + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-isbn="' + isbn + '"]').removeClass('disabled')
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').show()
            }
        })
    })
</script>
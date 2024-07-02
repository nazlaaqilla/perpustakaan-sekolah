<div class="container pt-3">
    <div class="card shadow-lg border-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Peminjaman Buku</h5>
            <div>
                <a href="<?= base_url('peminjaman/export') ?>" target="_blank" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Export"><i class="fas fa-download"></i></a>
                <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">No</th>
                            <th colspan="3" class="align-middle text-center">Siswa</th>
                            <th rowspan="2" class="align-middle text-center">Judul Buku</th>
                            <th colspan="2" class="align-middle text-center">Tanggal</th>
                            <th rowspan="2" class="align-middle text-center">Jumlah</th>
                            <th rowspan="2" class="align-middle text-center">Lama Peminjaman<br><small>(Hari)</small></th>
                            <th rowspan="2" class="align-middle text-center">Dibuat</th>
                            <th rowspan="2" class="align-middle text-center">Diubah</th>
                            <th rowspan="2" class="align-middle text-center" style="display: table-cell !important;">Aksi</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">NISN</th>
                            <th class="align-middle text-center">Nama</th>
                            <th class="align-middle text-center">Nomor Ponsel</th>
                            <th class="align-middle text-center">Peminjaman</th>
                            <th class="align-middle text-center">Pengembalian</th>
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
                url: "<?= base_url('peminjaman/ambil_data') ?>",
                type: 'GET'
            },
            columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center',
                sortable: false,
                searchable: false
            }, {
                data: 'nisn',
                name: 'nisn'
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'nomor_ponsel',
                name: 'nomor_ponsel'
            }, {
                data: 'judul_buku',
                name: 'judul_buku'
            }, {
                data: 'tanggal_peminjaman',
                name: 'tanggal_peminjaman'
            }, {
                data: 'tanggal_pengembalian',
                name: 'tanggal_pengembalian',
                sortable: false,
                searchable: false
            }, {
                data: 'jumlah',
                name: 'jumlah',
                className: 'text-center'
            }, {
                data: 'lama_peminjaman',
                name: 'lama_peminjaman',
                className: 'text-center'
            }, {
                data: 'dibuat_oleh',
                name: 'dibuat_oleh'
            }, {
                data: 'diubah_oleh',
                name: 'diubah_oleh'
            }, {
                data: 'aksi',
                name: 'aksi',
                className: 'text-center',
                sortable: false,
                searchable: false
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
                url: "<?= base_url('peminjaman/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(id_peminjaman) {
        if ($('.ubah[data-id_peminjaman="' + id_peminjaman + '"]').length > 0) {
            $('.ubah[data-id_peminjaman="' + id_peminjaman + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('peminjaman/modal_ubah') ?>",
                data: {
                    id_peminjaman: id_peminjaman
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-id_peminjaman="' + id_peminjaman + '"]').modal('show')
                }
            })
        }
    }

    function hapus(id_peminjaman) {
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
                    url: "<?= base_url('peminjaman/hapus') ?>",
                    data: {
                        id_peminjaman: id_peminjaman
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Peminjaman telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Peminjaman gagal untuk dihapuskan', 'error')
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
            url: "<?= base_url('peminjaman/tambah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Peminjaman telah berhasil ditambahkan', 'success')

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

                        if (response.nisn_error != null && response.nisn_error != '') {
                            $('#nisn').addClass('is-invalid')
                            $('#nisn').removeClass('is-valid')
                            $('#feedback_nisn').html(response.nisn_error)
                        } else {
                            $('#nisn').removeClass('is-invalid')
                            $('#nisn').addClass('is-valid')
                            $('#feedback_nisn').html('')
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

                        if (response.tanggal_peminjaman_error != null && response.tanggal_peminjaman_error != '') {
                            $('#tanggal_peminjaman').addClass('is-invalid')
                            $('#tanggal_peminjaman').removeClass('is-valid')
                            $('#feedback_tanggal_peminjaman').html(response.tanggal_peminjaman_error)
                        } else {
                            $('#tanggal_peminjaman').removeClass('is-invalid')
                            $('#tanggal_peminjaman').addClass('is-valid')
                            $('#feedback_tanggal_peminjaman').html('')
                        }

                        if (response.tanggal_pengembalian_error != null && response.tanggal_pengembalian_error != '') {
                            $('#tanggal_pengembalian').addClass('is-invalid')
                            $('#tanggal_pengembalian').removeClass('is-valid')
                            $('#feedback_tanggal_pengembalian').html(response.tanggal_pengembalian_error)
                        } else {
                            $('#tanggal_pengembalian').removeClass('is-invalid')
                            $('#tanggal_pengembalian').addClass('is-valid')
                            $('#feedback_tanggal_pengembalian').html('')
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

                        if (response.lama_peminjaman_error != null && response.lama_peminjaman_error != '') {
                            $('#lama_peminjaman').addClass('is-invalid')
                            $('#lama_peminjaman').removeClass('is-valid')
                            $('#feedback_lama_peminjaman').html(response.lama_peminjaman_error)
                        } else {
                            $('#lama_peminjaman').removeClass('is-invalid')
                            $('#lama_peminjaman').addClass('is-valid')
                            $('#feedback_lama_peminjaman').html('')
                        }

                        if (response.is_dikembalikan_error != null && response.is_dikembalikan_error != '') {
                            $('#is_dikembalikan').addClass('is-invalid')
                            $('#is_dikembalikan').removeClass('is-valid')
                            $('#feedback_is_dikembalikan').html(response.is_dikembalikan_error)
                        } else {
                            $('#is_dikembalikan').removeClass('is-invalid')
                            $('#is_dikembalikan').addClass('is-valid')
                            $('#feedback_is_dikembalikan').html('')
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
        const id_peminjaman = $(this).attr('data-id_peminjaman')
        const form = $(this).serialize()
        $('.ubahSubmit[data-id_peminjaman="' + id_peminjaman + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-id_peminjaman="' + id_peminjaman + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('peminjaman/ubah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-id_peminjaman="' + id_peminjaman + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-id_peminjaman="' + id_peminjaman + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Peminjaman telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-id_peminjaman="' + id_peminjaman + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-id_peminjaman="' + id_peminjaman + '"]').html(response.message)
                        $('.pesan_error[data-id_peminjaman="' + id_peminjaman + '"]').show()
                    } else {
                        $('.pesan_error[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                        $('.pesan_error[data-id_peminjaman="' + id_peminjaman + '"]').hide()
                    }

                    if (response.nisn_error != null && response.nisn_error != '') {
                        $('.nisn[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.nisn[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_nisn[data-id_peminjaman="' + id_peminjaman + '"]').html(response.nisn_error)
                    } else {
                        $('.nisn[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.nisn[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_nisn[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }

                    if (response.isbn_error != null && response.isbn_error != '') {
                        $('.isbn[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.isbn[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_isbn[data-id_peminjaman="' + id_peminjaman + '"]').html(response.isbn_error)
                    } else {
                        $('.isbn[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.isbn[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_isbn[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }

                    if (response.tanggal_peminjaman_error != null && response.tanggal_peminjaman_error != '') {
                        $('.tanggal_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.tanggal_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_tanggal_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').html(response.tanggal_peminjaman_error)
                    } else {
                        $('.tanggal_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.tanggal_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_tanggal_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }

                    if (response.tanggal_pengembalian_error != null && response.tanggal_pengembalian_error != '') {
                        $('.tanggal_pengembalian[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.tanggal_pengembalian[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_tanggal_pengembalian[data-id_peminjaman="' + id_peminjaman + '"]').html(response.tanggal_pengembalian_error)
                    } else {
                        $('.tanggal_pengembalian[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.tanggal_pengembalian[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_tanggal_pengembalian[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }

                    if (response.jumlah_error != null && response.jumlah_error != '') {
                        $('.jumlah[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.jumlah[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_jumlah[data-id_peminjaman="' + id_peminjaman + '"]').html(response.jumlah_error)
                    } else {
                        $('.jumlah[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.jumlah[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_jumlah[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }

                    if (response.lama_peminjaman_error != null && response.lama_peminjaman_error != '') {
                        $('.lama_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.lama_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_lama_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').html(response.lama_peminjaman_error)
                    } else {
                        $('.lama_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.lama_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_lama_peminjaman[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }

                    if (response.is_dikembalikan_error != null && response.is_dikembalikan_error != '') {
                        $('.is_dikembalikan[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-invalid')
                        $('.is_dikembalikan[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-valid')
                        $('.feedback_is_dikembalikan[data-id_peminjaman="' + id_peminjaman + '"]').html(response.is_dikembalikan_error)
                    } else {
                        $('.is_dikembalikan[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('is-invalid')
                        $('.is_dikembalikan[data-id_peminjaman="' + id_peminjaman + '"]').addClass('is-valid')
                        $('.feedback_is_dikembalikan[data-id_peminjaman="' + id_peminjaman + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-id_peminjaman="' + id_peminjaman + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_peminjaman="' + id_peminjaman + '"]').removeClass('disabled')
                $('.pesan_error[data-id_peminjaman="' + id_peminjaman + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-id_peminjaman="' + id_peminjaman + '"]').show()
            }
        })
    })
</script>
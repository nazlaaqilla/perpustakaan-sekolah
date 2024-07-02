<div class="container pt-3">
    <div class="card shadow-lg border-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Klasifikasi</h5>
            <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">Nama Klasifikasi</th>
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
                url: "<?= base_url('klasifikasi/ambil_data') ?>",
                type: 'GET'
            },
            columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center'
            }, {
                data: 'nama_klasifikasi',
                name: 'nama_klasifikasi'
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
                url: "<?= base_url('klasifikasi/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(id_klasifikasi) {
        if ($('.ubah[data-id_klasifikasi="' + id_klasifikasi + '"]').length > 0) {
            $('.ubah[data-id_klasifikasi="' + id_klasifikasi + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('klasifikasi/modal_ubah') ?>",
                data: {
                    id_klasifikasi: id_klasifikasi
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-id_klasifikasi="' + id_klasifikasi + '"]').modal('show')
                }
            })
        }
    }

    function hapus(id_klasifikasi) {
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
                    url: "<?= base_url('klasifikasi/hapus') ?>",
                    data: {
                        id_klasifikasi: id_klasifikasi
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Klasifikasi telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Klasifikasi gagal untuk dihapuskan', 'error')
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
            url: "<?= base_url('klasifikasi/tambah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Klasifikasi telah berhasil ditambahkan', 'success')

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

                        if (response.nama_klasifikasi_error != null && response.nama_klasifikasi_error != '') {
                            $('#nama_klasifikasi').addClass('is-invalid')
                            $('#nama_klasifikasi').removeClass('is-valid')
                            $('#feedback_nama_klasifikasi').html(response.nama_klasifikasi_error)
                        } else {
                            $('#nama_klasifikasi').removeClass('is-invalid')
                            $('#nama_klasifikasi').addClass('is-valid')
                            $('#feedback_nama_klasifikasi').html('')
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
        const id_klasifikasi = $(this).attr('data-id_klasifikasi')
        const form = $(this).serialize()
        $('.ubahSubmit[data-id_klasifikasi="' + id_klasifikasi + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-id_klasifikasi="' + id_klasifikasi + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('klasifikasi/ubah') ?>",
            data: form,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-id_klasifikasi="' + id_klasifikasi + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_klasifikasi="' + id_klasifikasi + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-id_klasifikasi="' + id_klasifikasi + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Klasifikasi telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-id_klasifikasi="' + id_klasifikasi + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').html(response.message)
                        $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').show()
                    } else {
                        $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').html('')
                        $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').hide()
                    }

                    if (response.nama_klasifikasi_error != null && response.nama_klasifikasi_error != '') {
                        $('.nama_klasifikasi[data-id_klasifikasi="' + id_klasifikasi + '"]').addClass('is-invalid')
                        $('.nama_klasifikasi[data-id_klasifikasi="' + id_klasifikasi + '"]').removeClass('is-valid')
                        $('.feedback_nama_klasifikasi[data-id_klasifikasi="' + id_klasifikasi + '"]').html(response.nama_klasifikasi_error)
                    } else {
                        $('.nama_klasifikasi[data-id_klasifikasi="' + id_klasifikasi + '"]').removeClass('is-invalid')
                        $('.nama_klasifikasi[data-id_klasifikasi="' + id_klasifikasi + '"]').addClass('is-valid')
                        $('.feedback_nama_klasifikasi[data-id_klasifikasi="' + id_klasifikasi + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-id_klasifikasi="' + id_klasifikasi + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_klasifikasi="' + id_klasifikasi + '"]').removeClass('disabled')
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').show()
            }
        })
    })
</script>
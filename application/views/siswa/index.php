<div class="container pt-3">
    <div class="card shadow-lg border-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Siswa</h5>
            <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">NISN</th>
                            <th class="align-middle text-center">Nama</th>
                            <th class="align-middle text-center">Jenjang</th>
                            <th class="align-middle text-center">Nomor Ponsel</th>
                            <th class="align-middle text-center">Alamat</th>
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
                url: "<?= base_url('siswa/ambil_data') ?>",
                type: 'GET'
            },
            columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center'
            }, {
                data: 'nisn',
                name: 'nisn'
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'nama_jenjang',
                name: 'nama_jenjang'
            }, {
                data: 'nomor_ponsel',
                name: 'nomor_ponsel'
            }, {
                data: 'alamat',
                name: 'alamat'
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
                url: "<?= base_url('siswa/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(nisn) {
        if ($('.ubah[data-nisn="' + nisn + '"]').length > 0) {
            $('.ubah[data-nisn="' + nisn + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('siswa/modal_ubah') ?>",
                data: {
                    nisn: nisn
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-nisn="' + nisn + '"]').modal('show')
                }
            })
        }
    }

    function hapus(nisn) {
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
                    url: "<?= base_url('siswa/hapus') ?>",
                    data: {
                        nisn: nisn
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Siswa telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Siswa gagal untuk dihapuskan', 'error')
                        }
                    }
                })
            }
        })
    }

    $(document).on('submit', '#tambahForm', function(e) {
        e.preventDefault()
        const form = new FormData(this)
        $('#tambahSubmit').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('#tambahSubmit').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('siswa/tambah') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Siswa telah berhasil ditambahkan', 'success')

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

                        if (response.nama_error != null && response.nama_error != '') {
                            $('#nama').addClass('is-invalid')
                            $('#nama').removeClass('is-valid')
                            $('#feedback_nama').html(response.nama_error)
                        } else {
                            $('#nama').removeClass('is-invalid')
                            $('#nama').addClass('is-valid')
                            $('#feedback_nama').html('')
                        }

                        if (response.id_jenjang_error != null && response.id_jenjang_error != '') {
                            $('#id_jenjang').addClass('is-invalid')
                            $('#id_jenjang').removeClass('is-valid')
                            $('#feedback_id_jenjang').html(response.id_jenjang_error)
                        } else {
                            $('#id_jenjang').removeClass('is-invalid')
                            $('#id_jenjang').addClass('is-valid')
                            $('#feedback_id_jenjang').html('')
                        }

                        if (response.gambar_error != null && response.gambar_error != '') {
                            $('#gambar').addClass('is-invalid')
                            $('#gambar').removeClass('is-valid')
                            $('#feedback_gambar').html(response.gambar_error)
                        } else {
                            $('#gambar').removeClass('is-invalid')
                            $('#gambar').addClass('is-valid')
                            $('#feedback_gambar').html('')
                        }

                        if (response.nomor_ponsel_error != null && response.nomor_ponsel_error != '') {
                            $('#nomor_ponsel').addClass('is-invalid')
                            $('#nomor_ponsel').removeClass('is-valid')
                            $('#feedback_nomor_ponsel').html(response.nomor_ponsel_error)
                        } else {
                            $('#nomor_ponsel').removeClass('is-invalid')
                            $('#nomor_ponsel').addClass('is-valid')
                            $('#feedback_nomor_ponsel').html('')
                        }

                        if (response.alamat_error != null && response.alamat_error != '') {
                            $('#alamat').addClass('is-invalid')
                            $('#alamat').removeClass('is-valid')
                            $('#feedback_alamat').html(response.alamat_error)
                        } else {
                            $('#alamat').removeClass('is-invalid')
                            $('#alamat').addClass('is-valid')
                            $('#feedback_alamat').html('')
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
        const nisn = $(this).attr('data-nisn')
        const form = new FormData(this)
        $('.ubahSubmit[data-nisn="' + nisn + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-nisn="' + nisn + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('siswa/ubah') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-nisn="' + nisn + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-nisn="' + nisn + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-nisn="' + nisn + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Siswa telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-nisn="' + nisn + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-nisn="' + nisn + '"]').html(response.message)
                        $('.pesan_error[data-nisn="' + nisn + '"]').show()
                    } else {
                        $('.pesan_error[data-nisn="' + nisn + '"]').html('')
                        $('.pesan_error[data-nisn="' + nisn + '"]').hide()
                    }

                    if (response.nisn_error != null && response.nisn_error != '') {
                        $('.nisn[data-nisn="' + nisn + '"]').addClass('is-invalid')
                        $('.nisn[data-nisn="' + nisn + '"]').removeClass('is-valid')
                        $('.feedback_nisn[data-nisn="' + nisn + '"]').html(response.nisn_error)
                    } else {
                        $('.nisn[data-nisn="' + nisn + '"]').removeClass('is-invalid')
                        $('.nisn[data-nisn="' + nisn + '"]').addClass('is-valid')
                        $('.feedback_nisn[data-nisn="' + nisn + '"]').html('')
                    }

                    if (response.nama_error != null && response.nama_error != '') {
                        $('.nama[data-nisn="' + nisn + '"]').addClass('is-invalid')
                        $('.nama[data-nisn="' + nisn + '"]').removeClass('is-valid')
                        $('.feedback_nama[data-nisn="' + nisn + '"]').html(response.nama_error)
                    } else {
                        $('.nama[data-nisn="' + nisn + '"]').removeClass('is-invalid')
                        $('.nama[data-nisn="' + nisn + '"]').addClass('is-valid')
                        $('.feedback_nama[data-nisn="' + nisn + '"]').html('')
                    }

                    if (response.id_jenjang_error != null && response.id_jenjang_error != '') {
                        $('.id_jenjang[data-nisn="' + nisn + '"]').addClass('is-invalid')
                        $('.id_jenjang[data-nisn="' + nisn + '"]').removeClass('is-valid')
                        $('.feedback_id_jenjang[data-nisn="' + nisn + '"]').html(response.id_jenjang_error)
                    } else {
                        $('.id_jenjang[data-nisn="' + nisn + '"]').removeClass('is-invalid')
                        $('.id_jenjang[data-nisn="' + nisn + '"]').addClass('is-valid')
                        $('.feedback_id_jenjang[data-nisn="' + nisn + '"]').html('')
                    }

                    if (response.gambar_error != null && response.gambar_error != '') {
                        $('.gambar[data-nisn="' + nisn + '"]').addClass('is-invalid')
                        $('.gambar[data-nisn="' + nisn + '"]').removeClass('is-valid')
                        $('.feedback_gambar[data-nisn="' + nisn + '"]').html(response.gambar_error)
                    } else {
                        $('.gambar[data-nisn="' + nisn + '"]').removeClass('is-invalid')
                        $('.gambar[data-nisn="' + nisn + '"]').addClass('is-valid')
                        $('.feedback_gambar[data-nisn="' + nisn + '"]').html('')
                    }

                    if (response.nomor_ponsel_error != null && response.nomor_ponsel_error != '') {
                        $('.nomor_ponsel[data-nisn="' + nisn + '"]').addClass('is-invalid')
                        $('.nomor_ponsel[data-nisn="' + nisn + '"]').removeClass('is-valid')
                        $('.feedback_nomor_ponsel[data-nisn="' + nisn + '"]').html(response.nomor_ponsel_error)
                    } else {
                        $('.nomor_ponsel[data-nisn="' + nisn + '"]').removeClass('is-invalid')
                        $('.nomor_ponsel[data-nisn="' + nisn + '"]').addClass('is-valid')
                        $('.feedback_nomor_ponsel[data-nisn="' + nisn + '"]').html('')
                    }

                    if (response.alamat_error != null && response.alamat_error != '') {
                        $('.alamat[data-nisn="' + nisn + '"]').addClass('is-invalid')
                        $('.alamat[data-nisn="' + nisn + '"]').removeClass('is-valid')
                        $('.feedback_alamat[data-nisn="' + nisn + '"]').html(response.alamat_error)
                    } else {
                        $('.alamat[data-nisn="' + nisn + '"]').removeClass('is-invalid')
                        $('.alamat[data-nisn="' + nisn + '"]').addClass('is-valid')
                        $('.feedback_alamat[data-nisn="' + nisn + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-nisn="' + nisn + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-nisn="' + nisn + '"]').removeClass('disabled')
                $('.pesan_error[data-nisn="' + nisn + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-nisn="' + nisn + '"]').show()
            }
        })
    })
</script>
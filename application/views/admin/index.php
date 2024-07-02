<div class="container pt-3">
    <div class="card shadow-lg border-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="far fa-circle"></i>&nbsp; Daftar Admin</h5>
            <button onclick="tambah()" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">Email</th>
                            <th class="align-middle text-center">Nama</th>
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
                url: "<?= base_url('admin/ambil_data') ?>",
                type: 'GET'
            },
            columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center'
            }, {
                data: 'email',
                name: 'email'
            }, {
                data: 'nama',
                name: 'nama'
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
                url: "<?= base_url('admin/modal_tambah') ?>",
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('#tambah').modal('show')
                }
            })
        }
    }

    function ubah(id_admin) {
        if ($('.ubah[data-id_admin="' + id_admin + '"]').length > 0) {
            $('.ubah[data-id_admin="' + id_admin + '"]').modal('show')
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('admin/modal_ubah') ?>",
                data: {
                    id_admin: id_admin
                },
                dataType: 'html',
                success: function(response) {
                    $('.modals').append(response)
                    $('.ubah[data-id_admin="' + id_admin + '"]').modal('show')
                }
            })
        }
    }

    function hapus(id_admin) {
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
                    url: "<?= base_url('admin/hapus') ?>",
                    data: {
                        id_admin: id_admin
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire('Berhasil', 'Admin telah berhasil dihapus', 'success')

                            if ($.fn.dataTable.isDataTable('table')) {
                                $('#table-data').DataTable().ajax.reload(null, false)
                            }
                        } else {
                            Swal.fire('Gagal', 'Admin gagal untuk dihapuskan', 'error')
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
            url: "<?= base_url('admin/tambah') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $('#tambahSubmit').html('<i class="fas fa-save"></i>&nbsp; Tambah')
                $('#tambahSubmit').removeClass('disabled')

                if (response.status == true) {
                    $('#tambah').modal('hide')
                    Swal.fire('Berhasil', 'Admin telah berhasil ditambahkan', 'success')

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

                        if (response.nama_error != null && response.nama_error != '') {
                            $('#nama').addClass('is-invalid')
                            $('#nama').removeClass('is-valid')
                            $('#feedback_nama').html(response.nama_error)
                        } else {
                            $('#nama').removeClass('is-invalid')
                            $('#nama').addClass('is-valid')
                            $('#feedback_nama').html('')
                        }

                        if (response.email_error != null && response.email_error != '') {
                            $('#email').addClass('is-invalid')
                            $('#email').removeClass('is-valid')
                            $('#feedback_email').html(response.email_error)
                        } else {
                            $('#email').removeClass('is-invalid')
                            $('#email').addClass('is-valid')
                            $('#feedback_email').html('')
                        }

                        if (response.password_error != null && response.password_error != '') {
                            $('#password').addClass('is-invalid')
                            $('#password').removeClass('is-valid')
                            $('#feedback_password').html(response.password_error)
                        } else {
                            $('#password').removeClass('is-invalid')
                            $('#password').addClass('is-valid')
                            $('#feedback_password').html('')
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

                        if (response.permission_buku_error != null && response.permission_buku_error != '') {
                            $('#permission_buku').addClass('is-invalid')
                            $('#permission_buku').removeClass('is-valid')
                            $('#feedback_permission_buku').html(response.permission_buku_error)
                        } else {
                            $('#permission_buku').removeClass('is-invalid')
                            $('#permission_buku').addClass('is-valid')
                            $('#feedback_permission_buku').html('')
                        }

                        if (response.permission_kategori_buku_error != null && response.permission_kategori_buku_error != '') {
                            $('#permission_kategori_buku').addClass('is-invalid')
                            $('#permission_kategori_buku').removeClass('is-valid')
                            $('#feedback_permission_kategori_buku').html(response.permission_kategori_buku_error)
                        } else {
                            $('#permission_kategori_buku').removeClass('is-invalid')
                            $('#permission_kategori_buku').addClass('is-valid')
                            $('#feedback_permission_kategori_buku').html('')
                        }

                        if (response.permission_peminjaman_buku_error != null && response.permission_peminjaman_buku_error != '') {
                            $('#permission_peminjaman_buku').addClass('is-invalid')
                            $('#permission_peminjaman_buku').removeClass('is-valid')
                            $('#feedback_permission_peminjaman_buku').html(response.permission_peminjaman_buku_error)
                        } else {
                            $('#permission_peminjaman_buku').removeClass('is-invalid')
                            $('#permission_peminjaman_buku').addClass('is-valid')
                            $('#feedback_permission_peminjaman_buku').html('')
                        }

                        if (response.permission_penyimpanan_buku_error != null && response.permission_penyimpanan_buku_error != '') {
                            $('#permission_penyimpanan_buku').addClass('is-invalid')
                            $('#permission_penyimpanan_buku').removeClass('is-valid')
                            $('#feedback_permission_penyimpanan_buku').html(response.permission_penyimpanan_buku_error)
                        } else {
                            $('#permission_penyimpanan_buku').removeClass('is-invalid')
                            $('#permission_penyimpanan_buku').addClass('is-valid')
                            $('#feedback_permission_penyimpanan_buku').html('')
                        }

                        if (response.permission_klasifikasi_error != null && response.permission_klasifikasi_error != '') {
                            $('#permission_klasifikasi').addClass('is-invalid')
                            $('#permission_klasifikasi').removeClass('is-valid')
                            $('#feedback_permission_klasifikasi').html(response.permission_klasifikasi_error)
                        } else {
                            $('#permission_klasifikasi').removeClass('is-invalid')
                            $('#permission_klasifikasi').addClass('is-valid')
                            $('#feedback_permission_klasifikasi').html('')
                        }

                        if (response.permission_jenjang_error != null && response.permission_jenjang_error != '') {
                            $('#permission_jenjang').addClass('is-invalid')
                            $('#permission_jenjang').removeClass('is-valid')
                            $('#feedback_permission_jenjang').html(response.permission_jenjang_error)
                        } else {
                            $('#permission_jenjang').removeClass('is-invalid')
                            $('#permission_jenjang').addClass('is-valid')
                            $('#feedback_permission_jenjang').html('')
                        }

                        if (response.permission_siswa_error != null && response.permission_siswa_error != '') {
                            $('#permission_siswa').addClass('is-invalid')
                            $('#permission_siswa').removeClass('is-valid')
                            $('#feedback_permission_siswa').html(response.permission_siswa_error)
                        } else {
                            $('#permission_siswa').removeClass('is-invalid')
                            $('#permission_siswa').addClass('is-valid')
                            $('#feedback_permission_siswa').html('')
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
        const id_admin = $(this).attr('data-id_admin')
        const form = new FormData(this)
        $('.ubahSubmit[data-id_admin="' + id_admin + '"]').html(`<div class="spinner-border mr-2" style="width: 12px; height: 12px;" role="status">
				<span class="sr-only">Loading...</span>
			</div>Processing`)
        $('.ubahSubmit[data-id_admin="' + id_admin + '"]').addClass('disabled')
        $.ajax({
            type: 'POST',
            url: "<?= base_url('admin/ubah') ?>",
            data: form,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $('.ubahSubmit[data-id_admin="' + id_admin + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_admin="' + id_admin + '"]').removeClass('disabled')

                if (response.status == true) {
                    $('.ubah[data-id_admin="' + id_admin + '"]').modal('hide')
                    Swal.fire('Berhasil', 'Admin telah berhasil diubah', 'success')

                    if ($.fn.dataTable.isDataTable('table')) {
                        $('#table-data').DataTable().ajax.reload(null, false)
                    }

                    setTimeout(function() {
                        $('.ubah[data-id_admin="' + id_admin + '"]').remove()
                    }, 1000)
                } else {
                    if (response.message != null && response.message != '') {
                        $('.pesan_error[data-id_admin="' + id_admin + '"]').html(response.message)
                        $('.pesan_error[data-id_admin="' + id_admin + '"]').show()
                    } else {
                        $('.pesan_error[data-id_admin="' + id_admin + '"]').html('')
                        $('.pesan_error[data-id_admin="' + id_admin + '"]').hide()
                    }

                    if (response.nama_error != null && response.nama_error != '') {
                        $('.nama[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.nama[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_nama[data-id_admin="' + id_admin + '"]').html(response.nama_error)
                    } else {
                        $('.nama[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.nama[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_nama[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.email_error != null && response.email_error != '') {
                        $('.email[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.email[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_email[data-id_admin="' + id_admin + '"]').html(response.email_error)
                    } else {
                        $('.email[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.email[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_email[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.password_error != null && response.password_error != '') {
                        $('.password[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.password[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_password[data-id_admin="' + id_admin + '"]').html(response.password_error)
                    } else {
                        $('.password[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.password[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_password[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.gambar_error != null && response.gambar_error != '') {
                        $('.gambar[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.gambar[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_gambar[data-id_admin="' + id_admin + '"]').html(response.gambar_error)
                    } else {
                        $('.gambar[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.gambar[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_gambar[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_buku_error != null && response.permission_buku_error != '') {
                        $('.permission_buku[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_buku[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_buku[data-id_admin="' + id_admin + '"]').html(response.permission_buku_error)
                    } else {
                        $('.permission_buku[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_buku[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_buku[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_kategori_buku_error != null && response.permission_kategori_buku_error != '') {
                        $('.permission_kategori_buku[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_kategori_buku[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_kategori_buku[data-id_admin="' + id_admin + '"]').html(response.permission_kategori_buku_error)
                    } else {
                        $('.permission_kategori_buku[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_kategori_buku[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_kategori_buku[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_peminjaman_buku_error != null && response.permission_peminjaman_buku_error != '') {
                        $('.permission_peminjaman_buku[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_peminjaman_buku[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_peminjaman_buku[data-id_admin="' + id_admin + '"]').html(response.permission_peminjaman_buku_error)
                    } else {
                        $('.permission_peminjaman_buku[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_peminjaman_buku[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_peminjaman_buku[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_penyimpanan_buku_error != null && response.permission_penyimpanan_buku_error != '') {
                        $('.permission_penyimpanan_buku[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_penyimpanan_buku[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_penyimpanan_buku[data-id_admin="' + id_admin + '"]').html(response.permission_penyimpanan_buku_error)
                    } else {
                        $('.permission_penyimpanan_buku[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_penyimpanan_buku[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_penyimpanan_buku[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_klasifikasi_error != null && response.permission_klasifikasi_error != '') {
                        $('.permission_klasifikasi[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_klasifikasi[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_klasifikasi[data-id_admin="' + id_admin + '"]').html(response.permission_klasifikasi_error)
                    } else {
                        $('.permission_klasifikasi[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_klasifikasi[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_klasifikasi[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_jenjang_error != null && response.permission_jenjang_error != '') {
                        $('.permission_jenjang[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_jenjang[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_jenjang[data-id_admin="' + id_admin + '"]').html(response.permission_jenjang_error)
                    } else {
                        $('.permission_jenjang[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_jenjang[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_jenjang[data-id_admin="' + id_admin + '"]').html('')
                    }

                    if (response.permission_siswa_error != null && response.permission_siswa_error != '') {
                        $('.permission_siswa[data-id_admin="' + id_admin + '"]').addClass('is-invalid')
                        $('.permission_siswa[data-id_admin="' + id_admin + '"]').removeClass('is-valid')
                        $('.feedback_permission_siswa[data-id_admin="' + id_admin + '"]').html(response.permission_siswa_error)
                    } else {
                        $('.permission_siswa[data-id_admin="' + id_admin + '"]').removeClass('is-invalid')
                        $('.permission_siswa[data-id_admin="' + id_admin + '"]').addClass('is-valid')
                        $('.feedback_permission_siswa[data-id_admin="' + id_admin + '"]').html('')
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.ubahSubmit[data-id_admin="' + id_admin + '"]').html('<i class="fas fa-save"></i>&nbsp; Simpan')
                $('.ubahSubmit[data-id_admin="' + id_admin + '"]').removeClass('disabled')
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').html(xhr.status + ' - ' + thrownError)
                $('.pesan_error[data-id_klasifikasi="' + id_klasifikasi + '"]').show()
            }
        })
    })
</script>
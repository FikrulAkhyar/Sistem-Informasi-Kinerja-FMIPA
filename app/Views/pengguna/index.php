<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Kelola Pengguna</div>
<div class="mx-auto mt-5 mb-10">
    <div class="my-3">
        <div class="text-end my-3">
            <button class="btn btn-primary btn-tambah">Tambah Pengguna</button>
        </div>
        <table id="table" class="table w-full" style="width: 100%;">
            <thead>
                <tr class="text-center">
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
</div>

<script>
    const table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: true,
        ajax: `${BASE_URL}/pengguna/datatable`,
        order: [
            [0, 'asc']
        ],
        columns: [{
                data: 'username',
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'nama',
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'nama_level',
                render: function(data, _, row) {
                    let level = row.jurusan_id == null ? `${data}` : `${data} ${row.nama_jurusan}`
                    return `<span class="truncate overflow-ellipsis w-3/5">${level}</span>`
                }
            },
            {
                data: 'pengguna_id',
                searchable: false,
                orderable: false,
                width: '25%',
                render: function(data, _, row) {
                    return `
                       <div class="flex justify-center gap-2">
                            <button data-reference="${data}" class="btn btn-warning btn-sm btn-edit-modal text-white" data-tippy-content="Edit Pengguna">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </button>

                            <button data-reference="${data}" class="btn btn-info btn-sm btn-password-modal text-white" data-tippy-content="Ubah Password Pengguna">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"></path>
                                </svg>
                            </button>

                            <button data-reference="${data}" class="btn btn-error btn-sm btn-delete-modal text-white" data-tippy-content="Hapus Pengguna">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        </div>
                    `
                }
            }
        ],
        drawCallback: function() {
            tippy('.dataTables_wrapper [data-tippy-content]', {
                arrow: false
            })
        }
    });

    $('.btn-tambah').on('click', function(e) {
        e.preventDefault()

        $.ajax({
            url: `${BASE_URL}/pengguna/modal_create/`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })

    $(document).on('click', '.btn-edit-modal', function() {
        const ref = $(this).data('reference')
        $.ajax({
            url: `${BASE_URL}/pengguna/modal_edit/${ref}`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })

    $(document).on('click', '.btn-password-modal', function() {
        const ref = $(this).data('reference')
        $.ajax({
            url: `${BASE_URL}/pengguna/modal_edit_password/${ref}`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })

    $(document).on('click', '.btn-delete-modal', function() {
        const ref = $(this).data('reference')
        $.ajax({
            url: `${BASE_URL}/pengguna/modal_delete/${ref}`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })

    initFormAjax('#form-add-pengguna', {
        success: function(response) {
            $('#modal-global').prop('checked', false)
            toastr.success(response.message)
            table.draw()
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })

    initFormAjax('#form-delete-pengguna', {
        success: function(response) {
            $('#modal-global').prop('checked', false)
            toastr.success(response.message)
            table.draw()
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })

    initFormAjax('#form-update-password-pengguna', {
        success: function(response) {
            $('#modal-global').prop('checked', false)
            toastr.success(response.message)
            table.draw()
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })

    initFormAjax('#form-update-pengguna', {
        success: function(response) {
            $('#modal-global').prop('checked', false)
            toastr.success(response.message)
            table.draw()
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })
</script>
<?= $this->endSection() ?>
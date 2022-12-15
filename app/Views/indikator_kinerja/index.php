<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Indikator Kinerja</div>
<div class="mx-auto mt-5 mb-10">
    <div class="form-control w-full">
        <label class="label" for="filter_tahun">
            <span class="label-text">Tahun Anggaran</span>
        </label>
        <select id="filter_tahun" class="select select-bordered" data-placeholder="pilih tahun anggaran" style="width: 100%;">
            <?php foreach ($tahun as $t) : ?>
                <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="my-3">
        <div class="text-end my-3">
            <button class="btn btn-primary btn-tambah">Tambah Indikator</button>
        </div>
        <table id="table" class="table w-full" style="width: 100%;">
            <thead>
                <tr class="text-center">
                    <th>Kode</th>
                    <th>Target</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#filter_tahun').select2()

    const table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: true,
        ajax: `${BASE_URL}/indikatorkinerja/datatable/`,
        order: [
            [0, 'asc']
        ],
        columns: [{
                data: 'kode_ik',
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'target',
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'ik_id',
                searchable: false,
                orderable: false,
                width: '25%',
                render: function(data, _, row) {
                    return `
                   <div class="flex justify-center gap-2">
                        <button data-reference="${data}" class="btn btn-warning btn-sm btn-edit text-white" data-tippy-content="edit indikator">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                        </button>

                        <button data-reference="${data}" class="btn btn-error btn-sm btn-delete-modal text-white" data-tippy-content="hapus indikator">
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

    $('#filter_tahun').on('change', function() {
        let tahun = $('#filter_tahun').val();

        table.ajax.url(`${BASE_URL}/indikatorkinerja/datatable?tahun=${tahun}`).load()
    })

    $('.btn-tambah').on('click', function(e) {
        e.preventDefault()

        location.href = `${BASE_URL}/indikatorkinerja/create`
    })


    $(document).on('click', '.btn-edit', function() {
        const ref = $(this).data('reference')

        location.href = `${BASE_URL}/indikatorkinerja/edit/${ref}`
    })

    $(document).on('click', '.btn-delete-modal', function() {
        const ref = $(this).data('reference')
        $.ajax({
            url: `${BASE_URL}/indikatorKinerja/modal_delete/${ref}`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })
</script>
<?= $this->endSection() ?>
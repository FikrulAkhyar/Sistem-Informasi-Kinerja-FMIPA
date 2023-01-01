<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Capaian Kinerja Jurusan</div>
<div class="mx-auto mt-5 mb-10">
    <div class="grid grid-cols-12 gap-3">
        <div class="lg:col-span-4 col-span-12">
            <div class="form-control w-full">
                <label class="label" for="filter_tahun">
                    <span class="label-text">Tahun Anggaran</span>
                </label>
                <select id="filter_tahun" class="select select-bordered" data-placeholder="Pilih Tahun Anggaran" style="width: 100%;">
                    <?php foreach ($tahun as $t) : ?>
                        <option value="<?= $t['tahun'] ?>" <?= $t['tahun'] == date('Y') ? 'selected' : '' ?>><?= $t['tahun'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="form-control w-full">
                <label class="label" for="filter_jurusan">
                    <span class="label-text">Jurusan</span>
                </label>
                <select id="filter_jurusan" class="select select-bordered" data-placeholder="Pilih Jurusan" style="width: 100%;">
                    <?php foreach ($jurusan as $j) : ?>
                        <option value="<?= $j['jurusan_id'] ?>"><?= $j['nama_jurusan'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="form-control w-full">
                <label class="label" for="filter_triwulan">
                    <span class="label-text">Triwulan</span>
                </label>
                <select id="filter_triwulan" class="select select-bordered" data-placeholder="Pilih Triwulan" style="width: 100%;">
                    <?php foreach ($triwulan as $t) : ?>
                        <option value="<?= $t['triwulan_id'] ?>" <?= in_array(date('F'), $t['bulan']) ? 'selected' : '' ?>><?= $t['nama_triwulan'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>

    <div class="my-3">
        <div class="datatable">
            <div class="overflow-x-auto">
                <table id="table" class="table w-full" style="width: 100%;">
                    <thead>
                        <tr class="text-center">
                            <th>Kode IK</th>
                            <th>Satuan</th>
                            <th>Target</th>
                            <th>Capaian</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#filter_tahun, #filter_jurusan, #filter_triwulan').select2()

    const table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: true,
        ajax: `${BASE_URL}/capaianJurusan/datatable?tahun=${$('#filter_tahun').val()}&jurusan=${$('#filter_jurusan').val()}&triwulan=${$('#filter_triwulan').val()}`,
        order: [
            [0, 'asc']
        ],
        columns: [{
                data: 'kode_indikator_kinerja',
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'nama_satuan',
                searchable: false,
                orderable: false,
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'target',
                searchable: false,
                orderable: false,
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'capaian',
                searchable: false,
                orderable: false,
                render: function(data) {
                    return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                }
            },
            {
                data: 'capaian_jurusan_id',
                searchable: false,
                orderable: false,
                width: '25%',
                render: function(data, _, row) {
                    let berkas = row.file != null ? `<button data-reference="${data}" class="btn btn-error btn-sm btn-unduh-modal text-white" data-tippy-content="Unduh Berkas Capaian">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                                </svg>
                            </button>` : ''
                    return `
                       <div class="flex justify-center gap-2">
                            ${berkas}
                            <button data-reference="${data}" class="btn btn-info btn-sm btn-detail-modal text-white" data-tippy-content="Detail Capaian">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <button data-reference="${data}" class="btn btn-warning btn-sm btn-edit-modal text-white" data-tippy-content="Isi Capaian">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
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
        table.ajax.url(`${BASE_URL}/capaianJurusan/datatable?tahun=${$('#filter_tahun').val()}&jurusan=${$('#filter_jurusan').val()}&triwulan=${$('#filter_triwulan').val()}`).load()
    })

    $('#filter_jurusan').on('change', function() {
        table.ajax.url(`${BASE_URL}/capaianJurusan/datatable?tahun=${$('#filter_tahun').val()}&jurusan=${$('#filter_jurusan').val()}&triwulan=${$('#filter_triwulan').val()}`).load()
    })

    $('#filter_triwulan').on('change', function() {
        table.ajax.url(`${BASE_URL}/capaianJurusan/datatable?tahun=${$('#filter_tahun').val()}&jurusan=${$('#filter_jurusan').val()}&triwulan=${$('#filter_triwulan').val()}`).load()
    })

    $(document).on('click', '.btn-detail-modal', function() {
        const ref = $(this).data('reference')
        $.ajax({
            url: `${BASE_URL}/capaianJurusan/modal_detail/${ref}`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })

    $(document).on('click', '.btn-edit-modal', function() {
        const ref = $(this).data('reference')

        location.href = `${BASE_URL}/capaianJurusan/isi_capaian/${ref}`
    })

    initFormAjax('#form-isi-capaian', {
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
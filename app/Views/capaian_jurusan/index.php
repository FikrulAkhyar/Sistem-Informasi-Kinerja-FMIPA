<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Capaian Kinerja Jurusan</div>
<div class="mx-auto mt-5 mb-10">
    <div class="grid grid-cols-12 gap-3">
        <div class="lg:col-span-5 col-span-12">
            <div class="form-control w-full">
                <label class="label" for="filter_tahun">
                    <span class="label-text">Tahun Anggaran</span>
                </label>
                <select id="filter_tahun" class="select select-bordered" data-placeholder="Pilih Tahun Anggaran" style="width: 100%;">
                    <option selected disabled>Pilih Tahun Anggaran</option>
                    <?php foreach ($tahun as $t) : ?>
                        <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="lg:col-span-5 col-span-12">
            <div class="form-control w-full">
                <label class="label" for="filter_jurusan">
                    <span class="label-text">Jurusan</span>
                </label>
                <select id="filter_jurusan" class="select select-bordered" style="width: 100%;" disabled>
                    <option selected disabled>Pilih Jurusan</option>
                    <?php foreach ($jurusan as $j) : ?>
                        <option value="<?= $j['jurusan_id'] ?>"><?= $j['nama_jurusan'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="lg:col-span-2 col-span-12 lg:mt-9">
            <button class="btn btn-primary w-full btn-lihat" disabled>Lihat</button>
        </div>
    </div>

    <div class="my-3">
        <div class="datatable">

        </div>
    </div>
</div>

<script>
    $('#filter_tahun, #filter_jurusan').select2()

    $('#filter_tahun').on('change', function() {
        $('#filter_jurusan').removeAttr('disabled')
    })

    $('#filter_jurusan').on('change', function() {
        $('.btn-lihat').removeAttr('disabled')
    })
    $('.btn-lihat').on('click', function() {
        let tahun = $('#filter_tahun').val()
        let jurusan = $('#filter_jurusan').val()

        $('.datatable').html(`
            <div class="text-end my-3">
                <button class="btn btn-success btn-rekap btn-block">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Rekap Excel
                </button>
            </div>
            <table id="table" class="table w-full" style="width: 100%;">
                <thead>
                    <tr class="text-center">
                        <th>Kode IK</th>
                        <th>Satuan</th>
                        <th>TW1</th>
                        <th>TW2</th>
                        <th>TW3</th>
                        <th>TW4</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                </tbody>
            </table>
        `)
        const table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            scrollX: true,
            ajax: `${BASE_URL}/capaianjurusan/datatable?tahun=${tahun}&jurusan=${jurusan}`,
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
                    data: 'nama_satuan',
                    render: function(data) {
                        return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                    }
                },
                {
                    data: 'triwulan_satu',
                    render: function(data) {
                        return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                    }
                },
                {
                    data: 'triwulan_dua',
                    render: function(data) {
                        return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                    }
                },
                {
                    data: 'triwulan_tiga',
                    render: function(data) {
                        return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                    }
                },
                {
                    data: 'triwulan_empat',
                    render: function(data) {
                        return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
                    }
                },
                {
                    data: 'capaian_id',
                    searchable: false,
                    orderable: false,
                    width: '25%',
                    render: function(data, _, row) {
                        return `
                       <div class="flex justify-center gap-2">
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
    })

    $(document).on('click', '.btn-edit-modal', function() {
        const ref = $(this).data('reference')
        $.ajax({
            url: `${BASE_URL}/capaianjurusan/modal_edit/${ref}`,
            success: function(response) {
                $('#modal-global-container.modal .modal-box').html(response.html)
                $('#modal-global').prop('checked', true)
            }
        })
    })
</script>
<?= $this->endSection() ?>
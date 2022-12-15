<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Capaian Kinerja Fakultas MIPA</div>
<div class="mx-auto mt-5 mb-10">
    <div class="form-control w-full">
        <label class="label" for="filter_tahun">
            <span class="label-text">Tahun Anggaran</span>
        </label>
        <select id="filter_tahun" class="select select-bordered" data-placeholder="Pilih Tahun Anggaran" style="width: 100%;">
            <option selected disabled>Pilih Tahun Anggaran</option>
            <?php foreach ($tahun as $t) : ?>
                <option value="<?= $t['tahun'] ?>" <?= $t['tahun'] == date('Y') ? 'selected' : '' ?>><?= $t['tahun'] ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="my-3">
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
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#filter_tahun').select2()
    let tahun = $('#filter_tahun').val()

    const table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: true,
        ajax: `${BASE_URL}/capaianfakultas/datatable?tahun=${tahun}`,
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
        ],
        drawCallback: function() {
            tippy('.dataTables_wrapper [data-tippy-content]', {
                arrow: false
            })
        }
    });
</script>
<?= $this->endSection() ?>
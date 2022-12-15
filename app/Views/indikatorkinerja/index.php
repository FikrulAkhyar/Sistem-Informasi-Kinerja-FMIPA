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
            <option value="2022">2022</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
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
            <tbody>
                <tr class="text-center">
                    <td>IKU-1.01</td>
                    <td>60</td>
                    <td>
                        <button data-reference="1" class="btn btn-warning btn-sm btn-edit text-white" data-tippy-content="edit indikator">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                        </button>

                        <button data-reference="1" class="btn btn-error btn-sm btn-delete-modal text-white" data-tippy-content="hapus indikator">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    tippy('.btn-delete-modal, .btn-edit')
    $('#filter_tahun').select2()

    $('#table').DataTable()

    $('.btn-tambah').on('click', function(e) {
        e.preventDefault()

        location.href = `${BASE_URL}/indikatorKinerja/create`
    })


    $(document).on('click', '.btn-edit', function() {
        const ref = $(this).data('reference')

        location.href = `${BASE_URL}/indikatorKinerja/edit/${ref}`
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

    // const table = $('#table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     responsive: true,
    //     ajax: `${BASE_URL}/indikatorKinerja/datatable/`,
    //     order: [
    //         [0, 'asc']
    //     ],
    //     columns: [{
    //             data: 'nama_kurikulum',
    //             render: function(data) {
    //                 return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
    //             }
    //         },
    //         {
    //             data: 'jumlah_sks_lulus',
    //             render: function(data) {
    //                 return `<span class="truncate overflow-ellipsis w-3/5">${data}</span>`
    //             }
    //         },
    //         {
    //             data: 'id_kurikulum',
    //             searchable: false,
    //             orderable: false,
    //             width: '25%',
    //             render: function(data, _, row) {
    //                 return `
    //                <div class="flex gap-2">
    //                     <button data-reference="${data}" data-prodi="${row.id_prodi}" class="btn btn-sm btn-info btn-lihat-matakuliah-modal" data-tippy-content="lihat matakuliah">
    //                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
    //                     </button>
    //                     <button data-reference="${data}" class="btn btn-sm btn-warning btn-edit-kurikulum-modal" data-tippy-content="edit kurikulum">
    //                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
    //                     </button>
    //                 </div>
    //             `
    //                 // <button data-reference="${data}" class="btn btn-error btn-sm btn-delete-kurikulum-modal" data-tippy-content="hapus kurikulum">
    //                 //     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
    //                 // </button>
    //             }
    //         }
    //     ],
    //     drawCallback: function() {
    //         tippy('.dataTables_wrapper [data-tippy-content]', {
    //             theme: 'indatu',
    //             arrow: false
    //         })
    //     }
    // });
</script>
<?= $this->endSection() ?>
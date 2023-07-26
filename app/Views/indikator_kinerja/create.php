<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Tambah Indikator Kinerja</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorKinerja/store') ?>" id="form-add-indikator" method="POST" enctype="multipart/form-data" show-validation>
        <div class="form-control">
            <label for="sasaran" class="label">
                <span class="label-text label-required">Sasaran</span>
            </label>
            <select type="text" name="sasaran" id="sasaran" class="select select-bordered" data-placeholder="Pilih Sasaran" style="width: 100%;">
                <option></option>
                <?php foreach ($sasaran as $s) : ?>
                    <option value="<?= $s['sasaran_id'] ?>"><?= $s['keterangan'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control">
            <label for="kode" class="label">
                <span class="label-text label-required">Kode Indikator Kinerja</span>
            </label>
            <input type="text" name="kode" id="kode" class="input input-bordered" placeholder="Masukkan kode IK">
        </div>

        <div class="form-control">
            <label for="tahun" class="label">
                <span class="label-text label-required">Tahun</span>
            </label>
            <input type="text" name="tahun" id="tahun" class="input input-bordered" placeholder="Masukkan tahun" value="<?= date('Y') ?>">
        </div>

        <div class="grid grid-cols-12 gap-3">
            <div class="lg:col-span-6 col-span-12">
                <div class="form-control">
                    <label for="satuan" class="label">
                        <span class="label-text label-required">Satuan</span>
                    </label>
                    <select type="text" name="satuan" id="satuan" data-placeholder="Pilih Satuan" class="select select-bordered" style="width: 100%;">
                        <option></option>
                        <?php foreach ($satuan as $st) : ?>
                            <option value="<?= $st['satuan_id'] ?>"><?= $st['nama_satuan'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="lg:col-span-6 col-span-12">
                <div class="grid grid-cols-12">
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw1" class="label">
                                <span class="label-text label-required">Target TW1</span>
                            </label>
                            <input type="number" name="target_tw1" id="target_tw1" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="0">
                        </div>
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw2" class="label">
                                <span class="label-text label-required">Target TW2</span>
                            </label>
                            <input type="number" name="target_tw2" id="target_tw2" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="0">
                        </div>
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw3" class="label">
                                <span class="label-text label-required">Target TW3</span>
                            </label>
                        </div>
                        <input type="number" name="target_tw3" id="target_tw3" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="0">
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw4" class="label">
                                <span class="label-text label-required">Target TW4</span>
                            </label>
                        </div>
                        <input type="number" name="target_tw4" id="target_tw4" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="0">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-control">
            <label for="keterangan" class="label">
                <span class="label-text label-required">Keterangan</span>
            </label>
            <textarea class="textarea textarea-bordered" name="keterangan" id="keterangan" placeholder="Masukkan keterangan"></textarea>
        </div>

        <div class="form-control">
            <label for="file_pendukung" class="label">
                <span class="label-text">File Format Pendukung</span>
            </label>
            <input type="file" name="file_pendukung" id="file_pendukung" class="file-input file-input-bordered file-input-primary" />
            <label class="label">
                <span class="label-text-alt text-error">Ekstension file harus .xlsx atau.pdf dengan max size 2MB</span>
            </label>
        </div>

        <div class="form-control">
            <label for="level_akses" class="label">
                <span class="label-text label-required">Level Akses</span>
            </label>
            <select name="level_akses[]" id="level_akses" multiple="multiple" data-placeholder="Pilih Level" class="select select-bordered" style="width: 100%;">
                <?php foreach ($level as $l) : ?>
                    <option value="<?= $l['level_id'] ?>"><?= $l['nama_level'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control">
            <label for="cascading" class="label">
                <span class="label-text label-required">Cascading</span>
            </label>
            <select name="cascading[]" id="cascading" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;">
                <?php foreach ($cascading as $c) : ?>
                    <option value="<?= $c['cascading_id'] ?>"><?= $c['nama_cascading'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control">
            <label for="uraian" class="label">
                <span class="label-text label-required">Uraian</span>
            </label>
            <select name="uraian[]" id="uraian" multiple="multiple" data-placeholder="Masukkan uraian" class="select select-bordered" style="width: 100%;">
            </select>
            <label class="label">
                <span class="label-text-alt text-error">Jangan terdapat symbol pada kalimat uraian</span>
            </label>
        </div>

        <div class="form-control mt-3">
            <div id="uraian-list">
                <table class="table w-full">
                    <thead class="sticky top-0">
                        <tr>
                            <th class="text-center">Uraian</th>
                            <th class="text-center">Sumber Data</th>
                        </tr>
                    </thead>

                    <tbody class="list">

                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block my-3">TAMBAH</button>

    </form>
</div>

<script>
    $('#sasaran, #satuan, #cascading, #level_akses').select2()
    $('#uraian').select2({
        tags: true,
        language: {
            noResults: function(params) {
                return "Ketik uraian..";
            }
        }
    })

    const uraianList = new List('uraian-list', {
        item: `
            <tr>
                <td class="name text-center"></td>
                <td>
                    <div class="form-control">
                        <input type="text" name="sumber_data[]" id="sumber_data" placeholder="Masukkan sumber data" class="input input-bordered" />
                    </div>
                </td>
            </tr>
        `,
        valueNames: [
            'name',
        ]
    })

    $('#uraian').on('select2:select', function(e) {
        uraianList.add({
            name: e.params.data.text,
        })

        let uraian_name = e.params.data.text.replace(/ /g, "_");
        $('#sumber_data').attr('id', `sumber_data_${uraian_name}`)
        $(`#sumber_data_${uraian_name}`).attr('name', `sumber_data[${uraian_name}]`)
    })

    $('#uraian').on('select2:unselect', function(e) {
        uraianList.remove('name', e.params.data.text)
    })

    $(document).ready(function() {
        $("#file_pendukung").change(function() {
            checkFileSize();
        });

        function checkFileSize() {
            const fileInput = $("#file_pendukung")[0];
            const maxFileSizeInBytes = 2 * 1024 * 1024; // 2 MB
            const allowedFileTypes = ["application/pdf", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size;
                const fileType = file.type;

                if (fileSize > maxFileSizeInBytes) {
                    toastr.error("File melebihi ukuran maksimum 2 MB");
                    fileInput.value = ''; 
                } else if (!allowedFileTypes.includes(fileType)) {
                    toastr.error("Jenis file tidak diizinkan. Hanya file Excel (.xlsx, .xls) dan PDF yang diizinkan.")
                    fileInput.value = ''; 
                }
            }
        }
    });

    initFormAjax('#form-add-indikator', {
        success: function(response) {
            console.log(response.message)
            toastr.success(response.message)
            setTimeout(function() {
                location.href = `${BASE_URL}/indikatorKinerja/`
            }, 1000);
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Tambah Indikator Kinerja</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorkinerja/store') ?>" id="form-add-indikator" method="POST" show-validation>
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
                <span class="label-text label-required">Kode Indikator Kerja</span>
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
                            <input type="number" name="target_tw1" id="target_tw1" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="0">
                        </div>
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw2" class="label">
                                <span class="label-text label-required">Target TW2</span>
                            </label>
                            <input type="number" name="target_tw2" id="target_tw2" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="0">
                        </div>
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw3" class="label">
                                <span class="label-text label-required">Target TW3</span>
                            </label>
                        </div>
                        <input type="number" name="target_tw3" id="target_tw3" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="0">
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw4" class="label">
                                <span class="label-text label-required">Target TW4</span>
                            </label>
                        </div>
                        <input type="number" name="target_tw4" id="target_tw4" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="0">
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
            <label for="uraian" class="label">
                <span class="label-text label-required">Uraian</span>
            </label>
            <select name="uraian[]" id="uraian" multiple="multiple" data-placeholder="Masukkan uraian" class="select select-bordered" style="width: 100%;">
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

        <button type="submit" class="btn btn-primary btn-block my-3">TAMBAH</button>

    </form>
</div>

<script>
    $('#sasaran, #satuan, #cascading').select2()
    $('#uraian').select2({
        tags: true,
        language: {
            noResults: function(params) {
                return "Ketik uraian..";
            }
        }
    })

    initFormAjax('#form-add-indikator', {
        success: function(response) {
            console.log(response.message)
            toastr.success(response.message)
            setTimeout(function() {
                location.href = `${BASE_URL}/indikatorkinerja/`
            }, 1000);
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })
</script>
<?= $this->endSection() ?>
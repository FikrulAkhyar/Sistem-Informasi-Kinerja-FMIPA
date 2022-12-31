<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Edit Indikator Kinerja IK-1.01</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorkinerja/update/' . $id) ?>" id="form-update-indikator" method="POST" show-validation>
        <div class="form-control">
            <label for="sasaran" class="label">
                <span class="label-text label-required">Sasaran</span>
            </label>
            <select type="text" name="sasaran" id="sasaran" data-placeholder="Pilih Sasaran" class="select select-bordered" style="width: 100%;">
                <option></option>
                <?php foreach ($sasaran as $s) : ?>
                    <option value="<?= $s['sasaran_id'] ?>" <?= $s['sasaran_id'] == $ik['sasaran_id'] ? 'selected' : '' ?>><?= $s['keterangan'] ?></option>
                <?php endforeach ?>
            </select>
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
                            <option value="<?= $st['satuan_id'] ?>" <?= $st['satuan_id'] == $ik['satuan_id'] ? 'selected' : '' ?>><?= $st['nama_satuan'] ?></option>
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
                            <input type="number" name="target_tw1" id="target_tw1" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="<?= $ik['target']['triwulan_satu'] ?>">
                        </div>
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw2" class="label">
                                <span class="label-text label-required">Target TW2</span>
                            </label>
                            <input type="number" name="target_tw2" id="target_tw2" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="<?= $ik['target']['triwulan_dua'] ?>">
                        </div>
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw3" class="label">
                                <span class="label-text label-required">Target TW3</span>
                            </label>
                        </div>
                        <input type="number" name="target_tw3" id="target_tw3" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="<?= $ik['target']['triwulan_tiga'] ?>">
                    </div>
                    <div class="lg:col-span-3 col-span-12">
                        <div class="form-control">
                            <label for="target_tw4" class="label">
                                <span class="label-text label-required">Target TW4</span>
                            </label>
                        </div>
                        <input type="number" name="target_tw4" id="target_tw4" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="<?= $ik['target']['triwulan_empat'] ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-control">
            <label for="keterangan" class="label">
                <span class="label-text label-required">Keterangan</span>
            </label>
            <textarea class="textarea textarea-bordered" name="keterangan" id="keterangan" placeholder="Masukkan keterangan IK untuk fakultas"><?= $ik['keterangan'] ?></textarea>
        </div>

        <div class="form-control">
            <label for="uraian" class="label">
                <span class="label-text label-required">Uraian</span>
            </label>
            <select name="uraian[]" id="uraian" multiple="multiple" data-placeholder="Masukkan uraian" class="select select-bordered" style="width: 100%;">
                <?php foreach ($uraian as $u) : ?>
                    <option selected><?= $u['uraian'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control">
            <label for="cascading" class="label">
                <span class="label-text label-required">Cascading</span>
            </label>
            <select name="cascading[]" id="cascading" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;">
                <?php foreach ($cascading as $c) : ?>
                    <option value="<?= $c['cascading_id'] ?>" <?= in_array($c['cascading_id'], $ik['cascading']) ? 'selected' : '' ?>><?= $c['nama_cascading'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-block my-3">EDIT</button>

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

    initFormAjax('#form-update-indikator', {
        success: function(response) {
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
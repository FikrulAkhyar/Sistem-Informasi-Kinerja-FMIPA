<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Edit Indikator Kinerja IK-1.01</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorKinerja/edit') ?>" id="form-add-indikator" method="POST" show-validation>
        <div class="form-control">
            <label for="sasaran" class="label">
                <span class="label-text label-required">Sasaran</span>
            </label>
            <select type="text" name="sasaran" id="sasaran" class="select select-bordered" style="width: 100%;">
                <option disabled selected>Pilih Sasaran</option>
                <?php foreach ($sasaran as $s) : ?>
                    <option value="<?= $s['sasaran_id'] ?>" <?= $s['sasaran_id'] == $ik['sasaran_id'] ? 'selected' : '' ?>><?= $s['keterangan'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control">
            <label for="target" class="label">
                <span class="label-text label-required">Target</span>
            </label>
            <input type="number" name="target" id="target" class="input input-bordered" min="0" value="<?= $ik['target'] ?>">
        </div>

        <div class="form-control my-3 text-center">
            <label class="label cursor-pointer justify-start">
                <input type="checkbox" class="checkbox" name="is_jurusan" id="is_jurusan" <?= $ik['is_jurusan'] == 1 ? 'checked' : '' ?> />
                <span class="label-text ml-3">Gunakan IK untuk jurusan</span>
            </label>
        </div>

        <div class="grid grid-cols-12 gap-3">
            <div class="lg:col-span-6 col-span-12 is-fakultas">
                <div class="form-control">
                    <label for="ket_fakultas" class="label">
                        <span class="label-text label-required">Keterangan (Fakultas)</span>
                    </label>
                    <textarea class="textarea textarea-bordered" name="ket_fakultas" id="ket_fakultas" placeholder="Masukkan keterangan IK untuk fakultas"><?= $ik['ket_fakultas'] ?></textarea>
                </div>

                <div class="form-control">
                    <label for="satuan_fakultas" class="label">
                        <span class="label-text label-required">Satuan (Fakultas)</span>
                    </label>
                    <select type="text" name="satuan_fakultas" id="satuan_fakultas" class="select select-bordered" style="width: 100%;">
                        <option disabled selected>Pilih Satuan</option>
                        <?php foreach ($satuan as $st) : ?>
                            <option value="<?= $st['satuan_id'] ?>" <?= $st['satuan_id'] == $ik['satuan_fakultas'] ? 'selected' : '' ?>><?= $st['nama_satuan'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-control">
                    <label for="cascading_fakultas" class="label">
                        <span class="label-text label-required">Cascading (Fakultas)</span>
                    </label>
                    <select name="cascading_fakultas" id="cascading_fakultas" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;">
                        <?php foreach ($cascading as $c) : ?>
                            <option value="<?= $c['cascading_id'] ?>" <?= in_array($c['cascading_id'], $ik['cascading_fakultas']) ? 'selected' : '' ?>><?= $c['nama_cascading'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="lg:col-span-6 col-span-12 is-jurusan <?= $ik['is_jurusan'] == 1 ? '' : 'hidden' ?>">
                <div class="form-control">
                    <label for="ket_jurusan" class="label">
                        <span class="label-text label-required">Keterangan (Jurusan)</span>
                    </label>
                    <textarea class="textarea textarea-bordered" name="ket_jurusan" id="ket_jurusan" placeholder="Masukkan keterangan IK untuk jurusan"><?= $ik['ket_jurusan'] ?></textarea>
                </div>

                <div class="form-control">
                    <label for="satuan_jurusan" class="label">
                        <span class="label-text label-required">Satuan (Jurusan)</span>
                    </label>
                    <select type="text" name="satuan_jurusan" id="satuan_jurusan" class="select select-bordered" style="width: 100%;">
                        <option disabled selected>Pilih Satuan</option>
                        <?php foreach ($satuan as $st) : ?>
                            <option value="<?= $st['satuan_id'] ?>" <?= $st['satuan_id'] == $ik['satuan_jurusan'] ? 'selected' : '' ?>><?= $st['nama_satuan'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-control">
                    <label for="cascading_jurusan" class="label">
                        <span class="label-text label-required">Cascading (Jurusan)</span>
                    </label>
                    <select name="cascading_jurusan" id="cascading_jurusan" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;">
                        <?php foreach ($cascading as $c) : ?>
                            <option value="<?= $c['cascading_id'] ?>" <?= in_array($c['cascading_id'], $ik['cascading_jurusan']) ? 'selected' : '' ?>><?= $c['nama_cascading'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block my-3">EDIT</button>

    </form>
</div>

<script>
    $('#sasaran, #satuan_fakultas, #cascading_fakultas, #satuan_jurusan, #cascading_jurusan').select2()

    $('#is_jurusan').on('click', function() {
        if ($('#is_jurusan:checked').is(':checked')) {
            // console.log('checked')
            $('.is-jurusan').removeClass('hidden')
        } else {
            $('.is-jurusan').addClass('hidden')
        }
    })
</script>
<?= $this->endSection() ?>
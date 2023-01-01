<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Tambah Tahun Baru</h2>
<form action="<?= base_url('indikatorKinerja/import_data_tahun/') ?>" id="form-add-tahun-indikator" method="POST" show-validation>
    <div class="form-control">
        <label for="new_tahun" class="label">
            <span class="label-text label-required">Tahun</span>
        </label>
        <input type="text" name="new_tahun" id="new_tahun" class="input input-bordered" placeholder="masukkan tahun baru" value="<?= date('Y') ?>">
    </div>
    <div class="form-control">
        <label for="old_tahun" class="label">
            <span class="label-text label-required">Ambil data Indikator Kinerja dari tahun</span>
        </label>
        <select type="text" name="old_tahun" id="old_tahun" class="select select-bordered" style="width: 100%;">
            <option disabled selected>Pilih Tahun</option>
            <?php foreach ($tahun as $t) : ?>
                <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
            <?php endforeach ?>
        </select>
    </div>


    <div class="modal-action">
        <button type="submit" form="form-add-tahun-indikator" class="btn btn-success btn-block">Tambah</button>
    </div>
</form>

<script>
    $('#old_tahun').select2()
</script>
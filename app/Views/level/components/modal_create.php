<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Tambah Level</h2>
<form action="<?= base_url('level/store/') ?>" id="form-add-level" method="POST" show-validation>
    <div class="form-control">
        <label for="nama_level" class="label">
            <span class="label-text label-required">Nama Level</span>
        </label>
        <input type="text" name="nama_level" id="nama_level" class="input input-bordered" placeholder="masukkan nama level">
    </div>
    <div class="form-control">
        <label for="menu_akses" class="label">
            <span class="label-text label-required">Menu Akses</span>
        </label>
        <select type="text" name="menu_akses[]" id="menu_akses" data-placeholder="Pilih hak akses" multiple="multiple" class="select select-bordered" style="width: 100%;">
            <option></option>
            <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['url'] ?>"><?= $m['nama_menu'] ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="modal-action">
        <button type="submit" form="form-add-level" class="btn btn-primary btn-block">Tambah</button>
    </div>
</form>

<script>
    $('#menu_akses').select2()
</script>
<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Edit Pengguna</h2>
<form action="<?= base_url('pengguna/update/' . $id) ?>" id="form-update-pengguna" method="POST" show-validation>
    <div class="form-control">
        <label for="nama" class="label">
            <span class="label-text label-required">Nama</span>
        </label>
        <input type="text" name="nama" id="nama" class="input input-bordered" placeholder="masukkan nama pengguna" value="<?= $pengguna['nama'] ?>">
    </div>
    <div class="form-control">
        <label for="username" class="label">
            <span class="label-text label-required">Username</span>
        </label>
        <input type="text" name="username" id="username" class="input input-bordered" placeholder="masukkan username pengguna" value="<?= $pengguna['username'] ?>">
    </div>
    <div class="form-control">
        <label for="level" class="label">
            <span class="label-text label-required">Level</span>
        </label>
        <select type="text" name="level" id="level" class="select select-bordered" style="width: 100%;">
            <option disabled selected>Pilih Level</option>
            <?php foreach ($level as $l) : ?>
                <option value="<?= $l['level_id'] ?>" <?= $pengguna['level_id'] == $l['level_id'] ? 'selected' : '' ?>><?= $l['nama_level'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-control input-jurusan <?= $pengguna['level_id'] != 3 ? 'hidden' : '' ?>">
        <label for="jurusan" class="label">
            <span class="label-text label-required">Jurusan</span>
        </label>
        <select type="text" name="jurusan" id="jurusan" class="select select-bordered" style="width: 100%;">
            <option disabled selected>Pilih Jurusan</option>
            <?php foreach ($jurusan as $j) : ?>
                <option value="<?= $j['jurusan_id'] ?>" <?= $pengguna['jurusan_id'] == $j['jurusan_id'] ? 'selected' : '' ?>><?= $j['nama_jurusan'] ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="modal-action">
        <button type="submit" form="form-update-pengguna" class="btn btn-primary btn-block">Edit</button>
    </div>
</form>

<script>
    $('#level, #jurusan').select2()

    $('#level').on('change', function() {
        let level = $(this).val()
        if (level == 3) {
            $('.input-jurusan').removeClass('hidden')
        } else {
            $('.input-jurusan').addClass('hidden')
            $('#jurusan option:first').prop('selected', true);
        }
    })
</script>
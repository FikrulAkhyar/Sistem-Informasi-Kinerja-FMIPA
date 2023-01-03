<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Unduh Perjanjian Kerja</h2>
<div class="form-control">
    <label for="tahun" class="label">
        <span class="label-text label-required">Tahun</span>
    </label>
    <select type="text" name="tahun" id="tahun" data-placeholder="Pilih Tahun" class="select select-bordered" style="width: 100%;">
        <option></option>
        <?php foreach ($tahun as $t) : ?>
            <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
        <?php endforeach ?>
    </select>
</div>
<div class="form-control">
    <label for="unit_kerja" class="label">
        <span class="label-text label-required">Unit Kerja</span>
    </label>
    <select type="text" name="unit_kerja" id="unit_kerja" data-placeholder="Pilih Unit Kerja" class="select select-bordered" style="width: 100%;">
        <option></option>
        <option value="1">Fakultas MIPA</option>
        <option value="2">Jurusan</option>
    </select>
</div>
<div class="form-control input-jurusan hidden">
    <label for="jurusan" class="label">
        <span class="label-text label-required">Jurusan</span>
    </label>
    <select type="text" name="jurusan" id="jurusan" data-placeholder="Pilih Jurusan" class="select select-bordered" style="width: 100%;">
        <option></option>
        <?php foreach ($jurusan as $j) : ?>
            <option value="<?= $j['jurusan_id'] ?>"><?= $j['nama_jurusan'] ?></option>
        <?php endforeach ?>
    </select>
</div>
<div class="my-3">
    <button id="btn-unduh" class="btn btn-block btn-primary" disabled>UNDUH</button>
</div>

<script>
    $('#unit_kerja, #jurusan, #tahun').select2()

    $('#unit_kerja').on('change', function() {
        let unit_kerja = $(this).val()
        if (unit_kerja == 2) {
            $('.input-jurusan').removeClass('hidden')

            $('#jurusan').on('change', function() {
                $('#btn-unduh').prop('disabled', false);
            })
        } else {
            $('.input-jurusan').addClass('hidden')
            $('#jurusan option:first').prop('selected', true);

            $('#btn-unduh').prop('disabled', false);
        }
    })

    $('#btn-unduh').on('click', function() {
        open(`${BASE_URL}/indikatorKinerja/unduh_pk?tahun=${$('#tahun').val()}&unit=${$('#unit_kerja').val()}&jurusan=${$('#jurusan').val()}`)
    })
</script>
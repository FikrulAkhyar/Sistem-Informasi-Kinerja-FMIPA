<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Gunakan Indikator Untuk Jurusan</h2>
<form action="<?= base_url('indikatorkinerja/import_data_tahun/') ?>" id="form-add-tahun-indikator" method="POST" show-validation>
    <div class="form-control">
        <label for="jurusan" class="label">
            <span class="label-text label-required">Jurusan</span>
        </label>
        <select type="text" name="jurusan" id="jurusan" class="select select-bordered" style="width: 100%;">
            <option disabled selected>Pilih Jurusan</option>
            <?php foreach ($jurusan as $j) : ?>
                <option value="<?= $j['jurusan'] ?>"><?= $j['jurusan'] ?></option>
            <?php endforeach ?>
        </select>
    </div>


    <div class="modal-action">
        <button type="submit" form="form-add-tahun-indikator" class="btn btn-success btn-block">Tambah</button>
    </div>
</form>

<script>
    $('#jurusan').select2()

    const jurusanList = new List('jurusan-list', {
        item: `
            <tr>
                <td class="name"></td>
                <td>
                    <div class="form-control">
                        <input type="radio" name="isKoordinator" class="radio isKoordinator" required>
                    </div>
                </td>
                <td>
                    <div class="form-control">
                        <input type="text" name="sks_dosen[]" class="input input-bordered" placeholder="masukkan sks dosen" required>
                    </div>
                </td>
                <td>
                    <div class="form-control">
                        <input type="text" name="pertemuan_dosen[]" class="input input-bordered" placeholder="masukkan pertemuan dosen" required>
                    </div>
                </td>
            </tr>
        `,
        valueNames: [
            'name',
            {
                attr: 'value',
                name: 'isKoordinator'
            }
        ]
    })
</script>
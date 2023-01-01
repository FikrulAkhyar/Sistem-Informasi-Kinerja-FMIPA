<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Gunakan IK-1.01 Untuk Jurusan</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorkinerja/store_jurusan/' . $id) ?>" id="form-add-indikator-jurusan" method="POST" show-validation>

        <div class="form-control">
            <label for="keterangan" class="label">
                <span class="label-text label-required">Keterangan Indikator</span>
            </label>
            <textarea class="textarea textarea-bordered" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan" required></textarea>
        </div>

        <div class="form-control">
            <label for="satuan" class="label">
                <span class="label-text label-required">Satuan</span>
            </label>
            <select type="text" name="satuan" id="satuan" class="select select-bordered" data-placeholder="Pilih Satuan" style="width: 100%;">
                <option></option>
                <?php foreach ($satuan as $st) : ?>
                    <option value="<?= $st['satuan_id'] ?>"><?= $st['nama_satuan'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control">
            <label for="jurusan" class="label">
                <span class="label-text label-required">Jurusan</span>
            </label>
            <select type="text" name="jurusan[]" id="jurusan" multiple="multiple" data-placeholder="Pilih Jurusan" class="select select-bordered" style="width: 100%;">
                <?php foreach ($jurusan as $j) : ?>
                    <option value="<?= $j['jurusan_id'] ?>"><?= $j['nama_jurusan'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-control my-3">
            <div id="jurusan-list">
                <table id="table" class="table w-full table-bordered" style="width: 100%;">
                    <thead class="sticky top-0">
                        <tr class="text-center">
                            <th>Jurusan</th>
                            <th>Target</th>
                        </tr>
                    </thead>

                    <tbody class="list">
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-block my-3">TAMBAH</button>

    </form>
</div>

<script>
    $('#jurusan, #satuan').select2()

    const jurusanList = new List('jurusan-list', {
        item: `
            <tr>
                <td class="name text-center"></td>
                <td>
                    <div class="form-control mb-2">
                        <select name="cascading[]" id="cascading" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;" required>
                            <?php foreach ($cascading as $c) : ?>
                                <option value="<?= $c['cascading_id'] ?>"><?= $c['nama_cascading'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div id="cascading-list">
                        <table id="table" class="table w-full table-bordered" style="width: 100%;">
                            <thead class="sticky top-0">
                                <tr class="text-center">
                                    <th>Cascading</th>
                                    <th>TW1</th>
                                    <th>TW2</th>
                                    <th>TW3</th>
                                    <th>TW4</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        `,
        valueNames: [
            'name',
        ]
    })

    $('#jurusan').on('select2:select', function(e) {
        jurusanList.add({
            name: e.params.data.text,
        })
        let jurusan_id = e.params.data.id

        $('#cascading').attr('name', `cascading[${jurusan_id}][]`)
        $('#cascading').attr('id', `cascading${jurusan_id}`)
        $(`#cascading${jurusan_id}`).select2()
        $('#cascading-list').attr('id', `cascading-list${jurusan_id}`)

        let cascadingList = new List(`cascading-list${jurusan_id}`, {
            item: `
            <tr>
                <td class="name text-center"></td>
                <td>
                    <div class="form-control text-center">
                        <input type="number" name="tw1[${jurusan_id}]" id="tw1" class="input input-bordered w-full" min="0" value="0" required>
                    </div>
                </td>
                <td>
                    <div class="form-control">
                        <input type="number" name="tw2[${jurusan_id}]" id="tw2"  class="input input-bordered w-full" min="0" value="0" required>
                    </div>
                </td>
                <td>
                    <div class="form-control">
                        <input type="number" name="tw3[${jurusan_id}]" id="tw3"  class="input input-bordered w-full" min="0" value="0" required>
                    </div>
                </td>
                <td>
                    <div class="form-control">
                        <input type="number" name="tw4[${jurusan_id}]" id="tw4"  class="input input-bordered w-full" min="0" value="0" required>
                    </div>
                </td>
            </tr>
        `,
            valueNames: [
                'name',
            ]
        })

        $(`#cascading${jurusan_id}`).on('select2:select', function(e) {
            cascadingList.add({
                name: e.params.data.text,
            })

            let cascading_id = e.params.data.id

            $('#tw1').attr('name', $('#tw1').attr('name') + `[${cascading_id}]`)
            $('#tw2').attr('name', $('#tw2').attr('name') + `[${cascading_id}]`)
            $('#tw3').attr('name', $('#tw3').attr('name') + `[${cascading_id}]`)
            $('#tw4').attr('name', $('#tw4').attr('name') + `[${cascading_id}]`)

            $('#tw1').attr('id', `tw1_${jurusan_id}_${cascading_id}`)
            $('#tw2').attr('id', `tw2_${jurusan_id}_${cascading_id}`)
            $('#tw3').attr('id', `tw3_${jurusan_id}_${cascading_id}`)
            $('#tw4').attr('id', `tw4_${jurusan_id}_${cascading_id}`)
        })

        $(`#cascading${jurusan_id}`).on('select2:unselect', function(e) {
            cascadingList.remove('name', e.params.data.text)
        })
    })

    $('#jurusan').on('select2:unselect', function(e) {
        jurusanList.remove('name', e.params.data.text)
    })

    initFormAjax('#form-add-indikator-jurusan', {
        success: function(response) {
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
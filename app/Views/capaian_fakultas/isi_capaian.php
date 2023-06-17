<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Isi Capaian <?= $ik['kode_indikator_kinerja'] ?> <?= $ik['tahun'] ?> <?= $ik['nama_triwulan'] ?> ( Target <?= $ik['target'] ?> )</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('capaianFakultas/store_capaian/' . $id) ?>" enctype="multipart/form-data" id="form-isi-capaian-fakultas" method="POST" show-validation>
        <div class="alert my-2">
            <div class="flex-1">
                <div>
                    <div class="prose prose-sm">
                        <h3 class="font-semibold">Sasaran</h3>
                        <p><?= $ik['sasaran'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert my-2">
            <div class="flex-1">
                <div>
                    <div class="prose prose-sm">
                        <h3 class="font-semibold">Indikator Kinerja</h3>
                        <p><?= $ik['keterangan'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-3 my-2">
            <div class="col-span-12 lg:col-span-8">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Upload File Capaian</span>
                    </label>
                    <input type="file" name="file" class="file-input file-input-bordered file-input-primary w-full" />
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Unduh File Format Pendukung</span>
                    </label>
                    <a href="<?= base_url('dokumen/' . $ik['file_pendukung']) ?>" class="btn btn-primary">Unduh file</a>
                </div>
            </div>
        </div>

        <table id="table" class="table w-full table-bordered" style="width: 100%;" data-satuan="<?= $ik['satuan_id'] ?>">
            <thead>
                <tr class="text-center">
                    <th>Uraian</th>
                    <th>Capaian</th>
                    <?php if ($ik['satuan_id'] == 1) : ?>
                        <th>Pembagi</th>
                        <th>Hasil</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($capaian); $i++) : ?>
                    <tr>
                        <td><?= $capaian[$i]['uraian'] ?> <?= $capaian[$i]['sumber_data'] != null ? "( <span class='text-error'>" . $capaian[$i]['sumber_data'] . "</span> )" : "" ?> </td>
                        <td class="text-center">
                            <input type="number" name="capaian[<?= $capaian[$i]['uraian'] ?>]" id="capaian<?= $i ?>" class="input input-bordered lg:w-32 w-full" min="0" step="0.01" value="<?= $capaian[$i]['capaian'] ?>">
                        </td>
                        <?php if ($ik['satuan_id'] == 1) : ?>
                            <td class="text-center">
                                <input type="number" name="pembagi[<?= $capaian[$i]['uraian'] ?>]" id="pembagi<?= $i ?>" class="input input-bordered lg:w-32 w-full pembagi" min="0" step="0.01" value="<?= $capaian[$i]['pembagi'] ?>">
                            </td>
                            <td class="text-center">
                                <input type="text" name="hasil[<?= $capaian[$i]['uraian'] ?>]" id="hasil<?= $i ?>" class="input input-bordered lg:w-32 w-full" value="<?= $capaian[$i]['hasil'] ?>" readonly>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endfor ?>
            </tbody>
        </table>


        <button type="submit" class="btn btn-success btn-block mt-3">ISI CAPAIAN</button>

    </form>
</div>

<script>
    let capaian = <?= json_encode($capaian) ?>

    let satuan = $('#table').data('satuan')
    if (satuan == 1) {
        for (let i = 0; i < capaian.length; i++) {
            $(`#capaian${i}`).on('input', function() {
                let hasil = parseFloat(($(`#capaian${i}`).val() / $('.pembagi').val()) * 100).toFixed(2)
                $(`#hasil${i}`).val(hasil)
            })
            $(`.pembagi`).on('input', function() {
                let pembagi = $('.pembagi').val()
                let hasil = parseFloat(($(`#capaian${i}`).val() / $('.pembagi').val()) * 100).toFixed(2)
                $(`#hasil${i}`).val(hasil)
            })
        }
    }


    initFormAjax('#form-isi-capaian-fakultas', {
        success: function(response) {
            console.log(response.message)
            toastr.success(response.message)
            setTimeout(function() {
                location.href = `${BASE_URL}/capaianFakultas/`
            }, 1000);
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Isi Capaian <?= $ik['kode_indikator_kinerja'] ?> <?= $ik['tahun'] ?> <?= $ik['nama_triwulan'] ?> <?= 'Jurusan ' . $ik['nama_jurusan'] ?> ( Target <?= $ik['target'] ?> )</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('capaianJurusan/store_capaian/' . $id) ?>" enctype="multipart/form-data" id="form-isi-capaian-jurusan" method="POST" show-validation>
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

        <div class="form-control w-full my-2">
            <label class="label">
                <span class="label-text">Upload Dokumen Capaian</span>
            </label>
            <input type="file" name="file" class="file-input file-input-bordered file-input-primary w-full" />
        </div>

        <table id="table" class="table w-full table-bordered" style="width: 100%;">
            <thead class="sticky top-0">
                <tr class="text-center">
                    <th>Cascading</th>
                    <th>Uraian</th>
                    <th>Capaian</th>
                    <th>Pembagi</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($capaian); $i++) : ?>
                    <tr>
                        <td rowspan="<?= count($capaian[$i]['capaian']) + 1 ?>"><?= $capaian[$i]['nama_cascading'] ?></td>

                        <?php for ($j = 0; $j < count($capaian[$i]['capaian']); $j++) : ?>
                    <tr>
                        <td><?= $capaian[$i]['capaian'][$j]['uraian'] ?></td>
                        <td class="text-center">
                            <input type="number" name="capaian[<?= $capaian[$i]['cascading_id'] ?>][<?= $capaian[$i]['capaian'][$j]['uraian'] ?>]" id="capaian_<?= $i . '_' . $j ?>" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="<?= $capaian[$i]['capaian'][$j]['capaian'] ?>">
                        </td>
                        <td class="text-center">
                            <input type="number" name="pembagi[<?= $capaian[$i]['cascading_id'] ?>][<?= $capaian[$i]['capaian'][$j]['uraian'] ?>]" id="pembagi_<?= $i . '_' . $j ?>" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="<?= $capaian[$i]['capaian'][$j]['pembagi'] ?>">
                        </td>
                        <td class="text-center">
                            <input type="text" name="hasil[<?= $capaian[$i]['cascading_id'] ?>][<?= $capaian[$i]['capaian'][$j]['uraian'] ?>]" id="hasil_<?= $i . '_' . $j ?>" class="input input-bordered lg:w-32 w-full" value="<?= $capaian[$i]['capaian'][$j]['hasil'] ?>" readonly>
                        </td>
                    </tr>
                <?php endfor ?>
                </tr>
            <?php endfor ?>
            </tbody>
        </table>


        <button type="submit" class="btn btn-success btn-block mt-3">ISI CAPAIAN</button>

    </form>
</div>

<script>
    let capaian = <?= json_encode($capaian) ?>;

    for (let i = 0; i < capaian.length; i++) {
        for (let j = 0; j < capaian[i].capaian.length; j++) {
            $(`#capaian_${i}_${j}`).on('input', function() {
                let hasil = parseFloat(($(`#capaian_${i}_${j}`).val() / $(`#pembagi_${i}_${j}`).val()) * 100).toFixed(2)
                $(`#hasil_${i}_${j}`).val(hasil)
            })
            $(`#pembagi_${i}_${j}`).on('input', function() {
                let hasil = parseFloat(($(`#capaian_${i}_${j}`).val() / $(`#pembagi_${i}_${j}`).val()) * 100).toFixed(2)
                $(`#hasil_${i}_${j}`).val(hasil)
            })
        }
    }

    initFormAjax('#form-isi-capaian-jurusan', {
        success: function(response) {
            console.log(response.message)
            toastr.success(response.message)
            setTimeout(function() {
                location.href = `${BASE_URL}/capaianJurusan/`
            }, 1000);
        },
        error: function(xhr) {
            const response = xhr.responseJSON
            toastr.error(response.message)
        }
    })
</script>
<?= $this->endSection() ?>
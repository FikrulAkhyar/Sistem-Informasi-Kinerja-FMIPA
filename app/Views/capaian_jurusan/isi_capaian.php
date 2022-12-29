<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Isi Capaian IK-1.01 Triwulan 4 ( Target 60 )</div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorkinerja/store') ?>" id="form-add-indikator" method="POST" show-validation>
        <div class="alert my-2">
            <div class="flex-1">
                <div>
                    <div class="prose prose-sm">
                        <h3 class="font-semibold">Sasaran</h3>
                        <p>Tersedianya lulusan yang memiliki nilai-nilai religius, mandiri,sosial, beretika, berakhlak mulia, berkarakter dan mampu mengaplikasikan nilai-nilai ke-Unsyiah-an dan terciptanya lulusan yang berjiwa entrepreneur, leadership, kreatif, inovatif, dan tangguh sehingga mampu bersaing pada level nasional dan global</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert my-2">
            <div class="flex-1">
                <div>
                    <div class="prose prose-sm">
                        <h3 class="font-semibold">Indikator Kinerja</h3>
                        <p>Persentasi lulusan yang berhasil mendapatkan pekerjaan, melanjutkan studi dan menjadi wirausaha</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-control w-full my-2">
            <label class="label">
                <span class="label-text">Upload Dokumen Capaian</span>
            </label>
            <input type="file" class="file-input file-input-bordered file-input-primary w-full" />
        </div>

        <table id="table" class="table w-full table-bordered" style="width: 100%;">
            <thead class="sticky top-0">
                <tr class="text-center">
                    <th>Uraian</th>
                    <th>Capaian</th>
                    <th>Pembagi</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mendapatkan Kerja</td>
                    <td class="text-center">
                        <input type="number" name="capaian" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="102">
                    </td>
                    <td class="text-center">
                        <input type="number" name="pembagi" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="232">
                    </td>
                    <td class="text-center">
                        <input type="text" name="persentase" class="input input-bordered lg:w-32 w-full" value="43.97" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Melanjutkan Studi</td>
                    <td class="text-center">
                        <input type="number" name="capaian" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="28">
                    </td>
                    <td class="text-center">
                        <input type="number" name="pembagi" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="232">
                    </td>
                    <td class="text-center">
                        <input type="text" name="persentase" class="input input-bordered lg:w-32 w-full" value="12.07" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Berwirausaha</td>
                    <td class="text-center">
                        <input type="number" name="capaian" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="21">
                    </td>
                    <td class="text-center">
                        <input type="number" name="pembagi" class="input input-bordered lg:w-32 w-full" min="0" step="0.1" value="232">
                    </td>
                    <td class="text-center">
                        <input type="text" name="persentase" class="input input-bordered lg:w-32 w-full" value="9.05" readonly>
                    </td>
                </tr>
            </tbody>
        </table>


        <button type="submit" class="btn btn-success btn-block mt-3">ISI CAPAIAN</button>

    </form>
</div>

<script>
    // $('#sasaran, #satuan, #cascading').select2()
    // $('#uraian').select2({
    //     tags: true,
    //     language: {
    //         noResults: function(params) {
    //             return "Ketik uraian..";
    //         }
    //     }
    // })

    // initFormAjax('#form-add-indikator', {
    //     success: function(response) {
    //         console.log(response.message)
    //         toastr.success(response.message)
    //         setTimeout(function() {
    //             location.href = `${BASE_URL}/indikatorkinerja/`
    //         }, 1000);
    //     },
    //     error: function(xhr) {
    //         const response = xhr.responseJSON
    //         toastr.error(response.message)
    //     }
    // })
</script>
<?= $this->endSection() ?>
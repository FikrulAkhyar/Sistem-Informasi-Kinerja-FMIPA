<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Tambah Indikator Kinerja Tahun <?= date('Y') ?></div>

<div class="mx-auto mt-5 mb-10">
    <form action="<?= base_url('indikatorKinerja/store') ?>" id="form-add-indikator" method="POST" show-validation>
        <input type="hidden" name="tahun" value="<?= date('Y') ?>">
        <div class="form-control">
            <label for="sasaran" class="label">
                <span class="label-text label-required">Sasaran</span>
            </label>
            <select type="text" name="sasaran" id="sasaran" class="select select-bordered" style="width: 100%;">
                <option disabled selected>Pilih Sasaran</option>
                <option value="1">Tersedianya lulusan yang memiliki nilai-nilai religius, mandiri, sosial, beretika, berakhlak mulia, berkarakter dan mampu mengaplikasikan nilai-nilai Syiah Kuala dan terciptanya lulusan yang berjiwa entrepreneur, leadership, kreatif, inovatif, dan tangguh sehingga mampu bersaing pada level nasional dan global</option>
                <option value="2">Terwujudnya hasil-hasil penelitian dan pengabdian masyarakat yang inovatif, aplikatif dan berdampak langsung kepada masyarakat dalam rangka mendukung pembangunan daerah, nasional dan global</option>
                <option value="3">Terealisasi peningkatan kerjasama dengan berbagai institusi nasional dan global di bidang IPTEK, Humaniora, Olahraga dan Seni</option>
                <option value="4">Terwujudnya tata kelola manajemen pendidikan tinggi yang bermutu</option>
            </select>
        </div>

        <div class="grid grid-cols-12 gap-3">
            <div class="lg:col-span-6 col-span-12">
                <div class="form-control">
                    <label for="kode" class="label">
                        <span class="label-text label-required">Kode Indikator Kerja</span>
                    </label>
                    <input type="text" name="kode" id="kode" class="input input-bordered" placeholder="Masukkan kode IK">
                </div>
            </div>
            <div class="lg:col-span-6 col-span-12">
                <div class="form-control">
                    <label for="target" class="label">
                        <span class="label-text label-required">Target</span>
                    </label>
                    <input type="number" name="target" id="target" class="input input-bordered" min="0" value="0">
                </div>
            </div>
        </div>

        <div class="form-control my-3 text-center">
            <label class="label cursor-pointer justify-start">
                <input type="checkbox" class="checkbox" name="is_jurusan" id="is_jurusan" />
                <span class="label-text ml-3">Gunakan juga IK untuk jurusan</span>
            </label>
        </div>

        <div class="grid grid-cols-12 gap-3">
            <div class="lg:col-span-6 col-span-12 is-fakultas">
                <div class="form-control">
                    <label for="ket_fakultas" class="label">
                        <span class="label-text label-required">Keterangan (Fakultas)</span>
                    </label>
                    <textarea class="textarea textarea-bordered" name="ket_fakultas" id="ket_fakultas" placeholder="Masukkan keterangan IK untuk fakultas"></textarea>
                </div>

                <div class="form-control">
                    <label for="satuan_fakultas" class="label">
                        <span class="label-text label-required">Satuan (Fakultas)</span>
                    </label>
                    <select type="text" name="satuan_fakultas" id="satuan_fakultas" class="select select-bordered" style="width: 100%;">
                        <option disabled selected>Pilih Satuan</option>
                        <option value="1">Persentase (%)</option>
                        <option value="2">Jumlah</option>
                        <option value="3">Nilai</option>
                        <option value="4">Tahun</option>
                        <option value="5">Lab</option>
                        <option value="6">Ranking</option>
                        <option value="7">PUI</option>
                        <option value="8">Jurnal</option>
                        <option value="9">Sitasi</option>
                        <option value="10">Produk</option>
                        <option value="11">Buah</option>
                        <option value="12">Orang</option>
                        <option value="13">Mahasiswa</option>
                        <option value="14">Kegiatan</option>
                    </select>
                </div>

                <div class="form-control">
                    <label for="cascading_fakultas" class="label">
                        <span class="label-text label-required">Cascading (Fakultas)</span>
                    </label>
                    <select name="cascading_fakultas" id="cascading_fakultas" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;">
                        <option value="1">Wakil Dekan I</option>
                        <option value="2">Wakil Dekan II</option>
                        <option value="3">Wakil Direktur I PPS</option>
                        <option value="4">Wakil Direktur II PPS</option>
                        <option value="5">Ketua LP3M</option>
                        <option value="6">Ketua LP2M</option>
                        <option value="5">Semua Kepala UPT</option>
                        <option value="6">Kepala UPT TIK</option>
                        <option value="7">Kepala UPT Lab Terpadu</option>
                        <option value="8">Kepala UPT Perpustakaan</option>
                        <option value="9">Kepala UPT Kewirausahaan</option>
                        <option value="10">Kepala UPT Pusat Bahasa</option>
                        <option value="11">Kepala UPT Pusat Mitigasi Bencana</option>
                        <option value="12">Jurusan</option>
                        <option value="13">Prodi S1</option>
                        <option value="14">Prodi S2</option>
                        <option value="15">Prodi D3</option>
                    </select>
                </div>
            </div>

            <div class="lg:col-span-6 col-span-12 is-jurusan hidden">
                <div class="form-control">
                    <label for="ket_jurusan" class="label">
                        <span class="label-text label-required">Keterangan (Jurusan)</span>
                    </label>
                    <textarea class="textarea textarea-bordered" name="ket_jurusan" id="ket_jurusan" placeholder="Masukkan keterangan IK untuk jurusan"></textarea>
                </div>

                <div class="form-control">
                    <label for="satuan_jurusan" class="label">
                        <span class="label-text label-required">Satuan (Jurusan)</span>
                    </label>
                    <select type="text" name="satuan_jurusan" id="satuan_jurusan" class="select select-bordered" style="width: 100%;">
                        <option disabled selected>Pilih Satuan</option>
                        <option value="1">Persentase (%)</option>
                        <option value="2">Jumlah</option>
                        <option value="3">Nilai</option>
                        <option value="4">Tahun</option>
                        <option value="5">Lab</option>
                        <option value="6">Ranking</option>
                        <option value="7">PUI</option>
                        <option value="8">Jurnal</option>
                        <option value="9">Sitasi</option>
                        <option value="10">Produk</option>
                        <option value="11">Buah</option>
                        <option value="12">Orang</option>
                        <option value="13">Mahasiswa</option>
                        <option value="14">Kegiatan</option>
                    </select>
                </div>

                <div class="form-control">
                    <label for="cascading_jurusan" class="label">
                        <span class="label-text label-required">Cascading (Jurusan)</span>
                    </label>
                    <select name="cascading_jurusan" id="cascading_jurusan" multiple="multiple" data-placeholder="Pilih Cascading" class="select select-bordered" style="width: 100%;">
                        <option value="1">Wakil Dekan I</option>
                        <option value="2">Wakil Dekan II</option>
                        <option value="3">Wakil Direktur I PPS</option>
                        <option value="4">Wakil Direktur II PPS</option>
                        <option value="5">Ketua LP3M</option>
                        <option value="6">Ketua LP2M</option>
                        <option value="5">Semua Kepala UPT</option>
                        <option value="6">Kepala UPT TIK</option>
                        <option value="7">Kepala UPT Lab Terpadu</option>
                        <option value="8">Kepala UPT Perpustakaan</option>
                        <option value="9">Kepala UPT Kewirausahaan</option>
                        <option value="10">Kepala UPT Pusat Bahasa</option>
                        <option value="11">Kepala UPT Pusat Mitigasi Bencana</option>
                        <option value="12">Jurusan</option>
                        <option value="13">Prodi S1</option>
                        <option value="14">Prodi S2</option>
                        <option value="15">Prodi D3</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block my-3">TAMBAH</button>

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
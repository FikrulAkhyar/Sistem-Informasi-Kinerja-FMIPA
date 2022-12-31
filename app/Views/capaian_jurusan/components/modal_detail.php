<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Capaian <?= $kode ?> <?= $tahun ?> <?= $nama_triwulan . '<br>' ?> Jurusan <?= $nama_jurusan ?></h2>
<div class="overflow-x-auto">
    <table id="table-detail" class="table w-full" style="width: 100%;">
        <thead>
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
                    <th rowspan="<?= count($capaian[$i]['capaian']) + 1 ?>"><?= $capaian[$i]['nama_cascading'] ?></th>
                    <?php for ($j = 0; $j < count($capaian[$i]['capaian']); $j++) : ?>
                <tr>
                    <td><?= $capaian[$i]['capaian'][$j]['uraian'] ?></td>
                    <td class="text-center"><?= $capaian[$i]['capaian'][$j]['capaian'] ?></td>
                    <td class="text-center"><?= $capaian[$i]['capaian'][$j]['pembagi'] ?></td>
                    <td class="text-center"><?= $capaian[$i]['capaian'][$j]['hasil'] ?></td>
                </tr>
            <?php endfor ?>
            </tr>
        <?php endfor ?>
        <tr>
            <td colspan="4" class="text-end font-bold">Jumlah</td>
            <td class="font-bold text-center"><?= $jumlah ?></td>
        </tr>
        </tbody>
    </table>
</div>
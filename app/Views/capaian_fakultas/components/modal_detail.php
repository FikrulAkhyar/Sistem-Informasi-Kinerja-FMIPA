<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Detail <?= $kode ?></h2>
<div class="overflow-x-auto">
    <table id="table-detail" class="table w-full" style="width: 100%;">
        <thead>
            <tr class="text-center">
                <th>Uraian</th>
                <th>Capaian</th>
                <th>Pembagi</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($capaian as $c) : ?>
                <tr>
                    <td><?= $c['uraian'] ?></td>
                    <td class="text-center"><?= $c['capaian'] ?></td>
                    <td class="text-center"><?= $c['pembagi'] == null ? 0 : $c['pembagi'] ?></td>
                    <td class="text-center"><?= $c['hasil'] ?></td>
                </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="3" class="text-end font-bold">Jumlah</td>
                <td class="font-bold text-center"><?= $jumlah ?></td>
            </tr>
        </tbody>
    </table>
</div>
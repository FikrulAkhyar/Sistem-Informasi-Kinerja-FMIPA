<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Isi Capaian IKU-1.01</h2>
<form action="<?= base_url('capaian/update/' . $id) ?>" id="form-update-capaian" method="POST" show-validation>
    <div class="form-control">
        <label for="tw1" class="label">
            <span class="label-text label-required">Triwulan 1</span>
        </label>
        <input type="number" name="tw1" id="tw1" class="input input-bordered" min="0" value="<?= $capaian['triwulan_satu'] ?>">
    </div>
    <div class="form-control">
        <label for="tw2" class="label">
            <span class="label-text label-required">Triwulan 2</span>
        </label>
        <input type="number" name="tw2" id="tw2" class="input input-bordered" min="0" value="<?= $capaian['triwulan_dua'] ?>">
    </div>
    <div class="form-control">
        <label for="tw3" class="label">
            <span class="label-text label-required">Triwulan 3</span>
        </label>
        <input type="number" name="tw3" id="tw3" class="input input-bordered" min="0" value="<?= $capaian['triwulan_tiga'] ?>">
    </div>
    <div class="form-control">
        <label for="tw4" class="label">
            <span class="label-text label-required">Triwulan 4</span>
        </label>
        <input type="number" name="tw4" id="tw4" class="input input-bordered" min="0" value="<?= $capaian['triwulan_empat'] ?>">
    </div>

    <div class="modal-action">
        <button type="submit" form="form-update-capaian" class="btn btn-primary btn-block">ISI</button>
    </div>
</form>
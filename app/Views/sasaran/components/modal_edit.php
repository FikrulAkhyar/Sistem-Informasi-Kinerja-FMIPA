<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Edit Sasaran</h2>
<form action="<?= base_url('sasaran/update/' . $id) ?>" id="form-update-sasaran" method="POST" show-validation>
    <div class="form-control">
        <label for="sasaran" class="label">
            <span class="label-text label-required">Sasaran</span>
        </label>
        <textarea name="sasaran" id="sasaran" class="textarea textarea-bordered" placeholder="masukkan sasaran"><?= $sasaran['keterangan'] ?></textarea>
    </div>

    <div class="modal-action">
        <button type="submit" form="form-update-sasaran" class="btn btn-primary btn-block">Edit</button>
    </div>
</form>

<script>
    $('#menu_akses').select2()
</script>
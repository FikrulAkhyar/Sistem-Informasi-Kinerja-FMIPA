<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<p>
    apakah anda yakin menghapus indikator kinerja ini?
</p>
<form action="<?= base_url("indikatorkinerja/delete/{$id}") ?>" id="form-delete-indikator" method="POST" show-validation>
    <div class="modal-action">
        <button type="submit" form="form-delete-indikator" class="btn btn-error">Hapus</button>
    </div>
</form>
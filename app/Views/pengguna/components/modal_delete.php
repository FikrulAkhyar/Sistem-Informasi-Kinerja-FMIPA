<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Hapus Pengguna</h2>
<p>
    apakah anda yakin menghapus pengguna ini?
</p>
<form action="<?= base_url("pengguna/delete/{$id}") ?>" id="form-delete-pengguna" method="POST" show-validation>
    <div class="modal-action">
        <button type="submit" form="form-delete-pengguna" class="btn btn-error">Hapus</button>
    </div>
</form>
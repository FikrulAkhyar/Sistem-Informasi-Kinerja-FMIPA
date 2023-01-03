<label for="modal-global" class="btn btn-sm btn-circle text-white absolute right-2 top-2">✕</label>
<h2 class="font-bold text-xl lg:text-2xl my-4">Edit Password Pengguna</h2>
<form action="<?= base_url('pengguna/update_password/' . $id) ?>" id="form-update-password-pengguna" method="POST" show-validation>
    <div class="form-control">
        <label for="password" class="label">
            <span class="label-text label-required">Password</span>
        </label>
        <input type="password" name="password" id="password" class="input input-bordered" placeholder="masukkan password baru">
    </div>
    <div class="form-control">
        <label for="confirm_password" class="label">
            <span class="label-text label-required">Konfirmasi Password</span>
        </label>
        <input type="password" name="confirm_password" id="confirm_password" class="input input-bordered" placeholder="masukkan konfirmasi password">
    </div>


    <div class="modal-action">
        <button type="submit" form="form-update-password-pengguna" class="btn btn-primary btn-block">Edit</button>
    </div>
</form>
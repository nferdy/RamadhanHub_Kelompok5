<section class="page-heading">
    <div>
        <span class="eyebrow muted">Administrator</span>
        <h1>Edit User</h1>
        <p>Ubah informasi pengguna atau reset password.</p>
    </div>
</section>

<section style="display: flex; justify-content: center; align-items: center; width: 100%;">
    <article class="panel" style="width: 100%; max-width: 500px;">
        <form action="<?php echo site_url('admin/users/edit'); ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo html_escape($edit_user_data['id']); ?>">
            
            <label class="field" style="margin-bottom: 15px;">
                <span>Username</span>
                <input type="text" name="username" value="<?php echo html_escape($edit_user_data['username']); ?>" required>
            </label>
            
            <label class="field" style="margin-bottom: 15px;">
                <span>Role Akses</span>
                <select name="role" required>
                    <option value="user" <?php echo $edit_user_data['role'] === 'user' ? 'selected' : ''; ?>>User Biasa</option>
                    <option value="admin" <?php echo $edit_user_data['role'] === 'admin' ? 'selected' : ''; ?>>Administrator</option>
                </select>
            </label>

            <label class="field" style="margin-bottom: 25px;">
                <span>Password Baru <small class="muted">(Kosongkan jika tidak ingin mengubah password)</small></span>
                <input type="password" name="password" placeholder="Masukkan password baru...">
            </label>
            
            <div style="display: flex; gap: 10px;">
                <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-outline" style="flex: 1; text-align: center;">Batal</a>
                <button class="btn btn-primary" type="submit" style="flex: 2;">Simpan Perubahan</button>
            </div>
        </form>
    </article>
</section>

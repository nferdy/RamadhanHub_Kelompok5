<section class="page-heading">
    <div>
        <span class="eyebrow muted">Administrator</span>
        <h1>Kelola User</h1>
        <p>Manajemen data akun: tambah, edit, atau hapus pengguna Ramadhan HUB.</p>
    </div>
</section>

<?php if(!empty($flash_error)): ?>
    <div style="background: #ffcccc; color: #cc0000; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
        <?php echo $flash_error; ?>
    </div>
<?php endif; ?>
<?php if(!empty($flash_success)): ?>
    <div style="background: #ccffcc; color: #008800; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
        <?php echo $flash_success; ?>
    </div>
<?php endif; ?>

<section class="panel mb-4">
    <div class="section-head" style="margin-bottom: 15px;">
        <h2>Tambah Akun Baru</h2>
    </div>
    <form action="<?php echo site_url('admin/users/add'); ?>" method="POST" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
        <label class="field" style="flex: 1; min-width: 200px;">
            <span>Username</span>
            <input type="text" name="username" placeholder="Masukkan username" required>
        </label>
        <label class="field" style="flex: 1; min-width: 200px;">
            <span>Password</span>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </label>
        <label class="field" style="flex: 1; min-width: 150px;">
            <span>Role Akses</span>
            <select name="role" required>
                <option value="user">User Biasa</option>
                <option value="admin">Administrator</option>
            </select>
        </label>
        <button class="btn btn-primary" type="submit">Tambah User</button>
    </form>
</section>

<section class="panel panel-large">
    <div class="section-head"><h2>Daftar Akun</h2></div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #eaeaea;">
                    <th style="padding: 12px 8px;">ID</th>
                    <th style="padding: 12px 8px;">Username</th>
                    <th style="padding: 12px 8px;">Role</th>
                    <th style="padding: 12px 8px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users_data)): ?>
                    <?php foreach($users_data as $u): ?>
                    <tr style="border-bottom: 1px solid #eaeaea;">
                        <td style="padding: 12px 8px;"><?php echo html_escape($u['id']); ?></td>
                        <td style="padding: 12px 8px;"><strong><?php echo html_escape($u['username']); ?></strong></td>
                        <td style="padding: 12px 8px;">
                            <span class="pill <?php echo $u['role'] === 'admin' ? 'strong' : ''; ?>">
                                <?php echo ucfirst(html_escape($u['role'])); ?>
                            </span>
                        </td>
                        <td style="padding: 12px 8px;">
                            <a href="<?php echo site_url('admin/users/edit?id=' . $u['id']); ?>" class="btn btn-small btn-outline" style="margin-right: 5px;">Edit</a>
                            
                            <?php if($u['id'] != $_SESSION['user_id']): ?>
                                <a href="<?php echo site_url('admin/users/delete?id=' . $u['id']); ?>" 
                                   onclick="return confirm('Hapus permanen akun <?php echo html_escape($u['username']); ?>?');" 
                                   class="btn btn-small btn-outline" style="color: #ff4757; border-color: #ff4757;">Hapus</a>
                            <?php else: ?>
                                <span class="muted" style="margin-left: 10px;"><small>(Anda)</small></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

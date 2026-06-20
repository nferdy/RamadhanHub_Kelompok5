<section class="page-heading" style="text-align: center; margin-top: 5vh; display: flex; flex-direction: column; align-items: center;">
    <img src="<?php echo base_url('assets/img/logo-navbar.png'); ?>" alt="Ramadhan HUB Logo" style="width: 80px; margin-bottom: 20px;">
    <div>
        <span class="eyebrow muted">Buat Akun Baru</span>
        <h1>Daftar Ramadhan HUB</h1>
        <p>Mulai pantau progress ibadah Anda sekarang.</p>
    </div>
</section>

<section style="display: flex; justify-content: center; align-items: center; width: 100%;">
    <article class="panel" style="width: 100%; max-width: 400px;">
        <?php if(!empty($flash_error)): ?>
            <div style="background: #ffcccc; color: #cc0000; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                <?php echo $flash_error; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo site_url('auth/register_process'); ?>" method="POST">
            <label class="field" style="margin-bottom: 15px;">
                <span>Username</span>
                <input type="text" name="username" placeholder="Buat username baru" required>
            </label>
            <label class="field" style="margin-bottom: 25px;">
                <span>Password</span>
                <input type="password" name="password" placeholder="Buat password" required>
            </label>
            <button class="btn btn-primary full" type="submit">Daftar Akun</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <small>Sudah punya akun? <a href="<?php echo site_url('login'); ?>" class="inline-link">Login di sini</a></small>
        </div>
    </article>
</section>

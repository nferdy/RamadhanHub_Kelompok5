<section class="page-heading" style="text-align: center; margin-top: 5vh; display: flex; flex-direction: column; align-items: center;">
    <img src="<?php echo base_url('assets/img/logo-navbar.png'); ?>" alt="Ramadhan HUB Logo" style="width: 80px; margin-bottom: 20px;">
    
    <div>
        <span class="eyebrow muted">Selamat Datang</span>
        <h1>Masuk ke Ramadhan HUB</h1>
        <p>Silakan login untuk menyimpan progress ibadah Anda.</p>
    </div>
</section>

<section style="display: flex; justify-content: center; align-items: center; width: 100%;">
    <article class="panel" style="width: 100%; max-width: 400px;">
        <?php if(!empty($flash_error)): ?>
            <div style="background: #ffcccc; color: #cc0000; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                <?php echo $flash_error; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($flash_success)): ?>
            <div style="background: #ccffcc; color: #008800; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                <?php echo $flash_success; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo site_url('auth/process'); ?>" method="POST">
            <label class="field" style="margin-bottom: 15px;">
                <span>Username</span>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </label>
            <label class="field" style="margin-bottom: 25px;">
                <span>Password</span>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </label>
            <button class="btn btn-primary full" type="submit">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <small>Belum punya akun? <a href="<?php echo site_url('register'); ?>" class="inline-link">Daftar di sini</a></small>
        </div>
    </article>
</section>

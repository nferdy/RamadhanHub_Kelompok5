<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b6b57">
    <meta name="description" content="Web interaktif untuk menunjang ibadah dan spiritual selama bulan Ramadhan: kalender, puasa, reminder sholat, Al-Quran, dan achievement.">
    <title><?php echo html_escape(isset($page_title) ? $page_title : 'Ramadhan HUB'); ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?php echo base_url('assets/css/ramadhan.css?v=20260619_logo_fit_v1'); ?>" rel="stylesheet">
</head>
<body data-page="<?php echo html_escape(isset($active_menu) ? $active_menu : 'dashboard'); ?>">
    <div class="ambient ambient-one" aria-hidden="true"></div>
    <div class="ambient ambient-two" aria-hidden="true"></div>

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="<?php echo site_url('dashboard'); ?>" aria-label="Ramadhan HUB Home">
                <span class="brand-mark logo-mark">
                    <img src="<?php echo base_url('assets/img/logo-navbar.png'); ?>" alt="Ramadhan HUB">
                </span>
                <span class="brand-copy">
                    <strong>Ramadhan HUB</strong>
                    <small>Ibadah tracker</small>
                </span>
            </a>

            <button class="nav-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false" data-nav-toggle>
                <span></span><span></span><span></span>
            </button>

            <nav class="main-nav" data-main-nav>
                <?php
                $menus = array(
                    'dashboard'   => array('Dashboard', 'dashboard'),
                    'calendar'    => array('Kalender', 'kalender'),
                    'prayer'      => array('Sholat', 'sholat'),
                    'fasting'     => array('Puasa', 'puasa'),
                    'quran'       => array('Al-Quran', 'quran'),
                    'achievement' => array('Achievement', 'achievement'),
                );
                foreach ($menus as $key => $item):
                    $isActive = (isset($active_menu) && $active_menu === $key) ? ' active' : '';
                ?>
                    <a class="nav-link<?php echo $isActive; ?>" href="<?php echo site_url($item[1]); ?>"><?php echo html_escape($item[0]); ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <main class="container page-shell">
        <?php if (!empty($not_found)): ?>
            <div class="alert-card mb-4">
                Halaman yang diminta tidak ditemukan. Anda diarahkan ke dashboard.
            </div>
        <?php endif; ?>

        <?php
        if (isset($content_file) && is_file($content_file)) {
            include $content_file;
        } elseif (isset($content) && isset($this) && isset($this->load)) {
            $this->load->view($content);
        }
        ?>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <span>Ramadhan HUB · Database-first prototype</span>
            <span>Projek Besar Pemrogaman Web 1 </span>
            <span>Oleh Kelompok 5 </span>
        </div>
    </footer>

    <div class="toast-stack" id="toastStack" aria-live="polite" aria-atomic="true"></div>

    <script>
        window.RAMADHAN_BASE_URL = "<?php echo base_url(); ?>";
        window.RAMADHAN_SITE_URL = "<?php echo site_url(); ?>";
        window.RAMADHAN_USER_ID = <?php echo isset($demo_user_id) ? (int) $demo_user_id : 1; ?>;
    </script>
    <script src="<?php echo base_url('assets/js/app.js?v=20260619_logo_fit_v1'); ?>"></script>
</body>
</html>

<section class="hero-grid">
    <article class="hero-card">
        <div class="eyebrow">Ramadhan Spiritual Operating System</div>
        <h1>Bangun ritme ibadah yang terukur, tenang, dan konsisten.</h1>
        <p>Kelola kalender Ramadhan, puasa harian, reminder sholat wajib dan sunnah, target khatam Al-Quran, serta achievement dalam satu dashboard interaktif.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="<?php echo site_url('kalender'); ?>">Mulai dari Kalender</a>
            <a class="btn btn-ghost" href="<?php echo site_url('quran'); ?>">Lanjutkan Bacaan</a>
        </div>
        <div class="hero-meta">
            <span><b id="heroRamadhanDay">-</b> hari berjalan</span>
            <span><b id="heroCompletionRate">0%</b> habit selesai</span>
        </div>
    </article>

    <aside class="prayer-widget">
        <div class="widget-topline">
            <span>Sholat berikutnya</span>
            <span class="live-dot">Live</span>
        </div>
        <h2 id="dashboardNextPrayer">-</h2>
        <p id="dashboardCountdown">Menghitung waktu...</p>
        <div class="time-ring" aria-label="progress menuju jadwal sholat berikutnya">
            <svg viewBox="0 0 120 120" role="img">
                <circle cx="60" cy="60" r="52"></circle>
                <circle cx="60" cy="60" r="52" id="dashboardPrayerRing"></circle>
            </svg>
            <span id="dashboardClock">--:--</span>
        </div>
        <a class="inline-link" href="<?php echo site_url('sholat'); ?>">Atur reminder sholat</a>
    </aside>
</section>

<section class="stats-grid" aria-label="Ringkasan progress">
    <article class="stat-card">
        <span class="stat-icon">01</span>
        <p>Puasa selesai</p>
        <h3><span id="statFastingDone">0</span><small>/30</small></h3>
    </article>
    <article class="stat-card">
        <span class="stat-icon">02</span>
        <p>Streak puasa</p>
        <h3><span id="statFastingStreak">0</span><small>hari</small></h3>
    </article>
    <article class="stat-card">
        <span class="stat-icon">03</span>
        <p>Juz selesai</p>
        <h3><span id="statQuranDone">0</span><small>/30</small></h3>
    </article>
    <article class="stat-card">
        <span class="stat-icon">04</span>
        <p>Total XP</p>
        <h3><span id="statXp">0</span><small>XP</small></h3>
    </article>
</section>

<section class="dashboard-layout">
    <article class="panel panel-large">
        <div class="section-head">
            <div>
                <span class="eyebrow muted">Progress Ramadhan</span>
                <h2>Target utama bulan ini</h2>
            </div>
            <a class="btn btn-small btn-outline" href="<?php echo site_url('puasa'); ?>">Update Puasa</a>
        </div>

        <div class="progress-group">
            <div class="progress-row">
                <div>
                    <strong>Puasa</strong>
                    <span id="dashboardFastingPercent">0%</span>
                </div>
                <div class="progress-track"><span id="dashboardFastingBar"></span></div>
            </div>
            <div class="progress-row">
                <div>
                    <strong>Al-Quran</strong>
                    <span id="dashboardQuranPercent">0%</span>
                </div>
                <div class="progress-track"><span id="dashboardQuranBar"></span></div>
            </div>
            <div class="progress-row">
                <div>
                    <strong>Sholat hari ini</strong>
                    <span id="dashboardPrayerPercent">0%</span>
                </div>
                <div class="progress-track"><span id="dashboardPrayerBar"></span></div>
            </div>
        </div>

        <div class="mini-calendar-preview" id="dashboardCalendarPreview"></div>
    </article>

    <aside class="panel daily-card">
        <span class="eyebrow muted">Ayat pengingat</span>
        <p class="arabic-text" id="dailyAyahArabic">يَا أَيُّهَا الَّذِينَ آمَنُوا كُتِبَ عَلَيْكُمُ الصِّيَامُ</p>
        <p id="dailyAyahTranslation">“Wahai orang-orang yang beriman, diwajibkan atas kamu berpuasa sebagaimana diwajibkan atas orang sebelum kamu agar kamu bertakwa.”</p>
        <small id="dailyAyahSource">QS. Al-Baqarah: 183</small>
        <button class="btn btn-primary full" id="markAyahReadBtn" type="button">Tandai sudah dibaca</button>
    </aside>
</section>

<section class="panel mt-4">
    <div class="section-head">
        <div>
            <span class="eyebrow muted">Achievement aktif</span>
            <h2>Badge yang sudah terbuka</h2>
        </div>
        <a class="inline-link" href="<?php echo site_url('achievement'); ?>">Lihat semua</a>
    </div>
    <div class="badge-strip" id="miniBadges"></div>
</section>

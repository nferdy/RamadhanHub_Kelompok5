<section class="page-heading">
    <div>
        <span class="eyebrow muted">Sholat & Reminder</span>
        <h1>Jam pengingat sholat wajib dan sunnah</h1>
        <p>Jadwal pada prototype ini bersifat demo/offline. Untuk produksi, sambungkan ke API jadwal sholat resmi sesuai kota pengguna.</p>
    </div>
    <div class="heading-actions">
        <label class="field compact-field">
            <span>Kota</span>
            <select id="citySelect">
                <option value="jakarta">Jakarta</option>
                <option value="purbalingga">Purbalingga</option>
                <option value="bandung">Bandung</option>
                <option value="surabaya">Surabaya</option>
                <option value="makassar">Makassar</option>
            </select>
        </label>
        <button class="btn btn-primary" id="enableNotificationBtn" type="button">Aktifkan Reminder</button>
    </div>
</section>

<section class="prayer-layout">
    <aside class="panel prayer-focus">
        <span class="eyebrow muted">Berikutnya</span>
        <h2 id="nextPrayerName">-</h2>
        <p id="nextPrayerCountdown">-</p>
        <div class="large-clock" id="prayerCurrentClock">--:--</div>
        <small>Reminder berjalan selama halaman web terbuka dan izin notifikasi browser aktif.</small>
    </aside>

    <article class="panel panel-large">
        <div class="section-head">
            <div>
                <h2>Jadwal Hari Ini</h2>
                <p class="section-desc">Centang sholat yang sudah dilaksanakan untuk menghitung progress harian.</p>
            </div>
            <span class="pill" id="prayerCityLabel">Jakarta</span>
        </div>
        <div class="prayer-list" id="prayerList"></div>
    </article>
</section>

<section class="panel mt-4">
    <div class="section-head">
        <div>
            <span class="eyebrow muted">Sholat sunnah</span>
            <h2>Target ibadah tambahan</h2>
        </div>
        <span class="section-desc" id="sunnahProgressLabel">0 selesai</span>
    </div>
    <div class="sunnah-grid" id="sunnahList"></div>
</section>

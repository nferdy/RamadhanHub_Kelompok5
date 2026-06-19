<section class="page-heading">
    <div>
        <span class="eyebrow muted">Kalender Ramadhan</span>
        <h1>Rencana 30 hari ibadah</h1>
        <p>Atur tanggal awal Ramadhan, lalu gunakan kalender ini untuk melihat status puasa, target Quran, dan prioritas ibadah harian.</p>
    </div>
    <div class="heading-actions">
        <label class="field compact-field">
            <span>Awal Ramadhan</span>
            <input type="date" id="ramadhanStartInput">
        </label>
        <button class="btn btn-primary" id="saveRamadhanStartBtn" type="button">Simpan</button>
    </div>
</section>

<section class="stats-grid compact-stats" aria-label="Ringkasan kalender">
    <article class="stat-card">
        <span class="stat-icon">A</span>
        <p>Hari berjalan</p>
        <h3><span id="calendarCurrentDay">-</span><small>/30</small></h3>
    </article>
    <article class="stat-card">
        <span class="stat-icon">B</span>
        <p>Puasa selesai</p>
        <h3><span id="calendarFastingDone">0</span><small>hari</small></h3>
    </article>
    <article class="stat-card">
        <span class="stat-icon">C</span>
        <p>Juz selesai</p>
        <h3><span id="calendarQuranDone">0</span><small>juz</small></h3>
    </article>
    <article class="stat-card">
        <span class="stat-icon">D</span>
        <p>Konsistensi</p>
        <h3><span id="calendarConsistency">0%</span></h3>
    </article>
</section>

<section class="panel">
    <div class="section-head">
        <div>
            <h2>Kalender 30 Hari</h2>
            <p class="section-desc">Klik kartu hari untuk membuka tracker puasa.</p>
        </div>
        <div class="legend-row">
            <span><i class="status-dot done"></i>Selesai</span>
            <span><i class="status-dot excused"></i>Uzur</span>
            <span><i class="status-dot missed"></i>Batal</span>
            <span><i class="status-dot empty"></i>Belum</span>
        </div>
    </div>
    <div class="calendar-grid" id="ramadhanCalendarGrid"></div>
</section>

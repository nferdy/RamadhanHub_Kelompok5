<section class="page-heading">
    <div>
        <span class="eyebrow muted">Puasa</span>
        <h1>Tracker puasa harian</h1>
        <p>Catat status setiap hari: selesai, uzur, batal, atau belum diisi. Data dipakai untuk menghitung streak dan achievement.</p>
    </div>
    <div class="heading-actions">
        <button class="btn btn-outline" id="resetFastingBtn" type="button">Reset Puasa</button>
        <button class="btn btn-primary" id="completeTodayFastingBtn" type="button">Tandai hari ini selesai</button>
    </div>
</section>

<section class="stats-grid compact-stats">
    <article class="stat-card"><span class="stat-icon">P</span><p>Berhasil puasa</p><h3><span id="fastingDoneCount">0</span><small>/30</small></h3></article>
    <article class="stat-card"><span class="stat-icon">U</span><p>Uzur</p><h3><span id="fastingExcusedCount">0</span><small>hari</small></h3></article>
    <article class="stat-card"><span class="stat-icon">S</span><p>Streak</p><h3><span id="fastingStreakCount">0</span><small>hari</small></h3></article>
    <article class="stat-card"><span class="stat-icon">R</span><p>Rasio selesai</p><h3><span id="fastingDoneRate">0%</span></h3></article>
</section>

<section class="fasting-layout">
    <article class="panel panel-large">
        <div class="section-head">
            <div>
                <h2>30 Hari Ramadhan</h2>
                <p class="section-desc">Pilih hari, lalu ubah status di panel kanan.</p>
            </div>
            <div class="legend-row">
                <span><i class="status-dot done"></i>Selesai</span>
                <span><i class="status-dot excused"></i>Uzur</span>
                <span><i class="status-dot missed"></i>Batal</span>
                <span><i class="status-dot empty"></i>Belum</span>
            </div>
        </div>
        <div class="fasting-grid" id="fastingGrid"></div>
    </article>

    <aside class="panel sticky-panel">
        <span class="eyebrow muted">Update status</span>
        <h2>Hari <span id="selectedFastingDay">-</span></h2>
        <p class="section-desc" id="selectedFastingDate">Pilih salah satu hari.</p>
        <div class="status-actions">
            <button class="btn btn-status status-done" data-fasting-status="done" type="button">Selesai Puasa</button>
            <button class="btn btn-status status-excused" data-fasting-status="excused" type="button">Uzur</button>
            <button class="btn btn-status status-missed" data-fasting-status="missed" type="button">Batal</button>
            <button class="btn btn-status status-empty" data-fasting-status="empty" type="button">Kosongkan</button>
        </div>
        <label class="field mt-3">
            <span>Catatan singkat</span>
            <textarea id="fastingNoteInput" rows="4" placeholder="Contoh: sahur tepat waktu, perlu tidur lebih awal..."></textarea>
        </label>
        <button class="btn btn-outline full" id="saveFastingNoteBtn" type="button">Simpan Catatan</button>
    </aside>
</section>

<section class="page-heading">
    <div>
        <span class="eyebrow muted">Al-Quran</span>
        <h1>Target tilawah dan khatam</h1>
        <p>Tandai juz yang sudah selesai dan simpan posisi bacaan terakhir agar progress Ramadhan tetap terukur.</p>
    </div>
    <div class="heading-actions">
        <button class="btn btn-outline" id="resetQuranBtn" type="button">Reset Quran</button>
        <button class="btn btn-primary" id="saveLastReadBtn" type="button">Simpan Bacaan</button>
    </div>
</section>

<section class="quran-layout">
    <article class="panel panel-large">
        <div class="section-head">
            <div>
                <h2>Progress 30 Juz</h2>
                <p class="section-desc">Klik kartu juz untuk menandai selesai/belum.</p>
            </div>
            <span class="pill strong" id="quranPercentBadge">0%</span>
        </div>
        <div class="progress-track tall"><span id="quranProgressBar"></span></div>
        <div class="quran-grid" id="quranGrid"></div>
    </article>

    <aside class="panel sticky-panel">
        <span class="eyebrow muted">Bacaan terakhir</span>
        <h2>Bookmark tilawah</h2>
        <label class="field">
            <span>Surah</span>
            <input id="lastSurahInput" placeholder="Contoh: Al-Baqarah">
        </label>
        <div class="two-fields">
            <label class="field">
                <span>Ayat</span>
                <input type="number" min="1" id="lastAyahInput" placeholder="183">
            </label>
            <label class="field">
                <span>Halaman</span>
                <input type="number" min="1" id="lastPageInput" placeholder="28">
            </label>
        </div>
        <div class="last-read-panel">
            <small>Tersimpan</small>
            <strong id="lastReadText">Belum ada data.</strong>
        </div>
        <hr>
        <span class="eyebrow muted">Target harian</span>
        <p class="section-desc mb-0" id="quranDailyTargetText">Selesaikan 1 juz per hari untuk khatam dalam 30 hari.</p>
    </aside>
</section>

<section class="panel mt-4">
    <div class="section-head">
        <div>
            <span class="eyebrow muted">Rujukan cepat</span>
            <h2>Surah pilihan Ramadhan</h2>
        </div>
    </div>
    <div class="surah-cards">
        <article><span>01</span><strong>Al-Baqarah</strong><small>Puasa, takwa, dan petunjuk hidup.</small></article>
        <article><span>18</span><strong>Al-Kahfi</strong><small>Bacaan rutin Jumat dan penguatan iman.</small></article>
        <article><span>36</span><strong>Yasin</strong><small>Pengingat kehidupan, risalah, dan akhirat.</small></article>
        <article><span>97</span><strong>Al-Qadr</strong><small>Keutamaan malam Lailatul Qadr.</small></article>
    </div>
</section>

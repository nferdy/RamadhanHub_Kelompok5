(function () {
    'use strict';

    const APP_VERSION = '20260619-calendar-sequence-fix-v2';
    const STORAGE_KEY = 'ramadhan_companion_state_v2';
    const DAY_COUNT = 30;
    const PRAYER_NAMES = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
    const SUNNAH_NAMES = ['tahajud', 'dhuha', 'rawatib', 'tarawih'];

    const CITY_SCHEDULES = {
        jakarta: {
            label: 'Jakarta',
            prayers: [
                { key: 'tahajud', name: 'Tahajud', time: '03:25', type: 'sunnah', desc: 'Waktu tenang sebelum Subuh' },
                { key: 'subuh', name: 'Subuh', time: '04:35', type: 'wajib', desc: 'Sholat wajib 2 rakaat' },
                { key: 'dhuha', name: 'Dhuha', time: '06:22', type: 'sunnah', desc: 'Awal waktu Dhuha' },
                { key: 'dzuhur', name: 'Dzuhur', time: '11:57', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'ashar', name: 'Ashar', time: '15:15', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'maghrib', name: 'Maghrib', time: '17:55', type: 'wajib', desc: 'Sholat wajib 3 rakaat' },
                { key: 'isya', name: 'Isya', time: '19:05', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'tarawih', name: 'Tarawih', time: '19:28', type: 'sunnah', desc: 'Qiyam Ramadhan setelah Isya' }
            ]
        },
        purbalingga: {
            label: 'Purbalingga',
            prayers: [
                { key: 'tahajud', name: 'Tahajud', time: '03:25', type: 'sunnah', desc: 'Waktu tenang sebelum Subuh' },
                { key: 'subuh', name: 'Subuh', time: '04:29', type: 'wajib', desc: 'Sholat wajib 2 rakaat' },
                { key: 'dhuha', name: 'Dhuha', time: '06:13', type: 'sunnah', desc: 'Awal waktu Dhuha' },
                { key: 'dzuhur', name: 'Dzuhur', time: '11:44', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'ashar', name: 'Ashar', time: '15:05', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'maghrib', name: 'Maghrib', time: '17:35', type: 'wajib', desc: 'Sholat wajib 3 rakaat' },
                { key: 'isya', name: 'Isya', time: '18:50', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'tarawih', name: 'Tarawih', time: '19:09', type: 'sunnah', desc: 'Qiyam Ramadhan setelah Isya' }
          ]
        },
        bandung: {
            label: 'Bandung',
            prayers: [
                { key: 'tahajud', name: 'Tahajud', time: '03:20', type: 'sunnah', desc: 'Waktu tenang sebelum Subuh' },
                { key: 'subuh', name: 'Subuh', time: '04:31', type: 'wajib', desc: 'Sholat wajib 2 rakaat' },
                { key: 'dhuha', name: 'Dhuha', time: '06:18', type: 'sunnah', desc: 'Awal waktu Dhuha' },
                { key: 'dzuhur', name: 'Dzuhur', time: '11:54', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'ashar', name: 'Ashar', time: '15:12', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'maghrib', name: 'Maghrib', time: '17:52', type: 'wajib', desc: 'Sholat wajib 3 rakaat' },
                { key: 'isya', name: 'Isya', time: '19:02', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'tarawih', name: 'Tarawih', time: '19:25', type: 'sunnah', desc: 'Qiyam Ramadhan setelah Isya' }
            ]
        },
        surabaya: {
            label: 'Surabaya',
            prayers: [
                { key: 'tahajud', name: 'Tahajud', time: '03:05', type: 'sunnah', desc: 'Waktu tenang sebelum Subuh' },
                { key: 'subuh', name: 'Subuh', time: '04:15', type: 'wajib', desc: 'Sholat wajib 2 rakaat' },
                { key: 'dhuha', name: 'Dhuha', time: '06:02', type: 'sunnah', desc: 'Awal waktu Dhuha' },
                { key: 'dzuhur', name: 'Dzuhur', time: '11:38', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'ashar', name: 'Ashar', time: '14:56', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'maghrib', name: 'Maghrib', time: '17:36', type: 'wajib', desc: 'Sholat wajib 3 rakaat' },
                { key: 'isya', name: 'Isya', time: '18:46', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'tarawih', name: 'Tarawih', time: '19:08', type: 'sunnah', desc: 'Qiyam Ramadhan setelah Isya' }
            ]
        },
        makassar: {
            label: 'Makassar',
            prayers: [
                { key: 'tahajud', name: 'Tahajud', time: '04:00', type: 'sunnah', desc: 'Waktu tenang sebelum Subuh' },
                { key: 'subuh', name: 'Subuh', time: '04:53', type: 'wajib', desc: 'Sholat wajib 2 rakaat' },
                { key: 'dhuha', name: 'Dhuha', time: '06:38', type: 'sunnah', desc: 'Awal waktu Dhuha' },
                { key: 'dzuhur', name: 'Dzuhur', time: '12:12', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'ashar', name: 'Ashar', time: '15:31', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'maghrib', name: 'Maghrib', time: '18:09', type: 'wajib', desc: 'Sholat wajib 3 rakaat' },
                { key: 'isya', name: 'Isya', time: '19:19', type: 'wajib', desc: 'Sholat wajib 4 rakaat' },
                { key: 'tarawih', name: 'Tarawih', time: '19:42', type: 'sunnah', desc: 'Qiyam Ramadhan setelah Isya' }
            ]
        }
    };

    const SUNNAH_ITEMS = [
        { key: 'tahajud', title: 'Tahajud', time: 'Sepertiga malam akhir', desc: 'Target minimal 2 rakaat sebelum Subuh.' },
        { key: 'dhuha', title: 'Dhuha', time: 'Pagi', desc: 'Mulai setelah matahari naik hingga sebelum Dzuhur.' },
        { key: 'rawatib', title: 'Rawatib', time: 'Sebelum/sesudah wajib', desc: 'Pendamping sholat wajib sesuai kemampuan.' },
        { key: 'tarawih', title: 'Tarawih', time: 'Setelah Isya', desc: 'Qiyam Ramadhan berjamaah atau mandiri.' }
    ];

    const ACHIEVEMENTS = [
        { id: 'first_fast', title: 'Niat Pertama', code: 'NF', desc: 'Selesaikan minimal 1 hari puasa.', reward: 50, test: m => m.fastingDone >= 1 },
        { id: 'seven_fast', title: '7 Hari Konsisten', code: '7H', desc: 'Selesaikan 7 hari puasa.', reward: 120, test: m => m.fastingDone >= 7 },
        { id: 'half_ramadhan', title: 'Nisfu Ramadhan', code: '15', desc: 'Selesaikan 15 hari puasa.', reward: 180, test: m => m.fastingDone >= 15 },
        { id: 'full_ramadhan', title: 'Full Ramadhan', code: '30', desc: 'Selesaikan 30 hari puasa.', reward: 420, test: m => m.fastingDone >= 30 },
        { id: 'prayer_guard', title: 'Penjaga Waktu', code: 'JW', desc: 'Centang 5 sholat wajib dalam satu hari.', reward: 90, test: m => m.prayersToday >= 5 },
        { id: 'sunnah_seeker', title: 'Pencari Sunnah', code: 'SS', desc: 'Selesaikan 2 target sholat sunnah hari ini.', reward: 80, test: m => m.sunnahToday >= 2 },
        { id: 'first_juz', title: 'Juz Starter', code: 'J1', desc: 'Selesaikan 1 juz Al-Quran.', reward: 60, test: m => m.quranDone >= 1 },
        { id: 'ten_juz', title: '10 Juz Runner', code: '10', desc: 'Selesaikan 10 juz Al-Quran.', reward: 180, test: m => m.quranDone >= 10 },
        { id: 'khatam', title: 'Khatam Target', code: 'KT', desc: 'Selesaikan 30 juz Al-Quran.', reward: 520, test: m => m.quranDone >= 30 },
        { id: 'xp_500', title: '500 XP', code: 'XP', desc: 'Kumpulkan minimal 500 XP Ramadhan.', reward: 100, test: m => m.xpBeforeReward >= 500 }
    ];

    const USER_ID = Number(window.RAMADHAN_USER_ID || 1);

    let state = loadState();
    let selectedFastingDay = clamp(Number(state.selectedFastingDay || getRamadhanDay()) || 1, 1, DAY_COUNT);
    if (!hasCompletePreviousFastingDays(selectedFastingDay)) selectedFastingDay = getCurrentFastingDay();
    let lastNotificationMinute = '';
    let syncTimer = null;
    let isSyncing = false;
    let pendingSync = false;
    let backendAvailable = false;

    document.addEventListener('DOMContentLoaded', init);

    function init() {
        bindNavigation();
        bindGlobalActions();
        renderAll();
        startClock();
        checkReminderPermissionLabel();
        loadStateFromApi();
    }

    function defaultState() {
        return {
            version: 2,
            ramadhanStart: toISODate(new Date()),
            city: 'jakarta',
            remindersEnabled: false,
            fasting: {},
            fastingNotes: {},
            quran: {},
            lastRead: { surah: '', ayah: '', page: '' },
            prayerLogs: {},
            sunnahLogs: {},
            ayahReadDates: [],
            selectedFastingDay: 1,
            notified: {},
            dailyAyah: null
        };
    }

    function loadState() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            const parsed = raw ? JSON.parse(raw) : {};
            return mergeState(defaultState(), parsed);
        } catch (error) {
            console.warn('Gagal membaca localStorage. State direset.', error);
            return defaultState();
        }
    }

    function mergeState(base, saved) {
        const merged = Object.assign({}, base, saved || {});
        merged.fasting = normalizeFastingObject(Object.assign({}, base.fasting, saved.fasting || {}));
        merged.fastingNotes = Object.assign({}, base.fastingNotes, saved.fastingNotes || {});
        merged.quran = Object.assign({}, base.quran, saved.quran || {});
        merged.lastRead = Object.assign({}, base.lastRead, saved.lastRead || {});
        merged.prayerLogs = Object.assign({}, base.prayerLogs, saved.prayerLogs || {});
        merged.sunnahLogs = Object.assign({}, base.sunnahLogs, saved.sunnahLogs || {});
        merged.ayahReadDates = Array.isArray(saved.ayahReadDates) ? saved.ayahReadDates : base.ayahReadDates;
        merged.notified = Object.assign({}, base.notified, saved.notified || {});
        merged.dailyAyah = saved.dailyAyah || base.dailyAyah || null;
        return merged;
    }

    function saveState(options = {}) {
        state.version = 4;
        state.appVersion = APP_VERSION;
        state.fasting = normalizeFastingObject(state.fasting || {});
        if (!canSelectFastingDay(selectedFastingDay)) selectedFastingDay = getCurrentFastingDay();
        state.selectedFastingDay = selectedFastingDay;
        localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        if (options.sync !== false) scheduleStateSync();
    }

    function saveLocalStateOnly() {
        state.version = 4;
        state.appVersion = APP_VERSION;
        state.fasting = normalizeFastingObject(state.fasting || {});
        if (!canSelectFastingDay(selectedFastingDay)) selectedFastingDay = getCurrentFastingDay();
        state.selectedFastingDay = selectedFastingDay;
        localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
    }

    function renderAll() {
        state.fasting = normalizeFastingObject(state.fasting || {});
        if (!canSelectFastingDay(selectedFastingDay)) selectedFastingDay = getCurrentFastingDay();
        renderSharedStats();
        renderDashboard();
        renderCalendarPage();
        renderFastingPage();
        renderPrayerPage();
        renderQuranPage();
        renderAchievementsPage();
    }

    function bindNavigation() {
        const toggle = document.querySelector('[data-nav-toggle]');
        const nav = document.querySelector('[data-main-nav]');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', () => {
            const isOpen = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    function bindGlobalActions() {
        const markAyahReadBtn = $('#markAyahReadBtn');
        if (markAyahReadBtn) {
            markAyahReadBtn.addEventListener('click', () => {
                const today = toISODate(new Date());
                if (!state.ayahReadDates.includes(today)) {
                    state.ayahReadDates.push(today);
                    saveState();
                    toast('Ayat harian ditandai sudah dibaca.');
                } else {
                    toast('Ayat harian hari ini sudah pernah ditandai.');
                }
                renderAll();
            });
        }

        const startInput = $('#ramadhanStartInput');
        const saveStartBtn = $('#saveRamadhanStartBtn');
        if (startInput) startInput.value = state.ramadhanStart;
        if (saveStartBtn && startInput) {
            saveStartBtn.addEventListener('click', () => {
                if (!startInput.value) {
                    toast('Tanggal awal Ramadhan belum diisi.');
                    return;
                }
                state.ramadhanStart = startInput.value;
                saveState();
                toast('Tanggal awal Ramadhan disimpan.');
                renderAll();
            });
        }

        const resetFastingBtn = $('#resetFastingBtn');
        if (resetFastingBtn) {
            resetFastingBtn.addEventListener('click', () => {
                if (!confirm('Reset seluruh data puasa?')) return;
                state.fasting = {};
                state.fastingNotes = {};
                saveState();
                toast('Data puasa direset.');
                renderAll();
            });
        }

        const completeTodayFastingBtn = $('#completeTodayFastingBtn');
        if (completeTodayFastingBtn) {
            completeTodayFastingBtn.addEventListener('click', () => {
                // Tombol ini sengaja mengikuti urutan progress, bukan tanggal komputer,
                // supaya user tidak bisa melompat ke hari jauh di depan.
                const day = getCurrentFastingDay();
                const updated = setFastingStatus(day, 'done');
                if (!updated) return;
                toast('Puasa hari ' + day + ' ditandai selesai.');
                renderAll();
            });
        }

        document.querySelectorAll('[data-fasting-status]').forEach(button => {
            button.addEventListener('click', () => {
                const dayBeforeUpdate = selectedFastingDay;
                const updated = setFastingStatus(dayBeforeUpdate, button.dataset.fastingStatus);
                if (!updated) return;
                toast('Status puasa hari ' + dayBeforeUpdate + ' diperbarui.');
                renderAll();
            });
        });

        const saveFastingNoteBtn = $('#saveFastingNoteBtn');
        const fastingNoteInput = $('#fastingNoteInput');
        if (saveFastingNoteBtn && fastingNoteInput) {
            saveFastingNoteBtn.addEventListener('click', () => {
                if (!canUpdateFastingDay(selectedFastingDay)) {
                    toast(getLockedFastingMessage(selectedFastingDay));
                    return;
                }
                state.fastingNotes[selectedFastingDay] = fastingNoteInput.value.trim();
                saveState();
                toast('Catatan puasa disimpan.');
                renderAll();
            });
        }

        const citySelect = $('#citySelect');
        if (citySelect) {
            citySelect.value = state.city;
            citySelect.addEventListener('change', () => {
                state.city = citySelect.value;
                saveState();
                toast('Kota jadwal sholat diperbarui.');
                renderAll();
            });
        }

        const notificationBtn = $('#enableNotificationBtn');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', async () => {
                if (!('Notification' in window)) {
                    toast('Browser ini tidak mendukung Notification API.');
                    return;
                }

                const permission = await Notification.requestPermission();
                state.remindersEnabled = permission === 'granted';
                saveState();
                checkReminderPermissionLabel();
                toast(permission === 'granted' ? 'Reminder browser aktif.' : 'Izin notifikasi tidak diberikan.');
            });
        }

        const resetQuranBtn = $('#resetQuranBtn');
        if (resetQuranBtn) {
            resetQuranBtn.addEventListener('click', () => {
                if (!confirm('Reset progress Al-Quran?')) return;
                state.quran = {};
                saveState();
                toast('Progress Al-Quran direset.');
                renderAll();
            });
        }

        const saveLastReadBtn = $('#saveLastReadBtn');
        if (saveLastReadBtn) {
            saveLastReadBtn.addEventListener('click', () => {
                state.lastRead = {
                    surah: ($('#lastSurahInput') || {}).value || '',
                    ayah: ($('#lastAyahInput') || {}).value || '',
                    page: ($('#lastPageInput') || {}).value || ''
                };
                saveState();
                toast('Bacaan terakhir disimpan.');
                renderAll();
            });
        }

        const resetAllProgressBtn = $('#resetAllProgressBtn');
        if (resetAllProgressBtn) {
            resetAllProgressBtn.addEventListener('click', () => {
                if (!confirm('Reset semua data lokal aplikasi?')) return;
                state = defaultState();
                selectedFastingDay = 1;
                saveState();
                toast('Semua data lokal direset.');
                setTimeout(() => window.location.reload(), 500);
            });
        }
    }

    function renderSharedStats() {
        const metrics = getMetrics();
        setText('statFastingDone', metrics.fastingDone);
        setText('statFastingStreak', metrics.fastingStreak);
        setText('statQuranDone', metrics.quranDone);
        setText('statXp', metrics.xp);
        setText('heroRamadhanDay', getRamadhanDayLabel());
        setText('heroCompletionRate', metrics.overallPercent + '%');
    }

    function renderDashboard() {
        if (!$('#dashboardFastingBar')) return;

        const metrics = getMetrics();
        const fastingPercent = percent(metrics.fastingDone, DAY_COUNT);
        const quranPercent = percent(metrics.quranDone, DAY_COUNT);
        const prayerPercent = percent(metrics.prayersToday, PRAYER_NAMES.length);

        setText('dashboardFastingPercent', fastingPercent + '%');
        setText('dashboardQuranPercent', quranPercent + '%');
        setText('dashboardPrayerPercent', prayerPercent + '%');
        setWidth('dashboardFastingBar', fastingPercent);
        setWidth('dashboardQuranBar', quranPercent);
        setWidth('dashboardPrayerBar', prayerPercent);

        const preview = $('#dashboardCalendarPreview');
        if (preview) {
            const currentFastingDay = getCurrentFastingDay();
            preview.innerHTML = range(1, DAY_COUNT).map(day => {
                const status = state.fasting[day] || 'empty';
                const locked = !canSelectFastingDay(day);
                const current = day === currentFastingDay && status === 'empty';
                const label = locked ? 'Terkunci' : (current ? 'Siap diupdate' : statusLabel(status));
                const classes = ['mini-day', status, current ? 'current' : '', locked ? 'locked' : ''].filter(Boolean).join(' ');
                return `<button class="${classes}" type="button" data-dashboard-day="${day}" aria-disabled="${locked ? 'true' : 'false'}" title="Hari ${day}: ${label}">${day}</button>`;
            }).join('');

            preview.querySelectorAll('[data-dashboard-day]').forEach(button => {
                button.addEventListener('click', () => {
                    const day = Number(button.dataset.dashboardDay);
                    if (!canSelectFastingDay(day)) {
                        toast(getLockedFastingMessage(day));
                        return;
                    }
                    selectedFastingDay = day;
                    saveState();
                    window.location.href = appUrl('puasa');
                });
            });
        }

        const badges = getUnlockedAchievements(metrics).slice(0, 4);
        const miniBadges = $('#miniBadges');
        if (miniBadges) {
            if (badges.length === 0) {
                miniBadges.innerHTML = '<article class="badge-card"><span>+</span><strong>Belum ada badge</strong><small>Mulai dari menandai puasa atau juz pertama.</small></article>';
            } else {
                miniBadges.innerHTML = badges.map(item => `
                    <article class="badge-card">
                        <span>${escapeHtml(item.code)}</span>
                        <strong>${escapeHtml(item.title)}</strong>
                        <small>${escapeHtml(item.desc)}</small>
                    </article>
                `).join('');
            }
        }

        renderNextPrayerWidget();
        renderDailyAyah();
    }

    function renderDailyAyah() {
        if (!state.dailyAyah) return;

        const arabic = $('#dailyAyahArabic');
        const translation = $('#dailyAyahTranslation');
        const source = $('#dailyAyahSource');

        if (arabic && state.dailyAyah.arabic_text) arabic.textContent = state.dailyAyah.arabic_text;
        if (translation && state.dailyAyah.translation) translation.textContent = '“' + state.dailyAyah.translation + '”';
        if (source && state.dailyAyah.source) source.textContent = state.dailyAyah.source;
    }

    function renderCalendarPage() {
        const grid = $('#ramadhanCalendarGrid');
        if (!grid) return;

        const metrics = getMetrics();
        setText('calendarCurrentDay', getRamadhanDayLabel());
        setText('calendarFastingDone', metrics.fastingDone);
        setText('calendarQuranDone', metrics.quranDone);
        setText('calendarConsistency', metrics.overallPercent + '%');

        const currentFastingDay = getCurrentFastingDay();
        grid.innerHTML = range(1, DAY_COUNT).map(day => {
            const date = addDays(parseISODate(state.ramadhanStart), day - 1);
            const iso = toISODate(date);
            const status = state.fasting[day] || 'empty';
            const quranDone = Boolean(state.quran[day]);
            const locked = !canSelectFastingDay(day);
            const current = day === currentFastingDay && status === 'empty';
            const todayClass = iso === toISODate(new Date()) ? ' today' : '';
            const lockedClass = locked ? ' locked' : '';
            const currentClass = current ? ' current' : '';
            return `
                <button class="day-card ${status}${todayClass}${lockedClass}${currentClass}" type="button" data-calendar-day="${day}" aria-disabled="${locked ? 'true' : 'false'}">
                    <span class="day-number">${day}</span>
                    <small>${formatDateShort(date)}</small>
                    <span class="micro">${locked ? 'Terkunci' : (current ? 'Siap diupdate' : statusLabel(status))}${quranDone ? ' · Juz selesai' : ''}</span>
                </button>
            `;
        }).join('');

        grid.querySelectorAll('[data-calendar-day]').forEach(button => {
            button.addEventListener('click', () => {
                const day = Number(button.dataset.calendarDay);
                if (!canUpdateFastingDay(day)) {
                    toast(getLockedFastingMessage(day));
                    return;
                }
                selectedFastingDay = day;
                saveState();
                window.location.href = appUrl('puasa');
            });
        });
    }

    function renderFastingPage() {
        const grid = $('#fastingGrid');
        if (!grid) return;

        if (!canSelectFastingDay(selectedFastingDay)) selectedFastingDay = getCurrentFastingDay();

        const metrics = getMetrics();
        setText('fastingDoneCount', metrics.fastingDone);
        setText('fastingExcusedCount', metrics.fastingExcused);
        setText('fastingStreakCount', metrics.fastingStreak);
        setText('fastingDoneRate', percent(metrics.fastingDone, DAY_COUNT) + '%');

        const currentFastingDay = getCurrentFastingDay();
        grid.innerHTML = range(1, DAY_COUNT).map(day => {
            const status = state.fasting[day] || 'empty';
            const date = addDays(parseISODate(state.ramadhanStart), day - 1);
            const locked = !canSelectFastingDay(day);
            const current = day === currentFastingDay && status === 'empty';
            const selectedClass = day === selectedFastingDay ? ' active' : '';
            const lockedClass = locked ? ' locked' : '';
            const currentClass = current ? ' current' : '';
            return `
                <button class="day-card ${status}${selectedClass}${lockedClass}${currentClass}" type="button" data-fasting-day="${day}" aria-disabled="${locked ? 'true' : 'false'}">
                    <span class="day-number">${day}</span>
                    <small>${formatDateShort(date)}</small>
                    <span class="micro">${locked ? 'Terkunci' : (current ? 'Siap diupdate' : statusLabel(status))}</span>
                </button>
            `;
        }).join('');

        grid.querySelectorAll('[data-fasting-day]').forEach(button => {
            button.addEventListener('click', () => {
                const day = Number(button.dataset.fastingDay);
                if (!canUpdateFastingDay(day)) {
                    toast(getLockedFastingMessage(day));
                    return;
                }
                selectedFastingDay = day;
                saveState();
                renderFastingPage();
            });
        });

        setText('selectedFastingDay', selectedFastingDay);
        const selectedDate = addDays(parseISODate(state.ramadhanStart), selectedFastingDay - 1);
        setText('selectedFastingDate', formatDateLong(selectedDate) + ' · ' + statusLabel(state.fasting[selectedFastingDay] || 'empty'));
        const noteInput = $('#fastingNoteInput');
        if (noteInput) noteInput.value = state.fastingNotes[selectedFastingDay] || '';
    }

    function renderPrayerPage() {
        const list = $('#prayerList');
        if (!list) {
            renderNextPrayerWidget();
            return;
        }

        const schedule = getCurrentSchedule();
        const dateKey = toISODate(new Date());
        const todayLog = state.prayerLogs[dateKey] || {};

        setText('prayerCityLabel', schedule.label);
        renderNextPrayerWidget();

        list.innerHTML = schedule.prayers
            .filter(item => item.type === 'wajib')
            .map(item => {
                const done = Boolean(todayLog[item.key]);
                return `
                    <article class="prayer-item">
                        <div>
                            <strong>${escapeHtml(item.name)}</strong>
                            <small>${escapeHtml(item.desc)}</small>
                        </div>
                        <span class="prayer-time">${escapeHtml(item.time)}</span>
                        <button class="check-btn ${done ? 'done' : ''}" type="button" data-prayer-key="${escapeHtml(item.key)}" aria-label="Toggle ${escapeHtml(item.name)}">${done ? '✓' : ''}</button>
                    </article>
                `;
            }).join('');

        list.querySelectorAll('[data-prayer-key]').forEach(button => {
            button.addEventListener('click', () => {
                const key = button.dataset.prayerKey;
                state.prayerLogs[dateKey] = state.prayerLogs[dateKey] || {};
                state.prayerLogs[dateKey][key] = !state.prayerLogs[dateKey][key];
                saveState();
                renderAll();
            });
        });

        renderSunnahList();
    }

    function renderSunnahList() {
        const sunnahList = $('#sunnahList');
        if (!sunnahList) return;

        const dateKey = toISODate(new Date());
        const todaySunnah = state.sunnahLogs[dateKey] || {};
        const doneCount = SUNNAH_NAMES.filter(key => todaySunnah[key]).length;
        setText('sunnahProgressLabel', doneCount + ' selesai');

        sunnahList.innerHTML = SUNNAH_ITEMS.map(item => {
            const done = Boolean(todaySunnah[item.key]);
            return `
                <article class="sunnah-card">
                    <header>
                        <div>
                            <strong>${escapeHtml(item.title)}</strong>
                            <small>${escapeHtml(item.time)}</small>
                        </div>
                        <button class="switch ${done ? 'active' : ''}" type="button" data-sunnah-key="${escapeHtml(item.key)}" aria-label="Toggle ${escapeHtml(item.title)}"></button>
                    </header>
                    <p class="section-desc">${escapeHtml(item.desc)}</p>
                </article>
            `;
        }).join('');

        sunnahList.querySelectorAll('[data-sunnah-key]').forEach(button => {
            button.addEventListener('click', () => {
                const key = button.dataset.sunnahKey;
                state.sunnahLogs[dateKey] = state.sunnahLogs[dateKey] || {};
                state.sunnahLogs[dateKey][key] = !state.sunnahLogs[dateKey][key];
                saveState();
                renderAll();
            });
        });
    }

    function renderQuranPage() {
        const grid = $('#quranGrid');
        if (!grid) return;

        const metrics = getMetrics();
        const quranPercent = percent(metrics.quranDone, DAY_COUNT);
        setText('quranPercentBadge', quranPercent + '%');
        setWidth('quranProgressBar', quranPercent);

        grid.innerHTML = range(1, DAY_COUNT).map(juz => {
            const done = Boolean(state.quran[juz]);
            return `
                <button class="juz-card ${done ? 'done active' : ''}" type="button" data-juz="${juz}">
                    <span class="juz-number">Juz ${juz}</span>
                    <small>${done ? 'Selesai dibaca' : 'Belum selesai'}</small>
                    <span class="micro">${done ? 'Klik untuk batalkan' : 'Klik jika selesai'}</span>
                </button>
            `;
        }).join('');

        grid.querySelectorAll('[data-juz]').forEach(button => {
            button.addEventListener('click', () => {
                const juz = Number(button.dataset.juz);
                state.quran[juz] = !state.quran[juz];
                if (!state.quran[juz]) delete state.quran[juz];
                saveState();
                renderAll();
            });
        });

        const lastRead = state.lastRead || {};
        const surahInput = $('#lastSurahInput');
        const ayahInput = $('#lastAyahInput');
        const pageInput = $('#lastPageInput');
        if (surahInput && document.activeElement !== surahInput) surahInput.value = lastRead.surah || '';
        if (ayahInput && document.activeElement !== ayahInput) ayahInput.value = lastRead.ayah || '';
        if (pageInput && document.activeElement !== pageInput) pageInput.value = lastRead.page || '';

        const lastText = lastRead.surah
            ? `${lastRead.surah}${lastRead.ayah ? ' ayat ' + lastRead.ayah : ''}${lastRead.page ? ' · halaman ' + lastRead.page : ''}`
            : 'Belum ada data.';
        setText('lastReadText', lastText);

        const remaining = Math.max(0, DAY_COUNT - metrics.quranDone);
        setText('quranDailyTargetText', remaining === 0
            ? 'Target khatam sudah selesai. Pertahankan murajaah harian.'
            : `Tersisa ${remaining} juz. Target aman: minimal ${Math.max(1, Math.ceil(remaining / Math.max(1, DAY_COUNT - clamp(getRamadhanDay(), 1, DAY_COUNT) + 1)))} juz per hari.`);
    }

    function renderAchievementsPage() {
        const grid = $('#achievementGrid');
        if (!grid) return;

        const metrics = getMetrics();
        const unlocked = getUnlockedAchievements(metrics);
        setText('achievementXp', metrics.xp);
        setText('achievementUnlocked', unlocked.length);
        setText('achievementTotal', '/' + ACHIEVEMENTS.length);
        setText('achievementLevel', 'Level ' + metrics.level);
        setText('achievementCompletion', percent(unlocked.length, ACHIEVEMENTS.length) + '%');

        grid.innerHTML = ACHIEVEMENTS.map(item => {
            const isOpen = unlocked.some(open => open.id === item.id);
            return `
                <article class="achievement-card ${isOpen ? '' : 'locked'}">
                    <span class="achievement-icon">${escapeHtml(item.code)}</span>
                    <strong>${escapeHtml(item.title)}</strong>
                    <small>${escapeHtml(item.desc)}</small>
                    <span class="reward">${isOpen ? 'Terbuka' : 'Terkunci'} · ${item.reward} XP</span>
                </article>
            `;
        }).join('');
    }

    function renderNextPrayerWidget() {
        const next = getNextPrayer();
        setText('dashboardNextPrayer', next.name);
        setText('dashboardCountdown', 'Dalam ' + next.countdown);
        setText('nextPrayerName', next.name);
        setText('nextPrayerCountdown', 'Dalam ' + next.countdown + ' · ' + next.time);
        setText('dashboardClock', formatClock(new Date()));
        setText('prayerCurrentClock', formatClock(new Date()));

        const ring = $('#dashboardPrayerRing');
        if (ring) {
            const circumference = 327;
            ring.style.strokeDashoffset = String(circumference - (circumference * next.progress));
        }
    }

    function startClock() {
        renderNextPrayerWidget();
        setInterval(() => {
            renderNextPrayerWidget();
            maybeSendPrayerNotification();
        }, 30000);
    }

    function maybeSendPrayerNotification() {
        if (!state.remindersEnabled || !('Notification' in window) || Notification.permission !== 'granted') return;

        const now = new Date();
        const currentMinuteKey = toISODate(now) + 'T' + formatClock(now);
        if (currentMinuteKey === lastNotificationMinute) return;

        const schedule = getCurrentSchedule().prayers;
        const matched = schedule.find(item => item.time === formatClock(now));
        if (!matched) return;

        lastNotificationMinute = currentMinuteKey;
        const notifyKey = currentMinuteKey + '-' + matched.key;
        if (state.notified[notifyKey]) return;

        state.notified[notifyKey] = true;
        saveState();
        new Notification('Reminder ' + matched.name, {
            body: matched.type === 'wajib' ? 'Waktu sholat wajib telah masuk.' : 'Waktu target sholat sunnah telah masuk.',
            tag: notifyKey
        });
    }

    function checkReminderPermissionLabel() {
        const button = $('#enableNotificationBtn');
        if (!button) return;
        if (!('Notification' in window)) {
            button.textContent = 'Notification tidak tersedia';
            button.disabled = true;
            return;
        }
        const active = state.remindersEnabled && Notification.permission === 'granted';
        button.textContent = active ? 'Reminder Aktif' : 'Aktifkan Reminder';
    }

    async function loadStateFromApi() {
        try {
            const localState = state;
            const response = await apiRequest('api/state?user_id=' + encodeURIComponent(USER_ID));
            if (!response || !response.success || !response.data || !response.data.state) return;

            backendAvailable = true;
            if (response.data.is_empty && hasMeaningfulProgress(localState)) {
                scheduleStateSync(10);
                return;
            }

            state = mergeState(defaultState(), response.data.state);
            selectedFastingDay = clamp(Number(state.selectedFastingDay || getRamadhanDay()) || 1, 1, DAY_COUNT);
            if (!hasCompletePreviousFastingDays(selectedFastingDay)) selectedFastingDay = getCurrentFastingDay();
            saveLocalStateOnly();
            renderAll();
            checkReminderPermissionLabel();
        } catch (error) {
            backendAvailable = false;
            console.info('Database belum aktif, aplikasi memakai fallback localStorage.', error);
        }
    }

    function scheduleStateSync(delay = 250) {
        window.clearTimeout(syncTimer);
        syncTimer = window.setTimeout(syncStateToApi, delay);
    }

    async function syncStateToApi() {
        if (isSyncing) {
            pendingSync = true;
            return;
        }

        isSyncing = true;
        pendingSync = false;
        try {
            const response = await apiRequest('api/state/save', {
                method: 'POST',
                body: JSON.stringify({ user_id: USER_ID, state })
            });
            backendAvailable = Boolean(response && response.success);
        } catch (error) {
            backendAvailable = false;
            console.info('Sinkron database gagal. Data tetap aman di localStorage.', error);
        } finally {
            isSyncing = false;
            if (pendingSync) scheduleStateSync(50);
        }
    }

    async function apiRequest(path, options = {}) {
        const url = appUrl(path);
        const response = await fetch(url, Object.assign({
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        }, options));

        const payload = await response.json().catch(() => null);
        if (!response.ok || !payload) throw new Error((payload && payload.message) || 'API request failed');
        return payload;
    }

    function hasMeaningfulProgress(candidate) {
        if (!candidate) return false;
        return Object.keys(candidate.fasting || {}).length > 0
            || Object.keys(candidate.fastingNotes || {}).length > 0
            || Object.keys(candidate.quran || {}).length > 0
            || Object.keys(candidate.prayerLogs || {}).length > 0
            || Object.keys(candidate.sunnahLogs || {}).length > 0
            || Boolean(candidate.lastRead && (candidate.lastRead.surah || candidate.lastRead.ayah || candidate.lastRead.page))
            || (Array.isArray(candidate.ayahReadDates) && candidate.ayahReadDates.length > 0);
    }

    function getMetrics() {
        const fastingDone = range(1, DAY_COUNT).filter(day => state.fasting[day] === 'done').length;
        const fastingExcused = range(1, DAY_COUNT).filter(day => state.fasting[day] === 'excused').length;
        const fastingStreak = getFastingStreak();
        const quranDone = range(1, DAY_COUNT).filter(juz => Boolean(state.quran[juz])).length;
        const today = toISODate(new Date());
        const prayersToday = PRAYER_NAMES.filter(key => state.prayerLogs[today] && state.prayerLogs[today][key]).length;
        const sunnahToday = SUNNAH_NAMES.filter(key => state.sunnahLogs[today] && state.sunnahLogs[today][key]).length;
        const totalPrayerChecks = countNestedTruthy(state.prayerLogs);
        const totalSunnahChecks = countNestedTruthy(state.sunnahLogs);
        const baseXp = (fastingDone * 20) + (quranDone * 15) + (totalPrayerChecks * 5) + (totalSunnahChecks * 6) + (state.ayahReadDates.length * 3);
        const xpBeforeReward = baseXp + ACHIEVEMENTS
            .filter(item => item.id !== 'xp_500')
            .filter(item => item.test({ fastingDone, fastingStreak, quranDone, prayersToday, sunnahToday, xpBeforeReward: baseXp }))
            .reduce((sum, item) => sum + item.reward, 0);
        const unlocked = ACHIEVEMENTS.filter(item => item.test({ fastingDone, fastingStreak, quranDone, prayersToday, sunnahToday, xpBeforeReward }));
        const xp = baseXp + unlocked.reduce((sum, item) => sum + item.reward, 0);
        const overallPercent = Math.round((percent(fastingDone, DAY_COUNT) + percent(quranDone, DAY_COUNT) + percent(prayersToday, PRAYER_NAMES.length)) / 3);

        return {
            fastingDone,
            fastingExcused,
            fastingStreak,
            quranDone,
            prayersToday,
            sunnahToday,
            totalPrayerChecks,
            totalSunnahChecks,
            xpBeforeReward,
            xp,
            level: Math.max(1, Math.floor(xp / 250) + 1),
            overallPercent
        };
    }

    function getUnlockedAchievements(metrics) {
        return ACHIEVEMENTS.filter(item => item.test(metrics));
    }

    function getFastingStreak() {
        let current = 0;
        let longest = 0;
        for (let day = 1; day <= DAY_COUNT; day += 1) {
            if (state.fasting[day] === 'done') {
                current += 1;
                longest = Math.max(longest, current);
            } else {
                current = 0;
            }
        }
        return longest;
    }

    function normalizeFastingObject(fasting) {
        const normalized = {};
        let isSequenceOpen = true;
        for (let day = 1; day <= DAY_COUNT; day += 1) {
            const status = fasting[String(day)] || fasting[day] || 'empty';
            if (!isSequenceOpen || !isFastingStatusFilled(status)) {
                isSequenceOpen = false;
                continue;
            }
            normalized[String(day)] = status;
        }
        return normalized;
    }

    function isFastingStatusFilled(status) {
        return ['done', 'excused', 'missed'].includes(status);
    }

    function hasCompletePreviousFastingDays(day) {
        const safeDay = clamp(Number(day), 1, DAY_COUNT);
        for (let previous = 1; previous < safeDay; previous += 1) {
            if (!isFastingStatusFilled(state.fasting[previous] || state.fasting[String(previous)] || 'empty')) {
                return false;
            }
        }
        return true;
    }

    function getCurrentFastingDay() {
        for (let day = 1; day <= DAY_COUNT; day += 1) {
            if (!isFastingStatusFilled(state.fasting[day] || state.fasting[String(day)] || 'empty')) {
                return day;
            }
        }
        return DAY_COUNT;
    }

    function canSelectFastingDay(day) {
        const safeDay = clamp(Number(day), 1, DAY_COUNT);
        const status = state.fasting[safeDay] || state.fasting[String(safeDay)] || 'empty';
        // Hari yang sudah ada status boleh dibuka lagi untuk koreksi.
        // Hari kosong hanya boleh dibuka pada hari urutan aktif pertama.
        return isFastingStatusFilled(status) || safeDay === getCurrentFastingDay();
    }

    function canUpdateFastingDay(day) {
        const safeDay = clamp(Number(day), 1, DAY_COUNT);
        return canSelectFastingDay(safeDay) && hasCompletePreviousFastingDays(safeDay);
    }

    function hasLaterFastingProgress(day) {
        const safeDay = clamp(Number(day), 1, DAY_COUNT);
        for (let next = safeDay + 1; next <= DAY_COUNT; next += 1) {
            if (isFastingStatusFilled(state.fasting[next] || state.fasting[String(next)] || 'empty')) {
                return true;
            }
        }
        return false;
    }

    function getLockedFastingMessage(day) {
        const currentDay = getCurrentFastingDay();
        return 'Hari ' + day + ' belum bisa diupdate. Selesaikan status puasa hari ' + currentDay + ' terlebih dahulu.';
    }

    function setFastingStatus(day, status) {
        const safeDay = clamp(Number(day), 1, DAY_COUNT);
        const nextStatus = ['done', 'excused', 'missed', 'empty'].includes(status) ? status : 'empty';

        if (!canUpdateFastingDay(safeDay)) {
            toast(getLockedFastingMessage(safeDay));
            selectedFastingDay = getCurrentFastingDay();
            renderFastingPage();
            return false;
        }

        if (nextStatus === 'empty' && hasLaterFastingProgress(safeDay)) {
            toast('Hari ' + safeDay + ' belum bisa dikosongkan karena hari setelahnya sudah punya status. Kosongkan dari hari terakhir terlebih dahulu.');
            return false;
        }

        if (nextStatus === 'empty') {
            delete state.fasting[safeDay];
        } else {
            state.fasting[safeDay] = nextStatus;
        }

        state.fasting = normalizeFastingObject(state.fasting);
        selectedFastingDay = nextStatus === 'empty' ? safeDay : getCurrentFastingDay();
        saveState();
        return true;
    }

    function getCurrentSchedule() {
        return CITY_SCHEDULES[state.city] || CITY_SCHEDULES.jakarta;
    }

    function getNextPrayer() {
        const now = new Date();
        const nowMinutes = now.getHours() * 60 + now.getMinutes() + (now.getSeconds() / 60);
        const schedule = getCurrentSchedule().prayers
            .slice()
            .sort((a, b) => timeToMinutes(a.time) - timeToMinutes(b.time));

        let nextIndex = schedule.findIndex(item => timeToMinutes(item.time) > nowMinutes);
        let nextDayOffset = 0;
        if (nextIndex === -1) {
            nextIndex = 0;
            nextDayOffset = 1440;
        }

        const next = schedule[nextIndex];
        const prevIndex = nextIndex === 0 ? schedule.length - 1 : nextIndex - 1;
        const nextMinutes = timeToMinutes(next.time) + nextDayOffset;
        let prevMinutes = timeToMinutes(schedule[prevIndex].time);
        if (prevIndex > nextIndex || (nextIndex === 0 && nextDayOffset === 0)) prevMinutes -= 1440;
        if (nextDayOffset === 1440 && prevIndex === schedule.length - 1) prevMinutes = timeToMinutes(schedule[prevIndex].time);

        const diff = Math.max(0, Math.round(nextMinutes - nowMinutes));
        const span = Math.max(1, nextMinutes - prevMinutes);
        const progress = clamp((nowMinutes - prevMinutes) / span, 0, 1);

        return {
            key: next.key,
            name: next.name,
            time: next.time,
            countdown: minutesToCountdown(diff),
            progress
        };
    }

    function getRamadhanDay() {
        const start = parseISODate(state.ramadhanStart);
        const today = parseISODate(toISODate(new Date()));
        return daysBetween(start, today) + 1;
    }

    function getRamadhanDayLabel() {
        const day = getRamadhanDay();
        if (day < 1) return 'Belum mulai';
        if (day > DAY_COUNT) return 'Selesai';
        return String(day);
    }

    function statusLabel(status) {
        return {
            done: 'Selesai',
            excused: 'Uzur',
            missed: 'Batal',
            empty: 'Belum'
        }[status] || 'Belum';
    }

    function appUrl(path) {
        const root = String(window.RAMADHAN_SITE_URL || '').replace(/\/$/, '');
        return root + '/' + String(path || '').replace(/^\//, '');
    }

    function $(selector) {
        return document.querySelector(selector);
    }

    function setText(id, value) {
        const element = document.getElementById(id);
        if (element) element.textContent = value;
    }

    function setWidth(id, value) {
        const element = document.getElementById(id);
        if (element) element.style.width = clamp(Number(value), 0, 100) + '%';
    }

    function range(start, end) {
        return Array.from({ length: end - start + 1 }, (_, index) => start + index);
    }

    function clamp(value, min, max) {
        return Math.min(Math.max(value, min), max);
    }

    function percent(value, total) {
        return total <= 0 ? 0 : Math.round((Number(value) / total) * 100);
    }

    function countNestedTruthy(object) {
        return Object.values(object || {}).reduce((sum, item) => {
            return sum + Object.values(item || {}).filter(Boolean).length;
        }, 0);
    }

    function toISODate(date) {
        const local = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
        return local.toISOString().slice(0, 10);
    }

    function parseISODate(iso) {
        return new Date(String(iso || toISODate(new Date())) + 'T00:00:00');
    }

    function addDays(date, days) {
        const copy = new Date(date.getTime());
        copy.setDate(copy.getDate() + days);
        return copy;
    }

    function daysBetween(start, end) {
        const oneDay = 24 * 60 * 60 * 1000;
        return Math.round((parseISODate(toISODate(end)).getTime() - parseISODate(toISODate(start)).getTime()) / oneDay);
    }

    function formatDateShort(date) {
        return new Intl.DateTimeFormat('id-ID', { weekday: 'short', day: 'numeric', month: 'short' }).format(date);
    }

    function formatDateLong(date) {
        return new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(date);
    }

    function formatClock(date) {
        return String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
    }

    function timeToMinutes(time) {
        const [hour, minute] = String(time).split(':').map(Number);
        return (hour * 60) + minute;
    }

    function minutesToCountdown(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        if (hours <= 0) return mins + ' menit';
        return hours + ' jam ' + mins + ' menit';
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function toast(message) {
        const stack = $('#toastStack');
        if (!stack) return;
        const item = document.createElement('div');
        item.className = 'toast';
        item.textContent = message;
        stack.appendChild(item);
        setTimeout(() => item.remove(), 3200);
    }
}());

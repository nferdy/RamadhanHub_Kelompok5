# Ramadhan HUB Kelompok 5

Ramadhan HUB adalah aplikasi web interaktif yang dirancang untuk membantu pengguna mengelola, memantau, dan menjaga konsistensi aktivitas ibadah selama bulan Ramadhan. Proyek ini dibangun dengan arsitektur MVC (Model-View-Controller) yang diadaptasi dari struktur CodeIgniter 3, namun dieksekusi secara independen menggunakan PHP Native dan Standalone Router.


**Anggota Tim:**
1. Hana Nur Fathiyyah             (H1H024017)
2. Yogi Ferdiansyah Amta Miluloh  (H1H024027)
3. Ardhis Alivio Rajendra         (H1H024031)


## Fitur Utama
Aplikasi ini mengimplementasikan sistem penyimpanan Database-First dengan Fallback Storage menggunakan localStorage sebagai cadangan apabila basis data mengalami gangguan jaringan. Fitur utama yang tersedia meliputi:

* **Autentikasi dan Manajemen Pengguna (RBAC)**
  * Pendaftaran akun baru dengan enkripsi kata sandi menggunakan algoritma Bcrypt.
  * Sistem login menggunakan Session PHP.
  * Role-Based Access Control: Pemisahan hak akses antara pengguna reguler dan administrator.
  * Admin Panel: Modul CRUD (Create, Read, Update, Delete) untuk mengelola data pengguna.
* **Dashboard Interaktif**
  * Ringkasan statistik ibadah, riwayat puasa beruntun (streak), akumulasi Experience Points (XP), dan ayat pengingat harian.
* **Kalender Ramadhan**
  * Perencanaan 30 hari ibadah dengan indikator status harian.
* **Tracker Puasa**
  * Pencatatan puasa harian yang dilengkapi validasi kronologis untuk mencegah manipulasi urutan hari.
* **Pengingat Sholat**
  * Jadwal sholat berdasarkan pengaturan kota pengguna yang terintegrasi dengan notifikasi peramban.
* **Progress Al-Quran**
  * Pencatatan tilawah 30 Juz dan fitur markah (bookmark) untuk posisi bacaan terakhir.
* **Sistem Pencapaian (Achievements)**
  * Sistem gamifikasi ibadah yang memberikan lencana (badge) dan level secara otomatis berdasarkan pencapaian pengguna.


## Teknologi yang Digunakan
* **Frontend:** HTML5, CSS3, dan Vanilla JavaScript.
* **Backend:** PHP 8.x (Native dengan pola arsitektur MVC).
* **Database:** MySQL.

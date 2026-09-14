# e-laptriv4 — perbaikan backend dengan UI sumber dipertahankan

Sumber: `dpng99/e-lkjip_pembinaan`, branch `refactor/jambin-v3-canonical`,
commit `8421732678c2cfa3425fbef57c6b25c448cc7769`.
Nama repository baru tidak mengganti kontrak domain JAMBIN V3.1.

## Perubahan yang diterapkan

| Temuan pemetaan | Implementasi |
|---|---|
| F01 | Pointer `.agents` diarahkan ke canonical V3.1; referensi v2/struktur tabel lama diberi penanda historis. |
| F02 | Kesembilan belas IKP utama tetap MANDIRI, walaupun mempunyai kontribusi SK/IKK. |
| F03–F04 | Register `config/formula_review.php` mencegah perhitungan pada formula/skala yang belum lengkap. Input mentah tetap dapat disimpan dengan formulir yang sama. Tidak dibuat rumus, bobot, faktor konversi, atau operand baru tanpa sumber. |
| F05 | `TargetResolver` digunakan oleh hitung, input, dashboard, review, dan ekspor. Target TW terpilih didahulukan, lalu target tahunan terpilih. Pilihan ambigu/kosong menghasilkan null; nilai target tahunan tidak dibagi empat. Seeder mempertahankan pilihan dan nilai yang sudah ada. |
| F07 | Validasi operand numerik, rentang canonical, penyebut positif, periode, unit, dan flag input. Seluruh IKK yang sebelumnya tampil tetap diberi metadata input yang konsisten. Penyimpanan batch atomik. |
| F08 | Formula aktif/status dievaluasi eksplisit; tidak ada fallback key tak dikenal ke nilai langsung atau CUSTOM ke survei. |
| F09 | Ekspor menelusuri CONTRIBUTION untuk menampilkan SK/IKK pendukung. Hubungan tersebut tetap tidak menjadi operand hitung. |
| F10 | Pengukuran APPROVED/FINAL/LOCKED serta yang mempunyai approved_at/locked_at tidak berubah oleh penyimpanan atau kalkulasi ulang. Snapshot mencatat ID/versi rumus, target/dokumen/periode, komponen dan jejak hitung. Hasil draft yang tidak lengkap menjadi null. |
| F11 | Reseed tidak menghapus atau membuat ulang komponen yang sudah ada dan tidak menimpa versi rumus administrator. |
| F12 | Dependency FORMULA_COMPONENT diproses sesuai urutan graf; siklus ditolak. Rata-rata tidak mengabaikan child kosong. Agregasi populasi mensyaratkan input lengkap setiap unit dan key yang sama; metode tak dikenal ditolak. |
| F13 | Alias rumus pada detail IKP/IKK memakai identitas node canonical, tanpa pencocokan nama kabur. Calculator memakai satu versi komponen yang sama. |
| F14 | Kalkulasi otomatis dibatasi indikator; SS/IKSS tetap referensi. Ekspor JAMBIN mengambil 11 SP utama; SP18 tetap ada di database sumber. |
| F15 | Validasi backend tidak menetapkan maksimum 100 secara generik untuk hitungan populasi. Kasus polaritas belum pasti tetap ditandai, tidak diubah menjadi komplemen persentase. |
| F16 | Reseed tidak mereset password, token, status aktif, atau akun yang sudah ada. Akun baru memakai `KINERJA_BOOTSTRAP_PASSWORD` jika diberikan, selain itu password acak. |
| F17 | Rollback migration penjelasan menghapus tiga kolom yang benar. |
| F18 | Perubahan master membuat versi baru; komponen harus berasal dari versi yang diedit. Penghapusan mengarsipkan rumus. Versi lama dan komponen historis tetap tersedia. Perubahan operand/bobot canonical yang belum direkonsiliasi ditolak. |

Angka menggunakan `brick/math` yang sudah terdapat pada lockfile untuk penjumlahan,
pembobotan, rasio, rata-rata, dan capaian. Bentuk angka dalam respons aplikasi tetap
kompatibel. Penyimpanan capaian mengikuti presisi tabel yang ada (dua desimal);
realisasi mengikuti empat desimal. Schema tabel tidak dirombak.

## Batas domain yang belum diputuskan

- **F06:** perbedaan teks pengampu dan pemetaan biro tidak diselesaikan lewat tebakan; ownership yang ada tetap dipertahankan.
- **F03–F04:** daftar formula yang ditahan tercantum dalam `config/formula_review.php` beserta alasannya. Ini daftar temuan audit repository, bukan pengganti sumber resmi. Setelah operand/skala disahkan, perbarui kontrak dan regression test, baru hapus penanda yang bersangkutan.
- **F12:** service konsolidasi organisasi diperketat, tetapi konsolidasi seluruh IKP organisasi belum diaktifkan otomatis. Menjumlahkan nilai komponen NKA antarunit, menentukan daftar unit wajib, metode antarperiode, dan inheritance SAME_INDICATOR membutuhkan kontrak yang tegas. Tidak menyalin child pertama secara otomatis.
- **Periode:** belum ada pemindahan otomatis nilai tahunan ke TW lain, pembagian target tahunan, atau konversi data periodik menjadi kumulatif. Nilai eksternal SAKIP boleh dicatat untuk periode pelaporan tempat nilai resmi digunakan.
- **Versioning:** versi final tidak berubah. Pemilihan formula draft mengikuti versi aktif; tanggal berlaku historis per formula belum tersedia dalam schema asal. Tidak ada klaim bahwa audit sumber resmi selesai.

## UI/UX

Tidak ada perubahan pada React, CSS, layout, navigation, assets, route, package
frontend, atau konfigurasi build. `scripts/verify-ui.php` membandingkan 53 berkas
tersebut dengan Git blob sumber. Input schema canonical, nama operand, label, dan
urutan kolom dipertahankan. Perbaikan angka/status/notifikasi berasal dari backend.
Tidak ditambahkan halaman atau alur UI baru.

## Menjalankan di lingkungan pengembangan

1. Gunakan versi PHP yang memenuhi **composer.lock**, bukan hanya batas minimum
   composer.json. Lock sumber saat ini memuat dependency Symfony 8.1; CI menggunakan PHP 8.5.
2. Siapkan `.env`, APP_KEY, dan koneksi database kosong/terisolasi. Jangan menjalankan
   `migrate:fresh` pada database berisi data pengguna.
3. `composer install`, lalu `php artisan key:generate` jika APP_KEY belum ada.
4. Untuk instalasi baru, jalankan `php artisan migrate` dan `php artisan db:seed`.
   Tetapkan `KINERJA_BOOTSTRAP_PASSWORD` sebelum seeding bila ingin menyediakan
   password awal yang diketahui; hapus variabel itu setelah provisioning.
5. `npm ci` dan `npm run build`.
6. `php scripts/verify-ui.php` dan `vendor/bin/phpunit`.

Akun yang sudah ada tidak diubah oleh seeder. Seeder master tidak lagi menjadi
mekanisme untuk menimpa koreksi target/rumus; gunakan perubahan eksplisit yang dapat
ditinjau. Data pengukuran final tidak dikalkulasi ulang otomatis.

## Publikasi

Koneksi GitHub sesi ini menyediakan operasi isi repository, tetapi tidak menyediakan
pembuatan repository. Karena itu keberadaan repository GitHub `dpng99/e-laptriv4`
tidak boleh dianggap berhasil sebelum ada URL/commit remote yang terverifikasi.
Repository asal tidak ditulisi. Paket patch diterapkan pada checkout sumber yang
tepat, sehingga dua dokumen biner besar di sumber tetap dapat dipertahankan melalui
git clone pengguna, meskipun connector tidak dapat mengunduh keduanya di sesi ini.

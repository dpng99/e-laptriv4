# Verifikasi e-laptriv4

Tanggal: 13 September 2026. Sumber dipatok ke commit
`8421732678c2cfa3425fbef57c6b25c448cc7769`.

| Pemeriksaan | Hasil |
|---|---|
| Seluruh unit test serta 7 kelas feature backend | 68 tes, 316 assertion, lulus |
| CalculationGraphTest: urutan dependency, kontribusi, child kosong, siklus | 2 tes, 5 assertion, lulus |
| Total regresi backend | **70 tes, 321 assertion, tanpa failure/error/skip** |
| `npm run build` | Berhasil; Vite 6.4.3, 14.065 modul |
| `scripts/verify-ui.php` | 53 Git blob UI/config/route identik dengan sumber |
| Parse PHP dan `git diff --check` | Berhasil |

Regresi dijalankan memakai PHP 8.4.25 WebAssembly, PHPUnit 11.5.56,
SQLite in-memory, dan dependency dari composer.lock sumber. Pada runner ini
`shell_exec` dan `proc_open` dinonaktifkan untuk menghindari crash integrasi terminal;
kode produksi tidak diubah untuk menyesuaikan runner. Dependency lokal dipulihkan
dari archive versi/ref lock yang sama, kemudian autoload dibuat ulang. Lockfile
produksi tidak diubah.

Suite gabungan sebelum penambahan kelas graf dan kelas graf dijalankan terpisah.
`phpunit.backend.xml` menyatukan cakupan tersebut untuk pengulangan dengan PHP native:

```sh
composer install
npm ci
npm run build
php scripts/verify-ui.php
vendor/bin/phpunit -c phpunit.backend.xml
```

## Batas verifikasi

- Upaya menjalankan seluruh suite berhenti karena `RuntimeError: unreachable` pada
  runtime WebAssembly ketika tes autentikasi kata sandi salah berjalan. Ini tidak
  dihitung sebagai hasil lulus; suite auth/profil lengkap belum terverifikasi.
- `.github/workflows/verify.yml` menyiapkan pengujian **seluruh suite** di PHP native
  8.5. Workflow belum dijalankan di GitHub karena repository tujuan belum dibuat.
- Pengujian database menggunakan SQLite, bukan uji konkurensi/transaksi MySQL
  produksi. Penguncian baris tetap perlu diverifikasi pada lingkungan staging.
- Bukti penjagaan UI berupa kesamaan berkas sumber dan build berhasil, bukan
  perbandingan screenshot browser. Respons angka, status, dan validasi backend
  memang mengikuti koreksi yang didokumentasikan dalam IMPLEMENTATION.md.
- Skrip publikasi disertakan untuk Git Bash/Linux dan PowerShell. Sintaks bash
  diperiksa. Pembuatan repository/push tidak dijalankan; PowerShell tidak tersedia
  untuk uji eksekusi di sesi ini.

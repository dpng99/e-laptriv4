# Arsitektur Kinerja JAMBIN Laravel

Paket ini berisi skema Laravel modular-monolith dengan tabel SS, IKSS, SP, IKP, SK, IKK, dan TARGET yang terpisah. Seluruh tabel paket memakai prefix `kinerja_` agar tidak bertabrakan dengan tabel lama seperti `sp`, `ikp`, `sk`, `ikk`, `targets`, atau `pengukurans`. Hubungan cascading disimpan sebagai graph melalui `kinerja_nodes` dan `kinerja_relasi`, sehingga hubungan langsung seperti IKSS ke SK/IKK dan hubungan lintas-program tetap dapat dicatat.

## Kebutuhan

- PHP 8.2 atau lebih baru
- Laravel 12/13
- MySQL 8+, PostgreSQL 14+, atau SQLite terbaru untuk pengujian
- Tabel `users` memakai `username` sebagai primary key, dengan kolom `nama_satker`, `bidang_id`, `role_id`, `is_active`, `login_at`, dan `password`

## Isi data awal

Dataset berasal dari rekonsiliasi KEPJA Nomor 1184 Tahun 2025 dan Renstra Kejaksaan RI 2025–2029:

| Level | Jumlah |
|---|---:|
| SS | 2 |
| IKSS | 2 |
| SP | 12 |
| IKP | 20 |
| SK | 35 |
| IKK | 97 |
| Seluruh node | 168 |
| Formula terdokumentasi | 119 |
| Target dua sumber, lima tahun | 1.190 |
| Relasi graph unik | 174 |

Target hanya diberikan kepada indikator IKSS, IKP, dan IKK. SS, SP, dan SK memperoleh makna target dari indikator di bawahnya.

## Struktur file

```text
app/
├── Enums/
├── Models/
└── Services/GraphValidator.php
database/
├── data/
│   ├── cascading_map.php
│   └── kinerja_jambin_2025_2029.json
├── migrations/
└── seeders/
tests/Feature/KinerjaSeederTest.php
```

Setiap tabel dibuat melalui migration tersendiri dan setiap level memiliki model serta seeder tersendiri.

## Pemasangan pada proyek kosong

Salin isi folder paket ke root proyek Laravel, kemudian jalankan:

```bash
composer dump-autoload
php artisan migrate
php artisan db:seed
php artisan test --filter=KinerjaSeederTest
```

Untuk menjalankan test, gunakan database testing terpisah, misalnya `e_lkjip_testing`, karena `RefreshDatabase` dapat menjalankan rollback atau migrate ulang. Jangan arahkan test ke database kerja yang berisi data produksi/operasional.

## Urutan seeder

```text
DokumenKinerjaSeeder
UnitKerjaSeeder
UnitKerjaUserSeeder
SsSeeder
IkssSeeder
SpSeeder
IkpSeeder
SkSeeder
IkkSeeder
ReferensiNodeSeeder
RelasiKinerjaSeeder
UnitNodeKinerjaSeeder
RumusIndikatorSeeder
TargetSeeder
```

Seluruh seeder memakai `updateOrCreate`/`updateOrInsert` dan tidak menjalankan `truncate`, sehingga aman dijalankan ulang terhadap data master hasil paket. Tetap buat cadangan sebelum menjalankan seeder pada lingkungan produksi.

## User Biro/Pusat

`UnitKerjaUserSeeder` membuat akun awal berdasarkan unit kerja JAMBIN. Password awal seluruh akun adalah:

```text
password
```

| Unit | Username | `bidang_id` | `role_id` |
|---|---|---|---|
| JAMBIN | `admin.jambin` | `JMBIN` | `ADMIN` |
| Sekretariat JAMBIN | `set.jambin` | `SET` | `OPR` |
| Biro Perencanaan | `ro.ren` | `REN` | `OPR` |
| Biro Kepegawaian | `ro.peg` | `PEG` | `OPR` |
| Biro Keuangan | `ro.keu` | `KEU` | `OPR` |
| Biro Perlengkapan | `ro.kap` | `KAP` | `OPR` |
| Biro Hukum dan Hubungan Luar Negeri | `ro.huk.hln` | `HLN` | `OPR` |
| Biro Umum | `ro.umum` | `UMUM` | `OPR` |
| Pusdaskrimti | `pusdaskrimti` | `PDTI` | `OPR` |
| Pusat Strategi Kebijakan Penegakan Hukum | `pustrajakgakum` | `PSKPH` | `OPR` |
| Pusat Kesehatan Yustisial | `pky` | `PKY` | `OPR` |

Seeder mencocokkan akun berdasarkan primary key `username`. `nama_satker` diisi dari nama unit pada tabel `kinerja_units`. Nilai `bidang_id` sengaja dibuat paling panjang 5 karakter agar sesuai dengan kolom `char(5)`.

## Pemisahan tabel dan graph

Enam tabel level menyimpan atribut bisnisnya masing-masing. `kinerja_nodes` hanya menjadi registrasi teknis:

```text
SS:2     -> kinerja_ss.node_id
IKSS:2.1 -> kinerja_ikss.node_id
SP:18    -> kinerja_sp.node_id
IKP:18.1 -> kinerja_ikp.node_id
SK:18.1  -> kinerja_sk.node_id
IKK:18.1.1 -> kinerja_ikk.node_id
```

`kinerja_relasi` menyimpan setiap edge parent-child dengan atribut:

- jenis relasi: `STRUCTURAL`, `CASCADING`, atau `DIRECT`;
- dasar relasi: `EXPLICIT` atau `ANALYTICAL`;
- halaman dan dokumen sumber jika eksplisit;
- catatan crosswalk jika analitis.

## Target

Target KEPJA dan Renstra disimpan sebagai baris berbeda dengan unique key:

```text
node_id + dokumen_kinerja_id + tahun + periode
```

Baris KEPJA ditandai `is_selected = true` sebagai default operasional paket. Ubah kebijakan pemilihan target melalui proses persetujuan aplikasi jika instansi menetapkan sumber lain.

Nilai `-` atau target yang tidak ditemukan tidak diubah menjadi nol. Nilainya disimpan `null` dengan status `NOT_SET`.

## Pengukuran dan audit user

Tabel `kinerja_pengukurans` menyimpan kolom audit `created_by`, `updated_by`, `submitted_by`, `verified_by`, dan `approved_by` sebagai `string` nullable tanpa foreign key. Isinya diarahkan untuk menyimpan `users.username`, misalnya `ro.ren` atau `admin.jambin`.

Jika aplikasi Bapak sudah memiliki tabel user final, relasi Eloquent dapat ditambahkan di model sesuai nama tabel dan primary key yang sebenarnya.

## Rumus

Formula sumber disimpan dengan `tipe_formula = DOCUMENTED`. Ini disengaja: beberapa rumus merupakan indeks komposit, hasil evaluasi eksternal, atau membutuhkan konfirmasi formal. Jangan mengeksekusi teks rumus dengan `eval()`.

Setelah formula operasional disahkan, ubah `tipe_formula`, tambahkan `kinerja_komponen_rumus`, dan proses melalui strategy calculator tersendiri.

## Catatan sumber

- Kode IKK menggunakan kode normalisasi, sedangkan kode cetak sumber tetap disimpan pada `kinerja_ikk.kode_sumber` dan `kinerja_referensi_nodes`.
- Hubungan SS–IKSS, SP–IKP, dan SK–IKK ditandai eksplisit.
- Hubungan IKSS–SP serta IKP–SK adalah crosswalk analitis berdasarkan substansi, penomoran, dan unit pelaksana.
- Jalur IKSS 2.1 ke SP 18 ditandai `DIRECT` dan lintas-program.

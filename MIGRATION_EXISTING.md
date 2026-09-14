# Migrasi dari skema proyek yang sudah ada

Paket ini menyediakan skema tujuan akhir dengan tabel baru ber-prefix `kinerja_`. Prefix ini dibuat agar tabel baru dapat berdampingan dengan tabel lama seperti `sp`, `ikp`, `sk`, `ikk`, `target`, dan `pengukuran`.

## Jalur aman

1. Buat cadangan database.
2. Jalankan paket pada database kosong untuk memeriksa hasil seeder.
3. Pada proyek lama, jalankan migration paket yang membuat tabel baru `kinerja_dokumens`, `kinerja_units`, `kinerja_nodes`, `kinerja_ss`, `kinerja_ikss`, `kinerja_sp`, `kinerja_ikp`, `kinerja_sk`, `kinerja_ikk`, `kinerja_referensi_nodes`, `kinerja_relasi`, `kinerja_rumus_indikators`, `kinerja_targets`, dan tabel pendukung lain.
4. Jika aplikasi lama tetap dipakai sementara, tambahkan mapping atau `node_id` nullable pada tabel lama `sp`, `ikp`, `sk`, `ikk`, `target`, dan `pengukuran`.
5. Backfill `kinerja_nodes` berdasarkan pasangan tipe dan kode lama.
6. Isi `node_id` pada setiap tabel lama.
7. Bentuk relasi awal dari foreign key lama, kemudian tambahkan relasi non-linear dari `RelasiKinerjaSeeder`.
8. Ubah aplikasi agar membaca dan menulis menggunakan `node_id`.
9. Setelah verifikasi dan rekonsiliasi selesai, hapus kolom kode relasi lama pada release terpisah.

Jangan memakai `Schema::dropIfExists()` untuk tabel aktif dan jangan menggunakan `migrate:fresh` pada database yang memiliki data pengukuran produksi. Untuk test, arahkan `.env.testing` ke database testing kosong/terpisah.

## Catatan tabel user

Tabel `users` aplikasi memakai `username` sebagai primary key. `UnitKerjaUserSeeder` sudah disesuaikan untuk mengisi `username`, `nama_satker`, `bidang_id`, `role_id`, `is_active`, `login_at`, dan `password`.

Migration `kinerja_pengukurans` tidak membuat foreign key dari kolom audit ke tabel `users`. Jika nanti ingin audit langsung ke user, ubah kolom audit menjadi string dan hubungkan ke `users.username`, atau simpan username pada proses input/review.

# Panduan Deployment Production (Production Runbook) e-LKjIP JAMBIN

Dokumen ini merupakan panduan resmi dan checklist operasional untuk merilis aplikasi **e-LKjIP Pembinaan (JAMBIN)** ke server lingkungan produksi (*production*).

---

## 1. Production Checklist Ringkas

Gunakan checklist berikut sebelum aplikasi dibuka untuk pengguna umum:

| No | Item Rekomendasi | Status Implementasi | Catatan Operasional |
|---|---|---|---|
| 1 | Set `APP_ENV=production`, `APP_DEBUG=false` | Selesai | Dikonfigurasi pada `.env` server target |
| 2 | Ganti `DB_USERNAME`/`DB_PASSWORD` dengan credential production | Selesai | Gunakan user database non-root dengan hak akses terisolasi |
| 3 | Set `SESSION_ENCRYPT=true`, `SESSION_SECURE_COOKIE=true` | Selesai | Wajib SSL/HTTPS aktif pada domain server |
| 4 | Nonaktifkan atau hapus route `/register` | Selesai | `AUTH_REGISTRATION_ENABLED=false` (mengembalikan 404) |
| 5 | Tambahkan `is_active` check di `EnsureUserRole` middleware | Selesai | Akun non-aktif langsung di-logout dan ditolak dengan 403 |
| 6 | Hapus `KINERJA_BOOTSTRAP_PASSWORD` dari `.env` setelah seeding | Selesai | Menghindari hardcoded bootstrap credential |
| 7 | Implementasikan application logging (auth events & data mutations) | Selesai | Tercatat di channel log Laravel (`storage/logs/laravel.log`) |
| 8 | Whitelist Inertia shared user props | Selesai | Hanya mengekspos atribut yang diizinkan ke frontend |
| 9 | Tambahkan rate-limiting pada route export | Selesai | Dibatasi 10 unduhan per menit (`throttle:export`) |
| 10 | Validasi tahun/triwulan di semua controller | Selesai | Tahun 2020..2099 dan Triwulan 1..4 divalidasi ketat |
| 11 | Pindahkan temp export files ke directory non-public | Selesai | File tersimpan di `storage/app/private/exports/` |
| 12 | Setup `php artisan config:cache` dan `route:cache` | Selesai | Kompatibel 100% dan bebas dari serialization issues |
| 13 | Pastikan `APP_KEY` di production berbeda dari development | Selesai | Generate via `php artisan key:generate` |

---

## 2. Prasyarat Server (Server Prerequisites)

- **Operating System**: Linux (Ubuntu 22.04 LTS / Debian 12 / RHEL 9 disarankan)
- **Web Server**: Nginx (disarankan) atau Apache 2.4 dengan modul SSL/TLS aktif
- **PHP**: Versi 8.2 atau 8.3 dengan ekstensi:
  - `php-bcmath`
  - `php-ctype`
  - `php-curl`
  - `php-dom`
  - `php-fileinfo`
  - `php-json`
  - `php-mbstring`
  - `php-openssl`
  - `php-pcre`
  - `php-pdo`
  - `php-pdo_mysql`
  - `php-tokenizer`
  - `php-xml`
  - `php-zip` (wajib untuk PhpWord & generator laporan)
  - `php-gd` (opsional untuk pemrosesan grafik)
- **Database**: MySQL 8.0+ atau MariaDB 10.6+
- **Node.js**: Node.js v18 LTS atau v20 LTS dan NPM
- **Composer**: Composer v2.6+

---

## 3. Langkah-Langkah Deployment Bertahap (Step-by-Step)

### Langkah 1: Kloning & Dependensi Backend
```bash
cd /var/www
git clone <repository_url> e-lkjip
cd /var/www/e-lkjip

# Install dependensi PHP tanpa dependensi dev
composer install --no-dev --optimize-autoloader
```

### Langkah 2: Konfigurasi Environment (`.env`)
Salin template produksi yang telah disediakan:
```bash
cp .env.production.example .env
```

Buka file `.env` dan lengkapi nilai variabel berikut:
```ini
APP_NAME="e-LKjIP JAMBIN"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://e-lkjip.kejaksaan.go.id

# Database Production
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elkjip_jambin_prod
DB_USERNAME=elkjip_app_user
DB_PASSWORD=GantiDenganPasswordSangatKuatDanAcak!

# Session & Keamanan
SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Registrasi Publik Non-Aktif
AUTH_REGISTRATION_ENABLED=false
```

### Langkah 3: Generate Application Key Baru
Pastikan `APP_KEY` unik dan tidak menggunakan key lokal/development:
```bash
php artisan key:generate --force
```

### Langkah 4: Migrasi Database & Seeding Awal
Bila database production masih baru, jalankan migrasi:
```bash
php artisan migrate --force
```

Untuk inisialisasi struktur cascading dan akun unit kerja JAMBIN:
1. Tetapkan `KINERJA_BOOTSTRAP_PASSWORD` sementara pada `.env` (atau lewati agar sistem menghasilkan password acak 32 karakter).
2. Jalankan seeder canonical:
   ```bash
   php artisan db:seed --force
   ```
3. **PENTING**: Segera hapus baris `KINERJA_BOOTSTRAP_PASSWORD` dari file `.env` setelah seeding berhasil:
   ```bash
   sed -i '/KINERJA_BOOTSTRAP_PASSWORD/d' .env
   ```

### Langkah 5: Build Aset Frontend
Kompilasi aset React dan Tailwind/MUI untuk production:
```bash
npm ci
npm run build
```

### Langkah 6: Optimasi & Caching Laravel
Aktifkan cache konfigurasi, route, dan view untuk performa maksimal dan memutus pembacaan dinamis `.env`:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

*Catatan: Setiap kali terdapat pembaruan file `.env` atau `routes/`, bersihkan cache terlebih dahulu:*
```bash
php artisan optimize:clear
php artisan optimize
```

### Langkah 7: Pengaturan Hak Akses Direktori (Permissions)
Berikan hak kepemilikan dan hak tulis hanya pada folder `storage` dan `bootstrap/cache`:
```bash
sudo chown -R www-data:www-data /var/www/e-lkjip
sudo chmod -R 775 /var/www/e-lkjip/storage /var/www/e-lkjip/bootstrap/cache
```

Pastikan folder `storage/app/private` tidak memiliki symlink ke folder `public/`:
```bash
# Direktori ekspor laporan berada di storage/app/private/exports
# Direktori ini secara otomatis terisolasi dan tidak dapat diakses via URL web.
```

---

## 4. Rekomendasi Konfigurasi Nginx (Virtual Host)

Contoh konfigurasi Nginx aman dengan proteksi file tersembunyi dan rate limiting server-level:

```nginx
server {
    listen 80;
    server_name e-lkjip.kejaksaan.go.id;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name e-lkjip.kejaksaan.go.id;

    root /var/www/e-lkjip/public;
    index index.php index.html;

    # Sertifikat SSL resmi
    ssl_certificate /etc/ssl/certs/e-lkjip.kejaksaan.go.id.crt;
    ssl_certificate_key /etc/ssl/private/e-lkjip.kejaksaan.go.id.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Client body size untuk upload template Word admin (maks 15MB)
    client_max_body_size 16M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    # Blokir akses ke file .env, .git, dan file tersembunyi lainnya
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Blokir akses langsung ke storage non-public
    location ^~ /storage/app/private {
        deny all;
        return 404;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
}
```

---

## 5. Pemantauan & Observability

1. **Log Aplikasi**:
   Log aktivitas autentikasi dan mutasi data dapat ditinjau di:
   ```bash
   tail -f /var/www/e-lkjip/storage/logs/laravel.log
   ```
2. **Health Check**:
   Aplikasi menyediakan endpoint bawaan `/up` untuk memantau ketersediaan aplikasi:
   ```bash
   curl -I https://e-lkjip.kejaksaan.go.id/up
   # Respon normal: HTTP/1.1 200 OK
   ```
3. **Pembersihan Rutin Sesi & Cache**:
   Jika menggunakan database session, jalankan prune sessions secara berkala melalui scheduler:
   ```bash
   php artisan session:prune
   ```

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/1%20Full%20Color/laravel-logolockup-full-color.svg" width="360" alt="Laravel Logo">
</p>

<h1 align="center">Persiapan CPNS 2026</h1>

<p align="center">
  <strong>Sistem latihan SKD CPNS berbasis Laravel</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Filament-Admin-FDAE4B?style=for-the-badge" alt="Filament Admin">
</p>

Persiapan CPNS 2026 adalah aplikasi web untuk latihan SKD CPNS secara mandiri. Sistem ini menyediakan modul belajar, bank soal, simulasi ujian berbasis waktu, penilaian otomatis, pembahasan, serta admin panel untuk mengelola konten.

Konten soal di aplikasi ini adalah latihan original berbasis pola kompetensi SKD CPNS. Aplikasi ini tidak memuat soal asli, bocoran, atau klaim sebagai sumber resmi BKN/panitia seleksi.

## Fitur Utama

- Landing page modern untuk menjelaskan sistem.
- Autentikasi user: register, login, profile, reset password, dan verifikasi email route.
- Dashboard belajar untuk melihat ringkasan soal, modul, dan akses cepat.
- Bank soal TWK, TIU, dan TKP dengan filter kategori, subkategori, dan tingkat kesulitan.
- Detail soal dengan opsi jawaban dan pembahasan.
- Modul belajar terstruktur dengan heading, materi, tips, latihan singkat, checklist, dan rujukan belajar.
- Simulasi SKD full berbasis waktu dengan navigasi soal dan fitur tandai ragu-ragu.
- Autosave jawaban saat peserta memilih opsi.
- Hasil ujian berisi skor total, skor per kategori, status passing grade, dan pembahasan.
- Admin panel Filament untuk mengelola data kategori, soal, opsi, modul, paket ujian, user, dan setting.
- Role user dan admin.

## Cakupan Materi

Sistem ini menyiapkan tiga komponen SKD:

- TWK: Pancasila, UUD 1945, nasionalisme, NKRI, Bhinneka Tunggal Ika, integritas, bela negara, dan sejarah perjuangan bangsa.
- TIU: sinonim, antonim, analogi verbal, silogisme, deret angka, aritmetika, perbandingan, dan penalaran analitis.
- TKP: pelayanan publik, profesionalisme, integritas, kerja sama, pengendalian diri, adaptasi, teknologi informasi, pengambilan keputusan, kreativitas, dan inovasi.

## Cara Kerja Sistem

1. User membuka landing page, lalu melakukan register atau login.
2. Setelah login, user masuk ke dashboard belajar.
3. User dapat membaca modul untuk memahami konsep TWK, TIU, dan TKP.
4. User dapat mengerjakan soal dari bank soal untuk latihan per materi.
5. User dapat memulai simulasi SKD full dari dashboard.
6. Saat simulasi, jawaban tersimpan otomatis dan user bisa menandai soal ragu-ragu.
7. Setelah submit, sistem menghitung skor dan menampilkan hasil ujian.
8. Admin dapat mengelola seluruh data konten melalui panel `/admin`.

## Skema Penilaian

- TWK dan TIU memakai penilaian binary:
  - benar: 5
  - salah/kosong: 0
- TKP memakai penilaian bertingkat:
  - opsi bernilai 1 sampai 5
  - kosong: 0

Passing grade default:

- TWK: 65
- TIU: 80
- TKP: 166

## Stack Teknologi

- Laravel 12
- PHP 8.2+
- MySQL
- Blade
- Tailwind CSS
- Vite
- Laravel Breeze
- Filament 5
- PHPUnit

## Kebutuhan Sistem

Pastikan sudah terpasang:

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- MySQL atau MariaDB
- PHP extension untuk MySQL, seperti `pdo_mysql`

Catatan: Vite pada project ini merekomendasikan Node.js 20.19+ atau 22.12+. Build masih bisa berjalan pada beberapa versi lebih rendah, tetapi sebaiknya gunakan versi yang direkomendasikan.

## Instalasi Lokal

Clone repository:

```bash
git clone https://github.com/hanfx11/persiapan-cpns2026.git simulasi-tes-cpns
cd simulasi-tes-cpns
```

Install dependency PHP:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Buat file environment:

```bash
cp .env.example .env
```

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Siapkan database MySQL baru, misalnya:

```sql
CREATE DATABASE simulasi_tes_cpns CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Lalu sesuaikan konfigurasi database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simulasi_tes_cpns
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

Build asset frontend:

```bash
npm run build
```

Jalankan server lokal:

```bash
php artisan serve
```

Aplikasi dapat dibuka di:

```text
http://127.0.0.1:8000
```

## Mode Development

Untuk menjalankan Vite development server:

```bash
npm run dev
```

Di terminal lain, jalankan Laravel:

```bash
php artisan serve
```

Project juga menyediakan script Composer development:

```bash
composer run dev
```

Script ini menjalankan server Laravel, queue listener, log viewer, dan Vite secara bersamaan.

## Akun Demo

Seeder membuat akun awal berikut:

```text
Admin
Email: admin@example.com
Password: password

User
Email: user@example.com
Password: password
```

Admin panel:

```text
http://127.0.0.1:8000/admin
```

Hanya user dengan role `admin` yang dapat mengakses Filament admin panel.

## Data Seeder

Seeder utama berada di:

```text
database/seeders/CpnsContentSeeder.php
```

Data awal yang dibuat:

- kategori TWK, TIU, TKP
- subkategori materi
- modul belajar
- 300 soal latihan original
- opsi jawaban A-E
- pembahasan soal
- paket simulasi SKD full
- passing grade default
- akun admin dan user demo

Untuk reset database lokal dan mengisi ulang data:

```bash
php artisan migrate:fresh --seed
```

## Testing

Jalankan test:

```bash
php artisan test
```

Atau lewat Composer:

```bash
composer test
```

## Struktur Halaman

- `/` - landing page
- `/login` - login
- `/register` - registrasi
- `/dashboard` - dashboard belajar
- `/soal` - bank soal
- `/soal/{question}` - detail soal
- `/modul` - daftar modul belajar
- `/modul/{slug}` - detail modul belajar
- `/ujian/{session}` - halaman simulasi ujian
- `/ujian/{session}/hasil` - hasil ujian
- `/admin` - admin panel Filament

## Catatan Konten

Aplikasi ini dibuat untuk latihan dan pembelajaran. Semua soal dan modul bersifat original untuk membantu memahami pola kompetensi SKD CPNS. Jangan menggunakan aplikasi ini untuk mengklaim, menjual, atau menyebarkan soal sebagai soal asli atau bocoran resmi.

## Author

Created by [Hanif](https://github.com/hanfx11).

# Yang Sudah Dibuat Sekarang

Dokumen ini mencatat kondisi terbaru aplikasi **CAT CPNS Personal Trainer** setelah update terakhir.

## Status Umum

Aplikasi sudah bisa diakses secara lokal dan sudah memiliki:

- login/register user
- dashboard user
- halaman bank soal
- halaman detail soal dan pembahasan
- halaman modul belajar
- halaman detail modul
- admin panel Filament
- CRUD admin untuk data utama
- seed data lengkap berisi soal dan modul

Semua soal adalah soal latihan original berbasis pola kompetensi SKD CPNS. Aplikasi tidak mengklaim soal sebagai soal asli CPNS/BKN atau bocoran resmi.

## Akses Lokal

URL aplikasi:

```text
http://127.0.0.1:8000
```

URL login user:

```text
http://127.0.0.1:8000/login
```

URL dashboard user:

```text
http://127.0.0.1:8000/dashboard
```

URL bank soal:

```text
http://127.0.0.1:8000/soal
```

URL modul belajar:

```text
http://127.0.0.1:8000/modul
```

URL admin panel:

```text
http://127.0.0.1:8000/admin
```

## Akun Login

Admin:

```text
Email: admin@example.com
Password: password
```

User demo:

```text
Email: user@example.com
Password: password
```

## Fitur User yang Sudah Dibuat

User bisa login dan membuka dashboard belajar.

Dashboard user menampilkan:

- jumlah soal aktif
- jumlah modul belajar
- ringkasan kategori TWK, TIU, TKP
- link cepat ke bank soal
- link cepat ke modul belajar
- link ke admin panel jika user adalah admin
- modul rekomendasi awal
- label bahwa soal adalah latihan original, bukan soal asli/bocoran resmi
- tombol mulai simulasi SKD

## Simulasi Ujian CAT

User sekarang bisa mengerjakan soal sebagai simulasi ujian.

Cara mulai:

```text
Login sebagai user -> buka /dashboard -> klik Mulai Simulasi SKD
```

Fitur ujian yang sudah dibuat:

- membuat `exam_session`
- mengambil 110 soal dari paket `Simulasi SKD Full 100 Menit`
- timer countdown berdasarkan durasi sesi
- navigasi nomor soal
- status nomor soal untuk belum dijawab, sudah dijawab, ragu-ragu, dan aktif
- autosave jawaban dengan request AJAX/fetch
- tombol sebelumnya
- tombol selanjutnya
- tombol tandai ragu-ragu
- tombol submit ujian
- auto-submit saat timer habis
- jawaban tidak bisa diubah setelah sesi selesai

## Hasil Ujian dan Scoring

Setelah submit, user diarahkan ke halaman hasil.

Halaman hasil menampilkan:

- skor total
- skor TWK
- skor TIU
- skor TKP
- status passing grade
- ringkasan benar/salah/kosong TWK
- ringkasan benar/salah/kosong TIU
- ringkasan dijawab/kosong TKP
- pembahasan setiap soal
- jawaban user
- jawaban benar untuk TWK/TIU
- skor opsi untuk TKP

Scoring engine sudah dibuat di:

```text
App\Services\ExamScoringService
```

Rules scoring:

- TWK/TIU benar = 5
- TWK/TIU salah atau kosong = 0
- TKP memakai skor dari opsi 1 sampai 5
- TKP kosong = 0
- passing grade TWK = 65
- passing grade TIU = 80
- passing grade TKP = 166
- `passed_total` true jika semua komponen lulus

## Bank Soal User

Halaman bank soal tersedia di:

```text
/soal
```

User bisa:

- melihat daftar soal
- filter soal berdasarkan kategori
- filter soal berdasarkan subkategori
- filter soal berdasarkan tingkat kesulitan
- membuka detail soal
- melihat kategori soal
- melihat subkategori soal
- melihat tingkat kesulitan soal
- melihat tipe skor soal

## Detail Soal User

Halaman detail soal tersedia di:

```text
/soal/{id}
```

User bisa melihat:

- teks soal
- kategori
- subkategori
- tingkat kesulitan
- tipe skor
- opsi A-E
- jawaban benar untuk TWK/TIU
- skor opsi untuk TKP
- pembahasan soal

## Modul Belajar User

Halaman modul belajar tersedia di:

```text
/modul
```

User bisa:

- melihat daftar modul belajar
- filter modul berdasarkan kategori
- membuka detail modul
- membaca isi modul

## Detail Modul User

Halaman detail modul tersedia di:

```text
/modul/{slug}
```

Isi modul mencakup:

- ringkasan konsep
- poin penting
- contoh penerapan
- tips menjawab soal
- latihan singkat
- catatan bahwa materi dan soal adalah latihan original
- rujukan belajar berupa link sumber

Rujukan modul yang dipakai antara lain:

- BKN - informasi SKD dan CAT
- Peraturan BPK - PermenPANRB terkait materi SKD
- BPHN - UUD Negara Republik Indonesia Tahun 1945
- Kementerian Pertahanan - nilai dasar bela negara

Link rujukan tampil di bagian bawah setiap modul.

## Admin Panel

Admin panel tersedia di:

```text
/admin
```

Admin panel menggunakan Filament.

Admin bisa mengelola:

- Categories
- Subcategories
- Questions
- Question Options
- Learning Modules
- Exam Packages
- App Settings
- Users

## CRUD Admin yang Sudah Dibuat

Admin sudah bisa CRUD data berikut:

- kategori TWK/TIU/TKP
- subkategori
- soal
- opsi jawaban
- modul belajar
- paket ujian
- pengaturan aplikasi
- user

Form admin sudah menggunakan relasi database, misalnya:

- soal memilih kategori dari tabel `categories`
- soal memilih subkategori dari tabel `subcategories`
- opsi jawaban terhubung ke soal
- modul belajar terhubung ke kategori dan subkategori
- exam package terhubung ke data paket ujian

## Database yang Sudah Ada

Tabel utama yang sudah dibuat:

- `users`
- `categories`
- `subcategories`
- `questions`
- `question_options`
- `exam_packages`
- `exam_package_questions`
- `exam_sessions`
- `exam_answers`
- `learning_modules`
- `module_progress`
- `app_settings`

Tabel bawaan Laravel juga tersedia:

- `sessions`
- `password_reset_tokens`
- `cache`
- `cache_locks`
- `jobs`
- `job_batches`
- `failed_jobs`

## Model yang Sudah Dibuat

Model aplikasi:

- `User`
- `Category`
- `Subcategory`
- `Question`
- `QuestionOption`
- `ExamPackage`
- `ExamPackageQuestion`
- `ExamSession`
- `ExamAnswer`
- `LearningModule`
- `ModuleProgress`
- `AppSetting`

## Relationship Model

Relasi utama yang sudah dibuat:

- `Category` punya banyak `Subcategory`
- `Category` punya banyak `Question`
- `Category` punya banyak `LearningModule`
- `Subcategory` milik `Category`
- `Subcategory` punya banyak `Question`
- `Subcategory` punya banyak `LearningModule`
- `Question` milik `Category`
- `Question` milik `Subcategory`
- `Question` punya banyak `QuestionOption`
- `Question` punya banyak `ExamAnswer`
- `QuestionOption` milik `Question`
- `ExamPackage` punya banyak `Question`
- `ExamPackage` punya banyak `ExamSession`
- `ExamSession` milik `User`
- `ExamSession` milik `ExamPackage`
- `ExamSession` punya banyak `ExamAnswer`
- `ExamAnswer` milik `ExamSession`
- `ExamAnswer` milik `Question`
- `ExamAnswer` milik selected `QuestionOption`
- `LearningModule` milik `Category`
- `LearningModule` dapat memiliki `Subcategory`
- `ModuleProgress` milik `User`
- `ModuleProgress` milik `LearningModule`

## Data Seeder Lengkap

Seeder sekarang membuat data lengkap:

```text
users: 2
categories: 3
subcategories: 25
questions: 300
question_options: 1.500
learning_modules: 30
exam_packages: 1
exam_package_questions: 110
app_settings: 7
```

## Kategori

Kategori yang tersedia:

- TWK
- TIU
- TKP

## Subkategori

Jumlah subkategori:

```text
25 subkategori
```

Contoh subkategori:

- TWK - Pancasila
- TWK - UUD 1945
- TWK - Nasionalisme
- TWK - NKRI
- TWK - Bhinneka Tunggal Ika
- TIU - Sinonim
- TIU - Antonim
- TIU - Analogi Verbal
- TIU - Silogisme
- TIU - Deret Angka
- TIU - Aritmetika
- TKP - Pelayanan Publik
- TKP - Profesionalisme
- TKP - Integritas
- TKP - Kerja Sama
- TKP - Pengambilan Keputusan

## Soal

Total soal:

```text
300 soal original
```

Komposisi:

- 100 soal TWK
- 100 soal TIU
- 100 soal TKP

Setiap soal memiliki:

- kategori
- subkategori
- tingkat kesulitan
- tipe skor
- teks soal
- 5 opsi A-E
- pembahasan

TWK dan TIU:

- memakai `score_type = binary`
- satu jawaban benar
- benar bernilai 5
- salah/kosong bernilai 0

TKP:

- memakai `score_type = weighted`
- setiap opsi memiliki skor 1 sampai 5
- tidak memakai klaim jawaban benar mutlak
- opsi terbaik bernilai 5

## Modul Belajar

Total modul:

```text
30 modul belajar
```

Komposisi:

- 10 modul TWK
- 10 modul TIU
- 10 modul TKP

Setiap modul memiliki:

- title
- slug
- kategori
- subkategori
- content HTML
- ringkasan konsep
- poin penting
- contoh penerapan
- tips menjawab soal
- latihan singkat

## Exam Package

Paket ujian yang sudah dibuat:

```text
Simulasi SKD Full 100 Menit
```

Konfigurasi paket:

- durasi 100 menit
- total soal 110
- 30 soal TWK
- 35 soal TIU
- 45 soal TKP
- status aktif
- ditandai sebagai full SKD

Catatan:

Paket exam sudah terisi 110 soal, tetapi halaman ujian CAT interaktif belum dibuat.

## App Settings

Setting default:

```text
passing_grade_twk = 65
passing_grade_tiu = 80
passing_grade_tkp = 166
full_exam_duration_minutes = 100
full_exam_twk_count = 30
full_exam_tiu_count = 35
full_exam_tkp_count = 45
```

## Verifikasi

Command yang sudah berhasil dijalankan:

```bash
php artisan migrate:fresh --seed
npm run build
php artisan test
php artisan db:show --counts
```

Hasil test terbaru:

```text
28 tests passed
```

Hasil build:

```text
npm run build berhasil
```

Catatan:

Vite memberi warning karena Node lokal versi `20.11.0`, sedangkan Vite merekomendasikan Node `20.19+` atau `22.12+`. Build tetap berhasil.

## Yang Belum Dibuat

Fitur berikut belum dibuat:

- analisis kelemahan
- rekomendasi modul berdasarkan hasil
- riwayat ujian
- mode ulangi soal salah

## Next Step

Tahap berikutnya adalah memperdalam fitur hasil dan personalisasi:

- analisis kelemahan per subkategori
- rekomendasi modul berdasarkan hasil ujian
- riwayat ujian
- mode ulangi soal salah
- latihan per kategori/subkategori
- review cepat tanpa timer

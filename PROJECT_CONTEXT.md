# PROJECT_CONTEXT - CAT CPNS Personal Trainer

Aplikasi ini adalah web latihan pribadi untuk persiapan SKD CPNS. Soal yang digunakan adalah soal latihan original berbasis pola kompetensi SKD CPNS, bukan soal asli CPNS/BKN, bukan bocoran resmi, dan tidak boleh diklaim sebagai soal resmi.

## Stack
- Laravel 12
- PHP 8.2
- SQLite untuk local default saat ini, bisa diganti ke MySQL lewat `.env`
- Blade, Tailwind CSS, Vite
- Laravel Breeze untuk auth
- Filament 5 untuk admin panel

## Phase 1 Completed
- Laravel project sudah dibuat di root project.
- Laravel Breeze Blade sudah terpasang untuk login, register, profile, password reset, dan email verification route.
- Filament admin panel sudah terpasang di `/admin`.
- Role user dibuat di kolom `users.role` dengan nilai default `user`.
- Akses Filament dibatasi lewat `User::canAccessPanel()`, hanya `role = admin`.
- Migration inti sudah dibuat:
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
- Model dan relationship utama sudah dibuat:
  - `Category` has many `Subcategory`, `Question`, `LearningModule`
  - `Subcategory` belongs to `Category`, has many `Question`, `LearningModule`
  - `Question` belongs to `Category` and `Subcategory`, has many `QuestionOption` and `ExamAnswer`
  - `QuestionOption` belongs to `Question`
  - `ExamPackage` belongs to many `Question`, has many `ExamSession`
  - `ExamSession` belongs to `User` and `ExamPackage`, has many `ExamAnswer`
  - `ExamAnswer` belongs to `ExamSession`, `Question`, and selected `QuestionOption`
  - `LearningModule` belongs to `Category` and optional `Subcategory`
  - `ModuleProgress` belongs to `User` and `LearningModule`
  - `AppSetting` stores configurable app values
- Seeder awal sudah dibuat:
  - Admin: `admin@example.com` / `password`
  - User demo: `user@example.com` / `password`
  - Kategori TWK, TIU, TKP
  - 25 subkategori awal
  - Passing grade default TWK 65, TIU 80, TKP 166
  - Konfigurasi simulasi full SKD 100 menit, 30 TWK, 35 TIU, 45 TKP
  - 30 modul belajar awal
  - 300 soal latihan original dengan opsi A-E dan pembahasan
  - 1 paket exam full SKD dengan 110 soal terhubung

## Content Access Update
- User dashboard sudah diganti dari dashboard Breeze default menjadi dashboard belajar.
- User bisa melihat bank soal di `/soal`.
- User bisa melihat detail soal dan pembahasan di `/soal/{question}`.
- User bisa melihat daftar modul belajar di `/modul`.
- User bisa membaca modul di `/modul/{slug}`.
- User bisa mulai simulasi SKD dari dashboard.
- Halaman ujian tersedia di `/ujian/{session}`.
- Autosave jawaban tersedia via `/ujian/{session}/jawaban/{answer}`.
- Tandai ragu-ragu tersedia via `/ujian/{session}/ragu/{answer}`.
- Submit ujian tersedia via `/ujian/{session}/submit`.
- Halaman hasil dan pembahasan tersedia di `/ujian/{session}/hasil`.
- Scoring engine dibuat di `App\Services\ExamScoringService`.
- Modul belajar sekarang memiliki struktur ringkasan, poin penting, contoh penerapan, tips, latihan singkat, dan rujukan/link belajar.
- Navigasi utama sekarang punya menu Dashboard, Bank Soal, dan Modul Belajar.
- Admin Filament sekarang punya resource:
  - Categories
  - Subcategories
  - Questions
  - Question Options
  - Learning Modules
  - Exam Packages
  - App Settings
  - Users
- Seeder lengkap sudah menggantikan seed contoh kecil:
  - 300 soal original
  - 1.500 opsi jawaban
  - 30 modul belajar
  - 110 soal terhubung ke paket `Simulasi SKD Full 100 Menit`

## Commands
- Install dependency PHP: `composer install`
- Install dependency Node: `npm install`
- Build asset: `npm run build`
- Reset dan seed database local: `php artisan migrate:fresh --seed`
- Jalankan test: `php artisan test`
- Jalankan server local: `php artisan serve`
- URL local yang dipakai saat Phase 1: `http://127.0.0.1:8000`

## Verification
- `php artisan migrate:fresh --seed` berhasil.
- `npm run build` berhasil dan membuat `public/build/manifest.json`.
- `php artisan test` berhasil: 28 tests passed.
- `php artisan db:show --counts` menunjukkan data seed awal:
  - users: 2
  - categories: 3
  - subcategories: 25
  - questions: 300
  - question_options: 1.500
  - learning_modules: 30
  - exam_packages: 1
  - exam_package_questions: 110
  - app_settings: 7
- Laravel dev server berhasil dibuka di `http://127.0.0.1:8000`.
- Catatan environment: `npm install` dan `npm run build` berhasil, tetapi Vite memberi warning bahwa Node lokal `20.11.0` lebih rendah dari rekomendasi Vite `20.19+` atau `22.12+`.

## Important Rules
- Jangan menyalin atau mengklaim soal asli CPNS/BKN.
- Semua soal harus berupa soal latihan original.
- Label yang harus muncul di area relevan aplikasi: "Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi."
- TWK/TIU memakai `score_type = binary`: benar 5, salah/kosong 0.
- TKP memakai `score_type = weighted`: opsi bernilai 1-5, kosong 0.
- Passing grade default:
  - TWK: 65
  - TIU: 80
  - TKP: 166

## Next Step
Next step teknis:
- analisis kelemahan per subkategori
- rekomendasi modul berdasarkan hasil ujian
- riwayat ujian
- mode ulangi soal salah
- latihan per kategori/subkategori
- review cepat tanpa timer

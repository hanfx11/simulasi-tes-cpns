# PRD Lengkap — Web Simulasi CAT CPNS Pribadi

## 1. Nama Produk

**CAT CPNS Personal Trainer**

Alternatif nama:

* Simulasi CAT CPNS Pribadi
* CPNS Study Lab
* LolosSKD Trainer
* CAT SKD Practice System

---

## 2. Tujuan Produk

Membangun aplikasi web pribadi untuk membantu pengguna mempersiapkan tes CPNS, khususnya SKD, melalui:

1. Simulasi ujian CAT berbasis timer.
2. Bank soal latihan original yang menyerupai pola kompetensi SKD, bukan menyalin soal asli.
3. Modul belajar TWK, TIU, dan TKP.
4. Sistem skor otomatis.
5. Pembahasan soal.
6. Analisis kelemahan pengguna.
7. Rekomendasi materi belajar berdasarkan hasil ujian.
8. Riwayat progres belajar dan tryout.

Aplikasi ini digunakan untuk pembelajaran pribadi, bukan untuk mengklaim sebagai soal resmi BKN atau soal asli CPNS.

---

## 3. Prinsip Keamanan Konten

Aplikasi tidak boleh menyimpan, menggunakan, atau mengklaim memiliki soal asli CPNS/BKN. Semua soal harus dibuat sebagai soal latihan original dengan pola kemampuan yang relevan, misalnya:

* TWK: Pancasila, UUD 1945, nasionalisme, NKRI, integritas, bela negara.
* TIU: verbal, numerik, logika, analitis, figural.
* TKP: pelayanan publik, profesionalisme, integritas, kerja sama, adaptasi, pengambilan keputusan.

Label yang digunakan di aplikasi:

> “Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi.”

---

## 4. Target Pengguna

Pengguna utama:

* Saya sendiri sebagai calon peserta CPNS.
* Pengguna yang ingin latihan SKD secara mandiri.
* Orang yang ingin mengukur kesiapan TWK, TIU, dan TKP.

Untuk versi awal, aplikasi cukup digunakan secara personal tanpa sistem pembayaran.

---

## 5. Scope MVP

Versi pertama aplikasi wajib memiliki:

1. Login dan register.
2. Dashboard pengguna.
3. Modul belajar TWK, TIU, TKP.
4. Bank soal.
5. Mode latihan per kategori.
6. Mode simulasi ujian penuh.
7. Timer 100 menit.
8. Navigasi nomor soal.
9. Fitur tandai ragu-ragu.
10. Auto-save jawaban.
11. Auto-submit saat waktu habis.
12. Hitung skor otomatis.
13. Hasil ujian lengkap.
14. Pembahasan soal.
15. Analisis kelemahan.
16. Riwayat ujian.
17. Admin sederhana untuk mengelola soal dan modul.
18. Seeder data awal berisi modul dan contoh soal original.

---

## 6. Format Simulasi Ujian

### 6.1 Simulasi SKD Full

* Total soal: 110.
* Durasi: 100 menit.
* TWK: 30 soal.
* TIU: 35 soal.
* TKP: 45 soal.

### 6.2 Sistem Skor

TWK:

* Benar: 5 poin.
* Salah: 0 poin.
* Tidak dijawab: 0 poin.

TIU:

* Benar: 5 poin.
* Salah: 0 poin.
* Tidak dijawab: 0 poin.

TKP:

* Setiap pilihan memiliki bobot 1 sampai 5.
* Tidak dijawab: 0 poin.

### 6.3 Nilai Maksimal

* TWK: 150.
* TIU: 175.
* TKP: 225.
* Total maksimal: 550.

### 6.4 Passing Grade Default

Gunakan konfigurasi default berikut, tetapi buat bisa diubah lewat admin/config:

* TWK: 65.
* TIU: 80.
* TKP: 166.

Status lulus jika semua komponen memenuhi passing grade.

---

## 7. Modul Belajar

### 7.1 Modul TWK

Materi utama:

1. Pancasila.
2. UUD 1945.
3. Bhinneka Tunggal Ika.
4. NKRI.
5. Nasionalisme.
6. Integritas.
7. Bela Negara.
8. Sejarah perjuangan bangsa.
9. Sistem pemerintahan Indonesia.
10. Demokrasi.
11. Hak dan kewajiban warga negara.
12. Wawasan Nusantara.
13. Anti-radikalisme.
14. Etika bernegara.

Format setiap modul:

* Judul modul.
* Ringkasan konsep.
* Poin penting.
* Contoh kasus.
* Tips menjawab soal.
* Latihan singkat 5–10 soal.

Contoh struktur modul:

```text
Judul: TWK - Pancasila
Ringkasan:
Pancasila adalah dasar negara dan ideologi bangsa Indonesia. Soal TWK tentang Pancasila sering menguji kemampuan memahami nilai dasar, nilai instrumental, dan nilai praksis.

Poin penting:
1. Sila pertama berkaitan dengan ketuhanan.
2. Sila kedua berkaitan dengan kemanusiaan.
3. Sila ketiga berkaitan dengan persatuan.
4. Sila keempat berkaitan dengan demokrasi/musyawarah.
5. Sila kelima berkaitan dengan keadilan sosial.

Tips:
Fokus pada penerapan nilai dalam kasus nyata, bukan hanya hafalan bunyi sila.
```

### 7.2 Modul TIU

Materi utama:

Verbal:

1. Sinonim.
2. Antonim.
3. Analogi.
4. Padanan kata.
5. Pemahaman bacaan.
6. Silogisme.

Numerik:

1. Aritmetika dasar.
2. Pecahan.
3. Persentase.
4. Perbandingan.
5. Deret angka.
6. Soal cerita matematika.
7. Kecepatan, jarak, waktu.
8. Statistik dasar.
9. Peluang dasar.

Logika/analitis:

1. Penalaran logis.
2. Urutan posisi.
3. Relasi antarobjek.
4. Kesimpulan dari premis.
5. Pola sebab-akibat.

Figural:

1. Pola gambar.
2. Rotasi.
3. Pencerminan.
4. Kelanjutan bentuk.
5. Klasifikasi bentuk.

### 7.3 Modul TKP

Materi utama:

1. Pelayanan publik.
2. Profesionalisme.
3. Integritas.
4. Jejaring kerja.
5. Sosial budaya.
6. Teknologi informasi dan komunikasi.
7. Semangat berprestasi.
8. Kemampuan beradaptasi.
9. Kerja sama.
10. Pengendalian diri.
11. Kreativitas dan inovasi.
12. Orientasi hasil.
13. Pengambilan keputusan.
14. Anti-korupsi.

Format pembahasan TKP harus menjelaskan kenapa suatu opsi bernilai tinggi atau rendah.

---

## 8. Mode Latihan

### 8.1 Latihan Per Materi

Pengguna memilih kategori dan subkategori, contoh:

* TWK - Pancasila.
* TIU - Deret angka.
* TKP - Pelayanan publik.

Fitur:

* Jumlah soal bisa dipilih: 5, 10, 20, 30.
* Bisa memakai timer atau tanpa timer.
* Setelah selesai langsung tampil skor dan pembahasan.

### 8.2 Simulasi Full CAT

Fitur:

* 110 soal.
* 100 menit.
* Tidak bisa melihat pembahasan sebelum submit.
* Bisa berpindah nomor soal.
* Bisa tandai ragu-ragu.
* Auto-submit saat waktu habis.

### 8.3 Mode Ulangi Soal Salah

Sistem menyimpan semua soal yang pernah salah. Pengguna bisa latihan ulang hanya dari soal-soal yang salah.

### 8.4 Mode Review Cepat

Mode belajar tanpa timer. Setelah memilih jawaban, pembahasan bisa langsung dilihat.

---

## 9. User Flow

### 9.1 Flow Register/Login

1. User membuka aplikasi.
2. User register/login.
3. User masuk dashboard.
4. User melihat progres dan rekomendasi belajar.

### 9.2 Flow Simulasi Ujian

1. User klik “Mulai Simulasi SKD”.
2. Sistem membuat exam session.
3. Sistem mengambil 110 soal sesuai komposisi.
4. Timer dimulai dari 100 menit.
5. User menjawab soal.
6. Jawaban tersimpan otomatis.
7. User bisa menandai soal ragu-ragu.
8. User submit manual atau sistem auto-submit.
9. Sistem menghitung skor.
10. Sistem menampilkan hasil.
11. Sistem memberi analisis kelemahan dan rekomendasi modul.

### 9.3 Flow Belajar Modul

1. User membuka menu Modul.
2. User memilih TWK/TIU/TKP.
3. User membaca materi.
4. User mengerjakan latihan singkat.
5. Sistem menyimpan progres modul.

---

## 10. Halaman Aplikasi

### 10.1 Public Page

Jika aplikasi hanya untuk pribadi, public page cukup sederhana:

* Landing page.
* Login.
* Register.

### 10.2 Dashboard User

Komponen dashboard:

1. Kartu skor terakhir.
2. Kartu status passing grade.
3. Grafik perkembangan skor.
4. Kelemahan terbesar.
5. Rekomendasi modul.
6. Tombol mulai simulasi.
7. Riwayat tryout terakhir.

Contoh isi dashboard:

```text
Skor terakhir: 397 / 550
TWK: 85 / 150
TIU: 105 / 175
TKP: 207 / 225
Status: Lulus Passing Grade

Kelemahan:
1. TIU - Deret angka
2. TWK - UUD 1945
3. TKP - Pengambilan keputusan
```

### 10.3 Halaman Ujian

Layout halaman ujian:

* Header: nama ujian, timer, tombol submit.
* Area soal: nomor soal, kategori, pertanyaan, pilihan jawaban.
* Sidebar/panel nomor: daftar nomor 1–110.
* Tombol: sebelumnya, selanjutnya, tandai ragu-ragu.

Status warna nomor:

* Abu-abu: belum dijawab.
* Hijau: sudah dijawab.
* Kuning: ragu-ragu.
* Biru: soal aktif.

### 10.4 Halaman Hasil

Isi halaman hasil:

1. Skor total.
2. Skor TWK.
3. Skor TIU.
4. Skor TKP.
5. Status passing grade.
6. Jumlah benar, salah, kosong untuk TWK/TIU.
7. Rata-rata skor TKP.
8. Waktu pengerjaan.
9. Grafik kategori.
10. Rekomendasi belajar.
11. Tombol lihat pembahasan.
12. Tombol ulangi soal salah.

### 10.5 Halaman Pembahasan

Untuk setiap soal tampilkan:

* Pertanyaan.
* Pilihan jawaban.
* Jawaban user.
* Jawaban benar/skor tertinggi.
* Pembahasan.
* Kategori.
* Subkategori.
* Level kesulitan.

---

## 11. Database Design

Gunakan database relasional seperti MySQL atau PostgreSQL.

### 11.1 users

```text
id
name
email
password
role: admin/user
created_at
updated_at
```

### 11.2 categories

```text
id
code: TWK/TIU/TKP
name
description
created_at
updated_at
```

### 11.3 subcategories

```text
id
category_id
name
description
created_at
updated_at
```

### 11.4 questions

```text
id
category_id
subcategory_id
question_text
explanation
difficulty: easy/medium/hard
score_type: binary/weighted
status: active/inactive
created_at
updated_at
```

### 11.5 question_options

```text
id
question_id
option_label: A/B/C/D/E
option_text
is_correct: boolean nullable
score: integer nullable
created_at
updated_at
```

Keterangan:

* Untuk TWK/TIU: gunakan is_correct.
* Untuk TKP: gunakan score 1–5.

### 11.6 exam_packages

```text
id
title
description
duration_minutes
total_questions
is_full_skd
status
created_at
updated_at
```

### 11.7 exam_package_questions

```text
id
exam_package_id
question_id
order_number
created_at
updated_at
```

### 11.8 exam_sessions

```text
id
user_id
exam_package_id nullable
mode: full/practice/review/wrong_only
started_at
finished_at
duration_seconds
status: ongoing/submitted/expired
score_total
score_twk
score_tiu
score_tkp
passed_twk
passed_tiu
passed_tkp
passed_total
created_at
updated_at
```

### 11.9 exam_answers

```text
id
exam_session_id
question_id
selected_option_id nullable
score
is_correct nullable
is_flagged
answered_at
created_at
updated_at
```

### 11.10 learning_modules

```text
id
category_id
subcategory_id nullable
title
slug
content
order_number
status
created_at
updated_at
```

### 11.11 module_progress

```text
id
user_id
learning_module_id
status: not_started/in_progress/completed
completed_at nullable
created_at
updated_at
```

### 11.12 app_settings

```text
id
key
value
created_at
updated_at
```

Isi default:

```text
passing_grade_twk = 65
passing_grade_tiu = 80
passing_grade_tkp = 166
full_exam_duration_minutes = 100
full_exam_twk_count = 30
full_exam_tiu_count = 35
full_exam_tkp_count = 45
```

---

## 12. Tech Stack Rekomendasi

Karena aplikasi ini untuk pembelajaran pribadi dan ingin cepat dibuat:

### Stack utama

* Laravel terbaru.
* Blade atau Livewire.
* Tailwind CSS.
* Filament Admin Panel.
* MySQL.

Alasan:

1. Lebih cepat untuk membuat CRUD soal.
2. Filament memudahkan admin panel.
3. Laravel cocok untuk sistem ujian, database, auth, dan session.
4. Bisa dijalankan lokal terlebih dahulu.

---

## 13. Spesifikasi UI

Gaya tampilan:

* Clean.
* Modern.
* Fokus belajar.
* Tidak terlalu ramai.
* Responsive desktop dan mobile.

Referensi style:

* Sidebar kiri untuk dashboard.
* Kartu statistik rounded.
* Warna utama: biru atau indigo.
* Warna status:

  * Hijau untuk lulus/benar.
  * Merah untuk gagal/salah.
  * Kuning untuk ragu-ragu.
  * Abu-abu untuk belum dikerjakan.

---

## 14. Aturan Generate Soal

Codex/AI harus membuat soal original dengan kriteria berikut:

1. Tidak boleh mengklaim sebagai soal asli CPNS.
2. Tidak boleh menyalin dari buku, website, atau sumber berhak cipta.
3. Setiap soal memiliki 5 opsi A–E.
4. Setiap soal memiliki pembahasan.
5. Setiap soal memiliki kategori, subkategori, dan tingkat kesulitan.
6. TWK/TIU memiliki satu jawaban benar.
7. TKP memiliki skor 1–5 untuk setiap opsi.
8. Soal harus menggunakan bahasa Indonesia yang jelas.
9. Hindari pertanyaan ambigu.
10. Hindari pembahasan terlalu pendek.

---

## 15. Contoh Data Soal Original

### 15.1 TWK — Pancasila

```json
{
  "category": "TWK",
  "subcategory": "Pancasila",
  "difficulty": "easy",
  "score_type": "binary",
  "question_text": "Dalam rapat organisasi, seorang anggota tetap menghargai pendapat orang lain meskipun berbeda pandangan dan berusaha mencapai keputusan melalui musyawarah. Sikap tersebut paling sesuai dengan nilai Pancasila sila ke-...",
  "options": [
    {"label": "A", "text": "Pertama", "is_correct": false},
    {"label": "B", "text": "Kedua", "is_correct": false},
    {"label": "C", "text": "Ketiga", "is_correct": false},
    {"label": "D", "text": "Keempat", "is_correct": true},
    {"label": "E", "text": "Kelima", "is_correct": false}
  ],
  "explanation": "Musyawarah untuk mencapai mufakat merupakan pengamalan sila keempat Pancasila, yaitu Kerakyatan yang dipimpin oleh hikmat kebijaksanaan dalam permusyawaratan/perwakilan."
}
```

### 15.2 TWK — UUD 1945

```json
{
  "category": "TWK",
  "subcategory": "UUD 1945",
  "difficulty": "medium",
  "score_type": "binary",
  "question_text": "Salah satu tujuan negara Indonesia yang tercantum dalam Pembukaan UUD 1945 adalah...",
  "options": [
    {"label": "A", "text": "Mewujudkan pemerintahan absolut yang kuat", "is_correct": false},
    {"label": "B", "text": "Melindungi segenap bangsa Indonesia dan seluruh tumpah darah Indonesia", "is_correct": true},
    {"label": "C", "text": "Menjadikan Indonesia sebagai negara federal penuh", "is_correct": false},
    {"label": "D", "text": "Menghapus seluruh kerja sama internasional", "is_correct": false},
    {"label": "E", "text": "Membatasi pendidikan hanya untuk golongan tertentu", "is_correct": false}
  ],
  "explanation": "Pembukaan UUD 1945 memuat tujuan negara, salah satunya melindungi segenap bangsa Indonesia dan seluruh tumpah darah Indonesia."
}
```

### 15.3 TIU — Deret Angka

```json
{
  "category": "TIU",
  "subcategory": "Deret Angka",
  "difficulty": "easy",
  "score_type": "binary",
  "question_text": "Tentukan angka berikutnya dari deret: 3, 6, 12, 24, ...",
  "options": [
    {"label": "A", "text": "30", "is_correct": false},
    {"label": "B", "text": "36", "is_correct": false},
    {"label": "C", "text": "42", "is_correct": false},
    {"label": "D", "text": "48", "is_correct": true},
    {"label": "E", "text": "54", "is_correct": false}
  ],
  "explanation": "Pola deret adalah dikali 2. Maka setelah 24 adalah 24 × 2 = 48."
}
```

### 15.4 TIU — Analogi Verbal

```json
{
  "category": "TIU",
  "subcategory": "Analogi Verbal",
  "difficulty": "medium",
  "score_type": "binary",
  "question_text": "Dokter : Rumah Sakit = Guru : ...",
  "options": [
    {"label": "A", "text": "Pasien", "is_correct": false},
    {"label": "B", "text": "Kelas", "is_correct": false},
    {"label": "C", "text": "Sekolah", "is_correct": true},
    {"label": "D", "text": "Buku", "is_correct": false},
    {"label": "E", "text": "Murid", "is_correct": false}
  ],
  "explanation": "Dokter bekerja di rumah sakit, sedangkan guru bekerja di sekolah. Hubungan analoginya adalah profesi dan tempat bekerja."
}
```

### 15.5 TIU — Silogisme

```json
{
  "category": "TIU",
  "subcategory": "Silogisme",
  "difficulty": "medium",
  "score_type": "binary",
  "question_text": "Semua pegawai disiplin datang tepat waktu. Sebagian peserta pelatihan adalah pegawai. Kesimpulan yang paling tepat adalah...",
  "options": [
    {"label": "A", "text": "Semua peserta pelatihan datang tepat waktu", "is_correct": false},
    {"label": "B", "text": "Sebagian peserta pelatihan yang merupakan pegawai datang tepat waktu", "is_correct": true},
    {"label": "C", "text": "Tidak ada peserta pelatihan yang datang tepat waktu", "is_correct": false},
    {"label": "D", "text": "Semua pegawai bukan peserta pelatihan", "is_correct": false},
    {"label": "E", "text": "Sebagian pegawai tidak disiplin", "is_correct": false}
  ],
  "explanation": "Karena sebagian peserta pelatihan adalah pegawai, dan semua pegawai disiplin datang tepat waktu, maka sebagian peserta pelatihan yang termasuk pegawai datang tepat waktu."
}
```

### 15.6 TKP — Pelayanan Publik

```json
{
  "category": "TKP",
  "subcategory": "Pelayanan Publik",
  "difficulty": "medium",
  "score_type": "weighted",
  "question_text": "Anda sedang melayani masyarakat di loket. Tiba-tiba ada warga yang marah karena merasa antreannya terlalu lama. Sikap Anda adalah...",
  "options": [
    {"label": "A", "text": "Meminta warga tersebut diam karena semua orang juga menunggu.", "score": 1},
    {"label": "B", "text": "Mengabaikan warga tersebut agar antrean tetap berjalan.", "score": 2},
    {"label": "C", "text": "Meminta petugas lain menanganinya tanpa memberi penjelasan.", "score": 3},
    {"label": "D", "text": "Menjelaskan kondisi antrean dengan sopan dan membantu mencarikan solusi sesuai prosedur.", "score": 5},
    {"label": "E", "text": "Menyuruh warga tersebut datang lagi di lain hari.", "score": 1}
  ],
  "explanation": "Pilihan D paling baik karena menunjukkan sikap tenang, komunikatif, solutif, dan tetap berorientasi pada pelayanan publik."
}
```

### 15.7 TKP — Integritas

```json
{
  "category": "TKP",
  "subcategory": "Integritas",
  "difficulty": "medium",
  "score_type": "weighted",
  "question_text": "Anda menemukan rekan kerja memanipulasi data laporan agar terlihat lebih baik. Apa yang sebaiknya Anda lakukan?",
  "options": [
    {"label": "A", "text": "Membiarkannya karena bukan tanggung jawab saya.", "score": 1},
    {"label": "B", "text": "Menegur dengan emosi agar rekan tersebut jera.", "score": 2},
    {"label": "C", "text": "Mengikuti cara tersebut agar pekerjaan terlihat baik.", "score": 1},
    {"label": "D", "text": "Mengajak rekan tersebut memperbaiki data dan mengingatkan pentingnya kejujuran.", "score": 5},
    {"label": "E", "text": "Langsung menyebarkan kesalahan tersebut ke semua rekan kerja.", "score": 2}
  ],
  "explanation": "Pilihan D paling tepat karena menjaga integritas, menyelesaikan masalah secara profesional, dan mendorong perbaikan tanpa mempermalukan pihak lain."
}
```

---

## 16. Prompt Utama untuk Codex CLI

Gunakan prompt ini untuk menyuruh Codex membuat aplikasi dari awal.

```text
Saya ingin kamu membangun aplikasi web Laravel untuk simulasi CAT CPNS pribadi bernama “CAT CPNS Personal Trainer”. Aplikasi ini digunakan untuk belajar pribadi mempersiapkan SKD CPNS. Jangan menggunakan, menyalin, atau mengklaim soal asli CPNS/BKN. Semua soal harus berupa soal latihan original yang mengikuti pola kompetensi TWK, TIU, dan TKP.

Gunakan stack:
- Laravel terbaru
- MySQL
- Tailwind CSS
- Blade atau Livewire
- Filament Admin Panel
- Laravel Breeze untuk auth jika diperlukan

Fitur utama:
1. Authentication user dan admin.
2. Role user: admin dan user.
3. Dashboard user dengan statistik skor terakhir, riwayat ujian, progres modul, kelemahan terbesar, dan rekomendasi belajar.
4. Admin panel untuk mengelola kategori, subkategori, soal, opsi jawaban, modul belajar, dan exam package.
5. Struktur kategori: TWK, TIU, TKP.
6. TWK dan TIU menggunakan score_type binary. Jawaban benar bernilai 5, salah/kosong bernilai 0.
7. TKP menggunakan score_type weighted. Setiap opsi A–E memiliki skor 1 sampai 5, kosong bernilai 0.
8. Buat mode simulasi full SKD berisi 110 soal: 30 TWK, 35 TIU, 45 TKP.
9. Durasi simulasi full SKD adalah 100 menit.
10. Buat mode latihan per kategori/subkategori dengan jumlah soal 5, 10, 20, atau 30.
11. Buat mode review tanpa timer.
12. Buat mode ulangi soal salah.
13. Halaman ujian harus memiliki timer countdown, navigasi nomor soal, tombol sebelumnya/selanjutnya, tombol tandai ragu-ragu, dan tombol submit.
14. Jawaban harus autosave setiap user memilih opsi.
15. Jika waktu habis, sistem otomatis submit.
16. Setelah submit, tampilkan skor total, TWK, TIU, TKP, status passing grade, jumlah benar/salah/kosong, pembahasan soal, dan rekomendasi modul.
17. Passing grade default: TWK 65, TIU 80, TKP 166. Simpan di app_settings agar bisa diubah.
18. Buat migration, model, relationship, controller, request validation, policy, seeder, dan UI yang rapi.
19. Buat seed data awal: kategori, subkategori, modul belajar, dan minimal 60 soal original: 20 TWK, 20 TIU, 20 TKP.
20. Pastikan setiap soal memiliki explanation/pembahasan.
21. Buat tampilan clean, modern, responsive, dan nyaman untuk belajar.
22. Tambahkan label di footer atau halaman ujian: “Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi.”

Database minimal:
- users
- categories
- subcategories
- questions
- question_options
- exam_packages
- exam_package_questions
- exam_sessions
- exam_answers
- learning_modules
- module_progress
- app_settings

Tolong implementasikan secara bertahap:
Tahap 1: setup Laravel, auth, role, migration, model, seeder.
Tahap 2: admin panel Filament untuk CRUD data.
Tahap 3: halaman dashboard user.
Tahap 4: halaman simulasi ujian dengan timer dan autosave.
Tahap 5: scoring engine dan halaman hasil.
Tahap 6: modul belajar dan rekomendasi belajar.
Tahap 7: polish UI dan testing.

Setelah setiap tahap selesai, update file PROJECT_CONTEXT.md berisi apa saja yang sudah dibuat, struktur file penting, command yang perlu dijalankan, dan next step.
```

---

## 17. Prompt Khusus Membuat Bank Soal

Gunakan prompt ini setelah struktur aplikasi siap.

```text
Buatkan seed data bank soal latihan CPNS original untuk aplikasi CAT CPNS Personal Trainer. Jangan menyalin soal asli CPNS, jangan mengambil dari sumber berhak cipta, dan jangan mengklaim sebagai bocoran soal. Buat soal original yang mengikuti pola kompetensi SKD.

Format soal:
- category: TWK/TIU/TKP
- subcategory
- difficulty: easy/medium/hard
- score_type: binary/weighted
- question_text
- options A–E
- explanation

Aturan:
1. TWK dan TIU harus memiliki satu jawaban benar.
2. TWK dan TIU benar = 5, salah = 0.
3. TKP harus memiliki skor 1 sampai 5 untuk masing-masing opsi.
4. TKP tidak boleh memiliki “jawaban benar mutlak”, tetapi harus ada opsi terbaik dengan skor 5.
5. Setiap pembahasan minimal 2 kalimat.
6. Bahasa harus natural, jelas, dan tidak ambigu.
7. Level difficulty harus bervariasi.

Buat total 300 soal original:
- 100 TWK
- 100 TIU
- 100 TKP

Pembagian TWK:
- Pancasila: 15
- UUD 1945: 15
- Nasionalisme: 15
- NKRI: 15
- Bhinneka Tunggal Ika: 10
- Integritas: 10
- Bela Negara: 10
- Sejarah Perjuangan Bangsa: 10

Pembagian TIU:
- Sinonim: 10
- Antonim: 10
- Analogi Verbal: 15
- Silogisme: 15
- Deret Angka: 15
- Aritmetika: 15
- Perbandingan: 10
- Penalaran Analitis: 10

Pembagian TKP:
- Pelayanan Publik: 15
- Profesionalisme: 15
- Integritas: 15
- Kerja Sama: 10
- Pengendalian Diri: 10
- Adaptasi: 10
- Teknologi Informasi: 10
- Pengambilan Keputusan: 10
- Kreativitas dan Inovasi: 5

Outputkan sebagai Laravel Seeder yang mengisi tabel categories, subcategories, questions, dan question_options. Pastikan kode valid, rapi, dan tidak terlalu berat dijalankan.
```

---

## 18. Prompt Khusus Membuat Modul Belajar

```text
Buatkan modul belajar untuk aplikasi CAT CPNS Personal Trainer. Modul harus original, ringkas, mudah dipahami, dan fokus untuk persiapan SKD CPNS.

Buat modul untuk kategori:
1. TWK
2. TIU
3. TKP

Setiap modul harus memiliki:
- title
- slug
- category
- subcategory
- content dalam format HTML atau Markdown
- ringkasan konsep
- poin penting
- contoh penerapan
- tips menjawab soal
- latihan singkat 3 soal di akhir modul

Buat minimal 30 modul:
- 10 modul TWK
- 10 modul TIU
- 10 modul TKP

Jangan menyalin materi berhak cipta. Buat penjelasan original dan edukatif. Outputkan sebagai Laravel Seeder untuk tabel learning_modules.
```

---

## 19. Prompt Khusus Halaman Ujian

```text
Buat halaman ujian CAT untuk aplikasi Laravel ini.

Kebutuhan halaman:
1. Menampilkan satu soal aktif.
2. Menampilkan pilihan A–E.
3. Menampilkan timer countdown.
4. Timer harus tetap akurat berdasarkan started_at dan duration_minutes dari server, bukan hanya JavaScript lokal.
5. User bisa klik nomor soal untuk berpindah.
6. Nomor soal memiliki status:
   - belum dijawab
   - sudah dijawab
   - ragu-ragu
   - aktif
7. Jawaban autosave via fetch/AJAX setiap user memilih opsi.
8. Tombol tandai ragu-ragu menyimpan is_flagged.
9. Tombol submit menampilkan konfirmasi.
10. Jika waktu habis, auto-submit.
11. Cegah user mengubah jawaban setelah exam_session status submitted/expired.
12. Buat UI responsive.
13. Tampilkan label kategori dan subkategori soal.
14. Jangan tampilkan pembahasan selama ujian berlangsung.

Buat controller, route, blade/livewire component, request validation, dan JavaScript yang diperlukan.
```

---

## 20. Prompt Khusus Scoring Engine

```text
Buat service class Laravel bernama ExamScoringService untuk menghitung hasil ujian.

Rules:
1. Untuk TWK dan TIU, jika selected_option.is_correct true maka skor 5, selain itu 0.
2. Untuk TKP, skor berasal dari selected_option.score, rentang 1 sampai 5.
3. Jika tidak dijawab, skor 0.
4. Hitung score_total, score_twk, score_tiu, score_tkp.
5. Hitung jumlah benar, salah, kosong untuk TWK dan TIU.
6. Hitung rata-rata skor TKP.
7. Tentukan passed_twk jika score_twk >= passing_grade_twk.
8. Tentukan passed_tiu jika score_tiu >= passing_grade_tiu.
9. Tentukan passed_tkp jika score_tkp >= passing_grade_tkp.
10. Tentukan passed_total jika semua komponen lulus.
11. Simpan skor ke exam_sessions dan exam_answers.
12. Buat method getWeaknessAnalysis(user_id atau exam_session_id) yang mengelompokkan kesalahan berdasarkan subcategory.
13. Buat rekomendasi learning_modules berdasarkan 3 subcategory terlemah.

Tambahkan unit test untuk memastikan scoring benar.
```

---

## 21. Prompt Khusus Dashboard User

```text
Buat dashboard user untuk aplikasi CAT CPNS Personal Trainer.

Dashboard harus menampilkan:
1. Skor tryout terakhir.
2. Status lulus/gagal passing grade.
3. Skor TWK, TIU, TKP.
4. Riwayat 5 ujian terakhir.
5. Grafik perkembangan skor dari waktu ke waktu.
6. Subkategori terlemah.
7. Rekomendasi modul belajar.
8. Progres modul belajar.
9. Tombol mulai simulasi full SKD.
10. Tombol latihan per materi.

Gunakan Tailwind CSS. Buat tampilan clean, modern, responsive, dan nyaman untuk belajar.
```

---

## 22. Prompt Khusus Testing

```text
Lakukan audit dan testing aplikasi CAT CPNS Personal Trainer.

Cek hal berikut:
1. Migration berjalan tanpa error.
2. Seeder berjalan tanpa error.
3. Login/register berjalan.
4. Role admin dan user benar.
5. Admin bisa CRUD kategori, subkategori, soal, opsi, modul, dan paket ujian.
6. User bisa mulai ujian.
7. Timer berjalan akurat.
8. Jawaban autosave.
9. Fitur ragu-ragu berjalan.
10. Auto-submit saat waktu habis.
11. Scoring TWK/TIU benar.
12. Scoring TKP benar.
13. Passing grade benar.
14. Halaman hasil tampil benar.
15. Pembahasan tampil setelah submit.
16. User tidak bisa mengubah jawaban setelah submit.
17. Responsif di mobile.
18. Tidak ada error console browser.
19. Tidak ada route yang bocor untuk user non-admin.
20. Tambahkan test jika diperlukan.

Jika menemukan bug, perbaiki dan update PROJECT_CONTEXT.md.
```

---

## 23. Prompt Lanjutan untuk Membuat Versi Lebih Canggih

```text
Kembangkan aplikasi ini menjadi lebih canggih dengan fitur:
1. AI weakness analysis.
2. Jadwal belajar otomatis 30 hari.
3. Target skor pribadi.
4. Kalender belajar.
5. Streak belajar harian.
6. Export hasil ujian ke PDF.
7. Import soal dari Excel.
8. Mode random question generator.
9. Mode fokus kelemahan.
10. Statistik waktu pengerjaan per soal.

Tetap jaga agar soal adalah latihan original, bukan soal asli CPNS/BKN.
```

---

## 24. Acceptance Criteria

Aplikasi dianggap selesai untuk MVP jika:

1. User bisa login.
2. Admin bisa input soal.
3. User bisa mengerjakan simulasi 110 soal dengan timer 100 menit.
4. Jawaban tersimpan otomatis.
5. Sistem bisa menghitung skor TWK, TIU, TKP.
6. Sistem bisa menentukan passing grade.
7. User bisa melihat pembahasan.
8. User bisa melihat kelemahan berdasarkan subkategori.
9. User bisa membaca modul belajar.
10. Aplikasi bisa berjalan lokal tanpa error.

---

## 25. Catatan Penting untuk Pengembangan

Prioritas pengerjaan:

1. Database dan seeder.
2. Admin panel soal.
3. Halaman ujian.
4. Timer dan autosave.
5. Scoring engine.
6. Halaman hasil.
7. Modul belajar.
8. Dashboard analisis.
9. UI polish.

Jangan mulai dari fitur AI dulu. Fitur paling penting adalah sistem ujian, bank soal, skor, dan pembahasan.

---

## 26. Command Awal Laravel

Contoh command awal:

```bash
composer create-project laravel/laravel cat-cpns-trainer
cd cat-cpns-trainer
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
php artisan migrate
composer require filament/filament
php artisan filament:install --panels
```

Setelah itu jalankan Codex dengan PRD ini sebagai konteks utama.

---

## 27. Instruksi untuk Codex agar Tidak Kehilangan Konteks

Buat file `PROJECT_CONTEXT.md` di root project dengan isi awal:

```markdown
# PROJECT_CONTEXT — CAT CPNS Personal Trainer

Aplikasi ini adalah web latihan pribadi untuk persiapan SKD CPNS. Soal yang digunakan adalah soal latihan original, bukan soal asli atau bocoran resmi.

## Stack
- Laravel
- MySQL
- Tailwind CSS
- Filament
- Blade/Livewire

## Core Features
- Auth user/admin
- Bank soal TWK/TIU/TKP
- Simulasi CAT 110 soal/100 menit
- Timer
- Autosave jawaban
- Tandai ragu-ragu
- Scoring otomatis
- Pembahasan soal
- Modul belajar
- Analisis kelemahan

## Scoring
TWK/TIU:
- benar 5
- salah/kosong 0

TKP:
- opsi bernilai 1–5
- kosong 0

## Passing Grade Default
- TWK 65
- TIU 80
- TKP 166

## Important Rule
Jangan menyalin atau mengklaim soal asli CPNS/BKN. Semua soal harus original untuk latihan.
```

Setiap selesai perubahan besar, minta Codex update file ini.

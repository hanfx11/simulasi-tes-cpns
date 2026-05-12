<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ExamPackage;
use App\Models\LearningModule;
use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CpnsContentSeeder extends Seeder
{
    private array $categories = [];

    private array $subcategories = [];

    private array $questionCounters = [];

    public function run(): void
    {
        $this->seedTaxonomy();
        $this->seedModules();
        $this->seedQuestions();
        $this->seedExamPackage();
    }

    private function seedTaxonomy(): void
    {
        $data = [
            'TWK' => [
                'name' => 'Tes Wawasan Kebangsaan',
                'description' => 'Latihan original untuk Pancasila, UUD 1945, nasionalisme, NKRI, integritas, dan bela negara.',
                'subcategories' => ['Pancasila', 'UUD 1945', 'Nasionalisme', 'NKRI', 'Bhinneka Tunggal Ika', 'Integritas', 'Bela Negara', 'Sejarah Perjuangan Bangsa'],
            ],
            'TIU' => [
                'name' => 'Tes Intelegensia Umum',
                'description' => 'Latihan original untuk kemampuan verbal, numerik, logika, analitis, dan figural.',
                'subcategories' => ['Sinonim', 'Antonim', 'Analogi Verbal', 'Silogisme', 'Deret Angka', 'Aritmetika', 'Perbandingan', 'Penalaran Analitis'],
            ],
            'TKP' => [
                'name' => 'Tes Karakteristik Pribadi',
                'description' => 'Latihan original untuk pelayanan publik, profesionalisme, integritas, kerja sama, adaptasi, dan pengambilan keputusan.',
                'subcategories' => ['Pelayanan Publik', 'Profesionalisme', 'Integritas', 'Kerja Sama', 'Pengendalian Diri', 'Adaptasi', 'Teknologi Informasi', 'Pengambilan Keputusan', 'Kreativitas dan Inovasi'],
            ],
        ];

        foreach ($data as $code => $categoryData) {
            $category = Category::query()->updateOrCreate(
                ['code' => $code],
                ['name' => $categoryData['name'], 'description' => $categoryData['description']],
            );

            $this->categories[$code] = $category;

            foreach ($categoryData['subcategories'] as $name) {
                $this->subcategories[$code][$name] = Subcategory::query()->updateOrCreate(
                    ['category_id' => $category->id, 'name' => $name],
                    ['description' => "Materi dan latihan {$code} tentang {$name}."],
                );
            }
        }
    }

    private function seedModules(): void
    {
        $modulePlan = [
            'TWK' => ['Pancasila', 'UUD 1945', 'Nasionalisme', 'NKRI', 'Bhinneka Tunggal Ika', 'Integritas', 'Bela Negara', 'Sejarah Perjuangan Bangsa', 'Pancasila', 'UUD 1945'],
            'TIU' => ['Sinonim', 'Antonim', 'Analogi Verbal', 'Silogisme', 'Deret Angka', 'Aritmetika', 'Perbandingan', 'Penalaran Analitis', 'Deret Angka', 'Aritmetika'],
            'TKP' => ['Pelayanan Publik', 'Profesionalisme', 'Integritas', 'Kerja Sama', 'Pengendalian Diri', 'Adaptasi', 'Teknologi Informasi', 'Pengambilan Keputusan', 'Kreativitas dan Inovasi', 'Pelayanan Publik'],
        ];

        $order = 1;

        foreach ($modulePlan as $code => $subcategories) {
            foreach ($subcategories as $index => $subcategoryName) {
                $title = "{$code} - {$subcategoryName}".($index >= 8 ? ' Lanjutan' : '');

                LearningModule::query()->updateOrCreate(
                    ['slug' => Str::slug($title)],
                    [
                        'category_id' => $this->categories[$code]->id,
                        'subcategory_id' => $this->subcategories[$code][$subcategoryName]->id,
                        'title' => $title,
                        'content' => $this->moduleContent($code, $subcategoryName),
                        'order_number' => $order++,
                        'status' => 'active',
                    ],
                );
            }
        }
    }

    private function seedQuestions(): void
    {
        $twkCounts = [
            'Pancasila' => 15,
            'UUD 1945' => 15,
            'Nasionalisme' => 15,
            'NKRI' => 15,
            'Bhinneka Tunggal Ika' => 10,
            'Integritas' => 10,
            'Bela Negara' => 10,
            'Sejarah Perjuangan Bangsa' => 10,
        ];

        $tiuCounts = [
            'Sinonim' => 10,
            'Antonim' => 10,
            'Analogi Verbal' => 15,
            'Silogisme' => 15,
            'Deret Angka' => 15,
            'Aritmetika' => 15,
            'Perbandingan' => 10,
            'Penalaran Analitis' => 10,
        ];

        $tkpCounts = [
            'Pelayanan Publik' => 15,
            'Profesionalisme' => 15,
            'Integritas' => 15,
            'Kerja Sama' => 10,
            'Pengendalian Diri' => 10,
            'Adaptasi' => 10,
            'Teknologi Informasi' => 10,
            'Pengambilan Keputusan' => 10,
            'Kreativitas dan Inovasi' => 5,
        ];

        foreach ($twkCounts as $subcategory => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $this->storeQuestion($this->twkQuestion($subcategory, $i));
            }
        }

        foreach ($tiuCounts as $subcategory => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $this->storeQuestion($this->tiuQuestion($subcategory, $i));
            }
        }

        foreach ($tkpCounts as $subcategory => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $this->storeQuestion($this->tkpQuestion($subcategory, $i));
            }
        }
    }

    private function storeQuestion(array $data): void
    {
        $categoryId = $this->categories[$data['category']]->id;
        $subcategoryId = $this->subcategories[$data['category']][$data['subcategory']]->id;
        $key = "{$data['category']}|{$data['subcategory']}";
        $position = ($this->questionCounters[$key] ?? 0) + 1;
        $this->questionCounters[$key] = $position;

        $question = Question::query()
            ->where('category_id', $categoryId)
            ->where('subcategory_id', $subcategoryId)
            ->orderBy('id')
            ->skip($position - 1)
            ->first() ?? new Question();

        $question->fill([
            'category_id' => $categoryId,
            'subcategory_id' => $subcategoryId,
            'question_text' => $data['question_text'],
            'explanation' => $data['explanation'],
            'difficulty' => $data['difficulty'],
            'score_type' => $data['score_type'],
            'status' => 'active',
        ])->save();

        foreach ($data['options'] as $option) {
            $question->options()->updateOrCreate(
                ['option_label' => $option['label']],
                [
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'] ?? null,
                    'score' => $option['score'] ?? null,
                ],
            );
        }
    }

    private function twkQuestion(string $subcategory, int $number): array
    {
        $difficulty = $this->difficulty($number);
        $correctIndex = ($number - 1) % 5;
        $correct = [
            'Mengutamakan kepentingan bersama dan tetap mengikuti aturan yang berlaku.',
            'Menggunakan musyawarah untuk mencari keputusan yang dapat dipertanggungjawabkan.',
            'Menjaga persatuan dengan menghormati perbedaan di lingkungan kerja.',
            'Menunjukkan kejujuran dan keberanian menolak penyimpangan.',
            'Menyelesaikan masalah dengan adil tanpa membeda-bedakan latar belakang.',
        ][$correctIndex];

        $options = [
            'A' => 'Mengabaikan prosedur karena hasil akhir dianggap lebih penting.',
            'B' => 'Memaksakan pendapat pribadi agar keputusan lebih cepat dibuat.',
            'C' => $correct,
            'D' => 'Mendahulukan kelompok sendiri meskipun merugikan pihak lain.',
            'E' => 'Menunda keputusan tanpa alasan agar tidak perlu bertanggung jawab.',
        ];

        return [
            'category' => 'TWK',
            'subcategory' => $subcategory,
            'difficulty' => $difficulty,
            'score_type' => 'binary',
            'question_text' => $this->twkPrompt($subcategory, $number),
            'explanation' => "Pilihan C paling tepat karena menempatkan nilai {$subcategory} dalam tindakan nyata yang tertib, bertanggung jawab, dan berorientasi kepentingan publik. Pilihan lain menunjukkan sikap yang terlalu subjektif, tidak adil, memaksakan kehendak, atau mengabaikan prosedur.",
            'options' => $this->binaryOptions($options, 'C'),
        ];
    }

    private function twkPrompt(string $subcategory, int $number): string
    {
        $prompts = [
            'Pancasila' => [
                'Dalam rapat warga, muncul usulan penggunaan dana bersama untuk kegiatan yang hanya menguntungkan kelompok tertentu. Sikap yang paling sesuai dengan nilai Pancasila adalah...',
                'Seorang pegawai menemukan bahwa keputusan tim dapat merugikan kelompok masyarakat kecil. Tindakan yang paling mencerminkan pengamalan Pancasila adalah...',
                'Ketika terjadi perbedaan pendapat di lingkungan kerja, seorang aparatur diminta mengambil sikap. Sikap yang paling tepat adalah...',
            ],
            'UUD 1945' => [
                'Sebuah kebijakan internal harus dibuat cepat, tetapi tetap wajib mengikuti aturan yang berlaku. Tindakan yang paling sesuai dengan prinsip konstitusional adalah...',
                'Seorang aparatur diminta mengabaikan prosedur karena dianggap memperlambat layanan. Sikap yang paling tepat menurut prinsip negara hukum adalah...',
                'Dalam pelayanan publik, terdapat permintaan perlakuan khusus tanpa dasar hukum. Respons yang paling sesuai dengan UUD 1945 adalah...',
            ],
            'Nasionalisme' => [
                'Di media sosial, beredar informasi yang dapat memecah persatuan masyarakat. Sikap yang menunjukkan nasionalisme yang tepat adalah...',
                'Seorang pegawai berbeda pandangan politik dengan rekan kerjanya. Tindakan yang mencerminkan nasionalisme dalam lingkungan kerja adalah...',
                'Dalam kegiatan pelayanan, terdapat warga dari latar belakang berbeda yang membutuhkan bantuan. Sikap nasionalis yang tepat adalah...',
            ],
            'NKRI' => [
                'Sebuah kelompok mengajak warga menolak aturan pemerintah daerah tanpa menempuh jalur resmi. Sikap yang paling sesuai untuk menjaga keutuhan NKRI adalah...',
                'Dalam diskusi publik, muncul pernyataan yang merendahkan daerah lain. Respons yang paling tepat adalah...',
                'Seorang aparatur ditempatkan di wilayah dengan budaya berbeda. Sikap yang mendukung keutuhan NKRI adalah...',
            ],
            'Bhinneka Tunggal Ika' => [
                'Dalam satu tim terdapat anggota dengan agama, suku, dan kebiasaan berbeda. Sikap yang paling sesuai dengan Bhinneka Tunggal Ika adalah...',
                'Seorang warga meminta layanan tetapi memiliki bahasa dan kebiasaan yang berbeda dari petugas. Respons yang paling tepat adalah...',
                'Perbedaan pendapat muncul karena latar belakang budaya yang tidak sama. Tindakan yang paling tepat adalah...',
            ],
            'Integritas' => [
                'Seorang pegawai mengetahui ada rekan yang memanipulasi data laporan. Tindakan yang paling menunjukkan integritas adalah...',
                'Atasan meminta Anda menandatangani dokumen yang belum sesuai data. Sikap yang paling tepat adalah...',
                'Anda diberi hadiah oleh pihak yang sedang mengurus layanan agar prosesnya dipercepat. Respons yang paling berintegritas adalah...',
            ],
            'Bela Negara' => [
                'Seorang warga menyebarkan informasi palsu yang dapat menimbulkan kepanikan. Bentuk bela negara yang tepat dalam situasi tersebut adalah...',
                'Di lingkungan kerja terjadi kelalaian yang dapat mengganggu layanan publik. Sikap bela negara yang tepat adalah...',
                'Dalam kondisi darurat, masyarakat membutuhkan koordinasi dan informasi yang benar. Tindakan yang paling mencerminkan bela negara adalah...',
            ],
            'Sejarah Perjuangan Bangsa' => [
                'Nilai utama yang dapat diteladani dari perjuangan para pendiri bangsa ketika menghadapi perbedaan pendapat adalah...',
                'Dalam konteks kerja modern, semangat perjuangan bangsa paling tepat diwujudkan melalui...',
                'Ketika menghadapi kepentingan pribadi yang bertentangan dengan kepentingan umum, teladan sejarah perjuangan bangsa mengarahkan kita untuk...',
            ],
        ];

        $items = $prompts[$subcategory] ?? $prompts['Pancasila'];
        $contexts = [
            'Keputusan perlu dibuat dalam forum resmi dan berdampak pada banyak pihak.',
            'Situasi terjadi ketika pelayanan publik sedang diawasi oleh masyarakat.',
            'Masalah muncul karena ada kepentingan pribadi yang bertentangan dengan kepentingan umum.',
            'Kondisi menuntut sikap adil, tertib, dan dapat dipertanggungjawabkan.',
            'Tindakan yang dipilih akan menjadi contoh bagi rekan kerja lain.',
        ];

        return $items[($number - 1) % count($items)].' '.$contexts[(int) floor(($number - 1) / count($items)) % count($contexts)];
    }

    private function tiuQuestion(string $subcategory, int $number): array
    {
        return match ($subcategory) {
            'Deret Angka' => $this->deretQuestion($number),
            'Aritmetika' => $this->aritmetikaQuestion($number),
            'Perbandingan' => $this->perbandinganQuestion($number),
            'Silogisme' => $this->silogismeQuestion($number),
            'Analogi Verbal' => $this->analogiQuestion($number),
            'Antonim' => $this->wordQuestion($subcategory, $number, false),
            'Sinonim' => $this->wordQuestion($subcategory, $number, true),
            default => $this->analitisQuestion($number),
        };
    }

    private function deretQuestion(int $number): array
    {
        $start = 2 + $number;
        $step = ($number % 4) + 2;
        $answer = $start + ($step * 4);
        $text = "{$start}, ".($start + $step).', '.($start + $step * 2).', '.($start + $step * 3).', ...';

        return $this->binaryQuestion('TIU', 'Deret Angka', $number, "Tentukan angka berikutnya dari deret: {$text}", (string) $answer, [
            (string) ($answer - $step),
            (string) ($answer + 1),
            (string) ($answer + $step),
            (string) ($answer + ($step * 2)),
        ], "Pola deret bertambah {$step} secara konsisten. Karena itu angka setelah ".($start + $step * 3)." adalah {$answer}.");
    }

    private function aritmetikaQuestion(int $number): array
    {
        $price = 3000 + ($number * 500);
        $qty = 4 + ($number % 5);
        $discount = 1000 + ($number * 100);
        $answer = ($price * $qty) - $discount;

        return $this->binaryQuestion('TIU', 'Aritmetika', $number, "Sebuah alat tulis seharga Rp{$price}. Jika dibeli {$qty} buah dan mendapat potongan Rp{$discount}, total yang harus dibayar adalah...", 'Rp'.number_format($answer, 0, ',', '.'), [
            'Rp'.number_format($answer - 1000, 0, ',', '.'),
            'Rp'.number_format($answer + 500, 0, ',', '.'),
            'Rp'.number_format($answer + 1000, 0, ',', '.'),
            'Rp'.number_format($answer + 1500, 0, ',', '.'),
        ], "Total awal adalah {$qty} x Rp{$price}, kemudian dikurangi potongan Rp{$discount}. Hasil akhirnya adalah Rp".number_format($answer, 0, ',', '.').'.');
    }

    private function perbandinganQuestion(int $number): array
    {
        $a = 2 + ($number % 4);
        $b = $a + 3;
        $unit = 5 + $number;
        $answer = $b * $unit;

        return $this->binaryQuestion('TIU', 'Perbandingan', $number, "Perbandingan data A dan B adalah {$a}:{$b}. Jika A bernilai ".($a * $unit).", maka nilai B adalah...", (string) $answer, [
            (string) ($answer - $unit),
            (string) ($answer + $unit),
            (string) ($answer + 2),
            (string) ($answer - 2),
        ], "Nilai satu bagian adalah ".($a * $unit)." dibagi {$a}, yaitu {$unit}. Maka B bernilai {$b} bagian atau {$answer}.");
    }

    private function silogismeQuestion(int $number): array
    {
        $items = [
            ['Semua pegawai yang mengikuti briefing memahami prosedur baru. Sebagian staf loket mengikuti briefing.', 'Sebagian staf loket memahami prosedur baru.', 'Semua staf loket pasti mengikuti briefing.', 'Tidak ada staf loket yang memahami prosedur baru.', 'Semua pegawai yang memahami prosedur baru adalah staf loket.', 'Sebagian pegawai yang mengikuti briefing tidak bekerja di loket.'],
            ['Setiap dokumen yang telah diverifikasi dapat diproses lebih lanjut. Beberapa berkas pendaftar telah diverifikasi.', 'Beberapa berkas pendaftar dapat diproses lebih lanjut.', 'Semua berkas pendaftar pasti telah diverifikasi.', 'Tidak ada berkas pendaftar yang dapat diproses.', 'Semua dokumen yang diproses adalah berkas pendaftar.', 'Berkas yang belum diverifikasi pasti ditolak.'],
            ['Semua peserta yang memenuhi syarat administrasi berhak mengikuti tahap berikutnya. Sebagian pelamar daerah X memenuhi syarat administrasi.', 'Sebagian pelamar daerah X berhak mengikuti tahap berikutnya.', 'Semua pelamar daerah X berhak mengikuti tahap berikutnya.', 'Tidak ada pelamar daerah X yang memenuhi syarat.', 'Semua peserta tahap berikutnya berasal dari daerah X.', 'Sebagian pelamar daerah X tidak pernah mendaftar.'],
            ['Semua layanan yang terdokumentasi dapat dievaluasi. Sebagian layanan unit A terdokumentasi.', 'Sebagian layanan unit A dapat dievaluasi.', 'Semua layanan unit A terdokumentasi.', 'Tidak ada layanan unit A yang dapat dievaluasi.', 'Semua layanan yang dievaluasi berasal dari unit A.', 'Layanan yang tidak terdokumentasi pasti berkualitas buruk.'],
            ['Setiap laporan yang lengkap dapat diaudit. Beberapa laporan triwulan lengkap.', 'Beberapa laporan triwulan dapat diaudit.', 'Semua laporan triwulan lengkap.', 'Tidak ada laporan triwulan yang dapat diaudit.', 'Semua laporan yang diaudit adalah laporan triwulan.', 'Laporan yang tidak lengkap pasti tidak pernah dibuat.'],
        ];
        $item = $items[($number - 1) % count($items)];

        return $this->binaryQuestion('TIU', 'Silogisme', $number, "{$item[0]} Kesimpulan yang paling tepat adalah...", $item[1], [
            $item[2],
            $item[3],
            $item[4],
            $item[5],
        ], 'Kesimpulan harus mengikuti hubungan premis tanpa memperluas makna. Jika semua A adalah B dan sebagian C adalah A, maka sebagian C adalah B.');
    }

    private function analogiQuestion(int $number): array
    {
        $pairs = [
            ['Dokter', 'Rumah Sakit', 'Guru', 'Sekolah'],
            ['Nelayan', 'Laut', 'Petani', 'Sawah'],
            ['Pilot', 'Pesawat', 'Masinis', 'Kereta'],
            ['Penulis', 'Buku', 'Pelukis', 'Lukisan'],
            ['Hakim', 'Pengadilan', 'Dosen', 'Kampus'],
            ['Apoteker', 'Obat', 'Arsitek', 'Bangunan'],
            ['Editor', 'Naskah', 'Auditor', 'Laporan'],
            ['Kompas', 'Arah', 'Termometer', 'Suhu'],
            ['Benih', 'Tanaman', 'Ide', 'Inovasi'],
            ['Perpustakaan', 'Buku', 'Arsip', 'Dokumen'],
            ['Kunci', 'Pintu', 'Sandi', 'Akses'],
            ['Kalender', 'Tanggal', 'Peta', 'Lokasi'],
            ['Jembatan', 'Penghubung', 'Aturan', 'Pedoman'],
            ['Murid', 'Belajar', 'Pegawai', 'Bekerja'],
            ['Perawat', 'Pasien', 'Petugas', 'Pemohon'],
        ];
        [$a, $b, $c, $answer] = $pairs[$number % count($pairs)];

        return $this->binaryQuestion('TIU', 'Analogi Verbal', $number, "{$a} : {$b} = {$c} : ...", $answer, ['Pasien', 'Meja', 'Kantor', 'Arsip'], "Hubungan pasangan pertama adalah profesi dengan tempat kerja atau hasil utamanya. Dengan pola yang sama, {$c} berhubungan paling tepat dengan {$answer}.");
    }

    private function wordQuestion(string $subcategory, int $number, bool $synonym): array
    {
        $words = [
            ['cermat', 'teliti', 'ceroboh'],
            ['dinamis', 'aktif', 'statis'],
            ['efisien', 'hemat', 'boros'],
            ['konsisten', 'taat asas', 'berubah-ubah'],
            ['transparan', 'terbuka', 'tertutup'],
            ['akurat', 'tepat', 'keliru'],
            ['objektif', 'netral', 'subjektif'],
            ['relevan', 'berkaitan', 'tidak berkaitan'],
            ['prioritas', 'utama', 'tambahan'],
            ['valid', 'sahih', 'tidak sah'],
        ];
        [$word, $same, $opposite] = $words[($number - 1) % count($words)];
        $answer = $synonym ? $same : $opposite;
        $prompt = $synonym ? 'sinonim' : 'antonim';

        return $this->binaryQuestion('TIU', $subcategory, $number, "Pilih {$prompt} yang paling tepat untuk kata '{$word}'.", $answer, ['cepat', 'rapi', 'kuat', 'umum'], "Kata '{$answer}' adalah pilihan yang paling sesuai sebagai {$prompt} dari '{$word}' dalam konteks bahasa Indonesia umum. Pilihan lain tidak memiliki hubungan makna yang sekuat pilihan tersebut.");
    }

    private function analitisQuestion(int $number): array
    {
        $items = [
            ['Dalam antrean, Rani berada di depan Budi. Sari berada di belakang Budi. Jika urutan hanya memuat ketiganya, siapa yang berada di posisi tengah?', 'Budi', ['Rani', 'Sari', 'Tidak dapat ditentukan', 'Rani dan Sari'], 'Rani berada di depan Budi dan Sari berada di belakang Budi. Maka urutannya Rani, Budi, Sari.'],
            ['Empat berkas A, B, C, dan D disusun berurutan. A diletakkan sebelum C, B setelah C, dan D sebelum A. Berkas mana yang berada paling awal?', 'D', ['A', 'B', 'C', 'Tidak dapat ditentukan'], 'D berada sebelum A, A sebelum C, dan B setelah C. Urutan yang sesuai adalah D, A, C, B.'],
            ['Rapat P dimulai setelah rapat Q. Rapat R dimulai sebelum Q. Jika hanya ada tiga rapat tersebut, rapat yang dimulai paling akhir adalah...', 'P', ['Q', 'R', 'Tidak dapat ditentukan', 'P dan Q'], 'R dimulai sebelum Q, sedangkan P setelah Q. Maka P paling akhir.'],
            ['Tiga pegawai, yaitu Andi, Bela, dan Citra, menangani loket berbeda. Andi tidak menangani loket 1, Bela menangani loket 2, dan Citra tidak menangani loket 3. Jika setiap loket diisi satu orang, Andi menangani loket...', '3', ['1', '2', 'Tidak dapat ditentukan', '1 dan 3'], 'Bela sudah di loket 2. Andi tidak di loket 1, sehingga Andi di loket 3 dan Citra di loket 1.'],
            ['Jika laporan X selesai, maka rapat evaluasi dilakukan. Rapat evaluasi tidak dilakukan. Kesimpulan yang tepat adalah...', 'Laporan X tidak selesai.', ['Laporan X selesai.', 'Rapat evaluasi tetap dilakukan.', 'Tidak ada kesimpulan yang mungkin.', 'Laporan X pasti disetujui.'], 'Bentuk logikanya adalah jika P maka Q. Jika Q tidak terjadi, maka P tidak terjadi.'],
        ];
        $item = $items[($number - 1) % count($items)];

        return $this->binaryQuestion('TIU', 'Penalaran Analitis', $number, $item[0], $item[1], $item[2], $item[3]);
    }

    private function binaryQuestion(string $category, string $subcategory, int $number, string $questionText, string $answer, array $distractors, string $explanation): array
    {
        $options = [
            'A' => $distractors[0],
            'B' => $answer,
            'C' => $distractors[1],
            'D' => $distractors[2],
            'E' => $distractors[3],
        ];

        return [
            'category' => $category,
            'subcategory' => $subcategory,
            'difficulty' => $this->difficulty($number),
            'score_type' => 'binary',
            'question_text' => $questionText,
            'explanation' => $explanation.' Soal ini adalah latihan original untuk memahami pola kompetensi, bukan soal resmi.',
            'options' => $this->binaryOptions($options, 'B'),
        ];
    }

    private function tkpQuestion(string $subcategory, int $number): array
    {
        $scenario = $this->tkpPrompt($subcategory, $number);

        return [
            'category' => 'TKP',
            'subcategory' => $subcategory,
            'difficulty' => $this->difficulty($number),
            'score_type' => 'weighted',
            'question_text' => $scenario,
            'explanation' => "Opsi dengan skor tertinggi menunjukkan respons yang tenang, etis, solutif, dan tetap sesuai prosedur. Opsi berskor rendah cenderung mengabaikan tanggung jawab, memperkeruh situasi, atau tidak berorientasi pada pelayanan dan hasil kerja.",
            'options' => [
                ['label' => 'A', 'text' => 'Menghindari situasi tersebut karena khawatir membuat kesalahan.', 'score' => 1],
                ['label' => 'B', 'text' => 'Menunggu instruksi tanpa mencoba memahami masalah yang terjadi.', 'score' => 2],
                ['label' => 'C', 'text' => 'Menyelesaikan bagian sendiri tetapi tidak berkoordinasi dengan pihak terkait.', 'score' => 3],
                ['label' => 'D', 'text' => 'Mengidentifikasi masalah, berkoordinasi secara sopan, dan memilih solusi sesuai prosedur.', 'score' => 5],
                ['label' => 'E', 'text' => 'Menyalahkan pihak lain agar tanggung jawab tidak tertuju kepada Anda.', 'score' => 1],
            ],
        ];
    }

    private function tkpPrompt(string $subcategory, int $number): string
    {
        $prompts = [
            'Pelayanan Publik' => [
                'Seorang warga datang dengan keluhan karena sudah beberapa kali mendapat informasi yang berbeda dari petugas. Respons yang paling tepat adalah...',
                'Antrean layanan sedang panjang, sementara ada pemohon yang terlihat kebingungan karena persyaratannya belum lengkap. Tindakan terbaik adalah...',
                'Sistem layanan sedang lambat dan masyarakat mulai gelisah. Sikap yang paling tepat adalah...',
            ],
            'Profesionalisme' => [
                'Anda menerima tugas mendadak dengan tenggat ketat, sementara tugas rutin juga belum selesai. Respons yang paling profesional adalah...',
                'Rekan kerja meminta Anda menyelesaikan pekerjaannya tanpa alasan yang jelas. Tindakan yang paling tepat adalah...',
                'Anda menemukan kesalahan kecil pada laporan yang sudah hampir dikirim. Respons terbaik adalah...',
            ],
            'Integritas' => [
                'Seorang kenalan meminta bantuan agar berkasnya diproses lebih dahulu dari antrean. Respons yang paling tepat adalah...',
                'Anda mengetahui ada data yang sengaja dibuat lebih baik dari kondisi sebenarnya. Tindakan terbaik adalah...',
                'Pihak luar menawarkan imbalan agar Anda memberi informasi internal. Respons yang paling tepat adalah...',
            ],
            'Kerja Sama' => [
                'Tim Anda berbeda pendapat tentang cara menyelesaikan tugas. Respons yang paling tepat adalah...',
                'Salah satu anggota tim kesulitan menyelesaikan bagiannya sehingga target bersama terancam. Tindakan terbaik adalah...',
                'Koordinasi antardivisi kurang lancar dan pekerjaan menjadi tertunda. Respons yang paling tepat adalah...',
            ],
            'Pengendalian Diri' => [
                'Seorang pengguna layanan berbicara dengan nada tinggi karena merasa dirugikan. Respons yang paling tepat adalah...',
                'Anda mendapat kritik keras di depan rekan kerja. Sikap terbaik adalah...',
                'Saat tekanan kerja meningkat, ada rekan yang menyalahkan Anda. Respons yang paling tepat adalah...',
            ],
            'Adaptasi' => [
                'Unit kerja menerapkan aplikasi baru yang belum Anda kuasai. Tindakan paling tepat adalah...',
                'Anda dipindahkan ke bidang kerja yang prosesnya berbeda dari kebiasaan sebelumnya. Respons terbaik adalah...',
                'Kebijakan layanan berubah dan sebagian masyarakat belum memahami prosedur baru. Sikap yang paling tepat adalah...',
            ],
            'Teknologi Informasi' => [
                'Data layanan harus diinput melalui sistem digital, tetapi beberapa rekan masih sering keliru. Respons terbaik adalah...',
                'Anda menerima tautan mencurigakan yang mengatasnamakan instansi. Tindakan paling tepat adalah...',
                'Sistem digital membuat proses kerja lebih cepat, tetapi ada data pribadi yang harus dilindungi. Sikap yang tepat adalah...',
            ],
            'Pengambilan Keputusan' => [
                'Anda harus memilih tindakan cepat ketika data belum sepenuhnya lengkap, tetapi layanan tidak boleh berhenti. Respons terbaik adalah...',
                'Dua pilihan solusi memiliki kelebihan dan risiko masing-masing. Cara mengambil keputusan yang paling tepat adalah...',
                'Atasan tidak berada di tempat, sementara ada masalah layanan yang perlu segera ditangani sesuai kewenangan Anda. Tindakan terbaik adalah...',
            ],
            'Kreativitas dan Inovasi' => [
                'Proses kerja di unit Anda berulang kali terlambat karena alur manual yang panjang. Respons terbaik adalah...',
                'Anda memiliki ide perbaikan layanan, tetapi belum pernah dicoba di unit kerja. Tindakan yang paling tepat adalah...',
                'Masyarakat sering menanyakan informasi yang sama setiap hari. Inovasi sederhana yang paling tepat adalah...',
            ],
        ];

        $items = $prompts[$subcategory] ?? $prompts['Pelayanan Publik'];
        $contexts = [
            'Kondisi ini terjadi saat target layanan harian tetap harus dipenuhi.',
            'Pada saat yang sama, pimpinan meminta setiap tindakan terdokumentasi dengan baik.',
            'Situasi melibatkan rekan kerja, pengguna layanan, dan batas kewenangan jabatan.',
            'Keputusan Anda akan memengaruhi kepercayaan masyarakat terhadap unit kerja.',
            'Masalah perlu diselesaikan tanpa memperburuk hubungan kerja di dalam tim.',
        ];

        return $items[($number - 1) % count($items)].' '.$contexts[(int) floor(($number - 1) / count($items)) % count($contexts)];
    }

    private function binaryOptions(array $options, string $correctLabel): array
    {
        $result = [];

        foreach ($options as $label => $text) {
            $result[] = [
                'label' => $label,
                'text' => $text,
                'is_correct' => $label === $correctLabel,
            ];
        }

        return $result;
    }

    private function difficulty(int $number): string
    {
        return ['easy', 'medium', 'hard'][$number % 3];
    }

    private function moduleContent(string $code, string $subcategory): string
    {
        $references = $this->referencesFor($code, $subcategory);
        $referenceList = collect($references)
            ->map(fn ($reference) => '<li><a href="'.$reference['url'].'" target="_blank" rel="noopener noreferrer">'.$reference['title'].'</a></li>')
            ->implode("\n");
        $focus = $this->moduleFocus($code, $subcategory);
        $keyTerms = collect($focus['key_terms'])->map(fn ($term) => "<li>{$term}</li>")->implode("\n");
        $steps = collect($focus['steps'])->map(fn ($step) => "<li>{$step}</li>")->implode("\n");
        $mistakes = collect($focus['mistakes'])->map(fn ($mistake) => "<li>{$mistake}</li>")->implode("\n");
        $practice = collect($focus['practice'])->map(fn ($item) => "<li>{$item}</li>")->implode("\n");
        $review = collect($focus['review'])->map(fn ($item) => "<li>{$item}</li>")->implode("\n");

        return <<<HTML
<h2>{$code} - {$subcategory}</h2>
<p class="module-lead">Modul ini dibuat sebagai materi belajar original untuk memahami pola kompetensi SKD CPNS. Materi tidak memuat klaim soal asli, bocoran, atau sumber resmi yang tidak dapat diverifikasi. Rujukan di bagian akhir dipakai sebagai bahan belajar umum, bukan sumber pengambilan soal.</p>

<h3>Tujuan Belajar</h3>
<div class="module-section">
    <p>Setelah membaca modul ini, peserta diharapkan mampu mengenali inti materi {$subcategory}, memahami bentuk soal yang sering muncul dalam latihan SKD, membedakan pilihan jawaban yang kuat dan lemah, serta menerapkan cara berpikir yang lebih sistematis ketika mengerjakan soal berbatas waktu.</p>
    <ul>
        <li>Memahami konsep utama {$subcategory} secara praktis, bukan hanya menghafal istilah.</li>
        <li>Mengenali kata kunci atau pola yang biasanya menjadi penentu jawaban.</li>
        <li>Menghubungkan materi dengan konteks kerja aparatur sipil negara yang tertib, objektif, dan bertanggung jawab.</li>
        <li>Menyusun strategi eliminasi agar jawaban yang dipilih lebih konsisten dengan data soal.</li>
    </ul>
</div>

<h3>Ringkasan Konsep</h3>
<div class="module-section">
    <p>{$focus['summary']}</p>
    <p>{$focus['detail']}</p>
</div>

<h3>Istilah dan Kata Kunci</h3>
<div class="module-section">
    <p>Bagian ini membantu membedakan mana informasi inti dan mana informasi pelengkap. Saat membaca soal, garis bawahi istilah yang mengubah arah jawaban.</p>
    <ul>
{$keyTerms}
    </ul>
</div>

<h3>Poin Penting</h3>
<div class="module-section">
    <ul>
        <li>{$focus['points'][0]}</li>
        <li>{$focus['points'][1]}</li>
        <li>{$focus['points'][2]}</li>
        <li>{$focus['points'][3]}</li>
        <li>{$focus['points'][4]}</li>
    </ul>
</div>

<h3>Contoh Penerapan</h3>
<div class="module-section">
    <p>{$focus['case']}</p>
    <h4>Cara membaca kasus</h4>
    <ol>
{$steps}
    </ol>
</div>

<h3>Tips Menjawab</h3>
<div class="module-section">
    <p>{$focus['tips']}</p>
    <p>Dalam kondisi ujian, jangan mengejar semua soal dengan cara yang sama. Untuk soal mudah, jawab cepat tetapi tetap cek kata kunci. Untuk soal sedang, gunakan eliminasi. Untuk soal sulit, beri batas waktu agar tidak menghabiskan energi pada satu nomor saja.</p>
</div>

<h3>Kesalahan yang Sering Terjadi</h3>
<div class="module-section">
    <ul>
{$mistakes}
    </ul>
</div>

<h3>Latihan Singkat</h3>
<div class="module-section">
    <ol>
{$practice}
    </ol>
</div>

<h3>Checklist Review Mandiri</h3>
<div class="module-section">
    <p>Gunakan checklist ini setelah mengerjakan latihan agar proses belajar tidak berhenti pada benar atau salah saja.</p>
    <ul>
{$review}
    </ul>
</div>

<p class="module-note">Catatan: materi ini dirancang untuk membangun kebiasaan berpikir. Jika ada perubahan aturan seleksi, jadikan laman resmi pemerintah dan dokumen regulasi terbaru sebagai acuan administratif utama.</p>

<h3>Rujukan Belajar</h3>
<div class="module-links">
    <p>Link berikut ditempatkan terpisah dari isi modul agar jelas mana materi belajar dan mana sumber rujukan eksternal.</p>
    <ul>
{$referenceList}
    </ul>
</div>
HTML;
    }

    private function moduleFocus(string $code, string $subcategory): array
    {
        if ($code === 'TWK') {
            return [
                'summary' => "{$subcategory} dipelajari sebagai bagian dari wawasan kebangsaan. Fokus utamanya adalah memahami nilai, aturan, dan penerapan sikap warga negara dalam kehidupan publik.",
                'detail' => "Dalam latihan TWK, jawaban yang kuat biasanya menunjukkan keseimbangan antara nilai kebangsaan, kepatuhan pada konstitusi, penghormatan terhadap keberagaman, dan keberanian menjaga kepentingan umum. Materi {$subcategory} perlu dibaca sebagai pedoman bersikap, bukan sekadar definisi.",
                'key_terms' => [
                    'Kepentingan nasional: tindakan yang menjaga persatuan, kedaulatan, dan keselamatan masyarakat luas.',
                    'Konstitusional: keputusan yang sejalan dengan Pancasila, UUD 1945, hukum, dan prosedur yang berlaku.',
                    'Musyawarah: proses mencari keputusan yang menghargai pendapat, data, dan tanggung jawab bersama.',
                    'Integritas kebangsaan: konsistensi antara ucapan, keputusan, dan tindakan yang tidak menyalahgunakan kewenangan.',
                    'Toleransi aktif: menghormati perbedaan sambil tetap menjaga aturan dan ketertiban umum.',
                ],
                'points' => [
                    'Hubungkan konsep dengan Pancasila, UUD 1945, NKRI, dan kehidupan berbangsa.',
                    'Perhatikan tindakan yang menjaga persatuan, integritas, keadilan, dan kepentingan umum.',
                    'Hindari opsi yang ekstrem, diskriminatif, atau mengabaikan dasar hukum dan etika.',
                    'Bedakan sikap nasionalis dengan sikap fanatik; nasionalisme yang tepat tetap menghormati hukum dan kemanusiaan.',
                    'Jika ada konflik nilai, pilih tindakan yang paling bertanggung jawab, terukur, dan tidak merugikan masyarakat.',
                ],
                'case' => "Dalam kasus perbedaan pendapat, penerapan {$subcategory} tampak pada sikap menghargai aturan, mencari mufakat, dan tetap menjaga kepentingan bangsa.",
                'steps' => [
                    'Tentukan nilai kebangsaan yang diuji: persatuan, hukum, keadilan, integritas, atau bela negara.',
                    'Cari tindakan yang menyelesaikan masalah tanpa memecah belah kelompok.',
                    'Singkirkan opsi yang memaksakan pendapat, mengabaikan prosedur, atau menguntungkan kelompok tertentu saja.',
                    'Pilih opsi yang dapat dipertanggungjawabkan di ruang publik dan tetap sesuai dasar negara.',
                ],
                'tips' => 'Untuk TWK, jangan hanya menghafal istilah. Cari nilai yang sedang diuji, lalu pilih opsi yang paling sesuai dengan penerapan nilai tersebut.',
                'mistakes' => [
                    'Memilih jawaban yang terdengar tegas tetapi sebenarnya melanggar prosedur atau tidak adil.',
                    'Menganggap semua tindakan cepat pasti benar, padahal TWK menuntut ketepatan nilai dan aturan.',
                    'Terjebak pada kata-kata nasionalisme yang berlebihan tetapi mengabaikan toleransi dan hukum.',
                    'Tidak membedakan kepentingan pribadi, kepentingan kelompok, dan kepentingan bangsa.',
                ],
                'practice' => [
                    'Buat satu contoh situasi kerja yang berkaitan dengan {$subcategory}, lalu tulis respons yang sesuai nilai kebangsaan.',
                    'Cari dua opsi yang terlihat baik, kemudian bandingkan mana yang paling sesuai prosedur dan kepentingan umum.',
                    'Latih membaca soal dalam 45 sampai 60 detik dengan menandai kata kunci nilai yang diuji.',
                    'Setelah memilih jawaban, jelaskan alasan pilihan dalam satu kalimat agar pemahaman lebih kuat.',
                ],
                'review' => [
                    'Saya bisa menjelaskan inti {$subcategory} tanpa menghafal kalimat panjang.',
                    'Saya bisa mengenali opsi yang diskriminatif, egois, atau melanggar aturan.',
                    'Saya bisa menghubungkan jawaban dengan Pancasila, UUD 1945, NKRI, dan kepentingan publik.',
                    'Saya mencatat jenis kesalahan yang paling sering saya lakukan saat latihan TWK.',
                ],
            ];
        }

        if ($code === 'TIU') {
            return [
                'summary' => "{$subcategory} mengukur kemampuan bernalar. Fokusnya adalah menemukan pola, hubungan, struktur argumen, atau operasi hitung secara sistematis.",
                'detail' => "Pada TIU, kemampuan utama bukan hanya menghitung cepat, tetapi memahami struktur soal. Materi {$subcategory} harus dilatih dengan cara memecah informasi, mencari hubungan paling stabil, menguji pola, lalu mencocokkan hasil dengan pilihan jawaban secara objektif.",
                'key_terms' => [
                    'Data utama: angka, kata, premis, atau hubungan yang benar-benar dipakai untuk menentukan jawaban.',
                    'Pola: hubungan berulang yang konsisten, misalnya penjumlahan, perbandingan, perubahan makna, atau sebab-akibat.',
                    'Eliminasi: membuang opsi yang tidak sesuai dengan data soal sebelum menghitung atau menalar terlalu jauh.',
                    'Konsistensi: semua bagian jawaban harus cocok dengan informasi soal, bukan hanya sebagian.',
                    'Efisiensi waktu: memilih cara penyelesaian yang cukup akurat tanpa langkah yang berlebihan.',
                ],
                'points' => [
                    'Ubah informasi soal menjadi pola sederhana sebelum memilih jawaban.',
                    'Gunakan eliminasi untuk opsi yang tidak konsisten dengan data soal.',
                    'Kerjakan dari relasi paling jelas, lalu cek ulang hasil secara cepat.',
                    'Pisahkan informasi penting dari cerita pengantar agar fokus tidak terpecah.',
                    'Jika satu pola tidak cocok sampai akhir, uji pola lain sebelum memutuskan jawaban.',
                ],
                'case' => "Pada soal {$subcategory}, kesalahan umum terjadi karena terburu-buru membaca pola. Susun informasi, uji satu pola utama, lalu bandingkan dengan pilihan.",
                'steps' => [
                    'Tulis informasi inti dalam bentuk singkat: angka, premis, pasangan kata, atau urutan data.',
                    'Tentukan operasi atau hubungan yang mungkin dipakai.',
                    'Uji hubungan tersebut pada lebih dari satu bagian soal agar tidak keliru membaca pola.',
                    'Cocokkan hasil dengan pilihan, lalu singkirkan opsi yang jelas tidak mungkin.',
                ],
                'tips' => 'Untuk TIU, prioritaskan ketelitian. Jika menemui angka atau premis, tulis hubungan intinya secara ringkas sebelum memilih jawaban.',
                'mistakes' => [
                    'Langsung menghitung tanpa memahami apa yang ditanyakan.',
                    'Menggunakan satu pola hanya karena cocok di awal, tetapi tidak memeriksa bagian berikutnya.',
                    'Terjebak pada pilihan jawaban yang mendekati hasil sementara.',
                    'Membaca premis logika secara terbalik, misalnya menganggap sebagian berarti semua.',
                ],
                'practice' => [
                    'Kerjakan lima soal {$subcategory} dengan membatasi waktu per soal, lalu catat langkah mana yang paling lama.',
                    'Ulangi soal yang salah tanpa melihat pembahasan, dan tulis pola yang seharusnya dipakai.',
                    'Bandingkan dua pilihan yang paling mirip, lalu cari perbedaan data yang membuat salah satunya gugur.',
                    'Latih membuat ringkasan soal dalam satu baris sebelum memilih jawaban.',
                ],
                'review' => [
                    'Saya bisa mengubah soal {$subcategory} menjadi pola atau struktur yang lebih sederhana.',
                    'Saya tidak memilih jawaban hanya karena terlihat familier.',
                    'Saya mengecek kembali operasi hitung, arah hubungan, atau makna kata sebelum mengunci jawaban.',
                    'Saya mengetahui tipe soal TIU yang paling sering menghabiskan waktu saya.',
                ],
            ];
        }

        return [
            'summary' => "{$subcategory} menilai kecenderungan perilaku kerja. Fokusnya adalah memilih respons yang etis, profesional, solutif, dan berorientasi pelayanan.",
            'detail' => "TKP menilai kualitas respons dalam situasi kerja. Pada materi {$subcategory}, jawaban terbaik biasanya tidak hanya terlihat sopan, tetapi juga aktif, proporsional, sesuai prosedur, memperbaiki keadaan, dan tetap mempertimbangkan dampak bagi orang lain.",
            'key_terms' => [
                'Orientasi pelayanan: menempatkan kebutuhan masyarakat atau pengguna layanan sebagai perhatian utama.',
                'Profesional: bekerja sesuai tugas, standar, waktu, dan etika jabatan.',
                'Koordinasi: melibatkan pihak yang relevan tanpa melempar tanggung jawab.',
                'Solutif: bergerak menyelesaikan masalah dengan cara realistis dan dapat dipertanggungjawabkan.',
                'Pengendalian diri: tetap tenang, objektif, dan tidak reaktif saat menghadapi tekanan.',
            ],
            'points' => [
                'Pilih tindakan yang aktif menyelesaikan masalah tanpa melanggar prosedur.',
                'Utamakan komunikasi sopan, tanggung jawab, kerja sama, dan integritas.',
                'Hindari opsi yang pasif, emosional, menyalahkan pihak lain, atau merugikan layanan.',
                'Respons terbaik biasanya menggabungkan empati, analisis masalah, dan tindak lanjut yang jelas.',
                'Jika semua opsi terlihat baik, pilih yang dampaknya paling luas dan paling sesuai peran kerja.',
            ],
            'case' => "Dalam situasi {$subcategory}, respons terbaik biasanya menggabungkan empati, analisis masalah, koordinasi, dan keputusan yang dapat dipertanggungjawabkan.",
            'steps' => [
                'Pahami siapa pihak yang terdampak dan apa masalah utamanya.',
                'Cari opsi yang aktif mengambil tanggung jawab tanpa bertindak di luar kewenangan.',
                'Bandingkan dampak jangka pendek dan jangka panjang dari setiap respons.',
                'Pilih tindakan yang menjaga layanan, etika, kerja sama, dan kepercayaan publik.',
            ],
            'tips' => 'Untuk TKP, bandingkan kualitas respons. Opsi terbaik bukan sekadar baik secara niat, tetapi juga tepat secara prosedur dan dampak.',
            'mistakes' => [
                'Memilih opsi yang sangat sopan tetapi terlalu pasif dan tidak menyelesaikan masalah.',
                'Memilih opsi yang cepat tetapi mengabaikan koordinasi, data, atau prosedur.',
                'Menganggap melapor selalu jawaban terbaik, padahal sering perlu ada upaya awal sesuai kewenangan.',
                'Tidak memperhatikan dampak pilihan terhadap pengguna layanan, rekan kerja, dan organisasi.',
            ],
            'practice' => [
                'Baca satu skenario {$subcategory}, lalu urutkan opsi dari respons paling lemah sampai paling kuat.',
                'Tandai kata yang menunjukkan sikap pasif, emosional, menyalahkan, atau menghindar.',
                'Latih memberi alasan mengapa satu opsi lebih baik dari opsi lain meskipun keduanya tampak positif.',
                'Buat contoh tindak lanjut setelah respons dipilih, misalnya koordinasi, dokumentasi, atau evaluasi.',
            ],
            'review' => [
                'Saya bisa membedakan respons aktif-solutif dari respons pasif yang hanya menunggu.',
                'Saya memperhatikan prosedur, etika, pelayanan, dan dampak sebelum memilih jawaban.',
                'Saya tidak memilih opsi yang menyalahkan orang lain atau menghindari tanggung jawab.',
                'Saya memahami mengapa skor TKP bertingkat, bukan sekadar benar atau salah.',
            ],
        ];
    }

    private function referencesFor(string $code, string $subcategory): array
    {
        $skdCore = [
            [
                'title' => 'BKN - Informasi seleksi CPNS dan pelaksanaan SKD berbasis CAT',
                'url' => 'https://www.bkn.go.id/3-juta-pelamar-cpns-2024-berkompetisi-di-tahap-skd-2/',
            ],
            [
                'title' => 'PermenPANRB - Kisi-kisi materi TWK, TIU, dan TKP dalam SKD',
                'url' => 'https://peraturan.bpk.go.id/Download/135315/Permenpan%20Nomor%2023%20Tahun%202019.pdf',
            ],
        ];

        $references = [
            'TWK' => [
                'Pancasila' => [
                    [
                        'title' => 'BPIP - Peraturan BPIP tentang Indikator Nilai Pancasila',
                        'url' => 'https://jdih.bpip.go.id/dokumen/view?id=269',
                    ],
                    [
                        'title' => 'BPIP - Naskah Sumber Arsip Dasar Negara I Masa Sidang BPUPK',
                        'url' => 'https://bpip.go.id/public/buku/naskah-sumber-arsip-dasar-negara-i/',
                    ],
                ],
                'UUD 1945' => [
                    [
                        'title' => 'BPHN - Naskah Undang-Undang Dasar Negara Republik Indonesia Tahun 1945',
                        'url' => 'https://bphn.go.id/data/documents/uud_1945.pdf',
                    ],
                    [
                        'title' => 'Peraturan BPK - UUD Negara Republik Indonesia Tahun 1945',
                        'url' => 'https://peraturan.bpk.go.id/Details/101646/uud-no--',
                    ],
                ],
                'Nasionalisme' => [
                    [
                        'title' => 'UU No. 24 Tahun 2009 - Bendera, Bahasa, Lambang Negara, dan Lagu Kebangsaan',
                        'url' => 'https://peraturan.bpk.go.id/Details/38661/uu-no-24-',
                    ],
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Peran ASN dalam penyelenggaraan pemerintahan dan pembangunan nasional',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                ],
                'NKRI' => [
                    [
                        'title' => 'BPHN - UUD 1945 sebagai dasar bentuk Negara Kesatuan Republik Indonesia',
                        'url' => 'https://bphn.go.id/data/documents/uud_1945.pdf',
                    ],
                    [
                        'title' => 'UU No. 24 Tahun 2009 - Simbol negara dan identitas kebangsaan',
                        'url' => 'https://peraturan.bpk.go.id/Details/38661/uu-no-24-',
                    ],
                ],
                'Bhinneka Tunggal Ika' => [
                    [
                        'title' => 'UU No. 24 Tahun 2009 - Lambang negara Garuda Pancasila dan semboyan Bhinneka Tunggal Ika',
                        'url' => 'https://peraturan.bpk.go.id/Details/38661/uu-no-24-',
                    ],
                    [
                        'title' => 'BPIP - Indikator Nilai Pancasila untuk aktualisasi nilai persatuan dan toleransi',
                        'url' => 'https://jdih.bpip.go.id/dokumen/view?id=269',
                    ],
                ],
                'Integritas' => [
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Nilai dasar, kode etik, dan kode perilaku ASN',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                    [
                        'title' => 'BPIP - Indikator Nilai Pancasila sebagai acuan perilaku berintegritas',
                        'url' => 'https://jdih.bpip.go.id/dokumen/view?id=269',
                    ],
                ],
                'Bela Negara' => [
                    [
                        'title' => 'Kementerian Pertahanan - Nilai Dasar Bela Negara',
                        'url' => 'https://kms-bpsdm.kemhan.go.id/course/Nilai-Dasar-Bela-Negara',
                    ],
                    [
                        'title' => 'Permenhan No. 27 Tahun 2019 - Pembinaan Kesadaran Bela Negara',
                        'url' => 'https://www.kemhan.go.id/itjen/wp-content/uploads/2022/07/PERMENHAN-NOMOR-27-TAHUN-2019-PENYELENGGARAAN-PEMBINAAN-KESADARAN-BELA-NEGARA.pdf',
                    ],
                ],
                'Sejarah Perjuangan Bangsa' => [
                    [
                        'title' => 'BPIP - Naskah Sumber Arsip Dasar Negara I Masa Sidang BPUPK',
                        'url' => 'https://bpip.go.id/public/buku/naskah-sumber-arsip-dasar-negara-i/',
                    ],
                    [
                        'title' => 'UU No. 24 Tahun 2009 - Simbol negara sebagai hasil sejarah perjuangan bangsa',
                        'url' => 'https://peraturan.bpk.go.id/Details/38661/uu-no-24-',
                    ],
                ],
            ],
            'TIU' => [
                'Sinonim' => [
                    [
                        'title' => 'KBBI Daring - Rujukan kosakata baku bahasa Indonesia',
                        'url' => 'https://kbbi.kemdikbud.go.id/',
                    ],
                    [
                        'title' => 'PermenPANRB - Kisi-kisi kemampuan verbal dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Antonim' => [
                    [
                        'title' => 'KBBI Daring - Rujukan makna kata untuk latihan antonim',
                        'url' => 'https://kbbi.kemdikbud.go.id/',
                    ],
                    [
                        'title' => 'PermenPANRB - Kisi-kisi kemampuan verbal dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Analogi Verbal' => [
                    [
                        'title' => 'KBBI Daring - Rujukan hubungan makna dan kosakata',
                        'url' => 'https://kbbi.kemdikbud.go.id/',
                    ],
                    [
                        'title' => 'PermenPANRB - Kisi-kisi kemampuan verbal dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Silogisme' => [
                    [
                        'title' => 'PermenPANRB - Kisi-kisi kemampuan berpikir logis dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Deret Angka' => [
                    [
                        'title' => 'PermenPANRB - Kisi-kisi kemampuan numerik dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Aritmetika' => [
                    [
                        'title' => 'PermenPANRB - Kisi-kisi operasi perhitungan angka dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Perbandingan' => [
                    [
                        'title' => 'PermenPANRB - Kisi-kisi hubungan antarangka dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Penalaran Analitis' => [
                    [
                        'title' => 'PermenPANRB - Kisi-kisi kemampuan berpikir analitis dalam TIU',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
            ],
            'TKP' => [
                'Pelayanan Publik' => [
                    [
                        'title' => 'UU No. 25 Tahun 2009 - Pelayanan Publik',
                        'url' => 'https://peraturan.bpk.go.id/Details/38748/uu-no-25tahun-2009',
                    ],
                    [
                        'title' => 'PP No. 96 Tahun 2012 - Pelaksanaan UU Pelayanan Publik',
                        'url' => 'https://jdih.kemenkeu.go.id/dok/pp-96-tahun-2012/files',
                    ],
                ],
                'Profesionalisme' => [
                    [
                        'title' => 'UU No. 20 Tahun 2023 - ASN profesional dan bebas dari KKN',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                ],
                'Integritas' => [
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Nilai dasar, kode etik, dan kode perilaku ASN',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                    [
                        'title' => 'PermenPANRB - Integritas diri sebagai aspek TKP',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Kerja Sama' => [
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Nilai dasar ASN dan perilaku kolaboratif',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                    [
                        'title' => 'PermenPANRB - Kemampuan bekerja sama dalam kelompok sebagai aspek TKP',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                ],
                'Pengendalian Diri' => [
                    [
                        'title' => 'PermenPANRB - Kemampuan mengendalikan diri sebagai aspek TKP',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Kode etik dan kode perilaku ASN',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                ],
                'Adaptasi' => [
                    [
                        'title' => 'PermenPANRB - Kemampuan beradaptasi sebagai aspek TKP',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Transformasi dan manajemen ASN',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                ],
                'Teknologi Informasi' => [
                    [
                        'title' => 'Perpres No. 95 Tahun 2018 - Sistem Pemerintahan Berbasis Elektronik',
                        'url' => 'https://peraturan.bpk.go.id/Details/96913/perpres-',
                    ],
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Digitalisasi manajemen ASN',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                ],
                'Pengambilan Keputusan' => [
                    [
                        'title' => 'UU No. 20 Tahun 2023 - Tugas ASN dalam penyelenggaraan kebijakan dan pelayanan publik',
                        'url' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun2023',
                    ],
                    [
                        'title' => 'UU No. 25 Tahun 2009 - Hak, kewajiban, dan penyelenggaraan pelayanan publik',
                        'url' => 'https://peraturan.bpk.go.id/Details/38748/uu-no-25tahun-2009',
                    ],
                ],
                'Kreativitas dan Inovasi' => [
                    [
                        'title' => 'PermenPANRB - Kreativitas dan inovasi sebagai aspek TKP',
                        'url' => 'https://peraturan.bpk.go.id/Download/123521/PERMENPAN%20NOMOR%2017%20TAHUN%202014.pdf',
                    ],
                    [
                        'title' => 'Perpres No. 95 Tahun 2018 - Inovasi layanan melalui SPBE',
                        'url' => 'https://peraturan.bpk.go.id/Details/96913/perpres-',
                    ],
                ],
            ],
        ];

        return array_merge($skdCore, $references[$code][$subcategory] ?? []);
    }

    private function seedExamPackage(): void
    {
        $package = ExamPackage::query()->updateOrCreate(
            ['title' => 'Simulasi SKD Full 100 Menit'],
            [
                'description' => 'Paket simulasi CAT SKD pribadi. Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi.',
                'duration_minutes' => 100,
                'total_questions' => 110,
                'is_full_skd' => true,
                'status' => 'active',
            ],
        );

        $questionIds = collect()
            ->merge($this->questionsForCategory('TWK', 30))
            ->merge($this->questionsForCategory('TIU', 35))
            ->merge($this->questionsForCategory('TKP', 45));

        $sync = [];
        $order = 1;

        foreach ($questionIds as $questionId) {
            $sync[$questionId] = ['order_number' => $order++];
        }

        $package->questions()->sync($sync);
    }

    private function questionsForCategory(string $code, int $limit)
    {
        return Question::query()
            ->where('category_id', $this->categories[$code]->id)
            ->where('status', 'active')
            ->orderBy('id')
            ->limit($limit)
            ->pluck('id');
    }
}

<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin CAT CPNS',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Peserta Demo',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        );

        foreach ($this->settings() as $key => $value) {
            AppSetting::query()->updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        $this->call(CpnsContentSeeder::class);
    }

    private function settings(): array
    {
        return [
            'passing_grade_twk' => 65,
            'passing_grade_tiu' => 80,
            'passing_grade_tkp' => 166,
            'full_exam_duration_minutes' => 100,
            'full_exam_twk_count' => 30,
            'full_exam_tiu_count' => 35,
            'full_exam_tkp_count' => 45,
        ];
    }
}

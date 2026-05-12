<?php

namespace Tests\Feature;

use App\Models\LearningModule;
use App\Models\Question;
use App\Models\User;
use App\Models\ExamPackage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_dashboard_questions_and_modules(): void
    {
        $this->seed();

        $user = User::query()->where('email', 'user@example.com')->firstOrFail();
        $question = Question::query()->firstOrFail();
        $module = LearningModule::query()->firstOrFail();

        $this->actingAs($user)->get('/dashboard')->assertOk();
        $this->actingAs($user)->get('/soal')->assertOk()->assertSee('Bank Soal');
        $this->actingAs($user)->get("/soal/{$question->id}")->assertOk()->assertSee('Pembahasan');
        $this->actingAs($user)->get('/modul')->assertOk()->assertSee('Modul Belajar');
        $this->actingAs($user)->get("/modul/{$module->slug}")->assertOk()->assertSee($module->title);
    }

    public function test_admin_can_access_filament_question_resource(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)->get('/admin/questions')->assertOk();
    }

    public function test_user_can_start_answer_and_submit_exam(): void
    {
        $this->seed();

        $user = User::query()->where('email', 'user@example.com')->firstOrFail();
        $package = ExamPackage::query()->where('is_full_skd', true)->firstOrFail();

        $response = $this->actingAs($user)->post("/ujian/paket/{$package->id}/mulai");
        $response->assertRedirect();

        $session = $user->examSessions()->latest()->firstOrFail();
        $answer = $session->answers()->with('question.options')->firstOrFail();
        $option = $answer->question->options()->firstOrFail();

        $this->actingAs($user)
            ->get("/ujian/{$session->id}")
            ->assertOk()
            ->assertSee('Submit Ujian');

        $this->actingAs($user)
            ->postJson("/ujian/{$session->id}/jawaban/{$answer->id}", [
                'selected_option_id' => $option->id,
            ])
            ->assertOk()
            ->assertJson(['saved' => true]);

        $this->actingAs($user)
            ->post("/ujian/{$session->id}/submit")
            ->assertRedirect("/ujian/{$session->id}/hasil");

        $this->actingAs($user)
            ->get("/ujian/{$session->id}/hasil")
            ->assertOk()
            ->assertSee('Hasil Ujian')
            ->assertSee('Pembahasan');
    }
}

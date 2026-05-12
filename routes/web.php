<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LearningModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionBankController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/soal', [QuestionBankController::class, 'index'])->name('questions.index');
    Route::get('/soal/{question}', [QuestionBankController::class, 'show'])->name('questions.show');
    Route::get('/modul', [LearningModuleController::class, 'index'])->name('modules.index');
    Route::get('/modul/{module:slug}', [LearningModuleController::class, 'show'])->name('modules.show');
    Route::post('/ujian/paket/{package}/mulai', [ExamController::class, 'start'])->name('exams.start');
    Route::get('/ujian/{session}', [ExamController::class, 'show'])->name('exams.show');
    Route::post('/ujian/{session}/jawaban/{answer}', [ExamController::class, 'answer'])->name('exams.answer');
    Route::post('/ujian/{session}/ragu/{answer}', [ExamController::class, 'flag'])->name('exams.flag');
    Route::post('/ujian/{session}/submit', [ExamController::class, 'submit'])->name('exams.submit');
    Route::get('/ujian/{session}/hasil', [ExamController::class, 'result'])->name('exams.result');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

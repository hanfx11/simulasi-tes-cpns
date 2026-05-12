<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['category_id', 'name']);
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('subcategory_id')->constrained()->restrictOnDelete();
            $table->longText('question_text');
            $table->longText('explanation');
            $table->string('difficulty')->default('medium');
            $table->string('score_type')->default('binary');
            $table->string('status')->default('active')->index();
            $table->timestamps();

            $table->index(['category_id', 'subcategory_id', 'status']);
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('option_label', 1);
            $table->text('option_text');
            $table->boolean('is_correct')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamps();

            $table->unique(['question_id', 'option_label']);
        });

        Schema::create('exam_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->default(100);
            $table->unsignedSmallInteger('total_questions')->default(110);
            $table->boolean('is_full_skd')->default(false)->index();
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });

        Schema::create('exam_package_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('order_number');
            $table->timestamps();

            $table->unique(['exam_package_id', 'question_id']);
            $table->unique(['exam_package_id', 'order_number']);
        });

        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('mode')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->string('status')->default('ongoing')->index();
            $table->unsignedSmallInteger('score_total')->default(0);
            $table->unsignedSmallInteger('score_twk')->default(0);
            $table->unsignedSmallInteger('score_tiu')->default(0);
            $table->unsignedSmallInteger('score_tkp')->default(0);
            $table->boolean('passed_twk')->default(false);
            $table->boolean('passed_tiu')->default(false);
            $table->boolean('passed_tkp')->default(false);
            $table->boolean('passed_total')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'status', 'created_at']);
        });

        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('selected_option_id')->nullable()->constrained('question_options')->nullOnDelete();
            $table->unsignedTinyInteger('score')->default(0);
            $table->boolean('is_correct')->nullable();
            $table->boolean('is_flagged')->default(false)->index();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            $table->unique(['exam_session_id', 'question_id']);
        });

        Schema::create('learning_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->unsignedSmallInteger('order_number')->default(0);
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });

        Schema::create('module_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_module_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('not_started');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'learning_module_id']);
        });

        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('module_progress');
        Schema::dropIfExists('learning_modules');
        Schema::dropIfExists('exam_answers');
        Schema::dropIfExists('exam_sessions');
        Schema::dropIfExists('exam_package_questions');
        Schema::dropIfExists('exam_packages');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
    }
};

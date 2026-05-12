<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class QuestionBankController extends Controller
{
    public function index(Request $request): View
    {
        $categoryId = $request->integer('category_id') ?: null;
        $subcategoryId = $request->integer('subcategory_id') ?: null;
        $difficulty = $request->string('difficulty')->toString();

        $questions = Question::query()
            ->with(['category', 'subcategory', 'options'])
            ->where('status', 'active')
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($subcategoryId, fn ($query) => $query->where('subcategory_id', $subcategoryId))
            ->when($difficulty !== '', fn ($query) => $query->where('difficulty', $difficulty))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('questions.index', [
            'questions' => $questions,
            'categories' => Category::query()->orderBy('code')->get(),
            'subcategories' => Subcategory::query()
                ->with('category')
                ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
                ->orderBy('name')
                ->get(),
            'selectedCategoryId' => $categoryId,
            'selectedSubcategoryId' => $subcategoryId,
            'selectedDifficulty' => $difficulty,
        ]);
    }

    public function show(Question $question): View
    {
        abort_unless($question->status === 'active', 404);

        return view('questions.show', [
            'question' => $question->load(['category', 'subcategory', 'options' => fn ($query) => $query->orderBy('option_label')]),
            'questionNumber' => Question::query()
                ->where('status', 'active')
                ->where('id', '>=', $question->id)
                ->count(),
        ]);
    }
}

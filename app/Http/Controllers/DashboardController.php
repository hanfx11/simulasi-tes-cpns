<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExamPackage;
use App\Models\ExamSession;
use App\Models\LearningModule;
use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'categoryStats' => Category::query()
                ->withCount(['questions', 'learningModules'])
                ->orderBy('code')
                ->get(),
            'totalQuestions' => Question::query()->where('status', 'active')->count(),
            'totalModules' => LearningModule::query()->where('status', 'active')->count(),
            'latestSession' => ExamSession::query()
                ->where('user_id', $user->id)
                ->latest()
                ->first(),
            'fullPackage' => ExamPackage::query()
                ->where('is_full_skd', true)
                ->where('status', 'active')
                ->first(),
            'recentModules' => LearningModule::query()
                ->with(['category', 'subcategory'])
                ->where('status', 'active')
                ->orderBy('order_number')
                ->limit(6)
                ->get(),
        ]);
    }
}

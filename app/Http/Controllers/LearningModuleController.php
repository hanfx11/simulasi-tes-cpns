<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LearningModule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LearningModuleController extends Controller
{
    public function index(Request $request): View
    {
        $categoryId = $request->integer('category_id') ?: null;

        return view('modules.index', [
            'modules' => LearningModule::query()
                ->with(['category', 'subcategory'])
                ->where('status', 'active')
                ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
                ->orderBy('order_number')
                ->paginate(12)
                ->withQueryString(),
            'categories' => Category::query()->orderBy('code')->get(),
            'selectedCategoryId' => $categoryId,
        ]);
    }

    public function show(LearningModule $module): View
    {
        abort_unless($module->status === 'active', 404);

        return view('modules.show', [
            'module' => $module->load(['category', 'subcategory']),
        ]);
    }
}

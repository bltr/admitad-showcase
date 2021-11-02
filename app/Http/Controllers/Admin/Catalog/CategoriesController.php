<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Kalnoy\Nestedset\Collection;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = $this->getCategoriesTree();

        return view('admin.catalog.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->getCategoriesTree();

        return view('admin.catalog.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        Category::create($data);

        return redirect()->route('admin.catalog.categories.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        $categories = $this->getCategoriesTree();

        return view('admin.catalog.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateRequest($request);
        $category->update($data);

        return redirect()->route('admin.catalog.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back();
    }

    public function appendTo(Category $category, Request $request)
    {
        if ($request->parent_category_id) {
            $parentCategory = Category::findOrFail($request->parent_category_id);
            $category->appendToNode($parentCategory);
        } else {
            $category->makeRoot();
        }

        $category->save();

        return back();
    }

    public function up(Category $category)
    {
        $category->up();

        return back();
    }

    public function down(Category $category)
    {
        $category->down();

        return back();
    }

    public function first(Category $category)
    {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }

        return back();
    }

    public function last(Category $category)
    {
        if ($last = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($last);
        }

        return back();
    }

    public function getCategoriesTree(): Collection
    {
        return Category::withDepth()
            ->defaultOrder()
            ->get()
            ->toTree();
    }

    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'parent_id' => [
                'nullable',
                'integer',
                'exists:' . Category::class . ',id',
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        $request->routeIs('admin.catalog.categories.update')
                        && $request->route('category')->id == $value
                    ) {
                        $fail('parent_id не может указывать на себя.');
                    }
                },
            ],
        ]);
    }
}

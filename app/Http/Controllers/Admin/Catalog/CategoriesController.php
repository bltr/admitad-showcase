<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Category $currentRootCategory)
    {
        $rootCategories = Category::whereIsRoot()->orderBy('name')->get();
        $currentRootCategory = $currentRootCategory ?? Category::whereIsRoot()->orderBy('name')->first();
        $categories = $currentRootCategory->descendants()
            ->defaultOrder()
            ->withDepth()
            ->get()
            ->toTree();
        return view('admin.catalog.categories.index', compact('categories', 'rootCategories', 'currentRootCategory'));
    }

    public function create()
    {
        return view('admin.catalog.categories.create');
    }

    public function store(Request $request)
    {
        Category::create($request->all());

        return redirect()->route('admin.catalog.categories.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}

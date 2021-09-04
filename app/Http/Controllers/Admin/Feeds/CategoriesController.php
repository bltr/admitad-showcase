<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\FeedCategory;
use App\Models\Shop;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Shop $shop)
    {
        $categories = FeedCategory::where('shop_id', $shop->id)->get()->keyBy('outer_id')->groupBy('parentId');

        $rendered_list = $this->renderNestedList($categories);

        return view('admin.feeds.categories', compact('shop', 'rendered_list'));
    }

    private function renderNestedList($categories, $roots = null, $depth = 0)
    {
        $roots = $roots ?? $categories[''] ?? [];
        $html = $depth ? '<ul class="list-group border-start">' : '<ul class="list-group">' ;
        foreach ($roots as $category) {
            if ($categories->has($category->outer_id)) {
                $subCategoriesHtml = $this->renderNestedList($categories, $categories[$category->outer_id], ++$depth);
            } else {
                $subCategoriesHtml = '';
            }
            $html .= '<li class="list-group-item ps-4 border-0">' . $category->name . $subCategoriesHtml . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}

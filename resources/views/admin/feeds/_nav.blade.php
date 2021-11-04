<div class="btn-group mb-4">
    <a href="{{ route('admin.feeds.report', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.report') ? 'active' : '' }}"
    >
        Отчеты
    </a>
    <a href="{{ route('admin.feeds.offers', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.offers') ? 'active' : '' }}"
    >
        Офферы
    </a>
    <a href="{{ route('admin.feeds.categories', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.categories') ? 'active' : '' }}"
    >
        Категории
    </a>
</div>

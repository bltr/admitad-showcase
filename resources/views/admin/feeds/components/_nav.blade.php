<div class="btn-group mb-4">
    <a href="{{ route('admin.feeds.analytics', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.analytics') ? 'active' : '' }}"
    >
        Аналитика
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

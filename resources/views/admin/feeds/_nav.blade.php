<div class="btn-group mb-4">
    <a href="{{ route('admin.feeds.import-settings', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.import-settings') ? 'active' : '' }}"
    >
        Настройки импорта
    </a>
    <a href="{{ route('admin.feeds.offers', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.offers') ? 'active' : '' }}"
    >
        Товары
    </a>
    <a href="{{ route('admin.feeds.categories', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.categories') ? 'active' : '' }}"
    >
        Категории
    </a>
</div>

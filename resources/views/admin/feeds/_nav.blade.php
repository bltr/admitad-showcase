<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a href="{{ route('admin.feeds.import-settings', $shop->id) }}"
           class="nav-link {{ request()->routeIs('admin.feeds.import-settings') ? 'active' : '' }}"
        >
            Настройки импорта
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.feeds.offers', $shop->id) }}"
           class="nav-link {{ request()->routeIs('admin.feeds.offers') ? 'active' : '' }}"
        >
            Товары
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.feeds.categories', $shop->id) }}"
           class="nav-link {{ request()->routeIs('admin.feeds.categories') ? 'active' : '' }}"
        >
            Категории
        </a>
    </li>
</ul>

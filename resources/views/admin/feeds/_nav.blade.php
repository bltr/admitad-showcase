<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a href="{{ route('admin.feeds.import-grouping', $shop) }}"
           class="nav-link {{ request()->routeIs('admin.feeds.import-*') ? 'active' : '' }}"
        >
            Настройки импорта
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.feeds.offers', $shop) }}"
           class="nav-link {{ request()->routeIs('admin.feeds.offers') ? 'active' : '' }}"
        >
            Товары
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.feeds.categories', $shop) }}"
           class="nav-link {{ request()->routeIs('admin.feeds.categories') ? 'active' : '' }}"
        >
            Категории
        </a>
    </li>
</ul>

<ul class="nav flex-column nav-pills">
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('admin.feeds.import-grouping')) active @endif"
           href="{{ route('admin.feeds.import-grouping', $shop) }}">
            Группировка
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('admin.feeds.import-mapping')) active @endif"
           href="{{ route('admin.feeds.import-mapping', $shop) }}">
            Маппинг
        </a>
    </li>
</ul>

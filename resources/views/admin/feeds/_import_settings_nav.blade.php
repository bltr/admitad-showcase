<ul class="nav flex-column nav-pills">
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('admin.feeds.import-grouping')) active @endif"
           href="{{ route('admin.feeds.import-grouping', $shop) }}">
            Группировка
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('admin.feeds.import-included-fields')) active @endif"
           href="{{ route('admin.feeds.import-included-fields', $shop) }}">
            Включаемые поля
        </a>
    </li>
</ul>

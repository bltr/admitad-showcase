<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-lowercase">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.feeds.index') }}">Фиды</a></li>
        @if(isset($shop))
            <li class="breadcrumb-item active" aria-current="page">{{ $shop->name }}</li>
        @endif
    </ol>
</nav>

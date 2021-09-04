<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-lowercase">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.feeds.index') }}">Feeds</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $shop->name }}</li>
    </ol>
</nav>

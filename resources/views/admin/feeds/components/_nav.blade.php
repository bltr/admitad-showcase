<div class="btn-group my-2">
    <a href="{{ route('admin.feeds.offers', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.offers') ? 'active' : '' }}"
    >
        Offers
    </a>
    <a href="{{ route('admin.feeds.categories', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.categories') ? 'active' : '' }}"
    >
        Categories
    </a>
    <a href="{{ route('admin.feeds.analytics', $shop->id) }}"
       class="btn btn-primary {{ request()->routeIs('admin.feeds.analytics') ? 'active' : '' }}"
    >
        Analytics
    </a>
</div>

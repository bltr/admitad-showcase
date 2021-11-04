@unless ($breadcrumbs->isEmpty())
    <nav>
        <ol class="breadcrumb text-lowercase">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{!! $breadcrumb->title !!}</a></li>
                @else
                    <li class="breadcrumb-item active">{!! $breadcrumb->title !!}</li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless

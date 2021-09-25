@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row ">
        @include('admin.feeds.components._nav', ['shop' => $currentShop])
    </div>
    <div class="row">
        <div class="col">
            @if($view)
                <div class="col-4">
                    <form action="{{ route('admin.feeds.import-type', $shop) }}" method="POST">
                        @method('patch')
                        @csrf

                        <select name='import_type' class="form-select" onchange="this.form.submit()">
                            <option value="">-</option>
                            <option @if($shop->import_type === \App\Models\Shop::IMPORT_WITHOUT_GROUPING) selected @endif value="{{ \App\Models\Shop::IMPORT_WITHOUT_GROUPING }}">{{ \App\Models\Shop::IMPORT_WITHOUT_GROUPING }}</option>
                            <option @if($shop->import_type === \App\Models\Shop::IMPORT_GROUP_BY_GROUP_ID) selected @endif value="{{ \App\Models\Shop::IMPORT_GROUP_BY_GROUP_ID }}">{{ \App\Models\Shop::IMPORT_GROUP_BY_GROUP_ID }}</option>
                            <option @if($shop->import_type === \App\Models\Shop::IMPORT_GROUP_BY_PICTURE) selected @endif value="{{ \App\Models\Shop::IMPORT_GROUP_BY_PICTURE }}">{{ \App\Models\Shop::IMPORT_GROUP_BY_PICTURE }}</option>
                            <option @if($shop->import_type === \App\Models\Shop::IMPORT_GROUP_BY_URL) selected @endif value="{{ \App\Models\Shop::IMPORT_GROUP_BY_URL }}">{{ \App\Models\Shop::IMPORT_GROUP_BY_URL }}</option>
                        </select>
                    </form>
                </div>

                {!! $view !!}
            @else
                <p class="my-5 text-center">Нет данных</p>
            @endif
        </div>
    </div>
@endsection

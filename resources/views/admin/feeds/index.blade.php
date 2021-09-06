@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Фиды</li>
                </ol>
            </nav>

            <table class="table">
                @foreach($shops as $shop)
                    <tr>
                        <th>{{ $shop->id }}</th>
                        <td>{{ $shop->name }}</td>
                        <td><a href="{{ $shop->site }}" target="_blank">{{ $shop->site }}</a></td>
                        <td>
                            <form action="{{ route('admin.feeds.toggle-activity', $shop) }}" method="POST">
                                @method('patch')
                                @csrf

                                @if($shop->is_active)
                                    <button class="btn btn-warning btn-sm">Отключить импорт</button>
                                @else
                                    <button class="btn btn-danger btn-sm">Подключить импорт</button>
                                @endif
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.feeds.import-type', $shop) }}" method="POST">
                                @method('patch')
                                @csrf

                                <select name='import_type' class="form-select" onchange="this.form.submit()">
                                    <option>-</option>
                                    <option @if($shop->import_type === \App\Models\Shop::IMPORT_WITHOUT_GROUPING) selected @endif value="{{ \App\Models\Shop::IMPORT_WITHOUT_GROUPING }}">{{ \App\Models\Shop::IMPORT_WITHOUT_GROUPING }}</option>
                                    <option @if($shop->import_type === \App\Models\Shop::IMPORT_GROUP_BY_GROUP_ID) selected @endif value="{{ \App\Models\Shop::IMPORT_GROUP_BY_GROUP_ID }}">{{ \App\Models\Shop::IMPORT_GROUP_BY_GROUP_ID }}</option>
                                    <option @if($shop->import_type === \App\Models\Shop::IMPORT_GROUP_BY_PICTURE) selected @endif value="{{ \App\Models\Shop::IMPORT_GROUP_BY_PICTURE }}">{{ \App\Models\Shop::IMPORT_GROUP_BY_PICTURE }}</option>
                                    <option @if($shop->import_type === \App\Models\Shop::IMPORT_GROUP_BY_URL) selected @endif value="{{ \App\Models\Shop::IMPORT_GROUP_BY_URL }}">{{ \App\Models\Shop::IMPORT_GROUP_BY_URL }}</option>
                                </select>
                            </form>
                        </td>
                        <td><a href="{{ route('admin.feeds.offers', $shop) }}">Офферы</a></td>
                        <td><a href="{{ route('admin.feeds.categories', $shop) }}">Категории</a></td>
                        <td><a href="{{ route('admin.feeds.analytics', $shop) }}">Аналитика</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

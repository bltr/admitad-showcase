@extends('admin.feeds.layout')
@php
    /**
     * @var \App\Models\Shop $shop
     */
@endphp

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
                            <option @if($shop->isImportWithoutGrouping()) selected @endif
                                value="{{ $shop::IMPORT_WITHOUT_GROUPING }}"
                            >
                                {{ $shop::IMPORT_WITHOUT_GROUPING }}
                            </option>
                            <option @if($shop->isImportGroupByGroupId()) selected @endif
                                value="{{ $shop::IMPORT_GROUP_BY_GROUP_ID }}"
                            >
                                {{ $shop::IMPORT_GROUP_BY_GROUP_ID }}
                            </option>
                            <option @if($shop->isImportGroupByPicture()) selected @endif
                                value="{{ $shop::IMPORT_GROUP_BY_PICTURE }}"
                            >
                                {{ $shop::IMPORT_GROUP_BY_PICTURE }}
                            </option>
                            <option @if($shop->isImportGroupByUrl()) selected @endif
                                value="{{ $shop::IMPORT_GROUP_BY_URL }}"
                            >
                                {{ $shop::IMPORT_GROUP_BY_URL }}
                            </option>
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

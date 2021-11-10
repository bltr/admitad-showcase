@extends('admin.layout')

@section('content')
    <div class="row">
        @include('admin.feeds._nav', compact('shop'))
    </div>

    <div class="row">
        <div class="col-2">
            @include('admin.feeds._import_settings_nav', compact('shop'))
        </div>

        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Различные поля offers</h5>
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <a href="{{ route('admin.feeds.import-mapping', compact('shop')) }}">Все</a>
                            </td>
                        </tr>
                        @foreach($feedOffersDistinctFields as $field)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.feeds.import-mapping', ['shop' => $shop, 'field' => $field]) }}"
                                       class="@if(\App\Models\ImportMapping::isUnusedField($field)) text-secondary @endif"
                                    >{{ $field }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="border mb-4 overflow-auto" style="height: 600px">
                @foreach($feedOffers as $offer)
                    <pre class="m-3 p-3 border">{{ $offer->raw_data }}</pre>
                @endforeach
            </div>

            {{ $feedOffers->links() }}
        </div>
    </div>
@endsection

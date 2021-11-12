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
                                <form id="form" method="POST" action="{{ route('admin.feeds.set-import-mapping',  $shop) }}">
                                    @csrf()
                                    @method('PATCH')

                                    <div>
                                        @error('forCategories')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                    <div>
                                        @error('forEndCategory')
                                        {{ $message }}
                                        @enderror
                                    </div>

                                    <button class="btn btn-primary float-end" type="submit">Сохранить</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ route('admin.feeds.import-mapping', $shop) }}">Все</a>
                            </td>
                        </tr>
                        @foreach($feedOffersDistinctFields as $field)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.feeds.import-mapping', ['shop' => $shop, 'field' => $field]) }}">{{ $field }}</a>

                                        <select class="form-select ms-auto d-inline w-50" form="form" name="{{ $field }}">
                                            <option value="" ></option>
                                            @foreach(\App\Models\Shop::IMPORT_MAPPING_TARGET_FIELDS as $targetField => $label)
                                                <option
                                                    value="{{ $targetField }}"
                                                    @if(in_array($field, $shop->import_mapping[$targetField] ?? [])) selected @endif
                                                >{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

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

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
                    <h5 class="card-title text-center">Поля offers</h5>
                    <form id="form" method="POST" action="{{ route('admin.feeds.set-import-included-fields',  $shop) }}" class="d-none">
                        @csrf()
                        @method('PATCH')
                    </form>
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                @if(request()->field === null)
                                    <span class="text-danger">Все</span>
                                @else
                                    <a href="{{ route('admin.feeds.import-included-fields', $shop) }}">Все</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex">
                                @if(request()->field === 'full_category_name')
                                    <span class="text-danger">full_category_name</span>
                                @else
                                    <a href="{{ route('admin.feeds.import-included-fields', ['shop' => $shop, 'field' => 'full_category_name']) }}">
                                        full_category_name
                                    </a>
                                @endif
                                <input
                                    class="form-check-input ms-auto d-inline"
                                    type="checkbox"
                                    form="form"
                                    name="fields[]"
                                    value="full_category_name"
                                    @if(in_array('full_category_name', $shop->import_included_fields ?? [])) checked @endif
                                    onchange="document.forms.form.submit()"
                                />
                            </td>
                        </tr>
                        @foreach($feedOffersDistinctFields as $field)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        @if(request()->field === $field)
                                            <span class="text-danger">{{ $field }}</span>
                                        @else
                                            <a href="{{ route('admin.feeds.import-included-fields', ['shop' => $shop, 'field' => $field]) }}">
                                                {{ $field }}
                                            </a>
                                        @endif
                                        <input
                                            class="form-check-input ms-auto d-inline"
                                            type="checkbox"
                                            form="form"
                                            name="fields[]"
                                            value="{{ $field }}"
                                            @if(in_array($field, $shop->import_included_fields ?? [])) checked @endif
                                            onchange="document.forms.form.submit()"
                                        />
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card mb-4">
                <div class="card-body overflow-auto" style="height: 600px">
                    <h5 class="card-title text-center">Значения</h5>
                    @foreach($feedOffers as $offer)
                        @if(request()->field === 'full_category_name')
                            <pre class="m-3 p-3 border">{{ $offer->full_category_name }}</pre>
                        @else
                            <pre class="m-3 p-3 border">{{ $offer->raw_data }}</pre>
                        @endif
                    @endforeach
                </div>
            </div>
            {{ $feedOffers->links() }}
        </div>
    </div>
@endsection

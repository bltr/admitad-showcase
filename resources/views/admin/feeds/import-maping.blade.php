@extends('admin.layout')

@section('content')
    <div class="row">
        @include('admin.feeds._nav', compact('shop'))
    </div>

    <div class="row">
        <div class="col-2">
            @include('admin.feeds._import_settings_nav', compact('shop'))
        </div>

        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Различные поля offers</h5>
                    <table class="table table-bordered">
                        @foreach($feed_offers_distinct_fields as $field)
                            <tr>
                                <td>{{ $field }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-4">
            <table class="table table-bordered">
                <tr>
                    <th>Количество товаров</th>
                    <td>{{ $values['total_offers_count'] }}</td>
                </tr>
                <tr>
                    <th>Количество товаров в фидах</th>
                    <td>{{ $values['total_feed_offers_count'] }}</td>
                </tr>
                <tr>
                    <th>Количество активных фидов</th>
                    <td>{{ $values['active_shops_count'] }}</td>
                </tr>
                <tr>
                    <th>Общее количество фидов</th>
                    <td>{{ $values['total_shops_count'] }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

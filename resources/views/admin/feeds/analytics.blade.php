@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds._breadcrums', compact('shop'))

            @include('admin.feeds._nav', compact('shop'))

            @if ($analytics)
                <h5 class="my-4">{{ $analytics->created_at }}</h5>

                {!! $report->render() !!}
            @else
                <p class="my-5 text-center">Нет подготовленных данных</p>
            @endif

        </div>
    </div>
@endsection

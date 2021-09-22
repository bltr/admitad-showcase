@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        <div class="col">
            @if($view)
                {!! $view !!}
            @else
                <p class="my-5 text-center">Нет данных</p>
            @endif
        </div>
    </div>
@endsection

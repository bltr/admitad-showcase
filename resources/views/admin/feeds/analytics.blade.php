@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds.components._breadcrums', compact('shop'))

            @include('admin.feeds.components._nav', compact('shop'))

            @if($view)
                {!! $view !!}
            @else
                <p class="my-5 text-center">Нет данных</p>
            @endif

        </div>
    </div>
@endsection

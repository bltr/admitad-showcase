@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @if($view)
                {!! $view !!}
            @else
                <p class="my-5 text-center">Нет подготовленных данных</p>
            @endif

        </div>
    </div>
@endsection

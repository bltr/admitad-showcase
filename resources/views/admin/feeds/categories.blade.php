@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds._breadcrums', compact('shop'))

            @include('admin.feeds._nav', compact('shop'))

            {!! $rendered_list !!}
        </div>
    </div>
@endsection

@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin._analytics.composite', compact('analytics'))
        </div>
    </div>
@endsection

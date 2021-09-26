@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.report.composite', compact('report'))
        </div>
    </div>
@endsection

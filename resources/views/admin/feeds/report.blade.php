@extends('admin.feeds.layout')
@php
    /**
     * @var \App\Models\Shop $shop
     */
@endphp

@section('feed-content')
    <div class="row ">
        @include('admin.feeds.components._nav', ['shop' => $currentShop])
    </div>

    <div class="row">
        <div class="col">
            @include('admin.report.composite', compact('report'))
        </div>
    </div>
@endsection

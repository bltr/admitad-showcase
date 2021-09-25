@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        <div class="col-5">
            <ul class="list-group">
                @foreach($shops as $shop)
                    <li class="list-group-item border-top d-flex"
                        style="height: 3rem"
                    >
                        <div class="me-2"><a href="{{ $shop->site }}" target="_blank">⮭</a></div>
                        <div>
                            <form action="{{ route('admin.feeds.toggle-activity', $shop) }}" method="POST">
                                @method('patch')
                                @csrf

                                @if($shop->is_active)
                                    <button class="btn btn-success btn-sm">Отключить импорт</button>
                                @elseif($shop->isCanBeActive())
                                    <button class="btn btn-outline-primary btn-sm">Включить импорт</button>
                                @endif
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-5">
            <h4>Аналитика</h4>
        </div>
    </div>
@endsection

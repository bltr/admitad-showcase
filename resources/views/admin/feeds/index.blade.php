@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        <div class="col-12">
            <ul class="list-group">
                @foreach($shops as $shop)
                    <li class="list-group-item border-top d-flex"
                        style="height: 3rem"
                    >
                        <div class="me-4"><a href="{{ $shop->site }}" target="_blank">site⮭</a></div>
                        <div class="me-4"><a href="{{ $shop->admitad_url }}" target="_blank">Ad⮭</a></div>
                        <div>
                            <form action="{{ route('admin.feeds.toggle-activity', $shop) }}" method="POST">
                                @method('patch')
                                @csrf

                                @if($shop->is_active)
                                    <button class="btn btn-success btn-sm">Отключить импорт</button>
                                @elseif($shop->isCanBeActive())
                                    <button class="btn btn-outline-primary btn-sm">Включить импорт</button>
                                @else
                                    <span data-bs-toggle="tooltip"
                                          data-bs-placement="right"
                                          title="Нельзя включить импорт если не установлен тип импорта"
                                    >
                                        <span class="btn btn-outline-primary btn-sm disabled">Включить импорт</span>
                                    </span>
                                @endif
                            </form>
                        </div>
                        <div class="ms-auto"
                             data-bs-toggle="tooltip"
                             data-bs-placement="right"
                             title="Количество групп"
                        >
                            {{ $shop->group_count }}
                            <i class="bi bi-union text-secondary"></i>
                        </div>
                        <div class="ms-auto"
                             data-bs-toggle="tooltip"
                             data-bs-placement="right"
                             title="Количество офферов в фиде"
                        >
                            {{ $shop->feed_offers_count->value ?? '-' }}
                            <i class="bi bi-union text-secondary"></i>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

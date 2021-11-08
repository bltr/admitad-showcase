@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>Имя (сайт)</th>
                    <th>профиль Admitad</th>
                    <th>Количество групп</th>
                    <th>Количество товаров</th>
                    <th></th>
                </tr>

                @foreach($shops as $shop)
                    <tr>
                        <td>
                            {{ $shop->id }}
                        </td>
                        <td>
                            <a href="{{ $shop->site }}" target="_blank">
                                {{ \Str::replaceFirst('www.', '', parse_url($shop->site, PHP_URL_HOST)) }}
                                <i class="bi bi-box-arrow-up-right small"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ $shop->admitad_url }}" target="_blank">
                                <i class="bi bi-box-arrow-up-right small"></i>
                            </a>
                        </td>
                        <td>{{ $shop->group_count }}</td>
                        <td>{{ $shop->feed_offers_count->value ?? '-' }}</td>
                        <td>
                            <form class="d-inline" action="{{ route('admin.feeds.toggle-activity', $shop) }}" method="POST">
                                @method('patch')
                                @csrf

                                @if($shop->is_active)
                                    <button class="btn btn-success btn-sm">Отключить импорт</button>
                                @elseif($shop->isCanBeActive())
                                    <button class="btn btn-outline-primary btn-sm">Включить импорт</button>
                                @else
                                    <span data-bs-toggle="tooltip"
                                          data-bs-placement="right"
                                          title="Нельзя включить импорт без настроек импорта"
                                    >
                                        <span class="btn btn-outline-primary btn-sm disabled">Включить импорт</span>
                                    </span>
                                @endif
                            </form>
                            <a data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="Настройки импорта"
                               class="btn btn-outline-primary btn-sm" href="{{ route('admin.feeds.import-settings', $shop) }}"
                            >
                                <i class="bi bi-sliders"></i>
                            </a>
                            <a data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="Товары"
                               class="btn btn-outline-primary btn-sm" href="{{ route('admin.feeds.offers', $shop) }}"
                            >
                                <i class="bi bi-grid-3x3-gap"></i>
                            </a>
                            <a data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="Категории"
                               class="btn btn-outline-primary btn-sm" href="{{ route('admin.feeds.categories', $shop) }}"
                            >
                                <i class="bi bi-diagram-3"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

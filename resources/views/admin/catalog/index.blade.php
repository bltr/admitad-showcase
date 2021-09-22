@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Каталог</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <form>

                <fieldset class="row p-2 border border-secondary rounded">
                    <legend class="col-form-label col-12 text-secondary">Магазины</legend>
                    <div class="col-12 mb-3">
                        @foreach($shops as $shop)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="shop-{{ $shop->id }}"
                                       name="shop[]"
                                       value="{{ $shop->id }}"
                                       @if(in_array($shop->id, request()->shop ?? []))checked @endif
                                >
                                <label class="form-check-label" for="shop-{{ $shop->id }}">
                                    {{ $shop->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @if($shops->isNotEmpty())
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Применить</button>
                            <button type="reset" class="btn btn-info btn-sm">Сбросить</button>
                        </div>
                    @else
                        <div class="col-12 small text-secondary">Нет одобренных магазинов</div>
                    @endif
                </fieldset>
            </form>
        </div>

        <div class="col-10">
            <div class="row  row-cols-1 row-cols-md-4 g-4 mb-4">
                @foreach($offers as $offer)
                    <div class="col">
                        <div class="card h-100">
                            @if($offer->photos->count() > 1)
                                <div id="carouselIndicator{{ $offer->id }}" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="false">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselIndicator{{ $offer->id }}" data-bs-slide-to="0" class="active text-success" aria-current="true" aria-label="Slide 0">
                                            @for($i = 1; $i < $offer->photos->count(); $i++)
                                                <button type="button" data-bs-target="#carouselIndicator{{ $offer->id }}" data-bs-slide-to="{{ $i }}" aria-label="Slide {{ $i }}"></button>
                                        @endfor
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach($offer->photos as $photo)
                                            <div class="carousel-item {{ $loop->index === 0 ? 'active' : '' }}">
                                                <img src="{{ $photo }}" class="d-block w-100" alt="...">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicator{{ $offer->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicator{{ $offer->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @else
                                <img src="{{ $offer->photos->first() }}" class="d-block w-100" alt="...">
                            @endif

                            <div class="card-body">
                                <a class="card-title small" href="{{ $offer->not_sponsored_url }}" target="_blank">{{ $offer->name }} ⮭</a>
                                <p class="card-subtitle my-2 text-muted">{{ $offer->price }} р.</p>
                                <p class="card-subtitle my-2 text-muted">{{ $offer->shop->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($offers->isEmpty())
                <div class="small text-secondary text-center mt-5">Нет офферов</div>
            @endif

            {{ $offers->links() }}
        </div>
    </div>
@endsection

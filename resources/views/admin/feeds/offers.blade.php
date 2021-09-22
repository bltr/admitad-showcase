@extends('admin.feeds.layout')

@section('feed-content')
    @if($offers->isNotEmpty())
        <div class="row  row-cols-1 row-cols-md-4 g-4 mb-4">
            @foreach($offers as $offer)
                <div class="col">

                    <div class="card h-100">

                        @if($offer->pictures->count() > 1)
                        <div id="carouselIndicator{{ $offer->id }}" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="false">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselIndicator{{ $offer->id }}" data-bs-slide-to="0" class="active text-success" aria-current="true" aria-label="Slide 0">
                                @for($i = 1; $i < $offer->pictures->count(); $i++)
                                    <button type="button" data-bs-target="#carouselIndicator{{ $offer->id }}" data-bs-slide-to="{{ $i }}" aria-label="Slide {{ $i }}"></button>
                                @endfor
                            </div>
                            <div class="carousel-inner">
                                @foreach($offer->pictures as $picture)
                                    <div class="carousel-item {{ $loop->index === 0 ? 'active' : '' }}">
                                        <img src="{{ $picture }}" class="d-block w-100" alt="...">
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
                            <img src="{{ $offer->pictures->first() }}" class="d-block w-100" alt="...">
                        @endif

                        <div class="card-body">
                            <button type="button" class="btn btn-outline-secondary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $offer->id }}">🛈</button>
                            <a class="card-title small" href="{{ $offer->not_sponsored_url }}" target="_blank">{{ $offer->data->name }} ⮭</a>
                            <p class="card-subtitle my-2 text-muted">{{ $offer->data->price }} р.</p>
                            <p class="card-subtitle small fw-bold mb-2">{{ $offer->full_category_name }}</p>
                            <p class="card-text small">{{ $offer->data->description ?? '' }}</p>

                            <div class="modal fade" id="staticBackdrop{{ $offer->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <pre class="my-4">{{ $offer->raw_data }}</pre>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="my-5 text-center">
            Нет данных
        </div>
    @endif

    {{ $offers->links() }}
@endsection

@php
/**
 * @var \App\Models\Analytics $analytics
 */
@endphp
@if($analytics)
<h5>{{ $analytics->created_at }}</h5>
<div class="row  row-cols-1 row-cols-md-2 g-4 mb-4">
    @foreach($analytics->data as $code => $reportData)
        <div class="col">
            @include('admin._analytics.' . $code, $reportData)
        </div>
    @endforeach
</div>
@else
    <p class="my-5 small text-secondary text-center">Нет подготовленных данных</p>
@endif

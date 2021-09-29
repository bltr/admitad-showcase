@php
/**
 * @var \App\Models\Report $report
 */
@endphp
@if($report)
<h5>{{ $report->created_at }}</h5>
<div class="row  row-cols-1 row-cols-md-2 g-4 mb-4">
    @foreach($report->data as $code => $reportData)
        <div class="col">
            @include('admin.report.' . $code, $reportData)
        </div>
    @endforeach
</div>
@else
    <p class="my-5 small text-secondary text-center">Нет подготовленных данных</p>
@endif

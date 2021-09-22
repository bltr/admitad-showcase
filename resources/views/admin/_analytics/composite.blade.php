<h5>{{ $date }}</h5>
<div class="row  row-cols-1 row-cols-md-4 g-4 mb-4">
    @foreach($reports as $report)
        <div class="col">
            {!! $report->render() !!}
        </div>
    @endforeach
</div>

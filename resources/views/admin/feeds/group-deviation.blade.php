@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.feeds.index') }}">Фиды</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('admin.feeds.report', $shop) }}">{{ $shop->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Отклонения групп</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            @include('admin.report.feed.offers_count', $report->data['feed.offers_count'])
        </div>
        <div class="col-6">
            @include('admin.report.feed.groups_count', $report->data['feed.groups_count'])
        </div>
    </div>

    <div class="row">
        <div class="col">
            @forelse($paginator as $group_key=>$offer_ids)
                <h5 class="mt-5">
                    Группа по <span class="badge bg-info">{{ $group_key }}</span>
                    @if(str_contains($deviation_type, 'in_picture'))
                        <img src="{{ $group_key }}" loading="lazy" width="50">
                    @endif
                </h5>
                <table class="table table-bordered small">
                    @foreach($offer_ids as $id)
                        <tr>
                            <td>
                                <a href="{{ $offers[$id]->data->pictures[0] ?? '' }}" target="_blank">
                                    <img src="{{ $offers[$id]->data->pictures[0] ?? '' }}" loading="lazy" width="50">
                                </a>
                            </td>
                            <td>
                                {{ $offers[$id]->data->pictures[0] ?? '-' }}
                            </td>
                            <td>{{ $offers[$id]->data->group_id ?? '-' }}</td>
                            <td>
                                <a href="{{ $offers[$id]->not_sponsored_url }}" target="_blank">
                                    {{ $offers[$id]->not_sponsored_url }}
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modal{{ $id }}">🛈</button>
                                <div class="modal" id="modal{{ $id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <pre class="my-4">{{ $offers[$id]->raw_data }}</pre>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @empty
                нет отклонений
            @endforelse
            {!! $paginator->links() !!}
        </div>
    </div>
@endsection

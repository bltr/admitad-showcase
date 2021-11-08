@extends('admin.layout')

@section('content')
    <div class="row">
        @include('admin.feeds._nav', [compact('shop')])
    </div>

    <div class="row">
        <div class="col-2">
            @include('admin.feeds._import_settings_nav', compact('shop'))
        </div>

        <div class="col-10">
            <div class="row mb-4">
                <div class="col-6">
                    <form action="{{ route('admin.feeds.set-import-grouping', $shop) }}" method="POST">
                        @method('patch')
                        @csrf

                        <select name='import_type' id="import_type" class="form-select" onchange="this.form.submit()">
                            <option value="">-</option>
                            <option @if($shop->isImportWithoutGrouping()) selected @endif
                            value="{{ $shop::IMPORT_WITHOUT_GROUPING }}"
                            >
                                {{ $shop::IMPORT_WITHOUT_GROUPING }}
                            </option>
                            <option @if($shop->isImportGroupByGroupId()) selected @endif
                            value="{{ $shop::IMPORT_GROUP_BY_GROUP_ID }}"
                            >
                                {{ $shop::IMPORT_GROUP_BY_GROUP_ID }}
                            </option>
                            <option @if($shop->isImportGroupByPicture()) selected @endif
                            value="{{ $shop::IMPORT_GROUP_BY_PICTURE }}"
                            >
                                {{ $shop::IMPORT_GROUP_BY_PICTURE }}
                            </option>
                            <option @if($shop->isImportGroupByUrl()) selected @endif
                            value="{{ $shop::IMPORT_GROUP_BY_URL }}"
                            >
                                {{ $shop::IMPORT_GROUP_BY_URL }}
                            </option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">Количество offers</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Общее количество</td>
                                    <td>{{ $feed_offers_count }}</td>
                                </tr>
                                <tr>
                                    <td>Количество не валидных</td>
                                    <td>{{ $invalid_feed_offers_count }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">Количество групп и отклонения групп</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <td>group_id</td>
                                    <td>{{ $feed_offers_groups_count['group_id_count'] }}</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Отклонения по picture в группах по group_id"
                                    >
                                        <span class="text-danger text-decoration-none">p:</span>
                                        @if(!empty($feed_offers_group_deviations['picture_deviation_in_group_id_group']))
                                            <a href="{{ route('admin.feeds.import-grouping', [$shop, 'deviation_type' => 'picture_deviation_in_group_id_group']) }}"
                                               class="badge text-dark @if(request()->deviation_type === 'picture_deviation_in_group_id_group') bg-danger @endif"
                                            >
                                                {{ count($feed_offers_group_deviations['picture_deviation_in_group_id_group']) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Отклонения по url в группах по group"
                                    >
                                        <span class="text-danger">u:</span>
                                        @if(!empty($feed_offers_group_deviations['url_deviation_in_group_id_group']))
                                            <a href="{{ route('admin.feeds.import-grouping', [$shop, 'deviation_type' => 'url_deviation_in_group_id_group']) }}"
                                               class="badge text-dark @if(request()->deviation_type === 'url_deviation_in_group_id_group') bg-danger @endif"
                                            >
                                                {{ count($feed_offers_group_deviations['url_deviation_in_group_id_group']) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>picture</td>
                                    <td>{{ $feed_offers_groups_count['picture_count'] }}</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Отклонения по group_id в группах по picture"
                                    >
                                        <span class="text-danger">g:</span>
                                        @if(!empty($feed_offers_group_deviations['group_id_deviation_in_picture_group']))
                                            <a href="{{ route('admin.feeds.import-grouping', [$shop, 'deviation_type' => 'group_id_deviation_in_picture_group']) }}"
                                               class="badge text-dark @if(request()->deviation_type === 'group_id_deviation_in_picture_group') bg-danger @endif"
                                            >
                                                {{ count($feed_offers_group_deviations['group_id_deviation_in_picture_group']) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Отклонения по url в группах по picture"
                                    >
                                        <span class="text-danger">u:</span>
                                        @if(!empty($feed_offers_group_deviations['url_deviation_in_picture_group']))
                                            <a href="{{ route('admin.feeds.import-grouping', [$shop, 'deviation_type' => 'url_deviation_in_picture_group']) }}"
                                               class="badge text-dark @if(request()->deviation_type === 'url_deviation_in_picture_group') bg-danger @endif"
                                            >
                                                {{ count($feed_offers_group_deviations['url_deviation_in_picture_group']) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td>url</td>
                                    <td>{{ $feed_offers_groups_count['url_count'] }}</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Отклонения по group_id в группах по url"
                                    >
                                        <span class="text-danger">g:</span>
                                        @if(!empty($feed_offers_group_deviations['group_id_deviation_in_url_group']))
                                            <a href="{{ route('admin.feeds.import-grouping', [$shop, 'deviation_type' => 'group_id_deviation_in_url_group']) }}"
                                               class="badge text-dark @if(request()->deviation_type === 'group_id_deviation_in_url_group') bg-danger @endif"
                                            >
                                                {{ count($feed_offers_group_deviations['group_id_deviation_in_url_group']) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Отклонения по picture в группах по url"
                                    >
                                        <span class="text-danger">p:</span>
                                        @if(!empty($feed_offers_group_deviations['picture_deviation_in_url_group']))
                                            <a href="{{ route('admin.feeds.import-grouping', [$shop, 'deviation_type' => 'picture_deviation_in_url_group']) }}"
                                               class="badge text-dark @if(request()->deviation_type === 'picture_deviation_in_url_group') bg-danger @endif"
                                            >
                                                {{ count($feed_offers_group_deviations['picture_deviation_in_url_group']) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if($paginator)
                <div class="row">
                    <div class="col">
                        @foreach($paginator as $group_key=>$offer_ids)
                            <h5 class="mt-5">
                                Группа по <span class="badge bg-info">{{ $group_key }}</span>
                                @if(str_contains(request()->deviation_type, 'in_picture'))
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
                        @endforeach
                        {!! $paginator->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

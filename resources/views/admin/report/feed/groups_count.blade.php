<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title text-center">Количество групп и отклонения групп</h5>
        <table class="table table-bordered">
            <tr>
                <td>group_id</td>
                <td>{{ $group_id_count }}</td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по picture в группах по group_id"
                >
                    <span class="text-danger text-decoration-none">p:</span>
                    @if(!empty($deviations['picture_deviation_in_group_id_group']))
                        <a href="{{ route('admin.feeds.report.group-deviation', [$shop, $report, 'deviation_type' => 'picture_deviation_in_group_id_group']) }}"
                           @class(['badge text-dark', 'bg-danger' => request()->deviation_type === 'picture_deviation_in_group_id_group'])
                        >
                            {{ count($deviations['picture_deviation_in_group_id_group']) }}
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
                    @if(!empty($deviations['url_deviation_in_group_id_group']))
                        <a href="{{ route('admin.feeds.report.group-deviation', [$shop, $report, 'deviation_type' => 'url_deviation_in_group_id_group']) }}"
                           @class(['badge text-dark', 'bg-danger' => request()->deviation_type === 'url_deviation_in_group_id_group'])
                        >
                            {{ count($deviations['url_deviation_in_group_id_group']) }}
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>picture</td>
                <td>{{ $picture_count }}</td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по group_id в группах по picture"
                >
                    <span class="text-danger">g:</span>
                    @if(!empty($deviations['group_id_deviation_in_picture_group']))
                        <a href="{{ route('admin.feeds.report.group-deviation', [$shop, $report, 'deviation_type' => 'group_id_deviation_in_picture_group']) }}"
                           @class(['badge text-dark', 'bg-danger' => request()->deviation_type === 'group_id_deviation_in_picture_group'])
                        >
                            {{ count($deviations['group_id_deviation_in_picture_group']) }}
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
                    @if(!empty($deviations['url_deviation_in_picture_group']))
                        <a href="{{ route('admin.feeds.report.group-deviation', [$shop, $report, 'deviation_type' => 'url_deviation_in_picture_group']) }}"
                           @class(['badge text-dark', 'bg-danger' => request()->deviation_type === 'url_deviation_in_picture_group'])
                        >
                            {{ count($deviations['url_deviation_in_picture_group']) }}
                        </a>
                    @else
                        -
                    @endif
                </td>

            </tr>
            <tr>
                <td>url</td>
                <td>{{ $url_count }}</td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по group_id в группах по url"
                >
                    <span class="text-danger">g:</span>
                    @if(!empty($deviations['group_id_deviation_in_url_group']))
                        <a href="{{ route('admin.feeds.report.group-deviation', [$shop, $report, 'deviation_type' => 'group_id_deviation_in_url_group']) }}"
                           @class(['badge text-dark', 'bg-danger' => request()->deviation_type === 'group_id_deviation_in_url_group'])
                        >
                            {{ count($deviations['group_id_deviation_in_url_group']) }}
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по picture в группах по url"
                >
                    <span class="text-danger">u:</span>
                    @if(!empty($deviations['picture_deviation_in_url_group']))
                        <a href="{{ route('admin.feeds.report.group-deviation', [$shop, $report, 'deviation_type' => 'picture_deviation_in_url_group']) }}"
                           @class(['badge text-dark', 'bg-danger' => request()->deviation_type === 'picture_deviation_in_url_group'])
                        >
                            {{ count($deviations['picture_deviation_in_url_group']) }}
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

        <form action="{{ route('admin.feeds.import-type', $shop) }}" method="POST">
            @method('patch')
            @csrf

            <label for="import_type" class="form-label">Тип импорта</label>
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

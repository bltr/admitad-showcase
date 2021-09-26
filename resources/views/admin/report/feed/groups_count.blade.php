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
                    @if(!empty($deviations['picture_deviation_in_group_id_group']))
                        <a href="#" class="text-danger text-decoration-none">p</a>
                    @else
                        -
                    @endif
                </td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по url в группах по group"
                >
                    @if(!empty($deviations['url_deviation_in_group_id_group']))
                        <span class="text-danger">u</span>
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
                    @if(!empty($deviations['group_id_deviation_in_picture_group']))
                        <span class="text-danger">g</span>
                    @else
                        -
                    @endif
                </td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по url в группах по picture"
                >
                    @if(!empty($deviations['url_deviation_in_picture_group']))
                        <span class="text-danger">u</span>
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
                    @if(!empty($deviations['group_id_deviation_in_url_group']))
                        <span class="text-danger">g</span>
                    @else
                        -
                    @endif
                </td>
                <td data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Отклонения по picture в группах по url"
                >
                    @if(!empty($deviations['picture_deviation_in_url_group']))
                        <span class="text-danger">u</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

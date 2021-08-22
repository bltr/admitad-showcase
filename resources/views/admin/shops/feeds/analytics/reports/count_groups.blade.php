<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title text-center">Количество групп и отклонения групп</h5>
        <table class="table table-bordered">
            <tr>
                <td>group_id</td>
                <td>{{ $group_id_count }}</td>
                <td>
                    @if(!empty($deviations['group_id_picture']))
                        <span class="text-danger">p</span>
                    @endif
                </td>
                <td>
                    @if(!empty($deviations['group_id_url']))
                        <span class="text-danger">u</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>picture</td>
                <td>{{ $picture_count }}</td>
                <td>
                    @if(!empty($deviations['picture_group_id']))
                        <span class="text-danger">g</span>
                    @endif
                </td>
                <td>
                    @if(!empty($deviations['picture_url']))
                        <span class="text-danger">u</span>
                    @endif
                </td>

            </tr>
            <tr>
                <td>url</td>
                <td>{{ $url_count }}</td>
                <td>
                    @if(!empty($deviations['url_group_id']))
                        <span class="text-danger">g</span>
                    @endif
                </td>
                <td>
                    @if(!empty($deviations['url_picture']))
                        <span class="text-danger">u</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

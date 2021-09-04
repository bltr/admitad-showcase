<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title text-center">Количество offers</h5>
        <table class="table table-bordered">
            <tr>
                <td>Общее количество</td>
                <td>{{ $count }}</td>
            </tr>
            <tr>
                <td>Количество не валидных</td>
                <td>{{ $invalid_count }}</td>
            </tr>
        </table>
    </div>
</div>

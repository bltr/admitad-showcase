<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title text-center">Различные поля offers</h5>
        <table class="table table-bordered">
            @foreach($fields as $field)
                <tr>
                    <td>{{ $field }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div><?php

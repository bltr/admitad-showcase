<div class="card h-100">
    <div class="card-body">
        <h5 class="card-title text-center">{{ $lable }}</h5>
        <p class="card-text text-center text-secondary small">{{ $desc }}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between px-4">
            <span>group_id</span>
            <span class="text-info fw-bold">{{ $group_id_count }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between px-4">
            <span>url</span>
            <span class="text-info fw-bold">{{ $url_count }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between px-4">
            <span>picture</span>
            <span class="text-info fw-bold">{{ $picture_count }}</span>
        </li>
    </ul>
</div>

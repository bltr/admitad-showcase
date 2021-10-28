<div class="me-auto">{{ $item->name }}</div>

<button class="btn btn-outline-primary" data-bs-toggle="modal"
        data-bs-target="#choiceParentModal"
        data-category-id="{{ $item->id }}"
        data-link="{{ route('admin.catalog.categories.append-to', $item) }}"
>
    <i class="bi bi-diagram-2-fill"></i>

{{--     модальное окно которым управляет эта кнопка--}}
    @once
        @push('modal')
            @include('admin.catalog.categories.index._change-parent', ['root' => $rootCategory, 'categories' => $items])
        @endpush
    @endonce
</button>

<form method="POST" action="{{ route('admin.catalog.categories.up', $item) }}" class="ms-1">
    @csrf
    <button class="btn btn-outline-primary"><i class="bi bi-chevron-up"></i></button>
</form>

<form method="POST" action="{{ route('admin.catalog.categories.down', $item) }}" class="ms-1">
    @csrf
    <button class="btn btn-outline-primary"><i class="bi bi-chevron-down"></i></button>
</form>

<form method="POST" action="{{ route('admin.catalog.categories.first', $item) }}" class="ms-1">
    @csrf
    <button class="btn btn-outline-primary"><i class="bi bi-chevron-double-up"></i></button>
</form>

<form method="POST" action="{{ route('admin.catalog.categories.last', $item) }}" class="ms-1">
    @csrf
    <button class="btn btn-outline-primary"><i class="bi bi-chevron-double-down"></i></button>
</form>

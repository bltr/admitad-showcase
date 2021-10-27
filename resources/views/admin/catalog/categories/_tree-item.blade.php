<div class="me-auto">{{ $item->name }}</div>

<button class="btn btn-outline-primary" data-bs-toggle="modal"
        data-bs-target="#choiceParentModal"
        data-category-id="{{ $item->id }}"
        data-link="{{ route('admin.catalog.append-to', $item) }}"
>
    <i class="bi bi-list"></i>

{{--     модальное окно которым управляет эта кнопка--}}
    @once
        @push('modal')
            @include('admin.catalog.categories.modal.change-parent-form', ['root' => $rootCategory, 'categories' => $items])
        @endpush
    @endonce
</button>

{{--<form method="POST" action="{{ route('categories.up', $item) }}" class="ms-1">--}}
{{--    @csrf--}}
{{--    <button class="btn btn-outline-primary"><i class="bi bi-chevron-up"></i></button>--}}
{{--</form>--}}

{{--<form method="POST" action="{{ route('categories.down', $item) }}" class="ms-1">--}}
{{--    @csrf--}}
{{--    <button class="btn btn-outline-primary"><i class="bi bi-chevron-down"></i></button>--}}
{{--</form>--}}

{{--<form method="POST" action="{{ route('categories.first', $item) }}" class="ms-1">--}}
{{--    @csrf--}}
{{--    <button class="btn btn-outline-primary"><i class="bi bi-chevron-double-up"></i></button>--}}
{{--</form>--}}

{{--<form method="POST" action="{{ route('categories.last', $item) }}" class="ms-1">--}}
{{--    @csrf--}}
{{--    <button class="btn btn-outline-primary"><i class="bi bi-chevron-double-down"></i></button>--}}
{{--</form>--}}

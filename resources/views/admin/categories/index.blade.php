@extends('admin.layout')

@section('content')
    <div class="row my-1">
        <div class="col">
            <div class="float-end">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success"><i class="bi-plus"></i></a>
            </div>
        </div>
    </div>

    <div class="row my-1">
        <div class="col">
            @component('components.tree', ['items' => $categories,'id' => 'categories'])
                @scopedSlot('itemTemplate', ($item), ($categories))
                    <div class="me-auto">{{ $item->name }}</div>

                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#change-parent-modal"
                            data-category-id="{{ $item->id }}"
                            data-link="{{ route('admin.categories.append-to', $item) }}"
                    >
                        <i class="bi bi-diagram-2-fill"></i>

                        {{-- модальное окно которым управляет эта кнопка--}}
                        @once
                            @push('modal')
                                @include('admin.categories._change-parent-modal', ['categories' => $categories])
                            @endpush
                        @endonce
                    </button>

                    <form method="POST" action="{{ route('admin.categories.up', $item) }}" class="ms-1">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-outline-primary"><i class="bi bi-chevron-up"></i></button>
                    </form>

                    <form method="POST" action="{{ route('admin.categories.down', $item) }}" class="ms-1">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-outline-primary"><i class="bi bi-chevron-down"></i></button>
                    </form>

                    <form method="POST" action="{{ route('admin.categories.first', $item) }}" class="ms-1">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-outline-primary"><i class="bi bi-chevron-double-up"></i></button>
                    </form>

                    <form method="POST" action="{{ route('admin.categories.last', $item) }}" class="ms-1">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-outline-primary"><i class="bi bi-chevron-double-down"></i></button>
                    </form>

                    <a class="btn btn-outline-primary ms-1" href="{{ route('admin.categories.edit', $item) }}">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <form method="POST" action="{{ route('admin.categories.destroy', $item) }}" class="ms-1">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger" @if($item->children->isNotEmpty()) disabled @endif><i class="bi bi-folder-minus"></i></button>
                    </form>
                @endScopedSlot
            @endcomponent
        </div>
    </div>
@endsection

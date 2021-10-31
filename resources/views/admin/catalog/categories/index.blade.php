@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active">Каталог</li>
                    <li class="breadcrumb-item active" aria-current="page">Категории</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <div class="btn-group">
                @foreach($rootCategories as $category)
                    <a type="button"
                       class="btn btn-primary {{ $rootCategory->is($category) ? 'active' : '' }}"
                       href="{{ route('admin.catalog.categories.index', $category) }}"
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="float-end">
                <a href="{{ route('admin.catalog.categories.create') }}" class="btn btn-success"><i class="bi-plus"></i></a>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            @component('components.tree', [
                'items' => $categories,
                'id' => 'a'
            ])
                @scopedSlot('itemTemplate', ($item), ($rootCategory, $categories))
                    <div class="me-auto">{{ $item->name }}</div>

                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#choiceParentModal"
                            data-category-id="{{ $item->id }}"
                            data-link="{{ route('admin.catalog.categories.append-to', $item) }}"
                    >
                        <i class="bi bi-diagram-2-fill"></i>

                        {{-- модальное окно которым управляет эта кнопка--}}
                        @once
                            @push('modal')
                                @include('admin.catalog.categories.index._change-parent', ['root' => $rootCategory, 'categories' => $categories])
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
                @endScopedSlot
            @endcomponent
        </div>
    </div>
@endsection

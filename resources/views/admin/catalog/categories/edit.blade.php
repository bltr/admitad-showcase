@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active">Каталог</li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('admin.catalog.categories.index') }}">Категории</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Изменить</li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.catalog.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-6">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label">Название</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control
                            @error('name')) is-invalid @enderror" id="name"
                               value="{{ old('name', $category->name) }}"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Создать</button>
            </div>

            <div class="col-6">
                <div class="d-flex">
                    <div class="ms-5">
                        <input
                            type="radio"
                            class="form-check-input"
                            name="parent_id"
                            value=""
                            @if(old('parent_id') === null) checked @endif
                        >
                    </div>
                    <div class="ms-2 me-auto ps-1 mb-2">Без родителя</div>
                </div>

                @component('components.tree', ['items' => $categories, 'id' => 'categories'])
                    @scopedSlot('itemTemplate', ($item), ($category))
                        <div class="me-2">
                            <input
                                type="radio"
                                class="form-check-input"
                                name="parent_id"
                                value="{{ $item->id }}"
                                @if($item->id === $category->id || $item->isDescendantOf($category)) disabled @endif
                                @if(old('parent_id', $category->parent_id) == $item->id) checked @endif
                            >
                        </div>

                        <div class="me-auto ms-1">{{ $item->name }}</div>
                    @endScopedSlot
                @endcomponent
            </div>
        </div>
    </form>
@endsection

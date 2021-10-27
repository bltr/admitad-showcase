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
            @include('components.tree', [
                'items' => $categories,
                'itemTemplate' => 'admin.catalog.categories._tree-item',
                'id' => 'a'
            ])
        </div>
    </div>
@endsection

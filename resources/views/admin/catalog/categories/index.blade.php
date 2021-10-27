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

    <div class="row">
        <div class="col">
            <div class="btn-group">
                @foreach($rootCategories as $rootCategory)
                    <a type="button"
                       class="btn btn-primary {{ $currentRootCategory->is($rootCategory) ? 'active' : '' }}"
                       href="{{ route('admin.catalog.categories.index', $rootCategory) }}"
                    >
                        {{ $rootCategory->name }}
                    </a>
                @endforeach
            </div>

            <div class="float-end">
                <a href="{{ route('admin.catalog.categories.create') }}" class="btn btn-success"><i class="bi-plus"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <ul>
                @foreach($categories as $category)
                    <li>{{ str_repeat(' -', $category->depth) . $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

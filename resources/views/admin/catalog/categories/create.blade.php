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
                    <li class="breadcrumb-item active" aria-current="page">Создать</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form method="POST" action="{{ route('admin.catalog.categories.store') }}">
                @csrf
                @method('POST')

                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Название</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                    <div class="col-sm-10">
                        <input type="text" name="slug" class="form-control" id="slug">
                    </div>
                </div>

                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Пол</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sex" id="women" value="women" checked>
                            <label class="form-check-label" for="women">
                                Женщина
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sex" id="men" value="men">
                            <label class="form-check-label" for="men">
                                Мужчина
                            </label>
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
        </div>
    </div>
@endsection

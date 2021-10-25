@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Каталог</li>
                    <li class="breadcrumb-item active" aria-current="page">Категории</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col">
        </div>
    </div>
@endsection

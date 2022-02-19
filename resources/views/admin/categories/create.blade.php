@extends('admin.layouts.layout')
@section('content')

<div class="container">
    <div style="margin-top: 65px">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 style="margin-bottom: 25px;">Добавление новой категории</h2>
    <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Название категории</label>
            <input name="name"  type="text" value="{{old('name')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Название категории en</label>
            <input name="name_en"  type="text" value="{{old('name_en')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание</label>
            <input name="description" value="{{old('description')}}" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание en</label>
            <input name="description_en" value="{{old('description_en')}}" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Картинка</label>
            <input name="image" type="file" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>


@endsection

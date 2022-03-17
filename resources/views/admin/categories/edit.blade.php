@extends('auth.layouts.master')
@section('content')


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

        <h2 style="margin-bottom: 25px;">Редактирование категории</h2>
    <form method="post" action="{{route('categories.update', ['category' => $category->id])}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="exampleInputEmail1">Название категории</label>
            <input value="{{$category->name}}" name="name"  type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Название категории en</label>
            <input value="{{$category->name_en}}" name="name_en"  type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание</label>
            <input value="{{$category->description}}" name="description" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание en</label>
            <input value="{{$category->description_en}}" name="description_en" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <img width="30%" src="{{$category->getImage()}}" alt="" >
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Заменить изображение</label>
            <input name="image" type="file" class="form-control" id="exampleInputPassword1">
        </div>
        <button  type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>



@endsection

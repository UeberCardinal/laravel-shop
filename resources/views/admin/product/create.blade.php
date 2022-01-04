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

        <h2 style="margin-bottom: 25px;">Добавление нового продукта</h2>
    <form method="post" action="{{route('products.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Название продукта</label>
            <input name="name" type="text" value="{{old('name')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание</label>
            <input name="description" value="{{old('description')}}" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Цена</label>
            <input name="price" value="{{old('price')}}" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Количество</label>
            <input name="count" value="{{old('count')}}" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Категории</label>
            <select name="category_id" class="form-control" id="exampleFormControlSelect1">
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        @foreach([
    'hit' => 'Хит продаж',
    'new' => 'Новинка',
    'recommend' => 'Рекомендуемые',
    ] as $field => $title)
        <div class="form-group">
            <label for="exampleInputEmail1">{{$title}}:</label>
            <input name="{{$field}}" type="checkbox" class="checkbox-inline" id="exampleInputEmail1">

        </div>
        @endforeach
        <div class="form-group">
            <label for="exampleInputPassword1">Картинка</label>
            <input name="image" type="file" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>


@endsection

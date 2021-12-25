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

        <h2 style="margin-bottom: 25px;">Редактирование продукта</h2>
    <form method="post" action="{{route('products.update', ['product' => $product->id])}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="exampleInputEmail1">Название продукта</label>
            <input value="{{$product->name}}" name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание</label>
            <input value="{{$product->description}}" name="description" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Цена</label>
            <input value="{{$product->price}}" name="price" type="text" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Категории</label>
            <select name="category_id" class="form-control" id="exampleFormControlSelect1">
                @foreach($categories as $category)
                    <option @if($category->id == $product->category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
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
                <input name="{{$field}}" @if($product->$field == 1) checked @endif type="checkbox" class="checkbox-inline" id="exampleInputEmail1">

            </div>
        @endforeach

        <div class="form-group">
            <label for="exampleInputPassword1">Заменить изображение</label>
            <input name="image" type="file" class="form-control" id="exampleInputPassword1">
        </div>
        <button  type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>


@endsection

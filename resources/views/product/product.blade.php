@extends('master')
@section('content')
    <div class="starter-template">
        <h1>{{$product->name}}</h1>
        <h2>{{$product->category->name}}</h2>
        <p>Цена: <b>{{$product->price}} ₽</b></p>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg">
        <p>{{$product->description}}</p>
        <form action="{{route('addToBasket', $product->id)}}" method="POST">
            @csrf
            @if($product->isAvailable())
                <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
            @else
                Нет в наличии
            @endif

        </form>
    </div>
@endsection

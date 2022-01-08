@extends('master')
@section('content')
    <div class="starter-template">
        <h1>{{$product->name}}</h1>
        <h2>{{$product->category->name}}</h2>
        <p>Цена: <b>{{$product->price}} ₽</b></p>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg">
        <p>{{$product->description}}</p>
        @if($product->isAvailable())
            <form action="{{route('addToBasket', $product->id)}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
            </form>
        @else
            <span>Нет в наличии</span><br>
            <span>Сообщить о наличии товара: </span>
            <div>
                @if($errors->get('email'))
                    <div class="alert alert-warning">
                        {{$errors->get('email')[0]}}
                    </div>
                @endif
            </div>

            <form action="{{route('subscription', $product)}}" method="post">
                @csrf
                <input type="text" name="email">
                <button type="submit">Отправить</button>
            </form>
        @endif
    </div>
@endsection

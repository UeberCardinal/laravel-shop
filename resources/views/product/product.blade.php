@extends('master')
@section('content')
    <div class="starter-template">
        <h1>{{$sku->product->__('name')}}</h1>
        <h2>{{$sku->product->category->__('name')}}</h2>
        <p>Цена: <b>{{$sku->price}}  {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</b></p>
        @isset($sku->product->properties)
            @foreach($sku->propertyOption as $propertyOption)
                <h5>{{$propertyOption->property->name}}: {{$propertyOption->name}}</h5>
            @endforeach
        @endisset
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg">
        <p>{{$sku->product->__('description')}}</p>
        @if($sku->isAvailable())
            <form action="{{route('addToBasket', $sku->product->id)}}" method="POST">
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

            <form action="{{route('subscription', $sku->product)}}" method="post">
                @csrf
                <input type="text" name="email">
                <button type="submit">Отправить</button>
            </form>
        @endif
    </div>
@endsection

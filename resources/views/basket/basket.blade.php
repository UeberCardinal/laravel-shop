@extends('master')
@section('content')
<div class="starter-template">

{{--        @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{\Illuminate\Support\Facades\Session::get('success')}}
            </div>
        @endif--}}
{{--        @if(\Illuminate\Support\Facades\Session::has('warning'))
            <div class="alert alert-warning" role="alert">
                {{\Illuminate\Support\Facades\Session::get('warning')}}
            </div>
        @endif--}}
    <h1>Корзина</h1>
    <p>Оформление заказа</p>
    <div class="panel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($order))
            @foreach($order->skus as $sku)
            <tr>
                <td>
                    <a href="{{route('sku', [$sku->product->category->slug, $sku->product->slug, $sku])}}">
                        <img height="56px" src="http://internet-shop.tmweb.ru/storage/products/iphone_x_silver.jpg">
                        {{$sku->product->name}}
                    </a>
                </td>
                <td><span class="badge">{{$sku->countInOrder}}</span>
                    <div class="btn-group form-inline">
                        <form action="{{route('removeFromBasket', [$sku->id])}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" href=""><span
                                    class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                        </form>
                        <form action="{{route('addToBasket', $sku->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                    href=""><span
                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                        </form>
                    </div>
                </td>
                <td>{{$sku->price}}  {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</td>
                <td>{{$sku->price * ($sku->countInOrder)}}  {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</td>

            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="3">Общая стоимость:</td>
                @if($order->hasCoupon())
                <td>
                    <h5><s>{{$order->getFullSum(false)}} {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</s></h5>
                    <h4>{{$order->getFullSum()}} {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</h4>
                </td>
                @else
                    <td>
                        <h4>{{$order->getFullSum()}} {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</h4>
                    </td>
                @endif
            </tr>

            </tbody>
        </table>
        @if(!$order->hasCoupon())
        <div class="row">
            <div class="form-inline pull-center">
                <form method="post" action="{{route('setCoupon')}}">
                    @csrf
                    <label for="coupon">Добавить купон:</label>
                    <input class="form-control" type="text" name="coupon">
                    <button type="submit" class="btn btn-success">Применить</button>
                </form>
            </div>
        </div>
        @else
            <div>Вы используете купон {{$order->coupon->code}}</div>
        @endif
        @error('coupon')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{route('basketPlace')}}">Оформить заказ</a>
        </div>


    </div>
</div>
@endsection

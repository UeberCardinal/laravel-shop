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
            @foreach($order->products()->with('category')->get() as $product)
            <tr>
                <td>
                    <a href="{{route('product', [$product->category->slug, $product->slug])}}">
                        <img height="56px" src="http://internet-shop.tmweb.ru/storage/products/iphone_x_silver.jpg">
                        {{$product->name}}
                    </a>
                </td>
                <td><span class="badge">{{$product->pivot->count}}</span>
                    <div class="btn-group form-inline">
                        <form action="{{route('removeFromBasket', [$product->id])}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" href=""><span
                                    class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                        </form>
                        <form action="{{route('addToBasket', $product->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                    href=""><span
                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                        </form>
                    </div>
                </td>
                <td>{{$product->price}} ₽</td>
                <td>{{$product->sumProduct()}} ₽</td>

            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="3">Общая стоимость:</td>
                <td>
                    {{$order->getFullSum()}}₽
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{route('basketPlace')}}">Оформить заказ</a>
        </div>
    </div>
</div>
@endsection

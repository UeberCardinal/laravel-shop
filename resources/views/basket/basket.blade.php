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
                <td>
                    <h4>{{$order->getFullSum()}} {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</h4>
                    @if(session()->has('fullSumWithoutPromocode'))
                        <s>{{session('fullSumWithoutPromocode')}} {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</s>
                        @endif
                </td>
            </tr>

            </tbody>
        </table>
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{route('basketPlace')}}">Оформить заказ</a>
        </div>
        <div style="display: inline-flex;"  role="group">
            <form method="post" action="{{route('applyPromocode')}}">
                @csrf
                <div class="input-group mb-3">
                    <input name="promocode" type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">Введите промокод на скидку</span>
                    </div>
                </div>
                @if(\App\Models\Promocode::getPromocode())
                    <div>
                        <a class="btn btn-primary" href="{{route('removePromocode')}}" role="button">Удалить промокод</a>
                    </div>
                @else
                <div class="btn-group pull-right" role="group">
                    <input value="Применить" type="submit" class="btn btn-success">
                </div>
                    @endif

            </form>


        </div>



    </div>
</div>
@endsection

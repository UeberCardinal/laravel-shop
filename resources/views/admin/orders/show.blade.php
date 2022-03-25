@extends('auth.layouts.master')

@section('title', 'Заказ ' . $order->id)

@section('content')
                <div class="panel">
                    <h1>Заказ №{{ $order->id }}</h1>
                    <p>Заказчик: <b>{{ $order->name }}</b></p>
                    <p>Номер телефона: <b>{{ $order->phone }}</b></p>
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
                        @foreach ($skus as $sku)
                            <tr>
                                <td>

                                    <a href="{{ route('sku', [$sku->product->category->slug, $sku->product->slug, $sku]) }}">
                                        <img height="56px"
                                             src="{{ $sku->product->getImage()}}">
                                        {{ $sku->product->name }}
                                    </a>
                                </td>
                                {{--@dd($order->skus->map->pivot->map->count)--}}
                                <td><span class="badge">{{$sku->pivot->count}}</span></td>
                                <td>{{ $sku->price }} {{$order->currency->symbol}}</td>
                                <td>{{ $sku->sumProduct()}} {{$order->currency->symbol}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">Общая стоимость:</td>
                            <td>{{ $order->sum }} {{$order->currency->symbol}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                </div>

@endsection

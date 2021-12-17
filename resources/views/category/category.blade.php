@extends('master')
@section('content')
    <div class="starter-template">
        <h1>
            {{$categoryObj->name}}
        </h1>
        <h2>
            {{$categoryObj->code}}
        </h2>
        <p>
            {{$categoryObj->description}}
        </p>
        <p>
            Товаров в категории:{{$categoryObj->products->count()}}
        </p>
        <div class="row">
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="labels">


                    </div>
                    <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg" alt="iPhone X 64GB">
                    <div class="caption">
                        <h3>{{$product->name}}</h3>
                        <p>{{$product->price}} ₽</p>
                        <p>
                        <form action="https://internet-shop.tmweb.ru/basket/add/1" method="POST">
                            <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                            <a href="{{route('product', [$categoryObj->slug, $product->slug])}}"
                               class="btn btn-default"
                               role="button">Подробнее</a>
                            <input type="hidden" name="_token" value="yJvutjVZgUZGiAlPk6dHtqpoEDm78NWLuJEqNUsv">            </form>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{$products->links()}}
    </div>
@endsection

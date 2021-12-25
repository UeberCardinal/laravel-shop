@extends('master')
@section('content')
    <div class="starter-template">

        <h1>Все товары</h1>
        <form method="GET" action="{{route('home.index')}}">
            <div class="filters row">
                <div class="col-sm-6 col-md-3">
                    <label for="price_from">Цена от
                        <input type="text" name="price_from" id="price_from" size="6" value="{{request()->price_from}}">
                    </label>
                    <label for="price_to">до
                        <input type="text" name="price_to" id="price_to" size="6" value="{{request()->price_to}}" >
                    </label>
                </div>

                <div class="col-sm-2 col-md-2">

                    <label for="hit">
                        <input type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif> Хит
                    </label>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="new">
                        <input type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif >
                        Новинка
                    </label>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="recommend">
                        <input type="checkbox" name="recommend" id="recommend" @if(request()->has('recommend')) checked @endif >
                        Рекомендуем
                    </label>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-primary">Фильтр</button>
                    <a href="{{route('home.index')}}" class="btn btn-warning">Сброс</a>
                </div>
            </div>
        </form>
        <div class="row">
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="labels">
                        @if($product->isHit())
                    <span class="badge badge-danger">Хит</span>
                        @endif
                            @if($product->isNew())
                        <span class="badge badge-success">Новинка</span>
                            @endif
                                @if($product->isRecommend())
                        <span class="badge badge-warning">Рекомендуемые</span>
                            @endif
                    </div>
                    <img src="https://dummyimage.com/400x600/decede/aeb2e8.jpg&text=Test" alt="iPhone X 64GB">
                    <div class="caption">
                        <h3>{{$product->name}}</h3>
                        <p>{{$product->category->name}} </p>
                        <p>{{$product->price}} ₽</p>
                        <form action="{{route('addToBasket', $product->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                            <a href="{{route('product', [$product->category->slug, $product->slug])}}"
                               class="btn btn-default"
                               role="button">Подробнее</a>
                             </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $products->appends([
    'price_from' => request()->price_from,
    'price_to'   => request()->price_to,
    'hit'        => request()->hit,
    'new'        => request()->new,
    'recommend'  => request()->recommend,
])->links()}}
    </div>
@endsection

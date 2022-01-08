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
                <img src="https://dummyimage.com/400x600/decede/aeb2e8.jpg&text=Test">
                <div class="caption">
                    <h3>{{$product->name}}</h3>
                    <p>{{$product->category->name}} </p>
                    <p>{{$product->price}} ₽</p>
                    <form action="{{route('addToBasket', $product->id)}}" method="post">
                        @csrf
                        @if($product->isAvailable())
                            <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                        @else
                            Нет в наличии
                            @endif

                        <a href="{{route('product', [$product->category->slug, $product->slug])}}"
                           class="btn btn-default"
                           role="button">Подробнее</a>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

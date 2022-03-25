
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="labels">
                @if($sku->product->isHit())
                        <span class="badge badge-danger">Хит</span>
                    @endif
                    @if($sku->product->isNew())
                        <span class="badge badge-success">Новинка</span>
                    @endif
                    @if($sku->product->isRecommend())
                        <span class="badge badge-warning">Рекомендуемые</span>
                    @endif
                </div>
                @if(!is_null($sku->product->image))
                    <img src="{{$sku->product->getImage()}}">
                @else
                <img src="https://dummyimage.com/400x600/decede/aeb2e8.jpg&text=Test">
                @endif
                <div class="caption">
                    <h3>{{$sku->product->__('name')}}</h3>
                    @isset($sku->product->properties)
                        @foreach($sku->propertyOption as $propertyOption)
                            <h5>{{$propertyOption->property->name}}: {{$propertyOption->name}}</h5>
                        @endforeach
                    @endisset
                    <p>{{$sku->product->category->__('name')}} </p>
                    <p>{{$sku->price}} {{\App\Services\CurrencyConversion::getCurrencySymbol()}}</p>
                    <form action="{{route('addToBasket', $sku)}}" method="post">
                        @csrf
                        @if($sku->isAvailable())
                            <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                        @else
                            Нет в наличии
                            @endif

                        <a href="{{route('sku', [$sku->product->category->slug, $sku->product->slug, $sku])}}"
                           class="btn btn-default"
                           role="button">Подробнее</a>
                    </form>
                </div>
            </div>
        </div>



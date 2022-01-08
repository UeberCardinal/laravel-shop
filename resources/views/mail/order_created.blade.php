<p>Уважаемый {{$name}}</p>
<p>Ваш заказ на сумму {{$fullSum}} руб. создан.</p>
@foreach($order->products as $product)
    {{$product->name}}<br>
    {{$product->price}}<br>
@endforeach

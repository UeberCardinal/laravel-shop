<p>Уважаемый {{$name}}</p>
<p>Ваш заказ на сумму {{$fullSum}} руб. создан.</p>
@foreach($order->skus as $sku)
    {{$sku->name}}<br>
    {{$sku->price}}<br>
@endforeach

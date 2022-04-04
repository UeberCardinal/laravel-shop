@extends('master')
@section('content')
    <div class="starter-template">

        <h1>Все товары</h1>
        <form id="form" method="GET" action="{{route('home.index')}}">
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
                        <input class="hit" type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif> Хит
                    </label>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="new">
                        <input class="newo" type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif >
                        Новинка
                    </label>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="recommend">
                        <input class="recommend" type="checkbox" name="recommend" id="recommend" @if(request()->has('recommend')) checked @endif >
                        Рекомендуем
                    </label>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button id="submit" type="submit" class="btn btn-primary">Фильтр</button>
                    <a href="{{route('home.index')}}" class="btn btn-warning">Сброс</a>
                </div>
            </div>
        </form>
        @foreach($skus as $sku)
        @include('layouts.card')
        @endforeach
        {{ $skus->appends([
    'price_from' => request()->price_from,
    'price_to'   => request()->price_to,
    'hit'        => request()->hit,
    'new'        => request()->new,
    'recommend'  => request()->recommend,
])->links()}}
    </div>
    <script src="{{asset('js/ajaxfilter.js')}}"></script>


@endsection

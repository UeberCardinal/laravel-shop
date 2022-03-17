<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('main.online_shop'): Главная</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/starter-template1.css')}}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home.index')}}">{{__('main.online_shop')}}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @routeactive('home.index')><a href="{{route('home.index')}}">{{__('main.all_products')}}</a></li>
                <li @routeactive('categor*')><a href="{{route('categories')}}">{{__('main.categories')}}</a>
                </li>
                <li @routeactive('basket*') ><a href="{{route('basket')}}">{{__('main.basket')}}</a></li>
                <li><a href="#">Сбросить проект в начальное состояние</a></li>
                <li><a href="{{route('locale', __('main.set_lang'))}}">{{__('main.set_lang')}}</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{$currencySymbol}}<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($currencies as $currency)
                            <li><a href="{{route('currency', $currency->code)}}">{{$currency->symbol}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @guest()
                    <li><a href="{{route('login')}}">Войти</a></li>
                @endguest
                @auth
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                        <li><a href="{{route('home')}}">Панель администратора</a></li>
                    @else
                        <li><a href="{{route('person.orders.index')}}">Мои заказы</a></li>
                    @endif

                    <li><a href="{{route('get-logout')}}">Выйти</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div style="margin-top: 25px">
        @include('alerts.index')
    </div>

    @yield('content')
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-6"><p>Категории товаров</p>
                <ul>
                    @foreach($categories as $category)
                    <li><a href="{{route('category', $category->slug)}}">{{$category->__('name')}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-6"><p>Самые популярные товары</p>
                <ul>
                    @foreach($bestProducts as $bestProduct)
                    <li><a href="{{route('product', [$bestProduct->category->slug, $bestProduct->slug])}}">{{$bestProduct->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

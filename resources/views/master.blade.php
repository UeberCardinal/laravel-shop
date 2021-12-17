
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Интернет Магазин: Главная</title>

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
            <a class="navbar-brand" href="{{route('home.index')}}">Интернет Магазин</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @routeactive('home.index')><a href="{{route('home.index')}}">Все товары</a></li>
                <li @routeactive('categor*')><a href="{{route('categories')}}">Категории</a>
                </li>
                <li @routeactive('basket*') ><a href="{{route('basket')}}">В корзину</a></li>
                <li><a href="#">Сбросить проект в начальное состояние</a></li>
                <li><a href="https://internet-shop.tmweb.ru/locale/en">en</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">₽<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="https://internet-shop.tmweb.ru/currency/RUB">₽</a></li>
                        <li><a href="https://internet-shop.tmweb.ru/currency/USD">$</a></li>
                        <li><a href="https://internet-shop.tmweb.ru/currency/EUR">€</a></li>
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
</body>
</html>

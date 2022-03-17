@extends('master')
@section('content')
    <div class="starter-template">
        <h1>Подтвердите заказ:</h1>
        <div class="container">
            <div class="row justify-content-center">
                <p>Общая стоимость: <b>{{$order->getFullSum()}}  {{\App\Services\CurrencyConversion::getCurrencySymbol()}}.</b></p>
                <form action="{{route('basketConfirm')}}" method="POST">
                    @csrf
                    <div>
                        <p>Укажите свои имя и номер телефона, чтобы наш менеджер мог с вами связаться:</p>
                        <input type="hidden" name="status" value="1">
                        <div class="container">
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-offset-3 col-lg-2">Имя: </label>
                                <div class="col-lg-4">
                                    <input type="text" name="name" id="name" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="phone" class="control-label col-lg-offset-3 col-lg-2">Номер
                                    телефона: </label>
                                <div class="col-lg-4">
                                    <input type="text" name="phone" id="phone" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            @guest
                                <div class="form-group">
                                    <label for="phone" class="control-label col-lg-offset-3 col-lg-2">Email: </label>
                                    <div class="col-lg-4">
                                        <input type="email" name="email" id="email" value="" class="form-control">
                                    </div>
                                </div>
                            @endguest
                            <br>
                            <br>
                            {{-- <div class="form-group">
                                 <label for="name" class="control-label col-lg-offset-3 col-lg-2">Email: </label>
                                 <div class="col-lg-4">
                                     <input type="text" name="email" id="email" value="" class="form-control">
                                 </div>
                             </div>--}}
                        </div>
                        <br>
                        <input type="submit" class="btn btn-success" value="Подтвердите заказ">
                    </div>
                </form>
            </div>
        </div>
@endsection

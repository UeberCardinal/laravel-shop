@extends('auth.layouts.master')
@section('content')
    <div class="col-md-12">
        <h1>Купон {{ $coupon->code }}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $coupon->id }}</td>
            </tr>
            <tr>
                <td>Номинал:</td>
                <td>{{ $coupon->value }}</td>
            </tr>
            @isset($coupon->currency)
                <tr>
                    <td>Валюта:</td>
                    <td>{{ $coupon->currency->code }}</td>
                </tr>
            @endisset
            <tr>
                <td>Абсолютное значение:</td>
                <td>@if($coupon->isAbsolute()) Да @else Нет @endif</td>
            </tr>
            <tr>
                <td>Купон может быть использован только один раз:</td>
                <td>@if($coupon->isOnlyOnce()) Да @else Нет @endif</td>
            </tr>
            <tr>
                <td>Использован:</td>
                <td>{{ $coupon->orders->count() }}</td>
            </tr>
            @isset($coupon->expired_at)
            <tr>
                <td>Использовать до:</td>
                <td>{{ $coupon->expired_at }}</td>
            </tr>
            @endisset
            <tr>
                <td>Описание:</td>
                <td>{{ $coupon->description }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

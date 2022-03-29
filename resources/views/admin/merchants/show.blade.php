@extends('auth.layouts.master')
@section('content')
    <div class="col-md-12">
        <h1>Поставщик {{ $merchant->name }}</h1>
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
                <td>{{ $merchant->id }}</td>
            </tr>
            <tr>
                <td>Имя:</td>
                <td>{{ $merchant->name }}</td>
            </tr>
            <tr>
                <td>Имейл:</td>
                <td>{{ $merchant->email }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

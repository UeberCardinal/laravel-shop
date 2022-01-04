@extends('master')
@section('content')
    <div class="starter-template">
        <h1>
            {{$categoryObj->name}}
        </h1>
        <h2>
            {{$categoryObj->code}}
        </h2>
        <p>
            {{$categoryObj->description}}
        </p>
        <p>
            Товаров в категории:{{$categoryObj->products->count()}}
        </p>
        @include('layouts.card')
        {{$products->links()}}
    </div>
@endsection

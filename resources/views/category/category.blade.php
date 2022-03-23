@extends('master')
@section('content')
    <div class="starter-template">
        <h1>
            {{$category->name}}
        </h1>
        <h2>
            {{$category->code}}
        </h2>
        <p>
            {{$category->description}}
        </p>
        <p>
            Товаров в категории:{{$category->products->count()}}
        </p>
        @foreach($category->products->map->skus->flatten() as $sku)
        @include('layouts.card', compact('sku'))
        @endforeach
        {{$skus->links()}}
    </div>
@endsection

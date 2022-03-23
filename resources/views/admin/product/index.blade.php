@extends('auth.layouts.master')
@section('title', 'Продукты')
@section('content')

        <div style="margin-top:15px; ">
            @if(\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{\Illuminate\Support\Facades\Session::get('success')}}
                </div>
            @endif
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-success" role="alert">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </div>
            @endif
        <div>
            <a href="{{route('products.create')}}"><button type="button" class="btn btn-success">Добавить новый продукт</button></a>
        </div>


            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Category product</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col">Count</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                <tr>
                    <th scope="row">{{$product->id}}</th>
                    <td>{{$product->category->name}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->slug}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->count}}</td>
                    <td>{{$product->price}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('products.edit', ['product' => $product->id])}}"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-primary" href="{{route('skus.index', [$product])}}">Skus</a>
                        <form method="post" action="{{route('products.destroy', ['product' => $product->id])}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            {{ $products->links() }}
        </div>

@endsection

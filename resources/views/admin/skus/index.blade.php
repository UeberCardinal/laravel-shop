@extends('auth.layouts.master')
@section('title', 'Товарные предложения')
@section('content')

        <div style="margin-top:15px; ">
        <div>
            <a href="{{route('skus.create', $product)}}"><button type="button" class="btn btn-success">Добавить sku</button></a>
        </div>
            @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{\Illuminate\Support\Facades\Session::get('success')}}
            </div>
            @endif
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </div>
            @endif
            <h2>{{$product->name}}</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Товарное предложение (свойства)</th>
                    <th scope="col">Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($skus as $sku)
                <tr>
                    <th scope="row">{{$sku->id}}</th>
                    <td>{{$sku->propertyOption->map->name->implode(', ')}}</td>
                    <td >
                        <a class="btn btn-info" href="{{route('skus.edit', [$product, $sku])}}"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-primary" href="{{route('skus.show', [$product, $sku])}}"><i class="fas fa-list-alt"></i></a>

                        <form method="post" action="{{route('skus.destroy', [$product, $sku])}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
           {{ $skus->links() }}
        </div>



@endsection

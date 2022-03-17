@extends('auth.layouts.master')
@section('title', 'Свойства')
@section('content')

        <div style="margin-top:15px; ">
        <div>
            <a href="{{route('properties.create')}}"><button type="button" class="btn btn-success">Добавить новое свойство</button></a>
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

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($properties as $property)
                <tr>
                    <th scope="row">{{$property->id}}</th>
                    <td>{{$property->name}}</td>
                    <td >
                        <a class="btn btn-info" href="{{route('properties.edit', ['property' => $property->id])}}"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-primary" href="{{route('property-options.index', ['property' => $property->id])}}"><i class="fas fa-list-alt"></i></a>
                        <form method="post" action="{{route('properties.destroy', ['property' => $property->id])}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
           {{ $properties->links() }}
        </div>



@endsection

@extends('auth.layouts.master')
@section('title', 'Варианты свойства')
@section('content')

        <div style="margin-top:15px; ">
        <div>

            <a href="{{route('property-options.create', $property)}}"><button type="button" class="btn btn-success">Добавить новую опцию свойства</button></a>
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
                @foreach($propertyOptions as $propertyOption)
                <tr>
                    <th scope="row">{{$propertyOption->id}}</th>
                    <td>{{$propertyOption->name}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('property-options.edit', [$property, $propertyOption])}}"><i class="fas fa-pencil-alt"></i></a>
                        <form method="post" action="{{route('property-options.destroy', [$property, $propertyOption])}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
           {{ $propertyOptions->links() }}
        </div>



@endsection

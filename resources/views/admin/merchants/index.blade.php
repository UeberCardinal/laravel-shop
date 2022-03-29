@extends('auth.layouts.master')
@section('title', 'Свойства')
@section('content')

        <div style="margin-top:15px; ">
        <div>
            <a href="{{route('merchants.create')}}"><button type="button" class="btn btn-success">Добавить нового поставщика</button></a>
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
                    <th scope="col">Email</th>
                    <th scope="col">Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($merchants as $merchant)
                <tr>
                    <th scope="row">{{$merchant->id}}</th>
                    <td>{{$merchant->name}}</td>
                    <td>{{$merchant->email}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('merchants.edit', $merchant)}}"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-primary" href="{{route('merchants.show', $merchant)}}"><i class="fas fa-list-alt"></i></a>
                        <a class="btn btn-success" href="{{route('merchants.update_token', $merchant)}}"><i class="fa fa-key"></i></a>
                        <form method="post" action="{{route('merchants.destroy', $merchant)}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
           {{ $merchants->links() }}
        </div>



@endsection

@extends('auth.layouts.master')
@section('title', 'Категории')
@section('content')

        <div style="margin-top:15px; ">
        <div>
            <a href="{{route('promocodes.create')}}"><button type="button" class="btn btn-success">Добавить новый промокод</button></a>
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
                    <th scope="col">Discount</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($promocodes as $promocode)
                <tr>
                    <th scope="row">{{$promocode->id}}</th>
                    <td>{{$promocode->name}}</td>
                    <td>{{$promocode->discount}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('promocodes.edit', $promocode)}}"><i class="fas fa-pencil-alt"></i></a>
                        <form method="post" action="{{route('promocodes.destroy', $promocode)}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            {{ $promocodes->links() }}
        </div>
@endsection

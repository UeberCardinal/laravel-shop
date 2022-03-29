@extends('auth.layouts.master')
@section('content')


    <div style="margin-top: 65px">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 style="margin-bottom: 25px;">Добавление нового поставщика</h2>
    <form method="post" action="{{route('merchants.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Название поставщика</label>
            <input name="name"  type="text" value="{{old('name')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Имейл</label>
            <input name="email"  type="text" value="{{old('email')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>



@endsection

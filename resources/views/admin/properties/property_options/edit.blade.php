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

        <h2 style="margin-bottom: 25px;">Редактирование свойства "{{$property->name}}"</h2>
    <form method="post" action="{{route('property-options.update', [$property, $propertyOption])}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="exampleInputEmail1">Название опции</label>
            <input value="{{$propertyOption->name}}" name="name"  type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Название опции en</label>
            <input value="{{$propertyOption->name_en}}" name="name_en"  type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <button  type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>



@endsection

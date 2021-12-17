@extends('admin.layouts.layout')
@section('title', 'Категории')
@section('content')
    <div class="container">
        <div style="margin-top:15px; ">
        <div>
            <a href="{{route('categories.create')}}"><button type="button" class="btn btn-success">Добавить новую категорию</button></a>
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
                    <th scope="col">Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>{{$category->description}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('categories.edit', ['category' => $category->id])}}"><i class="fas fa-pencil-alt"></i></a>
                        <form method="post" action="{{route('categories.destroy', ['category' => $category->id])}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            {{ $categories->links() }}
        </div>

    </div>

@endsection

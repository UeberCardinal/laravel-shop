@extends('auth.layouts.master')
@section('title', 'Категории')
@section('content')

        <div style="margin-top:15px; ">
        <div>
            <a href="{{route('coupon.create')}}"><button type="button" class="btn btn-success">Добавить новую купон</button></a>
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
                    <th scope="col">Код</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coupons as $coupon)
                <tr>
                    <th scope="row">{{$coupon->id}}</th>
                    <td>{{$coupon->code}}</td>
                    <td>{{$coupon->description}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('coupon.edit', $coupon)}}"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-primary" href="{{route('coupon.show', $coupon)}}"><i class="fas fa-list-alt"></i></a>
                        <form method="post" action="{{route('coupon.destroy', $coupon)}}">
                            @csrf
                            @method('delete')
                           <button onclick="return confirm('Подтвердите удаление')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            {{ $coupons->links() }}
        </div>
@endsection

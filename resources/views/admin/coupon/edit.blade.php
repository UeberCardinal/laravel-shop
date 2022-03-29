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

            <h2 style="margin-bottom: 25px;">Редактирование купона</h2>
            <form method="post" action="{{route('coupon.update', $coupon)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="exampleInputEmail1">Код</label>
                    <input name="code"  type="text" value="{{$coupon->code}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Номинал</label>
                    <input name="value"  type="text" value="{{$coupon->value}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <label>Валюта</label>
                <select  name="currency_id" class="form-control"  aria-label="Default select example">
                    @if($coupon->currency_id == null)
                    <option selected value="">Без валюты</option>
                    @endif

                    @foreach($currencies as $currency)
                        <option @if($coupon->currency_id == $currency->id) selected @endif value="{{$currency->id}}">{{$currency->symbol}}</option>
                    @endforeach

                </select>
                <br>
                @foreach ([
                     'type' => 'Абсолютное значение',
                     'only_once' => 'Купон может быть использован только один раз',
                     ] as $field => $title)
                    <div class="form-group row">
                        <label for="code" class="col-sm-2 col-form-label">{{ $title }}: </label>
                        <div class="col-sm-10">
                            <input type="checkbox" @if($coupon->$field == 1) checked @endif name="{{$field}}" id="{{$field}}"
                            >
                        </div>
                    </div>
                    <br>
                @endforeach
                <br>
                <div class="form-group">
                    <label for="exampleInputPassword1">Использовать до:</label>
                    <input name="expired_at" value="{{$coupon->expired_at->format('Y-m-d')}}" type="date" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Описание</label>
                    <input name="description" value="{{$coupon->description}}" type="text" class="form-control" id="exampleInputPassword1">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
    </div>



@endsection

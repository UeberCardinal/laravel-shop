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

        <h2 style="margin-bottom: 25px;">Добавление sku</h2>

    <form method="post" action="{{route('skus.store', $product)}}" enctype="multipart/form-data">
        @csrf
        <div class="input-group row">
            <label for="price" class="col-sm-2 col-form-label">Цена: </label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="price"
                       value="@isset($sku){{ $sku->price }}@endisset">
            </div>
        </div>
        <br>
        <div class="input-group row">
            <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="count"
                       value="@isset($sku){{ $sku->count }}@endisset">
            </div>
        </div>
        <br>
        @foreach ($product->properties as $property)
            <div class="input-group row">
                <label for="property_id[{{ $property->id }}]" class="col-sm-2 col-form-label">{{ $property->name }}: </label>
                <div class="col-sm-6">
                    <select name="property_id[{{ $property->id }}]" class="form-control">
                        @foreach($property->propertyOptions as $propertyOption)
                            <option value="{{ $propertyOption->id }}"
                                    @isset($sku)
                                    @if($sku->propertyOption->contains($propertyOption->id))
                                    selected
                                @endif
                                @endisset
                            >{{ $propertyOption->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>



@endsection

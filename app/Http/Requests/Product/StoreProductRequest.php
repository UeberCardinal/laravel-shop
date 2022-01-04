<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:30',
            'description' => 'required|min:10|max:255',
            'price' => 'required|min:1',
            'count' => 'required|numeric|min:0'
        ];
        if ($this->route()->named('products.store')){
            $rules['name'] .= '|unique:products';

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно'
        ];
    }
}
